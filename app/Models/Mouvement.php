<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mouvement extends Model
{
    public $table = 'mouvements';

    public $fillable = [
        'ECRCPT_NUMCPTE',
        'LOT_DATE',
        'ECRCPT_SENS',
        'ECRCPT_MONTANT',
        'ECRCPT_LIBELLE',
        'ECRCPT_LIBCOMP',
        'ECRCPT_REFER_1'
    ];

    protected $casts = [
        'ECRCPT_NUMCPTE' => 'string',
        'LOT_DATE' => 'date',
        'ECRCPT_SENS' => 'string',
        'ECRCPT_LIBELLE' => 'string',
        'ECRCPT_LIBCOMP' => 'string',
        'ECRCPT_REFER_1' => 'string'
    ];

    public static array $rules = [
        'ECRCPT_NUMCPTE' => 'nullable|string|max:40',
        'LOT_DATE' => 'required',
        'ECRCPT_SENS' => 'nullable|string|max:1',
        'ECRCPT_MONTANT' => 'nullable',
        'ECRCPT_LIBELLE' => 'nullable|string|max:100',
        'ECRCPT_LIBCOMP' => 'nullable|string|max:100',
        'ECRCPT_REFER_1' => 'nullable|string|max:50',
        'created_at' => 'nullable',
        'updated_at' => 'nullable',
        'deleted_at' => 'nullable'
    ];

    
}
