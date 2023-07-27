<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    public function __construct(public readonly UserService $userService)
    {
    }

    public function get_all_users(): JsonResponse {
        return response()->json( $this->userService->get_all_users() );
    }
}
