<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $table = 'customers';

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone_number',
        'is_verified',
        'password',
        'image_path',
    ];

    protected $casts = [
        'is_verified' => 'boolean',
    ];


    
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
