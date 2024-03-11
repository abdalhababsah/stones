<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory,Sluggable;

//    public mixed $name_en;

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name_en'
            ]
        ];
    }

    protected $guarded = [];

    // protected $fillable= ['name_en','description','price','model_number','warranty_period','product_code','status_id','brand_id'];
    
    
    public function reviews()
    {
        return $this->hasMany(ProductReview::class);
    }

    public function images()
    {
        return $this->hasMany(ProductPhoto::class);
    }
    public function attributes()
    {
        return $this->belongsToMany(Attribute::class,'product_attributes')->withPivot('details');
    }
    public function status()
    {
        return $this->belongsTo(ProductStatus::class);
    }


    
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'product_category');
    }

    public function inventory()
    {
        return $this->hasOne(Inventory::class);
    }
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
    public function seo()    {
        return $this->hasOne(ProductSeo::class);
    }
    
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'product_tags');
    }

    public function variants()
    {
        return $this->belongsToMany(VariantType::class, 'product_variants')->withPivot('option_value', 'price');
    }
}