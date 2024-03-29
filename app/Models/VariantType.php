<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VariantType extends Model
{
    use HasFactory;

    protected $guarded = [];



    public function variants()
    {
        return $this->hasMany(Variant::class);
    }
}
