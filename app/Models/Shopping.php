<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shopping extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'session_id',
        'product_id',
        'product_qty',
        'size_id',
        'color_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function products()
    {
        return $this->belongsTo(Product::class,'product_id');
    }

    public function colors()
    {
        return $this->belongsTo(Color::class,'color_id');
    }

    public function sizes()
    {
        return $this->belongsTo(Size::class,'size_id');
    }
}
