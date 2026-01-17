# AI Usage Disclosure
## AI tools used

* **ChatGPT (OpenAI)** was used as an assistance tool during development.

## Where AI was used (files / modules)

AI assistance was used mainly for:

* **Controllers**: `PostController`, `TodoController`, `UserController`
* **Services**: `PostService`, `TodoService`, `UserService`
* **Blade Views**: `posts/index.blade.php`, `posts/view.blade.php`, `todos/index.blade.php`, `users/index.blade.php`, `layouts/app.blade.php`
* **JavaScript logic**: Load-more pagination, loading/error handling
* **Environment & configuration guidance**: `.env`, caching and session setup

## What AI output was accepted

The following AI-generated outputs were accepted with little or no change:

* Basic Laravel controller and service class structure
* Initial caching logic
* Blade template structure for listing posts, todos, and users
* Client-side JavaScript for fetch-based pagination

## What AI output was modified
Several AI suggestions were **modified** to better suit project requirements:

* Replaced database-based caching with **in-memory/file caching** as per assignment rules
* Adjusted pagination logic to support **"load more" instead of Laravel paginator**
* Improved error handling to return **proper HTTP status codes**
* Refined Blade styling to use **pure internal CSS** instead of Tailwind
* Fixed routing issues 

## What AI suggestions were rejected and why

Some AI suggestions were deliberately rejected:

* ❌ Using database tables for cache and sessions (rejected because the assignment required no database storage)
* ❌ Using Vite/Tailwind (rejected due to setup issues and requirement for simple internal CSS)
* ❌ Using `Cache::remember` everywhere 
* ❌ Individual routes for every endpoint 



## Example of improving AI output using own judgment

* Use `Cache::remember()` blindly for all API calls.

**Improvement made:**
* Implemented **manual cache checks with logging**:
  * Logged posts,users,todos data was fetched from cache or API
  * Added custom cache keys per resource (e.g., `post_{id}`)
  * Reduced cache TTL for better demonstration during testing
  * Used JavaScript logic for pagination
