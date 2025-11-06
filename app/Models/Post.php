<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'title_bur',
        'cover_url',
        'content',
        'content_bur',
        'tags',
        'date',
        'images',
        'type',       // ✅ added
        'fbURL'
    ];

    protected $casts = [
        'tags' => 'array',
        'images' => 'array',
        'date' => 'date',
    ];

    protected $appends = ['formatted_date'];

    // public function getCoverUrlAttribute($value)
    // {
    //     if (! $value) {
    //         return null;
    //     }
    //     // Storage::url('programs/xxx.jpg') => '/storage/programs/xxx.jpg'
    //     // url(...) or asset(...) converts to full URL with APP_URL
    //     return asset(Storage::url($value));
    // }

    // // Return full public URL for img_url
    // public function getImagesAttribute($value)
    // {
    //     if (! $value) {
    //         return [];
    //     }

    //     $images = json_decode($value, true);

    //     return collect($images)->map(function ($path) {
    //         return url(Storage::url($path));   // Convert storage path => public URL
    //     })->toArray();
    // }

    public function getFormattedDateAttribute()
    {
        if (!$this->date) {
            return null;
        }

        // Examples: "03 Nov 2025", "5 Sep 2024", etc.
        return Carbon::parse($this->date)->format('d M Y');
    }
}
