# Design Justification

This document explains how the framework and MVP application demonstrate the SOLID principles and how the major classes support the exam rubric.

## Architecture Summary

The project is organized around a front controller, a custom router, a lightweight container, a base model class, and a view engine. The application layer contains controllers and models for posts and products, while the core layer owns request handling, routing, database access, validation, and rendering.

The result is a small but complete MVC stack:

- `public/index.php` bootstraps the application.
- `Core\Http\Router` resolves routes and dispatches controllers.
- `Core\Container\Container` resolves shared dependencies.
- `Core\Database\Model` centralizes CRUD behavior.
- `Core\Validation\Validator` centralizes rule checking.
- `Core\View\Engine` renders server-side templates.
- `App\Controllers\PostController` and `App\Controllers\ProductController` coordinate requests.
- `App\Models\Post` and `App\Models\Product` define the business-specific data rules.

## Single Responsibility Principle

Each class has one clear reason to change.

- `Core\Http\Router` is responsible only for matching a request path to a controller action and middleware chain. It does not query the database or render templates.
- `Core\View\Engine` is responsible only for loading a view file and passing variables into it.
- `Core\Validation\Validator` is responsible only for checking input against rules and returning validation errors.
- `Core\Database\Connection` is responsible only for preparing and executing PDO statements.
- `Core\Database\Model` is responsible for generic persistence behavior, while `App\Models\Post` and `App\Models\Product` only declare table-specific configuration.
- `App\Controllers\PostController` and `App\Controllers\ProductController` are responsible for orchestrating request flow, not for direct SQL or template parsing.

This separation keeps the codebase easy to reason about. For example, the validation logic can be adjusted in one place without changing every controller, and the rendering logic can evolve without changing database code.

## Open/Closed Principle

The system is open for extension and closed for invasive rewrites.

- New routes can be added in `routes/web.php` by registering an additional controller action.
- New resource types can be created by extending `Core\Database\Model`, just as `App\Models\Post` and `App\Models\Product` do.
- New validation rules can be added inside `Core\Validation\Validator` without changing controller code.
- Middleware can be layered into route registration without changing the router’s public calling convention.

The practical benefit is that the framework can grow from a posts/products MVP into a larger application without rewriting the dispatch or persistence layers.

## Liskov Substitution Principle

The application’s domain models are safe to use anywhere the base model behavior is expected.

- `App\Models\Post` and `App\Models\Product` both extend `Core\Database\Model` and rely on the same CRUD contract.
- Each subclass only supplies the data needed by the base class: table name, fillable fields, and validation rules.
- Controllers can rely on `all`, `find`, `create`, `update`, `delete`, and `validate` without caring which specific model class is injected.

This is a good fit for LSP because substituting one model for another does not break the behavior expected by the controller layer. The shared base implementation keeps the contract consistent.

## Interface Segregation Principle

The framework avoids forcing classes to depend on large, generic APIs.

- `Core\Http\Request` exposes only the methods the router and controllers need: `getPath`, `getMethod`, and `all`.
- `Core\View\Engine` exposes a single rendering responsibility instead of a larger template management surface.
- Middleware classes only need a `handle` method, so they remain small and focused.
- Controllers depend on a narrow set of collaborators: a model and a view engine, not the entire framework internals.

Although the project does not define many formal interfaces, it still follows the spirit of ISP by keeping collaboration surfaces compact. That makes each class easier to test, mock, and replace.

## Dependency Inversion Principle

High-level request flow depends on abstractions and injected services rather than hard-coded construction.

- `public/index.php` creates shared objects once and wires them through the container.
- `Core\Http\Router` asks the container to resolve controller instances instead of instantiating dependencies itself.
- `App\Controllers\PostController` and `App\Controllers\ProductController` receive their dependencies through constructor injection.
- `Core\Database\Model` receives `Core\Database\Connection` through its constructor rather than opening its own database connection.

This inversion matters because it decouples the application flow from concrete object creation. If the view engine, database connection, or controller dependency graph changes later, the bootstrap layer can be updated without rewriting the business logic.

## MVC Separation

The project follows MVC responsibilities in a practical way.

- Models store data rules and CRUD behavior.
- Controllers coordinate validation, persistence, and response selection.
- Views render output and receive plain data arrays.

Examples:

- `App\Controllers\PostController::store()` collects request data, validates it through the model, and chooses whether to re-render the form or redirect.
- `App\Controllers\ProductController::update()` performs the same flow for products.
- `Core\View\Engine::render()` isolates template inclusion from controller branching logic.

This avoids logic leakage into templates and keeps the controllers as orchestration points rather than mixed business and presentation layers.

## Route Handling and Parameter Support

`Core\Http\Router` supports parameterized routes such as `/posts/{id}/edit` and `/products/{id}/delete`.

The router converts route placeholders into named capture groups, extracts route parameters, and passes them into controller methods by argument name. That is important for the rubric because it demonstrates more than static route registration; it shows parameter-aware dispatch.

## Validation and Data Safety

Validation lives in the core layer and is reused by the application models.

- `App\Models\Post` requires `title` and `content`, with a length limit on the title.
- `App\Models\Product` requires `name`, `description`, and a numeric `price`.
- `Core\Database\Model::filterFillable()` prevents accidental mass assignment of fields that should not be written.

The controllers re-render the form with `errors` and `old` input when validation fails. That improves UX and keeps invalid data from reaching the database.

## Base-Path Awareness

The application is designed to work in a subdirectory during local development.

- `public/index.php` defines `APP_BASE_PATH` from the current script path.
- `Core\Http\Request::getPath()` strips the base path before route matching.
- Redirects in controllers use `APP_BASE_PATH` so the app can be hosted under XAMPP or Apache without breaking URLs.

This detail matters because many local PHP projects fail when moved from a domain root to a folder-based deployment. The current setup avoids that problem.

## Why This Is a Strong MVP

The application is deliberately narrow in scope, but it satisfies the grading criteria with concrete behavior:

- More than five routes are implemented.
- Controllers are separate from views and models.
- The router supports route parameters.
- The model layer performs real database interaction.
- Forms are validated before persistence.
- The app is autoloaded via Composer with PSR-4 namespaces for both `Core\\` and `App\\`.

That combination makes the project suitable as an exam submission because it shows working architecture rather than just individual language features.