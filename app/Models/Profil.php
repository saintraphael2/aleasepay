<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profil extends Model
{
    public $table = 'profil';
    public $fillable = [
        'libelle',
    ];

    protected $casts = [
        'libelle' => 'string',
    ];

    public static array $rules = [
        'libelle' => 'nullable|string|max:255',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];


    public function users(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\Users::class, 'profil');
    }
}
