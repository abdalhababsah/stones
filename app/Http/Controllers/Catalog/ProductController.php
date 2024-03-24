<?php

namespace App\Http\Controllers\Catalog;

use App\DataTables\Catalog\ProductDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Products\ProductStoreRequest;
use App\Http\Requests\Products\ProductUpdateRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\Variant;
use App\Models\VariantType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        $variants =VariantType::all();
        $categories = category::all();
//        dd($variants);
        return view('pages.catalog.products.create',compact('categories','variants'));
    }



    public function store(ProductStoreRequest $request): \Illuminate\Http\JsonResponse
    {
//        dd($request);
        $validatedData = $request->validated();
        $validatedData['slug_en'] = Str::slug($validatedData['name_en']);
        $validatedData['slug_ar'] = Str::slug($validatedData['name_ar'], '-');

        // Explicitly remove 'images' key to prevent attempting to insert it into the products table
        unset($validatedData['images']);

        // Extract and remove nested data for dimensions, variants, and inventory to handle separately
        $dimensionsData = $validatedData['dimensions'] ?? null;
        $variantsData = $validatedData['variants'] ?? [];
        $inventoryQuantity = $validatedData['quantity_available'] ?? null;
        unset($validatedData['dimensions'], $validatedData['variants'], $validatedData['quantity_available']);

        try {
            DB::beginTransaction();

            // Create the product
            $product = Product::create($validatedData);

            // Handle dimensions if provided
            if ($dimensionsData) {
                $product->dimension()->create($dimensionsData);
            }

            // Handle variants
            foreach ($variantsData as $variant) {
                $product->variants()->create($variant);
            }

            // Handle inventory if provided
            if ($inventoryQuantity !== null) {
                $product->inventory()->create(['quantity_available' => $inventoryQuantity]);
            }

            // Handle images
            // Handle images
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    // Generate a unique filename for each image
                    $filename = Str::slug($validatedData['name_en'], '_') . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                    $filePath = $image->storeAs('public/images', $filename); // Saving the file to the storage
                    $databasePath = 'storage/images/' . $filename; // Preparing the path for database

                    // Save the image path in relation to the product
                    $product->images()->create(['image_path' => $databasePath]);
                }
            }


            DB::commit();
            return response()->json(['message' => 'Product and its inventory added successfully', 'status' => 200]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Failed to add Product', 'error' => $e->getMessage(), 'status' => 500]);
        }
    }

    public function show(string $id): \Illuminate\Http\JsonResponse
    {
        $product = Product::with(['variants.variantType', 'category', 'images', 'dimension', 'seo', 'variants.inventory'])->findOrFail($id);
        return view('pages.catalog.products.create',compact($product));
    }

    public function edit(string $id): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        $product = Product::with(['variants.variantType', 'category', 'images', 'dimension', 'seo', 'variants','inventory'])->findOrFail($id);
        return view('pages.catalog.products.edit', compact('product'));
    }


    public function update(ProductUpdateRequest $request, $productId): \Illuminate\Http\JsonResponse
    {
        $validatedData = $request->validated();

        try {
            DB::beginTransaction();

            $product = Product::findOrFail($productId);

            // Update product's basic details
            $product->update($validatedData);

            // Update dimensions if provided
            if (isset($validatedData['dimensions'])) {
                $product->dimension()->update($validatedData['dimensions']);
            }

            // Update variants
            // Assuming variants can be both added and updated in the same request
            if (isset($validatedData['variants'])) {
                foreach ($validatedData['variants'] as $variantData) {
                    if (isset($variantData['id'])) {
                        // Update existing variant
                        $product->variants()->where('id', $variantData['id'])->update($variantData);
                    } else {
                        // Add new variant
                        $product->variants()->create($variantData);
                    }
                }
            }

            // Remove variants if provided
            if (isset($validatedData['removed_variants'])) {
                $product->variants()->whereIn('id', $validatedData['removed_variants'])->delete();
            }

            // Handle images
            // Handle images
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    // Generate a unique filename for each image
                    $filename = Str::slug($request->input('name_en'), '_') . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                    $filePath = $image->storeAs('public/images', $filename); // Saving the file to the storage
                    $databasePath = 'storage/images/' . $filename; // Preparing the path for database

                    // Save the image path in relation to the product
                    $product->images()->create(['image_path' => $databasePath]);
                }
            }



            // Remove images if provided
            if (isset($validatedData['removed_images'])) {
                $imagesToRemove = $product->images()->whereIn('id', $validatedData['removed_images'])->get();
                foreach ($imagesToRemove as $image) {
                    $pathInStorage = str_replace('storage/', '', $image->image_path);
                    Storage::disk('public')->delete($pathInStorage);
                    $image->delete();
                }
            }

            DB::commit();

            return response()->json(['message' => 'Product Updated Successfully', 'status' => 200]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Failed to update Product', 'error' => $e->getMessage(), 'status' => 500]);
        }
    }

    public function destroy($productId): \Illuminate\Http\JsonResponse
    {
        try {
            DB::beginTransaction();

            $product = Product::findOrFail($productId);

            // Delete dimensions
            $product->dimension()->delete();

            // Delete variants
            $product->variants()->delete();

            // Delete images and their associated files from storage
            foreach ($product->images as $image) {
                // Assuming you're storing the full path in the database and you have 'storage/' prefix
                $pathInStorage = str_replace('storage/', '', $image->image_path);
                Storage::disk('public')->delete($pathInStorage);
                $image->delete(); // Delete the image record
            }

            // Finally, delete the product itself
            $product->delete();

            DB::commit();

            return response()->json(['message' => 'Product Deleted Successfully', 'status' => 200]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Failed to delete Product', 'error' => $e->getMessage(), 'status' => 500]);
        }
    }
}
