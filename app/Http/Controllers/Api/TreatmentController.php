<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Libs\Repositories\Contracts\TreatmentRepositoryInterface;
use Illuminate\Http\Request;

class TreatmentController extends Controller
{
    private TreatmentRepositoryInterface $treatmentRepositoryInterface;

    public function __construct(TreatmentRepositoryInterface $treatmentRepositoryInterface)
    {
        $this->treatmentRepositoryInterface = $treatmentRepositoryInterface;
    }

    public function index()
    {
        //
    }


    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }

}
