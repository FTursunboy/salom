<?php

namespace App\Repositories\Favorite;

interface FavoriteRepositoryContract
{
    public function getAllByUser(string $userId);
    public function findByUserAndEvent(string $userId, string $eventId);
    public function add(string $userId, string $eventId);
    public function remove(string $userId, string $eventId);
}
