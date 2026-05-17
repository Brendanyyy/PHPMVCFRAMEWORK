## PHP MVC Framework

A lightweight PHP MVC project with a custom router, controller layer, simple DI container, PDO-based database access, and PHP view templates.

### Features

- MVC-style structure with `app`, `core`, `config`, `routes`, and `public`
- Custom router with route parameters like `/posts/{id}/edit`
- Simple dependency container for resolving controllers and shared services
- PDO database connection and query builder
- Server-rendered views for post management

### Requirements

- PHP 8.1+ recommended
- Composer
- MySQL or MariaDB
- XAMPP or another local PHP server

### Installation

Clone the repository, then install dependencies from the project root:

```bash
composer install
composer dump-autoload -o
```

### Configuration

Update the database settings in `config/database.php`:

- `host`
- `database`
- `username`
- `password`

Also check `config/app.php` for:

- `base_url`
- `timezone`
- `view_path`

### Running the project

You can run the app with the PHP built-in server:

```bash
php -S localhost:8080 -t public
```

Then open:

```text
http://localhost:8080
```

If you are using XAMPP/Apache, point the document root to the `public` directory or visit the project through your local Apache setup.

### Routes

Available routes currently include:

- `GET /login`
- `POST /login`
- `GET /posts`
- `GET /posts/create`
- `POST /posts`
- `GET /posts/{id}/edit`
- `POST /posts/{id}/update`
- `POST /posts/{id}/delete`

### Project Structure

```text
app/
config/
core/
public/
routes/
```

### Notes

- Make sure the database exists before running the app.
- The current auth flow is minimal and intended for local development.
- Do not commit real database credentials or secrets.

### Contributing

1. Create a branch
2. Make your changes
3. Run `composer dump-autoload -o`
4. Test the app locally
5. Open a pull request

