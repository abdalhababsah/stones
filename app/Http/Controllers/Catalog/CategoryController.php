<?php

namespace App\Http\Controllers\Catalog;

use App\Http\Controllers\Controller;
use App\DataTables\Catalog\CategoryDataTable;
use App\Http\Requests\Category\StoreRequest;
use App\Http\Requests\Category\UpdateRequest;
use App\Models\Category;
use App\Models\CategoryGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(CategoryDataTable $dataTable)
    {
        return $dataTable->render('pages.catalog.categories.category.list');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categoryGroups = CategoryGroup::all();
        return view('pages.catalog.categories.category.create', compact('categoryGroups'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        try {
            $request->validated();
    
            $categoryData = $request->except('icon_path');
    
            if ($request->hasFile('icon_path')) {
                $file = $request->file('icon_path');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('categories/icons', $fileName, 'public');
                $categoryData['icon_path'] = str_replace('public/', '', $filePath);
            }
    
            $category = Category::create($categoryData);
    
            return response()->json(['message' => 'Category Added Successfully', 'status' => 200]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to add category', 'error' => $e->getMessage(), 'status' => 500]);
        }
    }
    
    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        $categoryGroups = CategoryGroup::all();
        return view('pages.catalog.categories.category.create', compact('category', 'categoryGroups'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, $id)
    {
        try {
            $category = Category::findOrFail($id);
            $request->validated();
    
            if ($request->hasFile('icon_path')) {
                if ($category->icon_path && Storage::disk('public')->exists($category->icon_path)) {
                    Storage::disk('public')->delete($category->icon_path);
                }
    
                $file = $request->file('icon_path');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('categories/icons', $fileName, 'public');
                $category->icon_path = str_replace('public/', '', $filePath); // Save the new icon path
            }
    
            $category->update($request->except(['icon_path', '_method', '_token']));
    
            return response()->json(['message' => 'Category Updated Successfully', 'status' => 200]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to update category', 'error' => $e->getMessage(), 'status' => 500]);
        }
    }
    
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $category = Category::findOrFail($id);
            if ($category->icon_path && Storage::disk('public')->exists($category->icon_path)) {
            Storage::disk('public')->delete($category->icon_path);
            }
    
            $category->delete(); 
    
            return response()->json(['message' => 'Category Deleted Successfully', 'status' => 200]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to delete category', 'error' => $e->getMessage(), 'status' => 500]);
        }
    }
    
}
