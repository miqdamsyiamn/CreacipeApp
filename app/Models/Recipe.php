<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    use HasFactory;

    // Kolom-kolom yang dapat diisi
    protected $fillable = [
        'title',
        'description',
        'ingredients',
        'steps',
        'image',
        'user_id',
        'status_id',
    ];

    // Relasi ke tabel users
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relasi ke tabel status_recipes
    public function status()
    {
        return $this->belongsTo(StatusRecipe::class, 'status_id');
    }
}
