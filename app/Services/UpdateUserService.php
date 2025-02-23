<?php

namespace App\Services;

use App\Models\User;
use ErrorException;

class UpdateUserService
{
    public function execute(array $data, int $id)
    {
        $userToUpdate = User::firstWhere("id", $id);

        if (is_null($userToUpdate)) {
            throw new ErrorException("User not found.", 404);
        }

        $userToUpdate->update($data);

        return $userToUpdate;
    }
}