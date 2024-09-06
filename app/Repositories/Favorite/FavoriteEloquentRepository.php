<?php

namespace App\Repositories\Favorite;

use App\Models\BaseModel;
use App\Models\Favorite\Favorite;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use LaravelIdea\Helper\App\Models\_IH_BaseModel_C;
use LaravelIdea\Helper\App\Models\Favorite\_IH_Favorite_C;
use LaravelIdea\Helper\App\Models\Favorite\_IH_Favorite_QB;

class FavoriteEloquentRepository implements FavoriteRepositoryContract
{
    private Favorite $favorite;

    public function __construct(Favorite $favorite)
    {
        $this->favorite = $favorite;
    }

    public function findByUserAndEvent(string $userId, string $eventId): ?Favorite
    {
        return $this->favorite::query()
            ->where('user_id', $userId)
            ->where('event_id', $eventId)
            ->first();
    }

    public function add(string $userId, string $eventId)
    {
        $favorite = $this->findByUserAndEvent($userId, $eventId);

        if (empty($favorite)) {
            $favorite = $this->favorite::create([
                'user_id' => $userId,
                'event_id' => $eventId,
            ]);
        }

        return $favorite;
    }

    public function remove(string $userId, string $eventId): void
    {
        $favorite = $this->findByUserAndEvent($userId, $eventId);

        if (!empty($favorite)) {
            $favorite->delete();
        }
    }

    public function getAllByUser(string $userId): Collection
    {
        return $this->favorite::query()
            ->where('user_id', $userId)
            ->get();
    }
}
