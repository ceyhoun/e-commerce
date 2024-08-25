<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favory extends Model
{
    use HasFactory;


    protected $table ='favories';

    protected $fillable = ['user_id', 'session_id', 'product_id', 'favqty', 'created_at', 'updated_at'];


    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function products()
    {
        return $this->belongsTo(Product::class,'product_id');
    }
}
