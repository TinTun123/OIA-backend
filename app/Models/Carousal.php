<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carousal extends Model
{
    use HasFactory;

    protected $fillable = ['page'];

    public function slides()
    {
        return $this->hasMany(CarousalSlide::class)->orderBy('sort_order');
    }
}
