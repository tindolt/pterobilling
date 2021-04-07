<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Income;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class DashController extends Controller
{
    public function show()
    {
        $period = CarbonPeriod::create(Carbon::now()->subDays(30), Carbon::now());
        $incomes = $orders = $clients = [];

        foreach ($period as $date) {
            $format = Carbon::parse($date)->day;
            $incomes[$format] = $orders[$format] = $clients[$format] = 0;
            $day = [Carbon::parse($date)->format('Y-m-d'), Carbon::parse($date)->setHour(23)->setMinute(59)->setSecond(59)];

            foreach (Income::whereBetween('created_at', $day)->get() as $income) {
                $incomes[$format] += $income->price;
                $orders[$format] += 1;
            }

            $clients[$format] = count(Client::whereDate('created_at', $day)->get());
        }

        return view('admin.dash', ['title' => 'Admin Dashboard', 'incomes' => $incomes, 'orders' => $orders, 'clients' => $clients]);
    }
}
