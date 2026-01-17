<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class UserService
{
    protected $apiUrl;

    public function __construct()
    {
        $this->apiUrl = config('services.api_url');
    }

    // Fetch all users asynchronously and cache
    public function getAllUsers(): array
    {
        try{
            if (Cache::has('users')) {
            Log::info("Returning users from cache");
        }

        return Cache::remember('users', 3600, function () {
            return Http::get("{$this->apiUrl}/users")->json();
        });
        } catch (\Exception $e) {
            Log::error('Error in PostService: ' . $e->getMessage());
            return [];
        }
    }

    // Paginate users
    public function getPaginatedUsers(int $page = 1, int $perPage = 6): array
    {
        $allUsers = $this->getAllUsers();

        $offset = ($page - 1) * $perPage;
        $users = array_slice($allUsers, $offset, $perPage);

        return [
            'users' => $users,
            'hasMore' => ($offset + $perPage) < count($allUsers),
        ];
    }
}
