<?php

namespace App\Http\Controllers\Catalog;

use App\DataTables\Catalog\CategoryGroupsDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryGroup\StoreRequest;
use App\Http\Requests\CategoryGroup\UpdateRequest;
use App\Models\CategoryGroup;
use Illuminate\Http\Request;

class CategoryGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(CategoryGroupsDataTable $dataTable)
    {
        return $dataTable->render('pages.catalog.categories.categoryGroups.list');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.catalog.categories.categoryGroups.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        try {
            // Manual validation
            $request->validate($request->rules());

            $categoryGroup = CategoryGroup::create($request->all());

            return response()->json(['message' => 'Category Group Added Successfully', 'status' => 200]);
        } catch (\Exception $e) {
            \Log::error('Error in storing category group: ' . $e->getMessage());

            return response()->json(['message' => 'Failed to add category group', 'error' => $e->getMessage(), 'status' => 500]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CategoryGroup $categoryGroup)
    {
        return view('pages.catalog.categories.categoryGroups.create', compact('categoryGroup'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, CategoryGroup $categoryGroup)
    {
        try {
            // Manual validation
            $request->validate($request->rules());

            $categoryGroup->update($request->all());

            return response()->json(['message' => 'Category Group Updated Successfully', 'status' => 200]);
        } catch (\Exception $e) {
            \Log::error('Error in updating category group: ' . $e->getMessage());

            return response()->json(['message' => 'Failed to update category group', 'error' => $e->getMessage(), 'status' => 500]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            CategoryGroup::where('id', $id)->delete();
            return response()->json(['message' => 'Category Group Deleted Successfully', 'status' => 200]);
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return response()->json(['message' => 'Failed to delete category group', 'error' => $e->getMessage(), 'status' => 500]);
        }
    }
}
