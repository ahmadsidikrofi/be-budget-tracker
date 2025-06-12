<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\CategoriesModel;
use App\Models\TransactionModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class TransactionController extends Controller
{
    public function GetAllTransactions(Request $request)
    {
        $transactions = TransactionModel::where('user_id', Auth::id())
            ->with('category')
            ->orderBy('transaction_date', 'desc')
            ->paginate(15);

        return response()->json($transactions);
    }

    public function StoreTransaction(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|integer',
            'amount' => 'required|numeric|gt:0', // gt:0 artinya harus lebih besar dari 0
            'description' => 'required|string|max:255',
            'transaction_date' => 'required|date_format:Y-m-d',
        ]);

        $category = CategoriesModel::find($validated['category_id']);
        if (!$category || $category->user_id !== Auth::id()) {
            return response()->json(['message' => 'Kamu tidak memiliki kategori ini. Silahkan ditambahkan terlebih dahulu'], 403);
        }

        $transaction = TransactionModel::create($validated + ['user_id' => Auth::id()]);

        $transaction->load('category');

        return response()->json($transaction, 201);
    }

    public function GetTransactionById($id)
    {
        $transaction = TransactionModel::find($id);
        if (!$transaction) {
            return response()->json(['message' => 'Transaction not found'], 404);
        }

        if ($transaction->user_id !== Auth::id()) {
            return response()->json(['message' => 'Forbidden'], 403);
        }
        $transaction->load('category');

        return response()->json($transaction);
    }

    public function DeleteTransaction( $id )
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }

        $transaction = TransactionModel::find($id);
        if (!$transaction) return response()->json(['message' => 'transaction not found'], 404);
        if ($transaction->user_id !== Auth::user()->id) {
            return response()->json([
                'message' => 'You are not allowed to delete this transaction'
            ], 403);
        }

        $transaction->delete();
        return response()->json(['message' => 'Delete transaction succed'], 204);
    }
}
