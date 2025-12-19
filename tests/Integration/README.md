# Integration Tests

This directory contains integration tests that run against the UAT environment.

## Prerequisites

The following environment variables must be set:

- `PAYROC_API_KEY_PAYMENTS` - API key for payment operations
- `PAYROC_API_KEY_GENERIC` - API key for generic operations
- `TERMINAL_ID_AVS` - Terminal ID with AVS enabled
- `TERMINAL_ID_NO_AVS` - Terminal ID without AVS

## Running Integration Tests

To run all integration tests:

```bash
composer test tests/Integration/
```

To run a specific integration test:

```bash
vendor/bin/phpunit tests/Integration/CardPayments/Refunds/CreateTest.php
```

## Test Structure

Integration tests extend `IntegrationTestCase` which provides:
- Pre-configured UAT environment clients
- Environment variable validation
- Shared test fixtures
