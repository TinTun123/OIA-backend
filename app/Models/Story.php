<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Story extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'title_bur', 'description', 'description_bur', 'cover_url'];

    public function blocks()
    {
        return $this->hasMany(StoryBlock::class)->orderBy('order');
    }
}
