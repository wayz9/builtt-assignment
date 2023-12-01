
### Requirements

- PHP 8.2 or higher;
- Node.js and NPM, or Bun;
- SQLite3 extension for PHP.

### Installation

- Clone the repository.
- Copy the example environment file to `.env`.

```bash
cp .env.example .env
```

<br>

- Generate the application key.

```bash
php artisan key:generate
```

<br>

- Install Composer dependencies.

```bash
composer install
```

<br>

- Run migrations and seed the database.

```bash
php artisan migrate --seed
```

Default user credentials are:

```
email: test@example.com
password: password
```

<br>

- Build the assets with Vite. First, install dependencies using NPM or Bun, then build.

```bash
npm install
npm run build
# or
bun install
bun run build
```

<br>

- Create a symbolic link for the storage directory.

```bash
php artisan storage:link
```

<br>

- Run the test suite to ensure the application is working correctly.

```bash
php artisan test
```

<br>

- Finally, start the development server and test the application.

```bash
php artisan serve
```
