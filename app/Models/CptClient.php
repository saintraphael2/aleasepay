<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CptClient extends Model
{
    public $table = 'cpt_client';

    public $fillable = [
        'agence_code',
        'racine',
        'compte',
        'solde',
        'intitule',
        'email',
        'devise_code',
        'devise_libelle',
        'cle'
    ];

    protected $casts = [
        'agence_code' => 'string',
        'racine' => 'string',
        'compte' => 'string',
        'solde' => 'string',
        'intitule' => 'string',
        'email' => 'string',
        'devise_code' => 'string',
        'devise_libelle' => 'string',
        'cle' => 'string'
    ];

    public static array $rules = [
        'agence_code' => 'required|string|max:100',
        'racine' => 'required|string|max:100',
        'compte' => 'required|string|max:100',
        'solde' => 'required|string|max:100',
        'intitule' => 'required|string|max:100',
        'email' => 'required|string|max:100',
        'devise_code' => 'required|string|max:100',
        'devise_libelle' => 'required|string|max:100',
        'cle' => 'nullable|string|max:45',
        'created_at' => 'nullable',
        'updated_at' => 'nullable',
        'deleted_at' => 'nullable'
    ];

    
}
