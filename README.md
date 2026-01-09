# Geodata

A Laravel-based REST API that provides comprehensive geographic data including countries, cities, languages, currencies, and more. The application aggregates data from multiple reliable sources like REST Countries API and Geonames to provide up-to-date geographic information for other services and applications.

## Features

### Current Capabilities
- **Country Data**: Comprehensive country information including:
  - ISO codes (CCA2, CCA3, CIOC)
  - Official and common names with translations
  - Geographic coordinates and boundaries
  - Population, area, and demographic data
  - Languages, currencies, and calling codes
  - Timezones and administrative divisions
  - Flag emojis and SVG URLs

- **City Data**: Detailed city information including:
  - Names and translations
  - Geographic coordinates and boundaries
  - Population and elevation
  - Administrative hierarchy (country, state/province, district)
  - External references (Geonames, Wikidata, OpenStreetMap)
  - Timezone information

- **REST API**: Authenticated API endpoints for accessing geodata
- **Admin Panel**: Filament-based admin interface for managing data
- **Data Import**: Automated import from REST Countries API and Geonames
- **Versioning**: Built-in versioning system for tracking data changes

## Technology Stack

- **Framework**: Laravel 12
- **PHP Version**: 8.2+
- **Admin Panel**: Filament 4.0
- **Authentication**: Laravel Sanctum
- **Database**: SQLite (development) / PostgreSQL (production)
- **Frontend**: Vite + Tailwind CSS 4.0 (beta)
- **Container**: Laravel Sail / Docker

## Requirements

- PHP 8.2 or higher
- Composer
- Node.js and npm
- Docker and Docker Compose (for Sail)
- Geonames API account (free registration at https://www.geonames.org/login)

## Installation

### 1. Clone the Repository
```bash
git clone https://github.com/nycofox/geodata.git
cd geodata
```

### 2. Install Dependencies
```bash
composer install
npm install
```

### 3. Environment Setup
```bash
cp .env.example .env
php artisan key:generate
```

### 4. Configure Environment Variables
Edit `.env` file and set:
```env
APP_NAME=Geodata
APP_URL=http://localhost

# Database (SQLite for development)
DB_CONNECTION=sqlite

# Geonames API (register at https://www.geonames.org/login)
GEONAMES_USERNAME=your_username_here
```

### 5. Database Setup
```bash
# Create SQLite database
touch database/database.sqlite

# Run migrations
php artisan migrate
```

### 6. Create Admin User
```bash
php artisan app:create-user
```
Follow the prompts to create an admin user. Save the API token that is generated.

### 7. Import Initial Data
```bash
php artisan app:upsert-countries
```

## Usage

### Development Server

Using Laravel Sail (recommended):
```bash
./vendor/bin/sail up -d
./vendor/bin/sail artisan serve
```

Or using built-in PHP server:
```bash
php artisan serve
npm run dev
```

The application will be available at `http://localhost` (Sail) or `http://localhost:8000` (artisan serve).

### Accessing the Admin Panel
Navigate to `/admin` and login with the user credentials you created.

### Using the API

#### Authentication
All API endpoints require authentication using Laravel Sanctum. Include the API token in the Authorization header:
```bash
Authorization: Bearer YOUR_API_TOKEN
```

#### Available Endpoints

**Get All Countries**
```bash
GET /api/countries
Authorization: Bearer YOUR_API_TOKEN
```

Response:
```json
[
  {
    "id": 1,
    "cca2": "ES",
    "cca3": "ESP",
    "name_common": "Spain",
    "name_official": "Kingdom of Spain",
    "region": "Europe",
    "subregion": "Southern Europe",
    "population": 47351567,
    "area_km2": 505992.0,
    "latitude": 40.0,
    "longitude": -4.0,
    "languages": {...},
    "currencies": {...},
    ...
  }
]
```

**Get Authenticated User**
```bash
GET /api/user
Authorization: Bearer YOUR_API_TOKEN
```

## Data Sources

The application aggregates data from multiple sources:

1. **REST Countries API** (https://restcountries.com)
   - Primary source for country data
   - Provides names, codes, demographics, and general information

2. **Geonames** (https://www.geonames.org)
   - Geographic data and IDs
   - City information and hierarchies

3. **Future integrations planned**:
   - OpenStreetMap for detailed geographic boundaries
   - Wikidata for additional metadata
   - World Bank for economic indicators

## Development

### Running Tests
```bash
php artisan test
```

### Code Formatting
```bash
./vendor/bin/pint
```

### Available Artisan Commands

- `php artisan app:create-user` - Create a new user with API token
- `php artisan app:upsert-countries` - Import/update country data from external sources

## Project Structure

```
app/
├── Console/Commands/      # Artisan commands
├── Filament/             # Admin panel resources
├── Http/Controllers/     # API and web controllers
├── Models/               # Eloquent models
│   └── Geo/             # Geographic models (Country, City)
└── Providers/           # Service providers

database/
├── migrations/          # Database migrations
├── factories/          # Model factories
└── seeders/           # Database seeders

routes/
├── api.php            # API routes
├── web.php            # Web routes
└── console.php        # Console routes

tests/
├── Feature/          # Feature tests
└── Unit/            # Unit tests
```

## API Documentation

Currently, the API provides read-only access to country data. Full API documentation including all endpoints, request/response formats, and authentication details will be available soon.

For detailed API specifications, see the TODO.md file which includes planned endpoints and features.

## Contributing

Contributions are welcome! Please:

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Add tests for new features
5. Submit a pull request

See TODO.md for a list of planned features and improvements.

## Roadmap

- Complete REST API endpoints (cities, languages, currencies)
- Add comprehensive test coverage
- Implement API documentation (OpenAPI/Swagger)
- Add caching and performance optimizations
- Create webhooks for data change notifications
- Add GraphQL API option

See TODO.md for the complete list of planned features.

## License

This project is open-source software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## Support

For issues, questions, or contributions, please use the GitHub issue tracker.

## Credits

Built with:
- [Laravel](https://laravel.com)
- [Filament](https://filamentphp.com)
- [REST Countries API](https://restcountries.com)
- [Geonames](https://www.geonames.org)

