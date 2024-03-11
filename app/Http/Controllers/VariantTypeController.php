<?php

namespace App\Http\Controllers;

use App\DataTables\Catalog\VariantTypeDataTable; 
use App\Http\Controllers\Controller;
use App\Models\VariantType;
use Illuminate\Http\Request;

class VariantTypeController extends Controller
{
    public function index(VariantTypeDataTable $dataTable)
    {
        return $dataTable->render('pages.catalog.variants.list'); // Adjust view path as needed
    }
    // C:\xampp\htdocs\MIDAS_ADMIN\resources\views\pages\catalog\varients\list.blade.php
    public function create()
    {
        return view('pages.catalog.variants.create'); 
    }

    public function store(Request $request)
    {
        $request->validate([
            'name_en' => 'required|string|max:255',
        ]);

        try {
            $variantType = VariantType::create($request->only('name_en'));

            return response()->json(['message' => 'Variant Added Successfully', 'status' => 200, 'variantType' => $variantType]);
        } catch (\Exception $e) {
            \Log::error('Error in storing variant type: ' . $e->getMessage());

            return response()->json(['message' => 'Failed to add variant type', 'error' => $e->getMessage(), 'status' => 500]);
        }
    }

    public function edit(VariantType $variantType)
    {
        return view('pages.catalog.variants.create', compact('variantType')); // Adjust view path as needed
    }

    public function update(Request $request, VariantType $variantType)
    {
        $request->validate([
            'name_en' => 'required|string|max:255',
        ]);

        try {
            $variantType->update($request->only('name_en'));

            return response()->json(['message' => 'Variant Updated Successfully', 'status' => 200, 'variantType' => $variantType]);
        } catch (\Exception $e) {
            \Log::error('Error in updating variant type: ' . $e->getMessage());

            return response()->json(['message' => 'Failed to update variant type', 'error' => $e->getMessage(), 'status' => 500]);
        }
    }

    public function destroy($id)
    {
        try {
            VariantType::where('id', $id)->delete();
            return response()->json(['message' => 'Variant Deleted Successfully', 'status' => 200]);
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return response()->json(['message' => 'Failed to delete variant', 'error' => $e->getMessage(), 'status' => 500]);
        }
    }
}
