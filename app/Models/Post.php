<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
     protected $fillable = [
        'title',
        'slug',
        'content',
        'image_path',
        'category_id',
        'published_at',
        'is_published',
    ];

    protected $casts = [
    'image_path' => 'string',
];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
