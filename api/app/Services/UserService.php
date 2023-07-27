<?php

namespace App\Services;

use App\Models\User;

use Illuminate\Database\Eloquent\Collection;

class UserService
{

    public function __construct(public readonly User $user)
    {
    }

    public function get_all_users(): Collection {
        return $this->user->select('id', 'name', 'email', 'latitude', 'longitude')->get();
    }
}
