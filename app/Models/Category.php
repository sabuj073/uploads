<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';

    protected $fillable = ['name','variations'];

    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
    ];

    public static $rules = [
        'name' => 'required|unique:categories,name',
    ];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'category_id', 'id');
    }
}
