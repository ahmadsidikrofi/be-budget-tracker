<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\TransactionModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function GetLast5Transactions()
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }

        $transactions = TransactionModel::where('user_id', Auth::id())->orderBy('created_at', 'desc')->take(5)->get()->load('category');
        $countTransactions = $transactions->count();
        return response()->json([
            'transactions' => $transactions,
            'count' => $countTransactions
        ], 200);
    }

    public function GetSummaryBudget( Request $request )
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }
        $startDate = $request->query('start_date', now()->startOfMonth()->toDateString());
        $endDate = $request->query('end_date', now()->endOfMonth()->toDateString());

        $summary = DB::table('transactions')
        ->join('categories', 'transactions.category_id', '=', 'categories.id')
        ->where('transactions.user_id', Auth::user()->id)
        ->whereBetween('transactions.transaction_date', [$startDate, $endDate])
        ->select(
            'categories.type',
            DB::raw('SUM(transactions.amount) as total')
        )
        ->groupBy('categories.type')
        ->get()
        ->keyBy('type');

        $totalIncome = $summary->get('Pemasukan')?->total ?? 0;
        $totalExpense = $summary->get('Pengeluaran')?->total ?? 0;

        return response()->json([
            'total_income' => $totalIncome,
            'total_expense' => $totalExpense,
            'current_balance' => $totalIncome - $totalExpense,
        ], 200);
    }

    public function GetSpendingByCategory( Request $request )
    {
        $user = $request->user();
        $startDate = $request->query('start_date', now()->startOfMonth()->toDateString());
        $endDate = $request->query('end_date', now()->endOfMonth()->toDateString());

        $grandTotalExpense = DB::table('transactions')
        ->join('categories', 'transactions.category_id', '=', 'categories.id')
        ->where('transactions.user_id', $user->id)
        ->where('categories.type', 'Pengeluaran') // Pastikan ini 'expense' sesuai DB
        ->whereBetween('transactions.transaction_date', [$startDate, $endDate])
        ->sum('transactions.amount');

        $spendingByCategory = DB::table('transactions')
        ->join('categories', 'transactions.category_id', '=', 'categories.id')
        ->where('transactions.user_id', $user->id)
        ->where('categories.type', 'Pengeluaran') // Filter hanya untuk pengeluaran
        ->whereBetween('transactions.transaction_date', [$startDate, $endDate])
        ->select(
            'categories.name as category_name',
            DB::raw('SUM(transactions.amount) as total_amount')
        )
        ->groupBy('categories.name')
        ->orderBy('total_amount', 'desc') // Urutkan dari yang terbesar
        ->get();

        $response = $spendingByCategory->map(function ($item) use ($grandTotalExpense) {
            $percentage = 0;
            if ($grandTotalExpense > 0) {
                $percentage = ($item->total_amount / $grandTotalExpense) * 100;
            }

            $item->percentage = round($percentage, 2);
            return $item;
        });

        return response()->json([
            'data' => $response
        ]);
    }

    public function GetIncomeExpenseTrend()
    {
        $user = Auth::user();
        $endDate = now()->endOfDay();
        $startDate = now()->subMonths(5)->startOfMonth()->startOfDay();

        $trendData = DB::table('transactions')
            ->join('categories', 'transactions.category_id', '=', 'categories.id')
            ->where('transactions.user_id', $user->id)
            ->whereBetween('transactions.transaction_date', [$startDate, $endDate])
            ->select(
                DB::raw("YEAR(transaction_date) as year"),
                DB::raw("DATE_FORMAT(transaction_date, '%b') as month_name"),
                DB::raw("MONTH(transaction_date) as month_numeric"),

                DB::raw("SUM(CASE WHEN categories.type = 'Pemasukan' THEN amount ELSE 0 END) as income"),
                DB::raw("SUM(CASE WHEN categories.type = 'Pengeluaran' THEN amount ELSE 0 END) as expense")
            )
            ->groupBy('year', 'month_name', 'month_numeric')

            ->orderBy('year', 'asc')
            ->orderBy('month_numeric', 'asc')
            ->get();

        return response()->json($trendData);
    }

}
