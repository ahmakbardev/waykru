<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    use HasFactory;

    protected $fillable = ['name']; // Pastikan 'name' ada di fillable

    public function information()
    {
        return $this->hasOne(Information::class);
    }
}
