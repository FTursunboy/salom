<?php

namespace App\Repositories\Event;

interface EventRepositoryContract
{
    public function findById(string $id);
    public function paginateByUserId(string $userId, array $data = [], $perPage = 12, array $columns = ['*']);
    public function create(array $data);
    public function update(string $id, array $data);
    public function updateViewCount(string $id);
    public function incrementRegisteredUsers($id);
}
