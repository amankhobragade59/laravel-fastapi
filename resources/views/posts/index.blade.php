@extends('layout.app')

@section('content')
<style>
    h2 {
        text-align: center;
        margin-bottom: 25px;
        color: #1e90ff;
        font-weight: 500;
        letter-spacing: 1px;
    }

    /* Header with Add button */
    .posts-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .add-post-btn {
        padding: 8px 18px;
        background: #28a745;
        color: #fff;
        border-radius: 20px;
        font-size: 14px;
        cursor: pointer;
        border: none;
    }

    .add-post-btn:hover {
        background: #218838;
    }

    #posts-container {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 20px;
    }

    .post-card {
        background: linear-gradient(145deg, #2c2c2c, #242424);
        padding: 16px;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.4);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .post-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 18px rgba(0,0,0,0.6);
    }

    .post-title {
        font-size: 16px;
        font-weight: bold;
        margin-bottom: 10px;
        color: #ffffff;
        border-bottom: 1px solid #444;
        padding-bottom: 6px;
    }

    .post-body {
        font-size: 14px;
        color: #cccccc;
        line-height: 1.6;
        margin-bottom: 14px;
    }

    /* Action buttons */
    .post-actions {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
    }

    .action-btn {
        padding: 6px 12px;
        font-size: 12px;
        border-radius: 14px;
        border: none;
        cursor: pointer;
    }

    .edit-btn {
        background: #208abf;
        color: #000;
    }

    .edit-btn:hover {
        background: #3c6cc5;
    }

    .delete-btn {
        background: #dc3545;
        color: #fff;
    }

    .delete-btn:hover {
        background: #c82333;
    }

    .load-more-container {
        text-align: center;
        margin: 30px 0;
    }

    #load-more {
        min-width: 140px;
        padding: 10px 24px;
        background: #1e90ff;
        color: white;
        border: none;
        border-radius: 20px;
        cursor: pointer;
        font-size: 15px;
    }

    #load-more:disabled {
        background: #555;
        cursor: not-allowed;
    }

    .spinner {
        width: 18px;
        height: 18px;
        border: 3px solid rgba(255,255,255,0.3);
        border-top: 3px solid #fff;
        border-radius: 50%;
        animation: spin 0.8s linear infinite;
        display: inline-block;
    }

    @keyframes spin {
        to { transform: rotate(360deg); }
    }
</style>

<div class="posts-header">
    <h2>Posts</h2>
</div>

<div id="posts-container"></div>
<div id="message" style="text-align:center; margin:20px;"></div>
<div class="load-more-container">
    <button id="load-more">Load More</button>
</div>

<script>
let page = 1;
let isLoading = false;

const container = document.getElementById('posts-container');
const loadMoreBtn = document.getElementById('load-more');
const messageDiv = document.getElementById('message');

async function loadPosts() {
    if (isLoading) return;

    isLoading = true;
    loadMoreBtn.disabled = true;
    loadMoreBtn.innerHTML = '<span class="spinner"></span>';
    messageDiv.innerText = '';

    try {
        const res = await fetch(`/posts/fetch?page=${page}`);

        if (res.status === 204) {
            messageDiv.innerText = 'No more posts available.';
            loadMoreBtn.style.display = 'none';
            return;
        }

        if (!res.ok) throw new Error('Server error');

        const data = await res.json();

        if (data.posts.length === 0) {
            messageDiv.innerText = 'No posts to display.';
            loadMoreBtn.style.display = 'none';
        } else {
            data.posts.forEach(post => {
                const div = document.createElement('div');
                div.className = 'post-card';
                div.innerHTML = `
                    <div>
                        <div class="post-title">${post.title}</div>
                        <div class="post-body">${post.body}</div>
                    </div>
                    <div class="post-actions">
                        <a href="/posts/${post.id}/view" class="action-btn edit-btn">View</a>
                    </div>
                `;
                container.appendChild(div);
            });

            if (!data.hasMore) {
                loadMoreBtn.style.display = 'none';
            } else {
                loadMoreBtn.disabled = false;
                loadMoreBtn.innerText = 'Load More';
            }
        }

        page++;
    } catch (err) {
        console.error(err);
        messageDiv.innerText = 'Error loading posts. Please try again.';
        loadMoreBtn.innerText = 'Retry';
        loadMoreBtn.disabled = false;
    } finally {
        isLoading = false;
    }
}

loadMoreBtn.addEventListener('click', loadPosts);

loadPosts();
</script>

@endsection
