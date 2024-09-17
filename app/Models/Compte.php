<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Compte extends Model
{
    public $table = 'compte';

    public $fillable = [
        'racine',
        'compte',
        'solde',
        'intitule',
        'devise_code',
        'devise_libelle',
        'cle'
    ];

    protected $casts = [
        'racine' => 'string',
        'compte' => 'string',
        'solde' => 'string',
        'intitule' => 'string',
        'devise_code' => 'string',
        'devise_libelle' => 'string',
        'cle' => 'string'
    ];

    public static array $rules = [
        'racine' => 'required|string|max:100',
        'compte' => 'required|string|max:100',
        'solde' => 'required|string|max:100',
        'intitule' => 'required|string|max:100',
        'devise_code' => 'required|string|max:100',
        'devise_libelle' => 'required|string|max:100',
        'cle' => 'nullable|string|max:45',
        'created_at' => 'nullable',
        'updated_at' => 'nullable',
        'deleted_at' => 'nullable'
    ];

    
}
