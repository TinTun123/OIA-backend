<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ProgramPage extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'name_bur',
        'cover_url',
        'description',
        'description_bur',
        'content',
        'content_bur',
        'reason',
        'reason_bur',
        'img_url',
        'quote',
        'quote_bur'
    ];

    public function getCoverUrlAttribute($value)
    {
        if (! $value) {
            return null;
        }

        // Storage::url('programs/xxx.jpg') => '/storage/programs/xxx.jpg'
        // url(...) or asset(...) converts to full URL with APP_URL
        return url(Storage::url($value));
    }

    // Return full public URL for img_url
    public function getImgUrlAttribute($value)
    {
        if (! $value) {
            return null;
        }

        return url(Storage::url($value));
    }
}
