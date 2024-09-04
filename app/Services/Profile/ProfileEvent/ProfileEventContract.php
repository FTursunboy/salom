<?php

namespace App\Services\Profile\ProfileEvent;

interface ProfileEventContract
{
    public function create(array $data);

    public function update(string $id, array $data);

    public function destroy(string $id);
}
