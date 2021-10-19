<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public function scopeWhereNameLike(Builder $query, $value)
    {
        return $query->where('name', 'LIKE', "%{$value}%");
    }
}
