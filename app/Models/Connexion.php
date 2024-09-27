<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Connexion extends Model
{
    public $table = 'connexion';

    public $fillable = [
        'identifier',
        'validity',
        'valid'
    ];

    protected $casts = [
        'identifier' => 'string',
        'valid' => 'boolean'
    ];

    public static array $rules = [
        'identifier' => 'required|string|max:255',
        'validity' => 'required',
        'valid' => 'required|boolean',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];

    
}
