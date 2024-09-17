<?php

namespace App\Repositories;

use App\Models\Mouvement;
use App\Repositories\BaseRepository;

class MouvementRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'ECRCPT_NUMCPTE',
        'LOT_DATE',
        'ECRCPT_SENS',
        'ECRCPT_MONTANT',
        'ECRCPT_LIBELLE',
        'ECRCPT_LIBCOMP',
        'ECRCPT_REFER_1'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Mouvement::class;
    }
}
