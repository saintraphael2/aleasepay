<?php

namespace App\Repositories;

use App\Models\Type_bordereau;
use App\Repositories\BaseRepository;

class Type_bordereauRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'libelle'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Type_bordereau::class;
    }
}
