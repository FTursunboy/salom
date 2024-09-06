<?php

namespace App\Services\Common\Image;

interface ImageServiceContract
{
    public function saveImageBase64WithParam(string $path, string $image, float $width, float $height, string $name, string $image_format = 'jpg', bool $thumb = true);

    public function delete($path, $filename);
}
