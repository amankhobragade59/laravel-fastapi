<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TodoService
{
    protected $apiUrl;

    public function __construct()
    {
        $this->apiUrl = config('services.api_url');
    }

    // Fetch all todos (with caching)
    public function getAllTodos()
    {

        try{
            if(Cache::has('todos')){
            Log::info("Returning todos from cache");
        }
        return Cache::remember('todos', 3600, function () {
            return Http::get("{$this->apiUrl}/todos")->json();
        });
        }catch (\Exception $e) {
            Log::error('Error in Todoservice: ' . $e->getMessage());
        }
    }

    // Get paginated todos
    public function getPaginatedTodos($page = 1, $perPage = 10)
    {
        $allTodos = $this->getAllTodos();
        $offset = ($page - 1) * $perPage;
        $todos = array_slice($allTodos, $offset, $perPage);

        return [
            'todos' => $todos,
            'hasMore' => ($offset + $perPage) < count($allTodos),
        ];
    }
}
