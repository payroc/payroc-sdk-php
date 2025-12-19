# Contributing to Payroc PHP SDK

## Getting Started

### Prerequisites

To build and test this source code, you'll need:

- **PHP 8.1 or higher** - [Download](https://www.php.net/downloads)
- **Composer** - [Install](https://getcomposer.org/download/) (PHP package manager)
- **Git** - [Download](https://git-scm.com/)
- A code editor or IDE (e.g., Visual Studio Code, PhpStorm, or Sublime Text)

### Installation

Clone the repository and install dependencies:

```bash
git clone https://github.com/payroc/payroc-sdk-php.git
cd payroc-sdk-php
composer install
```

### Building

Validate the PHP syntax for source and test files:

```bash
composer build
```

This runs PHP linting on both `src/` and `tests/` directories.

### Project Structure

- `src/` - Main SDK source code
- `tests/` - Test files
- `wiremock/` - Mock server setup for testing

## Testing

### Prerequisites for Running Tests in VS Code

To run and debug tests directly in VS Code, install the following extensions:

- **[PHP Intelephense](https://marketplace.visualstudio.com/items?itemName=bmewburn.vscode-intelephense-client)** - PHP language support and IntelliSense
- **[PHP Debug](https://marketplace.visualstudio.com/items?itemName=xdebug.php-debug)** - Debug support for PHP with Xdebug
- **[PHPUnit Test Explorer](https://marketplace.visualstudio.com/items?itemName=recca0120.vscode-phpunit)** - Integrated test explorer for PHPUnit

#### Quick Setup

We've provided setup scripts to automatically install these extensions. Choose the appropriate script for your operating system:

**Windows (PowerShell):**
```powershell
.\scripts\vscode\setup-extensions.ps1
```

**macOS/Linux (Bash):**
```bash
bash scripts/vscode/setup-extensions.sh
```

After running the script, reload VS Code (`Ctrl+Shift+P` > `Reload Window`) to activate the extensions.

### Test Framework

This project uses **PHPUnit** as the testing framework, with the following test runners and utilities:

- **PHPUnit ^9.0** - Unit testing framework
- **php-cs-fixer 3.5.0** - Code style fixing
- **PHPStan ^1.12** - Static analysis tool

### Running Tests

Execute all tests:

```bash
composer test
```

Or directly with PHPUnit:

```bash
vendor/bin/phpunit
```

### Test Configuration

Tests are configured in `phpunit.xml` with the following setup:

- Bootstrap: `vendor/autoload.php`
- Test Suite: Files matching `*Test.php` in the `tests/` directory

## Code Quality

### Static Analysis

Run PHPStan for static code analysis:

```bash
composer analyze
```

This scans both `src/` and `tests/` directories for type errors and potential issues.

### Code Style

Fix code style issues using php-cs-fixer:

```bash
vendor/bin/php-cs-fixer fix src/
vendor/bin/php-cs-fixer fix tests/
```

Check code style without making changes:

```bash
vendor/bin/php-cs-fixer fix --dry-run src/
vendor/bin/php-cs-fixer fix --dry-run tests/
```

## Troubleshooting

### PHPUnit Installation Issues

If you encounter the error `'phpunit' is not recognized` or see messages about the zip extension being missing, you may need to enable the PHP zip extension.

**On Windows (with PHP installed via Chocolatey):**

1. Locate your `php.ini` file:
   ```bash
   php --ini
   ```
   
2. Open the `php.ini` file and find the line containing `;extension=zip`

3. Uncomment it by removing the semicolon:
   ```ini
   extension=zip
   ```

4. Save the file and verify the extension is loaded:
   ```bash
   php -m | findstr zip
   ```
   
   You should see `zip` in the output.

5. Run `composer install` again to download and install all dependencies:
   ```bash
   composer install
   ```

**On macOS/Linux:**

If using Homebrew, ensure PHP is installed with the zip extension:
```bash
brew install php
php -m | grep zip
