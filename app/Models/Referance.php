<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Referance extends Model
{
    use HasFactory;
    protected $fillable =[
        'name',
        'image',
        'status'
    ];

    protected $table ='referances';
}
