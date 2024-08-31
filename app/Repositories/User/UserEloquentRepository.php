<?php

namespace App\Repositories\User;

use App\Models\User;

class UserEloquentRepository implements UserRepositoryContract
{
    private User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function updatePhoto(string $userId, string $photo): User
    {
        $user = $this->user::find($userId);
        $user->photo = $photo;
        $user->save();

        return $user;
    }

    public function updateBackgroundImage(string $userId, string $image): User
    {
        $user = $this->user::find($userId);
        $user->background_image = $image;
        $user->save();

        return $user;
    }

    public function update(string $userId, array $data): User
    {
        $user = $this->user::find($userId);

        $user->update($data);

        return $user;
    }
}
