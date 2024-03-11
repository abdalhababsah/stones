<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'variant_type_id', 'option_value', 'price'];


    public function variantType()
    {
        return $this->belongsTo(VariantType::class);
    }


    public function orderProductVariants()
    {
        return $this->hasMany(OrderProductVariant::class);
    }
}