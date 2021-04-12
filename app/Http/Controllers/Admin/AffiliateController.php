<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AffiliateEarning;
use App\Models\AffiliateProgram;
use App\Models\Client;
use Illuminate\Http\Request;

class AffiliateController extends Controller
{
    public function index()
    {
        return view('admin.affiliate.index', ['title' => 'Affiliate Settings', 'affiliates' => AffiliateEarning::all()]);
    }
    
    public function show()
    {
        return view('admin.affiliate.show', ['title' => 'Affiliate Program Settings', 'affiliate_settings' => AffiliateProgram::orderBy('id', 'asc')->get()]);
    }
    
    public function store(Request $request)
    {
        $request->validate(['conversion' => 'required|numeric|gt:0|lte:100']);

        $affiliate_enabled = AffiliateProgram::where('key', 'enabled')->first();
        $affiliate_enabled->value = $request->has('enabled');
        $affiliate_enabled->save();
        
        $affiliate_conversion = AffiliateProgram::where('key', 'conversion')->first();
        $affiliate_conversion->value = $request->input('conversion');
        $affiliate_conversion->save();

        return back()->with('success_msg', 'You have updated the affiliate program settings! Please click \'Reload Config\' above on the navigation bar to apply them.');
    }

    public function accept($id)
    {
        $affiliate = AffiliateEarning::find($id);
        $client = Client::find($affiliate->client_id);
        $client->credit += $affiliate->commission;
        $client->save();
        $affiliate->status = 0;
        $affiliate->save();

        return back()->with('success_msg', 'You have accepted the withdrawal request! Commission has been added to the client\'s credit balance.');
    }

    public function reject($id)
    {
        $affiliate = AffiliateEarning::find($id);
        $affiliate->status = 2;
        $affiliate->save();

        return back()->with('success_msg', 'You have rejected the withdrawal request!');
    }
}
