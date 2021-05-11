## Installations

- Create new `.env` based on `.env.example`
- Comment codes within `boot()` from `App\Providers\PermissionsServiceProvider`
- Run `composer install`
- Run `npm i` or `yarn`
- Run `php artisan key:generate`
- Run `php artisan serve`
- Run `npm run watch` or `yarn watch`
- Run `php artisan storage:link` to create a symbolic link if files within storage directory not showing up.

## Socialite

This project comes with GitHub as an example for [Laravel Socialite](https://laravel.com/docs/8.x/socialite).

To enable the provider create a new GitHub application and use `https://example.com/api/oauth/github/callback` as the Authorization callback URL.

Edit `.env` and set `GITHUB_CLIENT_ID` and `GITHUB_CLIENT_SECRET` with the keys form your GitHub application.

For other providers you may need to set the appropriate keys in `config/services.php` and redirect url in `OAuthController.php`.

## Migrations

- Roles must be migrated first
  * Run `php artisan migrate --path=database\migrations\roles`
- Then run the other migration
  * Run `php artisan migrate --path=database\migrations\users`
- Then run `php artisan migrate --seed`
- To remove all relate users migration
    * Run `php artisan migrate:rollback --path=database\migrations\user
      `
- To remove all relate roles migration
    * Run `php artisan migrate:rollback --path=database\migrations\roles`    

## Important

- For generate model magic `php artisan ide-helper:models "App\Models\Post"`
