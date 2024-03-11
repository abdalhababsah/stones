<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProductVariant;
class VariantType extends Model
{
    use HasFactory;
    protected $guarded = [];


    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_variants')->withPivot('option_value');
    }


    public function ProductVariant()
    {
        return $this->hasMany(ProductVariant::class);
    }

}
