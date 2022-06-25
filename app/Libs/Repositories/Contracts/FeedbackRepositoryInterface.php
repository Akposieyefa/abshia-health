<?php

namespace App\Libs\Repositories\Contracts;

interface FeedbackRepositoryInterface
{
    public function createFeedback($request);
    public function getAllFeedbacks();
    public function getSingleFeedback($id);
    public function deleteFeedback($id);
}
