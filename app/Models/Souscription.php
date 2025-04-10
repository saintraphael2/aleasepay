<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Souscription extends Model
{
    public $table = 'souscription';
    public $fillable = [
        'client',
        'profil',
        'souscripteur',
        'email',
        'date_souscription',
        'compte_cree'
    ];

    protected $casts = [
        'client'=> 'string',
        'email' => 'string',
        'profil' => 'string',
        'date_souscription' => 'date',
        'compte_cree' => 'string',
    ];

    public static array $rules = [
        'client' => 'required',
        'profil' => 'required',
        'email' => 'nullable|string|max:255',
        'date_souscription' => 'nullable',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];

    public function clients(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\CptClient::class, 'client');
    }

 
}
