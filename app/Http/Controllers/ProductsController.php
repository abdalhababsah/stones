<?php

namespace App\Http\Controllers;
use App\DataTables\Catalog\ProductsDataTable;
use App\Http\Requests\ArrayOfCategoryIdsRequest;
// use App\Http\Requests\ProductRequest;
use App\Models\Attribute;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Product\StoreRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Inventory;
use App\Models\Product;
use App\Models\ProductPhoto;
use App\Models\ProductSeo;
use App\Models\ProductStatus;
use App\Models\Tag;
use App\Models\VariantType;
use Illuminate\Contracts\View\ViewCompilationException;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductsController extends Controller
{
    public function index(ProductsDataTable $dataTable)
    {
        
        return $dataTable->render('pages.catalog.products.list');
    }

      public function create(): View
    {
        $statuses = ProductStatus::all();
        $categories = Category::all();
        $tags =Tag::all();
        $variants =VariantType::all();
        $brands = Brand::all();
        return view('pages.catalog.products.create', compact('statuses', 'categories','brands','tags','variants'));
    }

      public function edit($id):View
    {
        $statuses = ProductStatus::all();
        $brands = Brand::all();
        $categories = Category::all();
        $tags =Tag::all();
        $variants =VariantType::all();
        $product = Product::findOrFail($id);
        $product->load('reviews','images','attributes','status','categories.attributeGroups.attributes','inventory','brand','seo','tags','variants',);
        return view('pages.catalog.products.edit', compact('product','statuses','brands','categories','tags','variants'));
    }
    public function update(Request $request, $id )
    {
        $product = Product::findOrFail($id);
//        if ($request->has('name_en') && $request->has('description') && $request->has('price') && $request->has('status_id') && $request->has('brand_id') && $request->has('sort_order')) {
        if ($request->has('name_en')
            && $request->has('description')
            && $request->has('price')
            && $request->has('status_id')
            && $request->has('brand_id')) {
            $product->fill($request->only([
                'name_en',
                'description',
                'price',
                'status_id',
                'brand_id',
//                'sort_order',
            ]));
            $product->save();
            return response()->json(['message' => 'Product Updated successfully'], 201);
        }
        if ($request->has('tags')) {
            $this->destroyTags($product);
            $result = $this->attachTags($request,$product);
            return response()->json(['message' => $result], 201);
        }
        if ($request->has('attribute_id')
            && $request->has('attribute_value')) {
            $this->destroyAttributes($product);
            $result = $this->storeProductAttributes($request,$product);
            return response()->json(['message'=> $result], 201);
        }
        if ($request->has('sku')
            && $request->has('quantity')
            && $request->has('inventory_id')){
                $result = $this->updateInventory($request);
            return response()->json(['message' => $result], 201);
        }
        if ($request->has('meta_title')
//        'product_id' => $product->id,
            && $request->has('meta_description')
            && $request->has('meta_id')){
                $result = $this->metaSeo($request,$product);
            return response()->json(['message' => $result], 201);
        }
        if ($request->has('variant_type_ids')
            && $request->has('option_values')){
                $this->destroyVariation($product);
                $result = $this->syncProductVariants($request,$product);
            return response()->json(['message' => $result], 201);

        }
        if ($request->hasFile('file')) {
            $result =  $this->uploadImages( $request, $product);
            return response()->json(['message' => $result], 201);
        }
        return response()->json(['message' => 'successfully'], 201);
    }

     public function store(StoreRequest $request)
    {

//        return response()->json($request->toArray());
        // Create the product
        $product = Product::create($request->validated());

        $images = $this->uploadImages($request,$product);
        $categories = $this->attachCategories($request,$product);
        $tags = $this->attachTags($request,$product);
        $seo = $this ->metaSeo($request,$product);
         $attripute='m';
         if ($request->has('attribute_id')
             && $request->has('attribute_value')) {
        $attripute = $this ->storeProductAttributes($request,$product);
         }
        $quantity = $this ->quantity($request,$product);
        $p_variants = $this ->syncProductVariants($request,$product);

        $product->load('categories.attributeGroups.attributes');


        // return redirect()->route('catalog.products.index');
        // Return a response indicating success
        return response()->json(['message' => 'Product created successfully', 'product' => $product,'Images' => $images,'categories' => $categories,'tags' => $tags,'Seo' => $seo,'attripute' => $attripute,'quantity' => $quantity], 201);
    }
    public function quantity(Request $request,Product $product)
    {
        $inventory = Inventory::create([
            'product_id' => $product->id,
            'sku' => $request->sku,
            'quantity' => $request->quantity,
        ]);

        return $inventory;

    }
    public function storeProductAttributes(Request $request,Product $product):JsonResponse
    {
        // Validate the request data
        $validatedData = $request->validate([
            'attribute_id.*' => 'required|exists:attributes,id',
            'attribute_value.*' => 'required|string', // Adjust the validation rules as needed
        ]);

        // Sync the attributes with pivot details for the product
        $attributes = [];
        foreach ($validatedData['attribute_id'] as $index => $attributeId) {
            $attributes[$attributeId] = ['details' => $validatedData['attribute_value'][$index]];
        }
        $product->attributes()->sync($attributes);

        // Optionally, you can return a response or redirect to a specific page
        return response()->json(['message' => 'Product attributes stored successfully']);
    }
    
    private function uploadImages(Request $request,Product $product):string
    {
//        $request->validate([
//            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
//        ]);
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imageName = $product->name_en . '_' . time() . '_' . $image->getClientOriginalName();
                $path = $image->storeAs('public/storage/images', $imageName);
                $path = str_replace('public/', '', $path); // Remove 'public/' from the path

                ProductPhoto::create([
                    'product_id' => $product->id,
                    'path' => $path,
                ]);
            }
            return 'Images uploaded successfully.';
        }

        if ($request->hasFile('file')) {
                $image = $request->file('file');
                $imageName = $product->name_en . '_' . time() . '_' . $image->getClientOriginalName();
                $path = $image->storeAs('public/storage/images', $imageName);
                $path = str_replace('public/', '', $path); // Remove 'public/' from the path

                ProductPhoto::create([
                    'product_id' => $product->id,
                    'path' => $path,
                ]);
                return 'Images uploaded successfully.';
            }
            return 'No images selected for upload.';
    }
        public function attachCategories(Request $request,Product $product):string
{
    if ($request->has('categories')) {
        // Retrieve category IDs from the request
        $categoryIds = $request->input('categories');
        // Attach each category to the product
        $product->categories()->attach($categoryIds);
    }
    return 'categories successfully.';

}
    private function attachTags(Request $request,Product $product):string
{
    if ($request->has('tags')) {
        // Retrieve category IDs from the request
        $tagIds = $request->input('tags');
        // Attach each category to the product
        $return = $product->tags()->attach($tagIds);
    }
    return $return ?? 'tags successfully.';

}
    public function destroyTags(Product $product)
    {
        $product->tags()->detach();
        return true;
    }    public function destroyVariation(Product $product)
    {
        $product->variants()->detach();
        return true;
    }
    public function categoriesWithAttributeGroups(ArrayOfCategoryIdsRequest $request):JsonResponse
{
    $categoryIds = $request->categories;

    $categoriesWithAttributeGroups = Category::with('attributeGroups.attributes')
    ->whereIn('id', $categoryIds)
    ->get()
;

    // Loop through each category and its attribute groups to hide 'created_at' and 'updated_at'

    return response()->json(['categories' => $categoriesWithAttributeGroups]);
}





public function metaSeo(Request $request,Product $product):JsonResponse
{
    $meta = $request ->validate([
        'meta_title' => 'required',
        'meta_description' => 'required',
    ]);
    $productSeo = ProductSeo::updateOrCreate(['product_id' => $product->id],[
//         'product_id' => $product->id,
        'name_en' => $meta['meta_title'], // Assuming 'title' is the correct column name in the ProductSeo model
        'description' => $meta['meta_description']
    ]);

    return response()->json([$productSeo]);

}





    public function syncProductVariants(Request $request, Product $product):JsonResponse
    {
        if ($request->has('variant_type_ids')
            && $request->has('option_values')){

        $variantTypeIds = $request->input('variant_type_ids');
        $optionValues = $request->input('option_values');

        // Ensure the arrays are of equal length
        if (count($variantTypeIds) !== count($optionValues)) {
            // Handle error: Arrays are not of equal length
            return response()->json(['error' => 'Arrays are not of equal length'], 400);
        }

        $variantsData = [];

        // Create an array of data for synchronization
        foreach ($variantTypeIds as $index => $variantTypeId) {
            $variantsData[$variantTypeId] = ['option_value' => $optionValues[$index]];
        }

        // Synchronize product variants using sync method
        $product->variants()->sync($variantsData);

        // Optionally, you can return a success response
        }
        return response()->json(['message' => 'Product variants synchronized successfully'], 200);
    }




    public function destroy($id):JsonResponse
    {
        $product = Product::findOrFail($id);

        $photos = $product->images;
        if ($photos->isNotEmpty()) {
            foreach ($photos as $photo) {
                Storage::delete('public/' . $photo->path);
            }
        }
        $product->delete();

        return response()->json('Product Deleted Successfully');
    }





    public function temp(Request $request)
{
    $requestData = ['categories' => ['1', '2']];
    $requestInstance = new ArrayOfCategoryIdsRequest();
    $requestInstance->merge($requestData);
    $m = $this->categoriesWithAttributeGroups($requestInstance);
    
    return response()->json(['categories' => $m]);

}

    private function updateInventory(Request $request)
    {
        $inventory = Inventory::findOrFail($request->input('inventory_id'));
        $data = $request->except('inventory_id');

        // Update inventory with all fields except 'inventory_id'
        $inventory->fill($data);
        $inventory->save();
        return response()->json(['message' => 'inventory updated Successfully']);
    }

    private function destroyAttributes($product)
    {
        $product->attributes()->detach();
        return true;
    }
    public function removeImage(Request $request)
    {
        $filename = $request->input('filename');

        // Remove the image from the database
        ProductPhoto::where('path', $filename)->delete();

        return response()->json(['message' => 'Image removed from the database'], 200);
    }


}
