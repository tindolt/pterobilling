<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Income;
use Carbon\Carbon;

class IncomeController extends Controller
{
    public function show()
    {
        $incomes7d = Income::whereBetween('created_at', [Carbon::now()->subWeek(), Carbon::now()])->get();
        $incomes30d = Income::whereBetween('created_at', [Carbon::now()->subMonth(), Carbon::now()])->get();
        $incomes90d = Income::whereBetween('created_at', [Carbon::now()->subMonths(3), Carbon::now()])->get();
        $incomesYear = Income::whereBetween('created_at', [Carbon::now()->subYear(), Carbon::now()])->get();

        $total_income7d = $total_income30d = $total_income90d = $total_incomeYear = 0;

        foreach ($incomes7d as $income) {
            $total_income7d += $income->price;
        }
        
        foreach ($incomes30d as $income) {
            $total_income30d += $income->price;
        }
        
        foreach ($incomes90d as $income) {
            $total_income90d += $income->price;
        }
        
        foreach ($incomesYear as $income) {
            $total_incomeYear += $income->price;
        }

        return view('admin.income', ['title' => 'Income', 'incomes' => [$incomes7d, $incomes30d, $incomes90d, $incomesYear], 'total_income' => [$total_income7d, $total_income30d, $total_income90d, $total_incomeYear]]);
    }
}
