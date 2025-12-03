<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\FuzzyCategory;
use Illuminate\Http\Request;

class FuzzyCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $fuzzyCategories = FuzzyCategory::orderBy('min_value', 'asc')->paginate(10);
        return view('admin.fuzzy-categories.index', compact('fuzzyCategories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255',
            'min_value' => 'required|numeric|min:0|max:1',
            'max_value' => 'required|numeric|min:0|max:1|gte:min_value',
            'label' => 'required|string|max:255',
            'color' => 'required|string|max:20',
            'is_active' => 'boolean'
        ]);

        FuzzyCategory::create($request->all());

        return redirect()->route('fuzzy-categories.index')
            ->with('success', 'Kategori fuzzy berhasil ditambahkan.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FuzzyCategory $fuzzyCategory)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255',
            'min_value' => 'required|numeric|min:0|max:1',
            'max_value' => 'required|numeric|min:0|max:1|gte:min_value',
            'label' => 'required|string|max:255',
            'color' => 'required|string|max:20',
            'is_active' => 'boolean'
        ]);

        $fuzzyCategory->update($request->all());

        return redirect()->route('fuzzy-categories.index')
            ->with('success', 'Kategori fuzzy berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FuzzyCategory $fuzzyCategory)
    {
        $fuzzyCategory->delete();

        return redirect()->route('fuzzy-categories.index')
            ->with('success', 'Kategori fuzzy berhasil dihapus.');
    }
}
