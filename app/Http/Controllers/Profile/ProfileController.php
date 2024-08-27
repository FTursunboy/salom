<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\User;
use App\Repositories\Event\EventRepositoryContract;
use App\Repositories\User\UserRepositoryContract;
use App\Services\Common\Helpers\Image\ImageFolderHelper;
use App\Services\Common\Image\ImageServiceContract;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;

class ProfileController extends Controller
{
    private ImageServiceContract $imageService;
    private UserRepositoryContract $userRepository;
    private EventRepositoryContract $eventRepository;

    public function __construct(ImageServiceContract $imageService,
                                UserRepositoryContract $userRepository,
                                EventRepositoryContract $eventRepository)
    {
        $this->imageService = $imageService;
        $this->userRepository = $userRepository;
        $this->eventRepository = $eventRepository;
    }

    public function index()
    {
        $user = auth()->user();
        $events = $this->eventRepository->paginateByUserId($user->id);

        return view('profile.index', compact('user', 'events'));
    }

    public function show(User $user)
    {
        $events = $this->eventRepository->paginateByUserId($user->id);

        return view('profile.show', compact('user', 'events'));
    }

    public function setting()
    {
        return view('profile.setting');
    }

    public function update(UpdateUserRequest $request)
    {
        $this->userRepository->update(auth()->user()->id, $request->validated());

        return redirect()->route('profile.index');
    }

    public function uploadPhoto(Request $request)
    {
        $name = Uuid::uuid4();
        $data = $request->get('image');

        $imageArray1 = explode(";", $data);
        $imageArray2 = explode(",", $imageArray1[1]);

        $image = base64_decode($imageArray2[1]);

        $this->imageService->saveImageBase64WithParam(public_path(ImageFolderHelper::USERS_PHOTO_PATH), $image, 256, 256, $name, 'jpg', false);
        $this->userRepository->updatePhoto(auth()->user()->id, $name . '.jpg');

        return $name . '.jpg';
    }

    public function uploadBackgroundImage(Request $request)
    {
        $name = Uuid::uuid4();
        $data = $request->get('image');

        $imageArray1 = explode(";", $data);
        $imageArray2 = explode(",", $imageArray1[1]);

        $image = base64_decode($imageArray2[1]);

        $this->imageService->saveImageBase64WithParam(public_path(ImageFolderHelper::USERS_PHOTO_PATH), $image, 720, 300, $name, 'jpg', false);
        $this->userRepository->updateBackgroundImage(auth()->user()->id, $name . '.jpg');

        return $name . '.jpg';
    }
}
