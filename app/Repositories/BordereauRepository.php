<?php

namespace App\Repositories;

use App\Models\Bordereau;
use App\Repositories\BaseRepository;

class BordereauRepository extends BaseRepository
{
    protected $fieldSearchable = [
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

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Bordereau::class;
    }
}
