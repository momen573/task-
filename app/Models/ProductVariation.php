<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductVariation extends Model
{
    use HasFactory;

    protected $fillable = ['color', 'price'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
