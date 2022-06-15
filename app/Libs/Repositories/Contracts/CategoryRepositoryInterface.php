<?php

namespace App\Libs\Repositories\Contracts;

interface CategoryRepositoryInterface
{
        public function createCategory($request);
        public function getSingleCategory($id);
        public function getAllCategory();
        public function updateCategory($request, $id);
        public function deleteCategory($id);
}
