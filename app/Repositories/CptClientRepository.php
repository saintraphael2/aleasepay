<?php

namespace App\Repositories;

use App\Models\CptClient;
use App\Repositories\BaseRepository;

class CptClientRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'agence_code',
        'racine',
        'compte',
        'solde',
        'intitule',
        'email',
        'devise_code',
        'devise_libelle'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return CptClient::class;
    }
}
