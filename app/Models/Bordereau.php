<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bordereau extends Model
{
    public $table = 'bordereau';

    public $fillable = [
        'client',
        'compte',
        'type',
        'nombre',
        'gestionnaire_traitement',
        'date_traitement',
        'gestionnaire_retrait',
        'date_retrait',
        'libelle',
        'feuillet_deb',
        'feuillet_fin'
    ];

    protected $casts = [
        'compte' => 'string',
        'date_traitement' => 'date',
        'date_retrait' => 'date',
        'libelle' => 'string',
        'feuillet_deb' => 'string',
        'feuillet_fin' => 'string'
    ];

    public static array $rules = [
        'client' => 'nullable',
        'compte' => 'nullable|string|max:12',
        'type' => 'nullable',
        'nombre' => 'nullable',
        'gestionnaire_traitement' => 'nullable',
        'date_traitement' => 'nullable',
        'gestionnaire_retrait' => 'nullable',
        'date_retrait' => 'nullable',
        'libelle' => 'nullable|string|max:255',
        'feuillet_deb' => 'nullable|string|max:45',
        'feuillet_fin' => 'nullable|string|max:45',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];

    public function types(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\Type_bordereau::class, 'type');
    }
}
