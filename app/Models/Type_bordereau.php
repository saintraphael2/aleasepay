<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Type_bordereau extends Model
{
    public $table = 'type_bordereau';

    public $fillable = [
        'libelle'
    ];

    protected $casts = [
        'libelle' => 'string'
    ];

    public static array $rules = [
        'libelle' => 'nullable|string|max:255',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];

    
}
