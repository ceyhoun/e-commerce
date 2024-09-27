<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiscountPercent extends Model
{
    use HasFactory;

    protected $table ='discount_percents';

    protected $fillable = [
        'name',
        'percent',
        'is_active'
    ];
}
