<?php

namespace App\Http\Controllers\Catalog;

use App\DataTables\Catalog\ProductDataTable;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(ProductDataTable $dataTable)
    {
        // Render a DataTable view
        return $dataTable->render('pages.catalog.products.list');
    }

    public function create(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        // Return a view for creating a new Product
        return view('pages.catalog.products.create');
    }

    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        $validatedData = $request->validate([
            // Validation rules for product fields
        ]);

        // Logic to handle file uploads (if applicable) and store product

        try {
            $product = Product::create($validatedData);
            // Additional logic to save related models like images, dimensions, etc.

            return response()->json(['message' => 'Product Added Successfully', 'status' => 200]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to add Product', 'error' => $e->getMessage(), 'status' => 500]);
        }
    }

    public function show(string $id): \Illuminate\Http\JsonResponse
    {
        $product = Product::with(['variants.variantType', 'category', 'images', 'dimension', 'seo', 'variants.inventory'])->findOrFail($id);
        return response()->json($product);
    }

    public function edit(string $id): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        $product = Product::with(['variants.variantType', 'category', 'images', 'dimension', 'seo', 'variants.inventory'])->findOrFail($id);
        return view('catalog.products.edit', compact('product'));
    }

    public function update(Request $request, string $id): \Illuminate\Http\JsonResponse
    {
        $validatedData = $request->validate([
            // Validation rules
        ]);

        try {
            $product = Product::findOrFail($id);
            $product->update($validatedData);
            // Additional logic for updating related models

            return response()->json(['message' => 'Product Updated Successfully', 'status' => 200]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to update Product', 'error' => $e->getMessage(), 'status' => 500]);
        }
    }

    public function destroy(string $id)
    {
        try {
            $product = Product::findOrFail($id);
            $product->delete();

            return response()->json(['message' => 'Product Deleted Successfully', 'status' => 200]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to delete Product', 'error' => $e->getMessage(), 'status' => 500]);
        }
    }
}
