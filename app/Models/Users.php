<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    public $table = 'users';

    public $fillable = [
        'name',
        'email',
        'email_verified_at',
        'password',
        'racine',
        'etat',
        'remember_token',
        'validation_code'
    ];

    protected $casts = [
        'name' => 'string',
        'email' => 'string',
        'email_verified_at' => 'datetime',
        'password' => 'string',
        'racine' => 'string',
        'etat' => 'boolean',
        'remember_token' => 'string'
    ];

    public static array $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|string|max:255',
        'email_verified_at' => 'nullable',
        'password' => 'required|string|max:255',
        'racine' => 'nullable|string|max:6',
        'etat' => 'nullable|boolean',
        'remember_token' => 'nullable|string|max:100',
        'created_at' => 'nullable',
        'updated_at' => 'nullable',
        'validation_code' => 'nullable'
    ];

    
}
