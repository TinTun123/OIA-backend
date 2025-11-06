<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoryBlock extends Model
{
    use HasFactory;

    protected $fillable = ['story_id', 'type', 'text', 'text_bur', 'image_url', 'order'];

    public function story()
    {
        return $this->belongsTo(Story::class);
    }
}
