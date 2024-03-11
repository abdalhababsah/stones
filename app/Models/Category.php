<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $guarded = [];


    public function categoryGroup()
    {
        return $this->belongsTo(CategoryGroup::class, 'category_group_id');
    }

    public function attributeGroups()
    {
        return $this->belongsToMany(AttributeGroup::class, 'category_attribute_group');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_category');
    }
}
