<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;


class PostService
{
    protected $apiUrl;

    public function __construct()
    {
        $this->apiUrl = config('services.api_url');
    }

    // Fetch all posts
    public function getAllPosts()
    {
        try{
            if (Cache::has('posts')) {
            Log::info("Returning posts from cache");
        }

        return Cache::remember('posts', 3600, function () {
            return Http::get("{$this->apiUrl}/posts")->json();
        });
        } catch (\Exception $e) {
            Log::error('Error in PostService: ' . $e->getMessage());
        }
    }

    // Fetch posts paginated
    public function getPaginatedPosts($page = 1, $perPage = 10)
    {
        $allPosts = $this->getAllPosts();

        $offset = ($page - 1) * $perPage;
        $posts = array_slice($allPosts, $offset, $perPage);

        return [
            'posts' => $posts,
            'hasMore' => $offset + $perPage < count($allPosts),
        ];
    }

    public function getPostById($id)
    {
        $cacheKey = "post_{$id}";

        if (Cache::has($cacheKey)) {
            Log::info("Returning post {$id} from cache");
        }

        return Cache::remember($cacheKey, 3600, function () use ($cacheKey, $id) {
            Log::info("Fetching post {$id} from API"); 
            $response = Http::get("{$this->apiUrl}/posts/{$id}");

            if (!$response->successful()) {
                return null;
            }
            $data = $response->json();
            return $data;
        });
    }
}
