<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Information extends Model
{
    use HasFactory;

    protected $fillable = ['topic_id', 'title', 'content'];

    // Pastikan nama tabel benar
    protected $table = 'informations';

    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }
}
