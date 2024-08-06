<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TopCategory extends Model
{
    use HasFactory;

    protected $table= 'top_categories';
    protected $fillable =[
        'name',
        'created_at',
        'updated_at',
    ];
}
