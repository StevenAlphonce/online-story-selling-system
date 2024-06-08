<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {

        $categories = Category::all();

        return view('category.categories', compact('categories'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $isEdit = false;

        return view('category.create-edit-category', compact('isEdit'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_name' => 'required|string|max:50', // Add validation rules as needed
        ]);

        $category = new Category();
        $category->name = $request->category_name;
        $category->save();

        return  redirect(url('dashboard/categories'));
        // response()->json(['message' => 'Category created successfully']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $isEdit = true;

        $category = Category::find($id);

        return view('category.create-edit-category', compact('category', 'isEdit'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'category_name' => 'required|string|max:50', // Add validation rules as needed
        ]);

        $category = Category::find($id);
        $category->name = $request->category_name;
        $category->update();

        return  redirect(url('dashboard/categories'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::find($id);

        $category->delete();

        return  redirect(url('dashboard/categories'));
    }
}
