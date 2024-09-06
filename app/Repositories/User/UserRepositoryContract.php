<?php

namespace App\Repositories\User;

interface UserRepositoryContract
{
    public function update(string $userId, array $data);
    public function updatePhoto(string $userId, string $photo);
    public function updateBackgroundImage(string $userId, string $image);
}
