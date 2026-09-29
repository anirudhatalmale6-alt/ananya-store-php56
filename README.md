# Ananya Store — Laravel 5.4 build for PHP 5.6

This is the Ananya e-commerce application migrated to run on **PHP 5.6**, with the
site theme changed to **#FF0000 on a pure white background**.

Everything below was verified by actually running the application on PHP 5.6.40 —
not by inspection.

---

## 1. Laravel version used

**Laravel 5.4.36** (`laravel/framework: 5.4.*`)

Laravel 5.4 is the **last** Laravel release that supports PHP 5.6 — it requires
`php >= 5.6.4`. Laravel 5.5 LTS raised the floor to PHP 7.0 and every release
after that is higher still. So 5.4 is the highest appropriate target for a PHP
5.6 server.

The project was previously on **Laravel 13.16.1** with `"php": "^8.3"`.

## 2. Composer version used

**Composer 2.2.25** (the final release of the Composer **2.2 LTS** line)

Composer 2.2 is the last Composer line that runs on old PHP — it supports PHP
5.3.2+. Composer 2.3 and newer require PHP 7.2.5+. Install it on the production
server with:

```bash
curl -sSL https://getcomposer.org/download/2.2.25/composer.phar -o composer.phar
php composer.phar --version     # Composer version 2.2.25
```

> Composer 2.2 introduced the `allow-plugins` gate. `composer.json` already
> allowlists `kylekatarnls/update-helper` (a Carbon 1 dependency), so
> `composer install` runs without an interactive prompt.

## 3. Final PHP requirement

```
"php": ">=5.6.4"
```

Verified on **PHP 5.6.40**. `composer.json` also pins the resolver platform:

```json
"config": { "platform": { "php": "5.6.40" } }
```

so Composer resolves against PHP 5.6 even if someone runs it on a newer PHP.

**`--ignore-platform-reqs` is not used anywhere.** Every dependency genuinely
supports PHP 5.6.

Required PHP extensions: `openssl`, `pdo`, `pdo_mysql`, `mbstring`, `tokenizer`,
`xml`, `json`.

## 4. Important dependency versions changed

| Package | Was (Laravel 13) | Now (PHP 5.6 build) |
|---|---|---|
| `laravel/framework` | v13.16.1 | **v5.4.36** |
| `symfony/console` | v7.4.13 | **v3.4.47** |
| `symfony/http-foundation` | v7.4.13 | **v3.4.47** |
| `symfony/http-kernel` | v7.4.13 | **v3.4.49** |
| `symfony/routing` | v7.4.x | **v3.4.47** |
| `symfony/translation` | v7.4.x | **v3.4.47** |
| `symfony/finder` / `process` / `var-dumper` / `css-selector` / `event-dispatcher` | v7.4.x | **v3.4.47** |
| `symfony/mailer` | v7.4.12 | **removed** → `swiftmailer/swiftmailer v5.4.12` |
| `symfony/error-handler` | v7.4.8 | **removed** → `symfony/debug v3.4.47` |
| `nesbot/carbon` | 3.13.0 | **1.39.1** |
| `monolog/monolog` | 3.10.0 | **1.27.1** |
| `psr/log` | 3.0.2 | **1.1.4** |
| `ramsey/uuid` | 4.9.3 | **3.9.7** |
| `league/flysystem` | 3.35.0 | **1.0.70** |
| `doctrine/inflector` | 2.1.0 | **v1.1.0** |
| `laravel/tinker` | ^3.0 | **v1.0.10** |
| `vlucas/phpdotenv` | (bundled) | **v2.6.9** |
| `dragonmantank/cron-expression` | v3.6.0 | **mtdowling/cron-expression v1.2.3** |
| `phpunit/phpunit` (dev) | ^12.5 | **5.7.27** |
| `mockery/mockery` (dev) | ^1.6 | **0.9.11** |
| `fakerphp/faker` (dev) | ^1.23 | **fzaninotto/faker v1.9.2** |
| `laravel/breeze` (dev) | ^2.4 | **removed** (see §5) |
| `laravel/pail`, `laravel/pao`, `laravel/pint`, `nunomaduro/collision` | present | **removed** (all require PHP 8) |
| Vite + `@tailwindcss/vite` build | required at runtime | **removed** — CSS is pre-compiled |

Package count went from 77 prod / 34 dev to **36 prod / 28 dev**.

## 5. PHP 5.6 compatibility changes made

### Language-level (PHP 7/8 syntax removed)

| Removed | Replaced with |
|---|---|
| Return types (`: View`, `: bool`, `: array`, `: void`, `: RedirectResponse`) | removed; documented in docblocks |
| Nullable types (`?string`, `?Cart`) | removed; documented in docblocks |
| Scalar type declarations (`string $slug`, `bool $create`) | untyped parameters |
| Null coalescing `??` (42 occurrences in views, plus controllers) | `?:` elvis, explicit `isset()`, or a null guard where the left side dereferences a relation |
| Nullsafe `?->` (`auth()->user()?->isAdmin()`) | explicit null check |
| Arrow functions `fn ($item) => ...` | `foreach` loops / closures |
| Named arguments (`route('x', absolute: false)`) | positional |
| Typed properties | plain properties |
| `\Throwable` | `\Exception` (PHP 5.6 has no `Throwable`) |
| Anonymous migration classes (`return new class extends Migration`) | named classes (`class CreateOrdersTable extends Migration`) |
| `protected function casts(): array` | `protected $casts = array(...)` |
| `Attribute::make(get: fn () => ...)` | `getCurrentPriceAttribute()` accessor |
| `'password' => 'hashed'` cast | `setPasswordAttribute()` mutator on the User model |

### Framework-level (APIs that do not exist in Laravel 5.4)

| Used before | Why it broke | Fix |
|---|---|---|
| `bootstrap/app.php` fluent `Application::configure()` | Laravel 11+ skeleton | Laravel 5.4 skeleton: `app/Http/Kernel.php`, `app/Console/Kernel.php`, `app/Exceptions/Handler.php`, `RouteServiceProvider` |
| `Route::get('/', [Controller::class, 'index'])` | array syntax is Laravel 8+ | `'Controller@index'` strings with the controller namespace set in `RouteServiceProvider` |
| Blade `<x-…>` components (56 usages) | components are Laravel 7+ | auth + profile screens rewritten as plain Blade; shared bits as `@include` partials |
| `@csrf` (21), `@method` (10) | Laravel 5.6+ | `{{ csrf_field() }}`, `{{ method_field('PATCH') }}` |
| `@error … @enderror` (6) | Laravel 6+ | `@if($errors->has('field')) … @endif` |
| `@switch / @case / @default` | Laravel 5.5+ — **and 5.4 *does* compile `@break`**, so a pass-through `@switch` emitted a bare `break;` and fatalled with *"Cannot break/continue 1 level"* | rewritten as `@if / @elseif` |
| `$request->validate([...])` | Laravel 5.5+ | `$this->validate($request, [...])`. Note 5.4's version returns **nothing**, so code that used the return value now reads `$request->only([...])` |
| `$request->filled()` | Laravel 5.5+ | `$request->has()` — in 5.4 `has()` already returns false for empty strings, so it is the exact equivalent |
| `$request->boolean()` | Laravel 5.5+ | `boolInput()` helper on the base controller |
| `$paginator->withQueryString()` | Laravel 8+ | `->appends($request->query())` in the controllers |
| `withSum('orders', 'total')` → `orders_sum_total` | Laravel 8+ | correlated sub-select in `Admin\CustomerController@index` |
| `Str::of($name)->explode(' ')->first()` | Laravel 7+ | `preg_split()` |
| `Str::` facade alias | not aliased until Laravel 9 | alias added to `config/app.php` |
| `'lt:price'` validation rule | Laravel 5.6+ | computed `max:` bound against the submitted price |
| `'current_password'` validation rule | Laravel 8+ | explicit `Hash::check()` |
| `now()` helper | Laravel 5.5+ | `date()` / `Carbon::now()` |
| `HasFactory`, model factories (class-based) | Laravel 8+ | removed; seeding is done by `DatabaseSeeder` |
| Laravel Breeze auth scaffolding | requires Laravel 9+ | rewritten on 5.4's `AuthenticatesUsers` / `RegistersUsers` / `ResetsPasswords` traits (login throttling preserved) |
| Vite (`@vite([...])`) | Laravel 9+ | CSS pre-compiled to `public/css/app.css`; **no Node required on the server** |
| `php artisan migrate:fresh` | Laravel 5.5+ | use `php artisan migrate:refresh --seed` |

### Bugs found and fixed during the migration

These were already broken in the Laravel 13 version and were fixed rather than
carried over:

1. **`admin/customers/{id}` crashed** — the view renders `$totalSpent`, but the
   controller never passed it (`Undefined variable: totalSpent`).
2. **"Total Spent" on the customers list always showed 0.00** — the view reads
   `orders_sum_total`, which requires `withSum()`; the controller only called
   `withCount()`, so the column was always null. Now computed with a sub-select.
3. **`/dashboard` route referenced a `dashboard` route that was never defined.**
4. **The `guest` middleware redirected logged-in users to `/home`**, a route this
   application does not define — a 404. It now sends admins to the Admin
   Dashboard and everyone else to their account dashboard.

### Database

The schema is **unchanged**. `$table->id()` → `bigIncrements('id')` and
`foreignId()->constrained()` → `unsignedBigInteger()` + an explicit
`foreign()->references()` clause produce identical MySQL DDL.

One deliberate change: `Schema::defaultStringLength(191)` in
`AppServiceProvider`. MySQL 5.5/5.6 (the versions that ship alongside PHP 5.6)
cap an index key at 767 bytes = 191 utf8mb4 characters, and Laravel's default
`VARCHAR(255)` overflows that on unique columns. This is the standard Laravel
5.4 fix.

`password_reset_tokens` keeps its name (Laravel 5.4 would normally call it
`password_resets`); `config/auth.php` points at the existing table.

---

## Theme

| Token | Value | Used for |
|---|---|---|
| Primary | `#FF0000` | buttons, links, active menu items, badges, focus rings, borders, branding |
| Background | `#FFFFFF` | every page background |
| Text | `#111111` | body copy |
| Dark neutral | `#111111` | admin sidebar, footer, the storefront values band |

Red is used for actions, highlights, active states and branding — the interface
itself is white with dark text, as specified. The old maroon/gold/cream palette
is gone: `grep -r "maroon\|gold\|cream" resources/views` returns nothing, and
the compiled stylesheet contains no `#5c1616` / `#c19a3d` / `#faf5ec`.

Applied to: header, top bar, navigation, sidebar, buttons, links, active menu
items, cards, forms, tables, badges, modals, alerts, pagination, login,
register, password reset, customer dashboard, admin dashboard, and both
notification email templates.

Theme source of truth: `tailwind.config.js` (`brand` / `ink` / `surface`).

### Rebuilding the CSS (only if you change the design)

Not needed to run the site — `public/css/app.css` is already compiled and
committed.

```bash
npm install
npx tailwindcss -c tailwind.config.js -i resources/css/app.css -o public/css/app.css --minify
```

---

## Email notifications

Order-placed and order-status-change emails go to **both the customer and the
administrator**, sent with PHP's native `mail()` function in
`app/Services/OrderMailer.php`. No SMTP account, no third-party service, no
external package.

Failures are logged, never thrown — a mail problem can never break checkout or
the admin panel.

Set the administrator inbox with `ADMIN_EMAIL` in `.env`.

---

## Installation on the production server

```bash
# 1. Dependencies (Composer 2.2.x on PHP 5.6)
php composer.phar install --no-dev --optimize-autoloader

# 2. Environment
cp .env.example .env
php artisan key:generate
#    then edit .env: DB_*, ADMIN_EMAIL, APP_URL, STORE_CURRENCY

# 3. Database — either import the dump...
mysql -u USER -p YOUR_DB < database/ananya.sql
#    ...or run the migrations
php artisan migrate --force
php artisan db:seed --force

# 4. Writable directories
chmod -R 775 storage bootstrap/cache

# 5. Point the web root at public/
```

`database/ananya.sql` is a real `mysqldump` (MySQL 5.7, utf8mb4) containing all
16 tables, 8 foreign keys and the seed catalogue. It has been test-imported into
a clean database.

### Demo accounts

| Role | Email | Password |
|---|---|---|
| Admin | `admin@ananya.com` | `admin123` |
| Customer | `customer@ananya.com` | `customer123` |

**Change both passwords before going live.**

---

## Verification performed

Run on PHP 5.6.40 + MySQL 5.7.44:

- `composer install` completes with **no** `--ignore-platform-reqs` and no dependency errors
- `php artisan optimize` / `php artisan migrate` / `php artisan db:seed` all run
- All 72 application PHP files pass `php -l` **under PHP 5.6**
- 28/28 end-to-end browser checks pass:
  storefront, shop with category/search/price filters, product detail, add to
  cart, checkout, order placement, order confirmation, customer dashboard,
  order history, profile, logout, admin login redirect, all four admin modules,
  product/category create forms, order status update, customer detail
- Admin login lands on `/admin` (the Admin Dashboard), never the storefront
- A customer hitting `/admin` gets 403
- Computed styles checked in the browser: background `rgb(255,255,255)`,
  primary `rgb(255,0,0)`, body text `rgb(17,17,17)`
- Both notification emails render with every required field
- The `.sql` dump re-imports cleanly into an empty database

## Troubleshooting

### "The only supported ciphers are AES-128-CBC and AES-256-CBC with the correct key lengths."

`APP_KEY` is the wrong length. `config/app.php` uses **AES-256-CBC**, which
needs a **32-byte** key — that is `base64:` followed by **44** base64
characters ending in `=`.

A key like `base64:QGlVleGwHZ1htgltoHPh8Q==` is only 24 base64 characters,
which decodes to **16 bytes**, so Laravel refuses it and every request 500s in
the `EncryptCookies` middleware.

Fix — generate a correct key:

```bash
php artisan key:generate
```

If that is not available (no SSH on shared hosting), use the bundled helper:

```bash
php keygen.php            # prints a valid key
php keygen.php --write    # writes it straight into .env
```

`keygen.php` sizes the key from `config/app.php` so it always matches the
cipher, and uses `openssl_random_pseudo_bytes()` rather than `random_bytes()`.

> **This is the usual cause of a bad key on PHP 5.6.** `random_bytes()` is a
> PHP 7 function. Laravel's own `key:generate` only works on 5.6 because
> Composer autoloads the `paragonie/random_compat` polyfill. A hand-written
> one-liner such as
> `php -r 'echo base64_encode(random_bytes(32));'`
> dies on PHP 5.6 with *"Call to undefined function random_bytes()"* — which is
> why keys often end up being copied from the web at the wrong length.

Quick length check:

```bash
php -r '$k=getenv("APP_KEY"); echo strlen(base64_decode(substr($k,7)))," bytes\n";'
# must print: 32 bytes
```

### Changing .env has no effect

If `bootstrap/cache/config.php` exists, Laravel reads that instead of `.env`.
Delete it, or run `php artisan config:clear`. `keygen.php` warns you when this
file is present.

### Values with special characters in .env

`vlucas/phpdotenv` v2 (the version Laravel 5.4 uses) only expands `${VAR}`
style references, so a bare `$` in a password is safe, and only the **first**
`=` on a line separates key from value — so a password containing `=` is fine
unquoted. A value containing a `#` **must** be quoted, or everything after the
`#` is treated as a comment and silently dropped.

### Serving from a `/public` sub-path

If the site is reached at `https://example.com/public`, the document root is
the Laravel project root rather than `public/`. Laravel still builds correct
URLs (5.4 derives them from the request, not from `APP_URL`), so the site
works — but confirm that `.env`, `composer.json`, `storage/` and `vendor/` are
**not** reachable over the web. Point the document root at `public/` when the
host allows it.

### Before going live

Set `APP_ENV=production` and `APP_DEBUG=false`. With debug on, any error
renders a full stack trace — including configuration values — to the public.

---

## Security note

PHP 5.6 reached end-of-life in **December 2018** and Laravel 5.4 in 2017 —
neither has had a security patch in roughly seven years. This build exists
because PHP 5.6 is the stated production requirement. If the host can offer PHP
7.4 or 8.x, moving to a supported Laravel would be worth doing.
