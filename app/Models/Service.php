<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'title_bur'];

    public function forms()
    {
        return $this->hasMany(ServiceForm::class);
    }
}
