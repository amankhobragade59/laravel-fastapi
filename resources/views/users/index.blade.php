@extends('layout.app')

@section('content')
<style>
    h2 {
        text-align: center;
        color: #1e90ff;
        margin-bottom: 20px;
    }

    .users-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
        gap: 16px;
    }

    .user-card {
        background: #2c2c2c;
        padding: 14px;
        border-radius: 8px;
    }

    .user-card h3 {
        margin: 0 0 6px;
        font-size: 16px;
    }

    .user-card p {
        margin: 0px 0;
        font-size: 13px;
        color: #ccc;
    }

    .load-more-container {
        text-align: center;
        margin-top: 20px;
    }

    #load-more {
        padding: 10px 20px;
        background: #1e90ff;
        color: #fff;
        border: none;
        border-radius: 6px;
        cursor: pointer;
    }

    #load-more:disabled {
        background: #555;
        cursor: not-allowed;
    }
</style>

<h2>Users</h2>

<div class="users-grid" id="users-container"></div>

<div class="load-more-container">
    <button id="load-more">Load More</button>
</div>

<script>
let page = 1;
let isLoading = false;

const btn = document.getElementById('load-more');
const container = document.getElementById('users-container');

function showMessage(message) {
    const div = document.createElement('div');
    div.style.color = '#ffc107';
    div.style.textAlign = 'center';
    div.style.marginTop = '20px';
    div.innerText = message;
    container.appendChild(div);
}

async function loadUsers() {
    if (isLoading) return;

    isLoading = true;
    btn.disabled = true;
    btn.innerText = 'Loading...';

    try {
        const res = await fetch(`/users/fetch?page=${page}`);

        if (res.status === 204) {
            showMessage('No users available.');
            btn.style.display = 'none';
            return;
        }

        if (!res.ok) {
            showMessage('Error fetching users. Please try again.');
            return;
        }

        const data = await res.json();

        if (!data.users || data.users.length === 0) {
            showMessage('No users found.');
            btn.style.display = 'none';
            return;
        }

        data.users.forEach(user => {
    const div = document.createElement('div');
    div.className = 'user-card';

    div.innerHTML = `
        <h3>${user.name} (@${user.username})</h3>
        <p><strong>Email:</strong> ${user.email}</p>
        <p><strong>Phone:</strong> ${user.phone}</p>
        <hr>
        <h4>Address</h4>
        <p>
            ${user.address.street}, ${user.address.suite}<br>
            ${user.address.city} - ${user.address.zipcode}
        </p>
        <hr>
        <h4>Company</h4>
        <p><strong>Name:</strong> ${user.company.name}</p>
        <p><strong>Catch Phrase:</strong> ${user.company.catchPhrase}</p>
        <p><strong>Business:</strong> ${user.company.bs}</p>
    `;

    container.appendChild(div);
});


        if (!data.hasMore) btn.style.display = 'none';
        page++;
    } catch (error) {
        console.error(error);
        showMessage('Failed to fetch users due to network or server error.');
    } finally {
        isLoading = false;
        btn.disabled = false;
        btn.innerText = 'Load More';
    }
}

btn.addEventListener('click', loadUsers);

loadUsers();
</script>

@endsection
