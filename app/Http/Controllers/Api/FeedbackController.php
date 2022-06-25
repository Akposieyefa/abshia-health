<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Libs\Repositories\Contracts\FeedbackRepositoryInterface;
use Illuminate\Http\Request;

/**
 * Feedback controller
 */
class FeedbackController extends Controller
{
    /**
     * @var FeedbackRepositoryInterface
     */
    private FeedbackRepositoryInterface $feedbackRepositoryInterface;

    /**
     * @param FeedbackRepositoryInterface $feedbackRepositoryInterface
     */
    public function __construct(FeedbackRepositoryInterface $feedbackRepositoryInterface)
    {
        $this->feedbackRepositoryInterface = $feedbackRepositoryInterface;
    }

    /**
     * get all feedback
     * @return mixed
     */
    public function index(): mixed
    {
       return $this->feedbackRepositoryInterface->getAllFeedbacks();
    }

    /**
     * create feedback
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request): mixed
    {
       return $this->feedbackRepositoryInterface->createFeedback($request);
    }

    /**
     * show feedback details
     * @param $id
     * @return mixed
     */
    public function show($id): mixed
    {
       return $this->feedbackRepositoryInterface->getSingleFeedback($id);
    }

    /**
     * delete feedback
     * @param $id
     * @return mixed
     */
    public function destroy($id): mixed
    {
        return $this->feedbackRepositoryInterface->deleteFeedback($id);
    }

}
