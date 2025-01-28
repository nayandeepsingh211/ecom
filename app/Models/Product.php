<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    // Table name (optional if default matches 'products')
    protected $table = 'products';

    // Fillable attributes for mass assignment
    protected $fillable = ['name', 'description', 'price', 'stock'];
}
