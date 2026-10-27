<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SitePage extends Model
{
    protected $fillable = ['slug', 'title', 'content', 'is_published', 'meta_title', 'meta_description'];

    protected function casts(): array
    {
        return ['is_published' => 'boolean'];
    }
}
