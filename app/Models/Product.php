<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
class Product extends Model
{
    use HasFactory;

    use Sluggable;

    protected $table ='products';

    protected $fillable = [
        'subcategory_id',
        'name',
        'slug',
        'price',
        'description',
        'images',
        'status',
    ];




    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public function category()
    {
        return $this->subcategory->category();
    }

    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class, 'subcategory_id');
    }

    public function isShoe(): bool
    {
        return $this->subcategory && $this->subcategory->name === 'Ayaqqabı';
    }

    public function sizes()
    {
        return $this->belongsToMany(Size::class,'product_size_color', 'product_id', 'size_id')->withPivot('qty');
    }

    public function colors()
    {
        return $this->belongsToMany(Color::class,'product_size_color', 'product_id', 'color_id')->withPivot('qty');
    }

    public function shoes()
    {
        return $this->belongsToMany(Shoe::class,'product_shoe_color', 'product_id', 'color_id')->withPivot('qty');
    }

    public function shopping()
    {
        return $this->belongsTo(Shopping::class);
    }

    public function favorites()
    {
        return $this->hasMany(Favory::class,'product_id');
    }

    public function comments()
    {
        return $this->hasMany(Comments::class,'product_id');
    }



}



