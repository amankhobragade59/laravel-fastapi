@extends('layout.app')

@section('content')
<style>
    h2 {
        text-align: center;
        color: #1e90ff;
        margin-bottom: 20px;
    }

    .todo-card {
        background: #2c2c2c;
        padding: 12px;
        border-radius: 6px;
        margin-bottom: 10px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .status {
        font-size: 12px;
        padding: 4px 10px;
        border-radius: 12px;
    }

    .done {
        background: #28a745;
        color: #fff;
    }

    .pending {
        background: #dc3545;
        color: #fff;
    }

    .load-more-container {
        text-align: center;
        margin-top: 20px;
    }

    #load-more {
        padding: 10px 20px;
        background: #1e90ff;
        border: none;
        border-radius: 6px;
        color: #fff;
        cursor: pointer;
    }

    #load-more:disabled {
        background: #555;
        cursor: not-allowed;
    }
</style>

<h2>Todos</h2>

<div id="todos-container"></div>

<div id="status-message" style="text-align:center; margin: 10px; color:#ffc107;"></div>

<div class="load-more-container">
    <button id="load-more">Load More</button>
</div>

<script>
let page = 1;
let isLoading = false;

const btn = document.getElementById('load-more');
const container = document.getElementById('todos-container');
const statusMessage = document.getElementById('status-message');

async function loadTodos() {
    if (isLoading) return;

    isLoading = true;
    btn.disabled = true;
    btn.innerText = 'Loading...';
    statusMessage.innerText = '';

    try {
        const res = await fetch(`/todos/fetch?page=${page}`);

        // Handle empty state
        if (res.status === 204) {
            statusMessage.innerText = 'No todos available.';
            btn.style.display = 'none';
            return;
        }

        // Handle other errors
        if (!res.ok) {
            throw new Error(`HTTP error! status: ${res.status}`);
        }

        const data = await res.json();

        // Render todos
        data.todos.forEach(todo => {
            const div = document.createElement('div');
            div.className = 'todo-card';
            div.innerHTML = `
                <span>${todo.title}</span>
                <span class="status ${todo.completed ? 'done' : 'pending'}">
                    ${todo.completed ? 'Done' : 'Pending'}
                </span>
            `;
            container.appendChild(div);
        });

        if (!data.hasMore) {
            btn.style.display = 'none';
            statusMessage.innerText = 'All todos loaded.';
        }

        page++;

    } catch (e) {
        console.error(e);
        statusMessage.innerText = 'Failed to load todos. Please try again.';
    } finally {
        isLoading = false;
        btn.disabled = false;
        btn.innerText = 'Load More';
    }
}

btn.addEventListener('click', loadTodos);

loadTodos();
</script>

@endsection
