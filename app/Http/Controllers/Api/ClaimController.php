<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Libs\Repositories\Contracts\ClaimRepositoryInterface;

class ClaimController extends Controller
{
    private ClaimRepositoryInterface $claimRepositoryInterface;

    public function __construct(ClaimRepositoryInterface $claimRepositoryInterface)
    {
        $this->claimRepositoryInterface = $claimRepositoryInterface;
    }
  
    public function index()
    {
        return $this->claimRepositoryInterface->getAllClaim();
    }
  
    public function store(Request $request)
    {
        return $this->claimRepositoryInterface->createClaim($request);
    }
   
    public function show($id)
    {
        return $this->claimRepositoryInterface->getSingleClaim($id);
    }
   
    public function update(Request $request, $id)
    {
        return $this->claimRepositoryInterface->updateClaim($request, $id);
    }

    public function approveRequest($id)
    {
        return $this->claimRepositoryInterface->approveClaim($id);
    }

    public function declineRequest($id)
    {
        return $this->claimRepositoryInterface->declineClaim($id);
    }
  
    public function destroy($id)
    {
        return $this->claimRepositoryInterface->deleteClaim($id);
    }

}
