<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\OrderProduct;
use App\Models\ProductVariant;
class OrderProductVariant extends Model
{
    use HasFactory;


    protected $table = 'order_product_variants';

    // Fillable fields for a mass assignment to protect against mass-assignment vulnerabilities.
    protected $guarded = [];

    /**
     * Get the order product that owns the variant.
     */
    public function orderProduct()
    {
        return $this->belongsTo(OrderProduct::class, 'order_product_id');
    }

    /**
     * Get the product variant associated with the order product variant.
     */
    public function productVariant()
    {
        return $this->belongsTo(ProductVariant::class, 'product_variant_id');
    }

}
