# Repair Cafe Leighton Buzzard

A Laravel-based event management application for the Repair Cafe in Leighton Buzzard. This application helps manage repair events, track items brought in for repair, coordinate volunteer skills, and streamline event operations.

**Live Site:** https://repaircafe.leightonbuzzard.org

## About Repair Cafe

Repair Cafes are free meeting places where people come together to repair items like electronics, clothing, furniture, and more. Volunteers with repair skills help visitors fix broken items, promoting sustainability and community connection.

## Features

- **Event Management** - Create and manage repair cafe events with dates, venues, and capacity
- **Item Tracking** - Track items brought in for repair, their categories, and repair status
- **Volunteer Coordination** - Manage volunteers and their repair skills
- **Venue Management** - Organize multiple venue locations
- **Role-Based Access** - Granular permissions using Spatie Laravel Permission
- **Admin Dashboard** - Filament-powered admin interface for staff
- **Public-Facing Pages** - Livewire Volt components for public event information

## Tech Stack

### Core Framework
- **PHP** 8.4.13
- **Laravel** 12.33.0
- **MySQL** Database

### Frontend
- **Livewire** 3.6.4 - Dynamic interfaces
- **Livewire Volt** 1.7.2 - Single-file components
- **Flux UI** 2.5.1 - UI component library
- **Tailwind CSS** 4.1.11 - Utility-first CSS
- **Vite** 7.0.4 - Asset bundling

### Backend
- **Filament** 4.1.6 - Admin panel
- **Laravel Fortify** 1.31.1 - Authentication
- **Spatie Laravel Permission** 6.21 - Role & permission management

### Development & Testing
- **Pest** 4.1.2 - Testing framework
- **Laravel Pint** 1.25.1 - Code style fixer
- **Laravel Sail** 1.46.0 - Docker development environment
- **Laravel Nightwatch** 1.15.0 - Exception tracking

## Requirements

- PHP 8.2 or higher
- Composer
- Node.js & npm
- MySQL or compatible database
- Web server (Apache/Nginx) or Laravel Herd

## Installation

### Quick Setup

```bash
# Clone the repository
git clone https://github.com/yourusername/repaircafe.leightonbuzzard.org.git
cd repaircafe.leightonbuzzard.org

# Run the setup script
composer setup
```

This will:
- Install PHP dependencies
- Copy `.env.example` to `.env`
- Generate application key
- Run database migrations
- Install and build frontend assets

### Manual Setup

```bash
# Install dependencies
composer install
npm install

# Environment configuration
cp .env.example .env
php artisan key:generate

# Configure your database in .env, then:
php artisan migrate

# Build assets
npm run build
```

### Database Seeding

After running migrations, you can populate the database with test data:

```bash
php artisan db:seed
```

**Important:** To access the admin panel at `/admin`, you'll probably want to grant yourself the `admin` role. You can do this using Laravel Tinker:

```bash
php artisan tinker
>>> $user = \App\Models\User::where('email', 'your@email.com')->first();
>>> $user->assignRole('admin');
```

Or update the database directly to assign the admin role to your user account.

## Development

### Using Laravel Herd (Recommended)

This project is configured for Laravel Herd. After installation, the site will be automatically available at:

```
https://repaircafe.leightonbuzzard.org.test
```

### Using Composer Dev Script

Start all development services (server, queue, and vite) simultaneously:

```bash
composer run dev
```

This runs:
- Laravel development server (port 8000)
- Queue worker
- Vite development server with hot reload

### Manual Development

Alternatively, run services individually:

```bash
# Terminal 1 - Application server
php artisan serve

# Terminal 2 - Asset compilation with hot reload
npm run dev

# Terminal 3 - Queue worker (if needed)
php artisan queue:listen
```

### Using Laravel Sail (Docker)

```bash
# Start containers
sail up -d

# Run migrations
sail artisan migrate

# Build assets
sail npm run dev
```

## Testing

The application uses Pest for testing with comprehensive feature and unit tests.

```bash
# Run all tests
composer run test

# Or directly
php artisan test

# Run specific test file
php artisan test tests/Feature/EventTest.php

# Run tests matching a filter
php artisan test --filter=event
```

### Browser Testing

Pest 4 includes powerful browser testing capabilities for end-to-end testing.

## Code Style

The project uses Laravel Pint for code formatting:

```bash
# Format all files
vendor/bin/pint

# Format only changed files
vendor/bin/pint --dirty

# Check formatting without making changes
vendor/bin/pint --test
```

## Environment Variables

Key environment variables to configure:

```env
APP_NAME="Repair Cafe Leighton Buzzard"
APP_URL=https://repaircafe.leightonbuzzard.org

DB_CONNECTION=mysql
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password

MAIL_MAILER=postmark
MAIL_FROM_ADDRESS=noreply@repaircafe.leightonbuzzard.org
CONTACT_MAIL_ADDRESS=contact@repaircafe.leightonbuzzard.org
```

## Contributing

1. Create a feature branch from `develop`
2. Make your changes following existing code conventions
3. Write tests for new functionality
4. Run `vendor/bin/pint --dirty` to format code
5. Ensure tests pass: `php artisan test`
6. Submit a pull request to `develop`

## Security

If you discover any security issues, please email [rob@leightonbuzzard.org](mailto:rob@leightonbuzzard.org) instead of using the issue tracker.

## License

This project is open-sourced software licensed under the [MIT license](LICENSE).

## Support

For questions or support:
- Website: https://repaircafe.leightonbuzzard.org
- Issues: GitHub Issues
- Community: Repair Cafe Leighton Buzzard

## Acknowledgments

Built with:
- [Laravel](https://laravel.com)
- [Filament](https://filamentphp.com)
- [Livewire](https://livewire.laravel.com)
- [Flux UI](https://fluxui.dev)
- [Tailwind CSS](https://tailwindcss.com)
- [Pest](https://pestphp.com)
