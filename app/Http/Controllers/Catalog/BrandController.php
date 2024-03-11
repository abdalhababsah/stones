<?php

namespace App\Http\Controllers\Catalog;

use App\DataTables\Catalog\BrandsDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Brand\StoreRequest;
use App\Http\Requests\Brand\UpdateRequest;
use App\Models\Brand;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(BrandsDataTable $dataTable)
    {


        return $dataTable->render('pages.catalog.brands.list');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.catalog.brands.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {



        try {
            $validatedData = $request->validated();

            if ($request->hasFile('icon_path') && $request->validate(['icon_path' => 'image'])) {
                $filename = Str::slug($request->name_en, '_');
                $extension = $request->file('icon_path')->getClientOriginalExtension();
                $fileNameToStore = $filename . '_' . time() . '.' . $extension;
                $validatedData['icon_path'] = Storage::/*disk('s3')->*/putFileAs('Brand', $request->file('icon_path'), $fileNameToStore);
            }

            Brand::create($validatedData);

            return response()->json(['message' => 'Brand Added Successfully', 'status' => 200]);
        } catch (\Exception $e) {

            return response()->json(['message' => 'Failed to add brand', 'error' => $e->getMessage(), 'status' => 500]);
        }
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Brand $brand)
    {

        return view('pages.catalog.brands.create', compact('brand'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Brand $brand)
    {
        $validatedData = $request->validated();

        // Handling the icon upload
        if ($request->hasFile('icon_path') && $request->validate(['icon_path' => 'image'])) {

            $oldIconPath = $brand->icon_path;
            if ($oldIconPath && file_exists(public_path($oldIconPath))) {
                @unlink(public_path($oldIconPath));
            }

            $icon = $request->file('icon_path');
            $iconName = date('YmdHi') . $icon->getClientOriginalName();
            $icon->move(public_path('upload/brand_icons'), $iconName);
            $validatedData['icon_path'] = 'upload/brand_icons/' . $iconName;
        } elseif ($request->has('icon_path') && $request->get('icon_path') == null) {
            $validatedData['icon_path'] = null;
        }

        $brand->update($validatedData);

        return response()->json(['message' => 'Brand Updated Successfully', 'status' => 200]);
    }


    /**
     * Remove the specified resource from storage.
     */

    public function destroy($id)
    {
        try {
            $brand = Brand::findOrFail($id);

            if ($brand->icon_path && file_exists(public_path($brand->icon_path))) {
                @unlink(public_path($brand->icon_path));
            }

            $brand->delete();

            return response()->json(['message' => 'Brand Deleted Successfully', 'status' => 200]);
        } catch (\Exception $e) {
            \Log::error('Error in deleting brand: ' . $e->getMessage());

            return response()->json(['message' => 'Failed to delete brand', 'error' => $e->getMessage(), 'status' => 500]);
        }
    }


}
