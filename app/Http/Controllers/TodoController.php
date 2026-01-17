<?php

namespace App\Http\Controllers;

use App\Services\TodoService;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    protected $todoService;

    public function __construct(TodoService $todoService)
    {
        $this->todoService = $todoService;
    }

    // Todos page
    public function index()
    {
        return view('todos.index');
    }

    // Fetch todos for Load More
    public function fetch(Request $request)
{
    $page = (int) $request->get('page', 1);

    try {
        $data = $this->todoService->getPaginatedTodos($page, 10);

        if (empty($data['todos'])) {
            return response()->json(['todos' => [], 'hasMore' => false], 204);
        }

        return response()->json($data, 200); 
    } catch (\Exception $e) {
        return response()->json([
            'message' => 'Failed to fetch todos',
        ], 500);
    }
}
}
