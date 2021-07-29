<?php

namespace App\Jobs;

use App\Models\Addon;
use App\Models\Client;
use App\Models\Invoice;
use App\Models\Server;
use App\Notifications\PayInvoiceNotif;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class IssueAddonInvoice implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The server instance.
     *
     * @var \App\Models\Server
     */
    protected $server;

    /**
     * The addon instance.
     *
     * @var \App\Models\Addon
     */
    protected $addon;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Server $server, Addon $addon)
    {
        $this->server = $server;
        $this->addon = $addon;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if (Invoice::where('server_id', $this->server->id)->where('addon_id', $this->addon->id)->where('paid', false)->exists()) return;

        $client = Client::find($this->server->client_id);
        $invoice = Invoice::create([
            'client_id' => $client->id,
            'server_id' => $this->server->id,
            'addon_id' => $this->addon->id,
            'payment_method' => $this->server->payment_method,
            'due_date' => $this->server->next_due,
        ]);

        $client->notify(new PayInvoiceNotif($invoice->id));
    }
}
