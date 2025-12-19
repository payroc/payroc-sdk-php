# Setup VS Code Extensions for Payroc SDK Development (Windows PowerShell)
# This script installs the recommended extensions for developing the Payroc PHP SDK

Write-Host "Installing VS Code extensions for Payroc SDK development..." -ForegroundColor Green

# Check if code command is available
$codeExists = Get-Command code -ErrorAction SilentlyContinue
if (-not $codeExists) {
    Write-Host "Error: VS Code command 'code' not found in PATH." -ForegroundColor Red
    Write-Host "Please ensure VS Code is installed and the 'code' command is available." -ForegroundColor Yellow
    Write-Host "You can add it to PATH by opening VS Code and running 'Shell Command: Install code command in PATH' from the command palette." -ForegroundColor Yellow
    exit 1
}

# Install PHP Intelephense extension
Write-Host "Installing PHP Intelephense extension..." -ForegroundColor Cyan
code --install-extension bmewburn.vscode-intelephense-client --force
if ($LASTEXITCODE -eq 0) {
    Write-Host "PHP Intelephense extension installed" -ForegroundColor Green
} else {
    Write-Host "Failed to install PHP Intelephense extension" -ForegroundColor Red
}

# Install PHP Debug extension
Write-Host "Installing PHP Debug extension..." -ForegroundColor Cyan
code --install-extension xdebug.php-debug --force
if ($LASTEXITCODE -eq 0) {
    Write-Host "PHP Debug extension installed" -ForegroundColor Green
} else {
    Write-Host "Failed to install PHP Debug extension" -ForegroundColor Red
}

# Install PHPUnit Test Explorer
Write-Host "Installing PHPUnit Test Explorer..." -ForegroundColor Cyan
code --install-extension recca0120.vscode-phpunit --force
if ($LASTEXITCODE -eq 0) {
    Write-Host "PHPUnit Test Explorer installed" -ForegroundColor Green
} else {
    Write-Host "Failed to install PHPUnit Test Explorer" -ForegroundColor Red
}

Write-Host ""
Write-Host "Extensions installation complete!" -ForegroundColor Green
Write-Host ""
Write-Host "Next steps:" -ForegroundColor Yellow
Write-Host "1. Reload VS Code (Ctrl+Shift+P > Reload Window)" -ForegroundColor White
Write-Host "2. Run tests using the Test Explorer in the sidebar" -ForegroundColor White
Write-Host ""
Write-Host "For more information, see CONTRIBUTING.md" -ForegroundColor White
