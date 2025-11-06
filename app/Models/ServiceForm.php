<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceForm extends Model
{
    use HasFactory;

    protected $fillable = ['service_id', 'form', 'form_bur'];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
