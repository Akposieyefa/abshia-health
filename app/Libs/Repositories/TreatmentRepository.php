<?php

namespace App\Libs\Repositories;

use App\Libs\Repositories\Contracts\TreatmentRepositoryInterface;
use App\Libs\Actions\TreatmentAction;

class TreatmentRepository implements TreatmentRepositoryInterface
{
    private TreatmentAction $action;

    public function __construct(TreatmentAction $action)
    {
        $this->action = $action;
    }

}
