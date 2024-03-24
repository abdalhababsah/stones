<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductsApiController extends Controller
{


    public function index(Request $request)
    {
        $lang = $request->get('lang', 'en');

        $product = Product::select('id', "name_$lang as name", "description_$lang as description",
                'products.slug_' . $lang . ' as slug', 'qrcode','category_id')
            ->with(["category:id,name_$lang as name,icon_path",
                'inventory:product_id,quantity_available',
                "variants:variant_type_id,product_id,variant_value_$lang as value",
                "variants.variantType:id,name_$lang as name",
                'images:product_id,image_path', 'seo', 'dimension:product_id,length,width,height,dimension_unit'])
            ->where('products.status', 'active')
            ->get();

        return response()->json($product);
    }

    public function show(Request $request, $id)
    {
        $lang = $request->get('lang', 'en');

        $product = Product::where('id', $id)
            ->select('id', "name_$lang as name", "description_$lang as description",
                'products.slug_' . $lang . ' as slug', 'qrcode','category_id')
            ->with(["category:id,name_$lang as name,icon_path",
                'inventory:product_id,quantity_available',
                "variants:variant_type_id,product_id,variant_value_$lang as value",
                "variants.variantType:id,name_$lang as name",
                'images:product_id,image_path', 'seo', 'dimension:product_id,length,width,height,dimension_unit'])

            ->first();

        return response()->json($product);
    }



}
