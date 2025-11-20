# Mini Gigs Marketplace API (Laravel 11)

A minimal Laravel 11 REST API for managing gigs in a marketplace-style application.  
It exposes CRUD endpoints for `Gig` resources and demonstrates clean separation of concerns, validation, and pagination.

## Stack

- PHP 8.2+
- Laravel 11
- MySQL
- Laravel Sanctum (installed via `artisan install:api`, but not required for this demo)

---

## Getting Started

### 1. Clone & install

```bash
git clone https://github.com/Awanmabur/gigs-api-clean.git
cd gigs-api-clean

cp .env.example .env   # or copy via your OS
composer install
php artisan key:generate

2. Configure database

Create a database, for example:

CREATE DATABASE gigs_api_clean;

Update .env:

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=gigs_api_clean
DB_USERNAME=root
DB_PASSWORD=

(Adjust credentials/port as needed.)

3. Run migrations
php artisan migrate


This will create the gigs table (plus default Laravel tables).

4. Run the dev server
php artisan serve


API base URL:

http://127.0.0.1:8000/api/gigs

{
    "current_page": 1,
    "data": [
        {
            "id": 3,
            "title": "Logo Design 120",
            "description": "Professional logo design delivered in 3 days.",
            "price": "150.00",
            "category": "Design",
            "seller_id": 1,
            "created_at": "2025-11-19T22:40:16.000000Z",
            "updated_at": "2025-11-20T08:00:53.000000Z"
        },
        {
            "id": 2,
            "title": "letter Head",
            "description": "Professional letter Head delivered in 3 days.",
            "price": "350.00",
            "category": "Design",
            "seller_id": 4,
            "created_at": "2025-11-19T22:19:32.000000Z",
            "updated_at": "2025-11-19T22:19:32.000000Z"
        }
    ],

   }



   Data Model: Gig

gigs table:

id (bigint, PK)

title (string, required)

description (text, nullable)

price (decimal(10,2), required)

category (string, required, indexed)

seller_id (unsigned big integer, required, indexed)

created_at, updated_at

See:

database/migrations/*_create_gigs_table.php

app/Models/Gig.php

Endpoints

All endpoints are prefixed with /api.

List gigs

GET /api/gigs

Query parameters:

category (optional) — filter by category

seller_id (optional) — filter by seller

per_page (optional, default 10) — page size

Example:

curl "http://127.0.0.1:8000/api/gigs?category=Design&per_page=5"


Response (paginated JSON):

{
  "current_page": 1,
  "data": [
    {
      "id": 1,
      "title": "Logo Design",
      "description": "Professional logo design delivered in 3 days.",
      "price": "150.00",
      "category": "Design",
      "seller_id": 1,
      "created_at": "2025-11-19T20:30:00.000000Z",
      "updated_at": "2025-11-19T20:30:00.000000Z"
    }
  ],
  "per_page": 5,
  "total": 1,
  ...
}


Show a single gig

GET /api/gigs/{id}
eg GET /api/gigs/1

curl "http://127.0.0.1:8000/api/gigs/1"

Create a gig

POST /api/gigs

Headers:

Content-Type: application/json

Accept: application/json (optional, but recommended)

Body:

{
  "title": "Logo Design",
  "description": "Professional logo design delivered in 3 days.",
  "price": 150,
  "category": "Design",
  "seller_id": 1
}


Example (curl):

curl -X POST "http://127.0.0.1:8000/api/gigs" \
  -H "Content-Type: application/json" \
  -d '{
    "title": "Logo Design",
    "description": "Professional logo design delivered in 3 days.",
    "price": 150,
    "category": "Design",
    "seller_id": 1
  }'


Returns 201 Created and the created resource.

Update a gig

PUT /api/gigs/{id}
eg PUT /api/gigs/2
Body (any subset of fields):

{
  "price": 175
}

Delete a gig

DELETE /api/gigs/{id}
eg DELETE /api/gigs/2
Returns 204 No Content on success.

Design Notes

Laravel 11 API routing
API routes are defined in routes/api.php and wired via bootstrap/app.php using withRouting(... api: __DIR__.'/../routes/api.php', ...). This ensures they use the api middleware group and are automatically prefixed with /api.

No CSRF for API routes
The API uses the api middleware group only. CSRF protection is left enabled for web routes but is not applied to /api/*, which is the standard Laravel behavior.

Validation
Create/update endpoints share validation rules via a private validateData method in GigController.

Pagination & filtering
The index endpoint supports simple filtering (category, seller_id) and per_page control, returning a standard Laravel paginator JSON structure.

Extensibility
This baseline can be extended with:

Auth (Sanctum) for user-scoped gigs

Policies for per-user access

API Resources for more structured responses

Search / sorting on multiple fields

Running Tests (if you add them)
php artisan test

if you see the output looking like the below output, then you are safe else follow the instructions again

PASS  Tests\Unit\ExampleTest
 ✓ that true is true 0.18s                                                                       
  PASS  Tests\Feature\ExampleTest
 ✓ the application returns a successful response 0.18s                                                                      
 Tests:    2 passed (2 assertions)
 Duration: 3.27s

 
Author

Built by Simon Awan Mabur as part of a senior full-stack developer assessment, demonstrating:

Laravel 11 familiarity (routing, middleware, API setup)

Clean RESTful API design

Practical handling of validation, pagination, and DB modeling
