<?php

namespace App\Http\Controllers;

use App\Services\PostService;
use Illuminate\Http\Request;

class PostController extends Controller
{
    protected $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    // Show posts page
    public function index()
    {
        return view('posts.index');
    }

    // API endpoint for "load more"
    public function fetch(Request $request)
{
    try {
        $page = $request->query('page', 1);
        $data = $this->postService->getPaginatedPosts($page, 10);

        if (empty($data['posts'])) {
            return response()->json(['posts' => [], 'hasMore' => false], 204);
        }

        return response()->json($data, 200);

    } catch (\Exception $e) {
        return response()->json([
            'error' => 'Failed to fetch posts',
            'message' => $e->getMessage()
        ], 500);
    }
}


    // View single post
    public function view($id)
    {
        $post = $this->postService->getPostById($id);

        if (!$post) {
            abort(404, 'Post not found');
        }

        return view('posts.view', compact('post'));
    }
}
