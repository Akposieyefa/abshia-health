<?php

namespace App\Libs\Actions;

use App\Models\Treatment;

class TreatmentAction
{
    private Treatment $model;

    public function __construct(Treatment $model)
    {
        $this->model = $model;
    }

}
