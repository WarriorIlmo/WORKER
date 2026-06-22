<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

In addition, [Laracasts](https://laracasts.com) contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

You can also watch bite-sized lessons with real-world projects on [Laravel Learn](https://laravel.com/learn), where you will be guided through building a Laravel application from scratch while learning PHP fundamentals.

## Agentic Development

Laravel's predictable structure and conventions make it ideal for AI coding agents like Claude Code, Cursor, and GitHub Copilot. Install [Laravel Boost](https://laravel.com/docs/ai) to supercharge your AI workflow:

```bash
composer require laravel/boost --dev

php artisan boost:install
```

Boost provides your agent 15+ tools and skills that help agents build Laravel applications while following best practices.

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).



============================================================================================
## Frontend Implementation

The frontend is built with:

- __Vite__: For modern frontend development
- __Tailwind CSS__: For styling
- __Alpine.js__: For client-side interactivity
- __SweetAlert2__: For notifications

The main login page (`welcome.blade.php`) provides:

- Mobile-responsive design
- Login and registration forms
- Password visibility toggles
- Form validation and submission

## Usage

1. __Start the development server__

   ```bash
   php artisan serve
   ```

2. __Access the application__

   - Visit `http://localhost:8000` in your browser

3. __Register a user__

   - Fill out the registration form with name, role, email, and password
   - The system will create a new user with the specified role

4. __Login__

   - Select role (Admin or Employee)
   - Enter email and password
   - Click "Login"

## Development Tools

### Backend

- __Composer__: For dependency management
- __Artisan__: Laravel's command-line interface
- __PHPUnit__: For testing (included in dev dependencies)

### Frontend

- __Vite__: Build tool for modern JavaScript
- __Tailwind CSS__: Utility-first CSS framework
- __Alpine.js__: Lightweight JavaScript framework

## Extending the System

To add new features:

1. Create new models and migrations as needed
2. Define routes in `routes/web.php`
3. Create controllers in `app/Http/Controllers/`
4. Add views to `resources/views/`
5. Update the frontend components as needed

## Deployment

For production deployment:

1. Build the frontend assets:

   ```bash
   npm run build
   ```

2. Configure your web server to serve the `public/` directory

3. Ensure proper environment variables are set for production

4. Consider using a production-ready database (MySQL, PostgreSQL, etc.)

## Security Considerations

- Passwords are hashed using Bcrypt (12 rounds by default)
- Input validation is performed on all forms
- CSRF protection is enabled by default
- Input sanitization is handled by Laravel's validation system

## Troubleshooting

Common issues and solutions:

1. __Database connection errors__

   - Ensure the database file exists at `database/database.sqlite`
   - Check `.env` database configuration

2. __Frontend build errors__

   - Run `npm install` to install missing packages
   - Clear Vite cache: `npm run cache:clear`

3. __Authentication issues__

   - Verify that users are being created correctly
   - Check password validation rules

## Future Enhancements

1. Add more features like task management, leave requests, etc.
2. Implement more robust role-based access control
3. Add more frontend features like charts and dashboards
4. Implement email verification and password reset functionality
5. Add more testing and CI/CD pipeline
