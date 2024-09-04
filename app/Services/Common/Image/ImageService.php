<?php

namespace App\Services\Common\Image;

use Image;
use Spatie\ImageOptimizer\OptimizerChain;

class ImageService implements ImageServiceContract
{

    public function saveImageBase64WithParam(string $path, string $image, float $width, float $height, string $name, string $image_format = 'jpg', bool $thumb = true): void
    {
        if (!\File::exists($path)) {
            \File::makeDirectory($path, 0777, true);
        }

        \File::put($path . $name . '.' . $image_format, $image);

        $image = Image::make($path . $name . '.' . $image_format)->encode('jpg', 75);
        $image->save();

        if ($thumb) {
            $image = Image::make($path . $name . '.' . $image_format);
            $image->crop(450, 300);
            $image->resize(300, 200);
            $image->save($path .  'thumb-' . $name . '.' . $image_format);
        }
    }

    public function delete($path, $filename)
    {
        // TODO: Implement delete() method.
    }
}
