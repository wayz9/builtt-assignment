### Requirements

-   PHP 8.2 and above;
-   Node and NPM or (Bun)
-   sqlite3 ext (php)

### Installation

-   Clone repository
-   Copy example enviroment to .env

```bash
cp .env.example .env
```

<br>

-   Generate application key using

```bash
php artisan key:generate
```

<br>

-   Run migrations and seed the database;

```bash
php artisan migrate --seed
```

Default user crendetials are;

```
email: test@example.com
password: password
```

<br>

-   Build the assets with Vite;

```bash
bun run build
```

<br>

-   Run test suite ensure app is working as it should

```bash
php artisan test
```

<br>

-   At last start he development server and test the application

```bash
php artisan serve
```
