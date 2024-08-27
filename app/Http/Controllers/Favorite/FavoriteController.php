<?php

namespace App\Http\Controllers\Favorite;

use App\Http\Controllers\Controller;
use App\Models\Event\Event;
use App\Repositories\Favorite\FavoriteRepositoryContract;

class FavoriteController extends Controller
{
    private FavoriteRepositoryContract $favoriteRepository;

    public function __construct(FavoriteRepositoryContract $favoriteRepository)
    {
        $this->favoriteRepository = $favoriteRepository;
    }

    public function index()
    {
        $favorites = $this->favoriteRepository->getAllByUser(auth()->user()->id);

        return view('profile.favorite.index', compact('favorites'));
    }

    public function add(Event $event)
    {
        $this->favoriteRepository->add(auth()->user()->id, $event->id);

        return response()->json();
    }

    public function remove(Event $event)
    {
        $this->favoriteRepository->remove(auth()->user()->id, $event->id);

        return response()->json();
    }
}
