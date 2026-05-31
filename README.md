# PHP MVC Framework

This repository contains a custom PHP 8.3+ MVC framework and a small CRUD application built on top of it. The project demonstrates front-controller routing, PSR-4 autoloading, controller dispatch, a database-backed model layer, server-rendered views, middleware, and form validation without relying on a full third-party framework.

## MVP Overview

The application is structured as a simple content and catalog manager:

- Posts can be created, edited, listed, updated, and deleted.
- Products can be created, edited, listed, updated, and deleted.
- A lightweight login flow establishes a session before protected routes are accessed.
- Validation is handled before persistence so invalid form submissions are re-rendered with errors.

This is intentionally compact, but it still exercises the full request lifecycle expected in the exam rubric: route matching, controller dispatch, dependency injection, model persistence, view rendering, middleware, and form handling.

## Requirements

- PHP 8.3 or higher
- Composer
- MySQL or MariaDB
- XAMPP, Apache, or the PHP built-in server

## Installation

From the project root:

```bash
composer install
composer dump-autoload -o
```

Then import the database schema:

```bash
mysql -u root -p mvc_db < mvc_db.sql
```

## Configuration

Update the project settings before running the app:

- `config/database.php` for database host, database name, username, and password
- `config/app.php` for the app name, timezone, base URL, and view path

The app is base-path aware, so it works both at a domain root and in an XAMPP subfolder such as `/Project/PHPMVCFramework/public`.

## Running Locally

Using the PHP built-in server:

```bash
php -S localhost:8080 -t public
```

Open the app at:

```text
http://localhost:8080
```

If you use Apache/XAMPP, point the document root at the `public` directory. All class loading must go through Composer; `public/index.php` is the only file that manually boots the application.

## Application Design

The request lifecycle starts in `public/index.php`, which loads Composer autoloading, builds shared services, loads route definitions, and hands the incoming request to the router.

### Core Flow

1. `public/index.php` creates the request, router, view engine, database connection, and container.
2. The container shares the connection and view engine with controllers.
3. `routes/web.php` registers application routes and middleware.
4. `Core\Http\Router` resolves the route, injects route parameters, and invokes the controller method.
5. Controllers coordinate the model layer and the view engine.
6. Models use the shared database connection through `Core\Database\Model`.

### Key Design Decisions

- PSR-4 namespaces are split between `Core\\` and `App\\` in `composer.json`.
- The router supports route parameters such as `/posts/{id}/edit` and `/products/{id}/update`.
- Validation is centralized in `Core\Validation\Validator` and reused by each model.
- `Core\Database\Model` provides the common CRUD contract so application models stay thin.
- `Core\View\Engine` keeps template rendering separate from controller logic.
- `Core\Container\Container` resolves dependencies so controllers do not manually construct shared services.
- `APP_BASE_PATH` keeps redirects and URL parsing correct when the app is not hosted at the domain root.

## Routes

The current route set includes authentication, posts, and products.

| Method | Route | Purpose |
| --- | --- | --- |
| GET | `/` | Show the login form |
| GET | `/login` | Show the login form |
| POST | `/login` | Create the demo session login |
| GET | `/posts` | List posts |
| GET | `/posts/create` | Show the create post form |
| POST | `/posts` | Store a new post |
| GET | `/posts/{id}/edit` | Show the edit post form |
| POST | `/posts/{id}/update` | Update an existing post |
| POST | `/posts/{id}/delete` | Delete a post |
| GET | `/products` | List products |
| GET | `/products/create` | Show the create product form |
| POST | `/products` | Store a new product |
| GET | `/products/{id}/edit` | Show the edit product form |
| POST | `/products/{id}/update` | Update an existing product |
| POST | `/products/{id}/delete` | Delete a product |

## Project Structure

```text
app/
config/
core/
public/
routes/
```

## Database Layer

The persistence layer is built on PDO:

- `Core\Database\Connection` wraps PDO and exposes query and execute helpers.
- `Core\Database\Model` provides `all`, `find`, `create`, `update`, `delete`, and `validate`.
- `App\Models\Post` and `App\Models\Product` define table names, fillable fields, and validation rules.

This keeps SQL access behind the model layer instead of spreading raw database calls through controllers.

## Form Handling and Validation

Form submissions are collected from `Core\Http\Request::all()` and validated before any insert or update occurs.

- Invalid data is sent back to the same form.
- Old input is preserved so the user does not lose their work.
- Validation rules are expressed per model, which keeps business rules close to the data they protect.

## Authentication

Authentication is intentionally minimal for the exam MVP. The login action creates a demo session user and redirects into the protected area. `App\Middleware\AuthMiddleware` then guards the protected routes.

## Design Justification

The detailed SOLID reflection is documented in [DESIGN_JUSTIFICATION.md](DESIGN_JUSTIFICATION.md).

## Notes

- Make sure the database exists before running the app.
- Do not commit real database credentials or secrets.
- If you change route files or class namespaces, rerun `composer dump-autoload -o`.

