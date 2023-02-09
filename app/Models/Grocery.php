<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Grocery extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        "category_id",
        "groceryName",
        "groceryQuantity",
    ];

    protected $hidden = [
        "created_at",
        "updated_at",
        "deleted_at"
    ];
}