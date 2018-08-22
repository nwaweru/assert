# asset-manager

Asset Management System

#### Running the application:

1. `git clone https://github.com/nwaweru/asset-manager.git`

2. `cd path/to/your/project`

3. `composer install`

4. (`cp .env.example .env`) Update `.env` with your setup e.g. database, email and sentry.

5. `php artisan migrate:fresh --seed`

6. `npm install`

7. `npm run dev` (or `npm run prod` for production) to generate your assets.

8. `php artisan serve` and explore.