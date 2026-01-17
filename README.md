# Laravel Dashboard

## 1. Setup Instructions

### Prerequisites

* PHP >= 8.1
* Composer
* Laravel 10+

### Steps

```bash
# Install PHP dependencies
composer install

# Create environment file
cp .env.example .env

# Generate app key
php artisan key:generate

# Set cache & session drivers (no database required)
CACHE_DRIVER=file
SESSION_DRIVER=file

# Start server
php artisan serve
```

Application will be available at: `http://127.0.0.1:8000`

---

## 2. API Documentation

## 2.1 Sample API Responses (JSON)

### Posts – `/posts/fetch?page=1`

```json
{
  "posts": [
    {
      "userId": 1,
      "id": 1,
      "title": "sunt aut facere repellat provident occaecati",
      "body": "quia et suscipit suscipit recusandae consequuntur"
    }
  ],
  "hasMore": true
}
```

### Single Post – `/posts/{id}/view`

```json
{
  "userId": 1,
  "id": 1,
  "title": "sunt aut facere repellat provident occaecati",
  "body": "quia et suscipit suscipit recusandae consequuntur"
}
```

### Users – `/users/fetch?page=1`

```json
{
  "users": [
    {
      "id": 1,
      "name": "Leanne Graham",
      "email": "leanne@example.com",
      "company": { "name": "Romaguera-Crona" }
    }
  ],
  "hasMore": true
}
```

### Todos – `/todos/fetch?page=1`

```json
{
  "todos": [
    {
      "id": 1,
      "title": "delectus aut autem",
      "completed": false
    }
  ],
  "hasMore": true
}
```

All data is fetched from:

```
https://jsonplaceholder.typicode.com
```

### Posts

| Method | Endpoint            | Description             |
| ------ | ------------------- | ----------------------- |
| GET    | /posts              | Posts dashboard         |
| GET    | /posts/fetch?page=1 | Fetch posts (load more) |
| GET    | /posts/{id}/view    | View single post        |

**Example Response**

```json
{
  "posts": [{ "id": 1, "title": "...", "body": "..." }],
  "hasMore": true
}
```

### Users

| Method | Endpoint            | Description             |
| ------ | ------------------- | ----------------------- |
| GET    | /users              | Users dashboard         |
| GET    | /users/fetch?page=1 | Fetch users (load more) |

### Todos

| Method | Endpoint            | Description             |
| ------ | ------------------- | ----------------------- |
| GET    | /todos              | Todos dashboard         |
| GET    | /todos/fetch?page=1 | Fetch todos (load more) |

---

## 3. Architecture Overview

```
Browser (Blade + JS)
   ↓ fetch()
Laravel Controllers
   ↓
Service Layer
   ↓
JSONPlaceholder API
```

### Key Components

* **Controllers**: Handle HTTP requests & responses
* **Services**: Encapsulate API calls and caching logic
* **Cache Layer**: Laravel Cache (file-based)
* **Views**: Blade templates + vanilla JavaScript

---

## 4. Key Decisions & Trade-offs

### Decisions

* Used **service layer** for clean separation of concerns
* Used **file cache** instead of database (assignment requirement)
* Implemented **Load More** instead of pagination

### Trade-offs

| Decision              | Trade-off                 |
| --------------------- | ------------------------- |
| No DB                 | Data not persistent       |
| File cache            | Not shared across servers |
| Client-side load more | More JS logic             |

---

## 5. Known Limitations

* External API is read-only (no real CRUD)
* Cache clears on server restart
* No authentication or authorization
* No automated tests implemented

---
