<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\CategoriesModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class CategoriesController extends Controller
{
    public function GetAllCategories()
    {
        $categories = Auth::user()->categories;

        return response()->json($categories);
    }

    public function StoreCategory(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => ['required', Rule::in(['Pemasukan', 'Pengeluaran'])],
        ]);

        $category = CategoriesModel::create($validated + ['user_id' => Auth::id()]);
        return response()->json($category, 201);
    }

    public function GetCategoriesById(CategoriesModel $category, $id)
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }

        $category = CategoriesModel::find($id);
        if (!$category) {
            return response()->json(['message' => 'Category not found'], 404);
        }

        if ($category->user_id !== Auth::id()) {
            return response()->json(['message' => 'Forbidden. You do not own this category.'], 403);
        }

        return response()->json($category);
    }

    public function UpdateCategory(Request $request, $id)
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }
        $category = CategoriesModel::where('id', $id)->first();
        if (!$category) {
            return response()->json(['message' => 'Category not found'], 404);
        }
        if (Auth::check()) {
            $category->update($request->all());
            return response()->json($category, 200);
        }
    }

    public function DeleteCategory(CategoriesModel $category, $id)
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }

        $category = CategoriesModel::find($id);
        if (!$category) return response()->json(['message' => 'Category not found'], 404);
        if ($category->user_id !== Auth::user()->id) {
            return response()->json([
                'message' => 'You are not allowed to delete this category'
            ], 403);
        }

        $category->delete();
        return response()->json(['message' => 'Delete category succed'], 200);
    }
}