<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Subcategory extends Model
{
    use HasFactory;

    protected $fillable=[
        'category_id',
        'name',
        'slug',
        'status',
    ];

    protected $table='subcategories';


    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }
    //üstü bağlamaq
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
    //altı bağlamaq

    public function products()
    {
        return $this->hasMany(Product::class);
    }

}
