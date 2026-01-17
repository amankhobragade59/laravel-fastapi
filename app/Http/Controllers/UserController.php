<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    // Users page
    public function index()
    {
        return view('users.index');
    }

    // Fetch users for Load More
    public function fetch(Request $request): JsonResponse
    {
        try {
            $page = (int) $request->get('page', 1);
            $data = $this->userService->getPaginatedUsers($page, 6);

            if (empty($data['users'])) {
                return response()->json(['message' => 'No users found'], 204);
            }

            return response()->json($data, 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to fetch users'], 500); 
        }
    }
}
