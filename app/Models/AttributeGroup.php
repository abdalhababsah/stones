<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttributeGroup extends Model
{
    use HasFactory;

    protected $guarded = [];
    public function attributes()
    {
        return $this->hasMany(Attribute::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_attributegroup');
    }
}
