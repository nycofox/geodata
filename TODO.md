# TODO List

## High Priority

### API Development
- [ ] Complete REST API endpoints for Countries
  - [ ] Implement `show()` method for single country retrieval
  - [ ] Add filtering and sorting capabilities to `index()` endpoint
  - [ ] Implement pagination for country listing
  - [ ] Add search functionality (by name, code, region)
- [ ] Create REST API endpoints for Cities
  - [ ] Index endpoint (list all cities with filtering)
  - [ ] Show endpoint (single city details)
  - [ ] Add relationship loading (country data)
- [ ] Add API versioning (e.g., `/api/v1/countries`)
- [ ] Remove commented code from CountryController

### Authentication & Security
- [ ] Review and improve API authentication strategy
- [ ] Add rate limiting for API endpoints
- [ ] Implement API key management interface
- [ ] Add CORS configuration for external API consumers
- [ ] Review and secure Sanctum token expiration settings

### Testing
- [ ] Create unit tests for models
  - [ ] Country model tests (versioning, relationships)
  - [ ] City model tests (soft deletes, relationships)
- [ ] Create feature tests for API endpoints
  - [ ] Country API tests (index, show)
  - [ ] City API tests
  - [ ] Authentication tests
- [ ] Add integration tests for data import commands
- [ ] Set up test database seeding

### Documentation
- [ ] Create API documentation
  - [ ] Document all endpoints with request/response examples
  - [ ] Add authentication instructions
  - [ ] Include error response formats
  - [ ] Consider using OpenAPI/Swagger specification
- [ ] Add inline code documentation
  - [ ] Document model relationships and attributes
  - [ ] Add PHPDoc blocks for public methods
- [ ] Create CONTRIBUTING.md for contributors

## Medium Priority

### Data Management
- [ ] Implement city data import command
  - [ ] Fetch city data from Geonames
  - [ ] Handle city-country relationships
  - [ ] Update existing city records
- [ ] Add data validation for imports
  - [ ] Validate API responses before saving
  - [ ] Handle API failures gracefully
  - [ ] Add retry logic for failed requests
- [ ] Implement data update scheduling
  - [ ] Set up scheduled tasks for periodic data updates
  - [ ] Add logging for import operations
- [ ] Add support for additional geodata entities
  - [ ] Languages as separate entity
  - [ ] Currencies as separate entity
  - [ ] Timezones normalization

### Admin Panel Enhancements
- [ ] Review Filament resource implementations
- [ ] Add bulk actions for data management
- [ ] Implement data export functionality
- [ ] Add statistics dashboard
- [ ] Create user management interface

### Performance Optimization
- [ ] Add database indexes for frequently queried fields
  - [ ] Country: region, subregion
  - [ ] City: geonames_id, wikidata_id (already indexed)
- [ ] Implement API response caching
- [ ] Optimize eager loading for relationships
- [ ] Add database query logging in development

### Code Quality
- [ ] Run Laravel Pint for code formatting
- [ ] Set up PHPStan or Psalm for static analysis
- [ ] Review and refactor UpsertCountries command
  - [ ] Extract API client logic into separate services
  - [ ] Improve error handling
  - [ ] Add progress logging
- [ ] Implement repository pattern for data access
- [ ] Add service layer for business logic

## Low Priority

### Infrastructure
- [ ] Set up CI/CD pipeline
  - [ ] Add GitHub Actions workflow
  - [ ] Run tests on pull requests
  - [ ] Run code quality checks
- [ ] Add Docker production configuration
- [ ] Create deployment documentation
- [ ] Set up environment-specific configurations

### Features
- [ ] Add country comparison functionality
- [ ] Implement geospatial search (find cities within radius)
- [ ] Add historical data tracking
- [ ] Create data change notifications
- [ ] Add webhook support for data updates

### Monitoring & Logging
- [ ] Implement application monitoring
- [ ] Add structured logging
- [ ] Set up error tracking (e.g., Sentry)
- [ ] Add API usage analytics

### Additional Data Sources
- [ ] Research and integrate additional data sources
  - [ ] OpenStreetMap for city boundaries
  - [ ] Wikidata for additional metadata
  - [ ] World Bank for economic indicators
- [ ] Add data source version tracking
- [ ] Implement data conflict resolution

## Future Considerations
- [ ] Consider GraphQL API as alternative to REST
- [ ] Evaluate need for real-time data updates (WebSockets)
- [ ] Plan for internationalization (i18n) support
- [ ] Consider adding image/media storage for flags and maps
- [ ] Explore machine learning for data quality improvement
