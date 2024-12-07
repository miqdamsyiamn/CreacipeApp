<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusRecipe extends Model
{
    use HasFactory;

    // Kolom yang dapat diisi
    protected $fillable = ['name'];

    // Relasi ke tabel recipes
    public function recipes()
    {
        return $this->hasMany(Recipe::class, 'status_id');
    }
}
