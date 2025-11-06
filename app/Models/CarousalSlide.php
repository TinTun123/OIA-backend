<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CarousalSlide extends Model
{
    use HasFactory;

    protected $fillable = [
        'carousal_id',
        'description',
        'description_bur',
        'image_url',
        'sort_order',
    ];

    public function carousal(): BelongsTo
    {
        return $this->belongsTo(Carousal::class);
    }
}
