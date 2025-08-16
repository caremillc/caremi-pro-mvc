📘 env.md — Environment Configuration Guide

This document explains the structure, usage, and management of the .env environment file in the Careminate PHP Framework. It also outlines how environment variables are loaded, validated, accessed, and used throughout the framework lifecycle.

# 📁 File Locations
File	                   Purpose
.env	               Main environment config (for development/production)
.env.example	       Template file for sharing across teams
bootstrap/app.php	   Loads and validates .env variables
helpers.php	           Defines global env() accessor

# ⚙️ How Environment Works
✅ 1. Load Environment

In bootstrap/app.php, the framework uses vlucas/phpdotenv to load and parse the .env file:
```php
$dotenv = Dotenv::createImmutable(BASE_PATH);
$dotenv->safeLoad();
```
This loads all variables into the $_ENV and getenv() scope.
✅ 2. Validate Required Variables

To prevent boot failures due to missing .env variables, required keys are enforced:

```php
$requiredKeys = ['APP_NAME', 'APP_ENV', 'APP_KEY', 'DB_HOST', 'DB_DATABASE', 'DB_USERNAME'];
$dotenv->required($requiredKeys)->notEmpty();
```

If any are missing or empty, a fatal error is thrown at bootstrap time.
✅ 3. Access Environment Variables

You should never access $_ENV or getenv() directly. Instead, use the provided helper:
```bash
env('APP_ENV');               // returns string or fallback
env('APP_DEBUG', false);      // returns boolean true/false/null
```
It auto-converts types:
```bash
APP_DEBUG=true     → true (bool)
APP_DEBUG=false    → false (bool)
APP_KEY=null       → null
```
Also supports fallback values:
```php
env('CACHE_DRIVER', 'file');  // returns 'file' if not defined
```
📂 Example .env File
```dotenv
APP_NAME=Careminate
APP_ENV=dev
APP_VERSION=1.0.0
APP_DEBUG=true
ASSET_URL=
APP_KEY=SomeSecureKey123
APP_URL=http://localhost

# Database
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=careminate
DB_USERNAME=root
DB_PASSWORD=

# Security
SESSION_DRIVER=file
SESSION_LIFETIME=120
CACHE_DRIVER=file
QUEUE_CONNECTION=sync

# Mail
MAIL_DRIVER=smtp
MAIL_HOST=mailhog
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
```
✅ Supported Value Types
Value in .env	                 Parsed as
true, (true)	                 true (bool)
false, (false)	                 false (bool)
null, (null)	                 null
empty, (empty)	                 '' (empty string)
'some string'	                 some string
123	                             123 (string unless casted later)

# ⚠️ Common Mistakes
Mistake	Fix
Typo in variable names (e.g. APPN_AME)	Always copy from .env.example
Missing APP_KEY	Generate using CLI or set manually
Boolean checks done as $_ENV['DEBUG'] == true	Use env('APP_DEBUG', false) instead
Accessing $_ENV directly	Use env() helper

# 🛠️ Use Cases
📌 1. Conditional Debug Output
```php
if (env('APP_DEBUG')) {
    echo 'Debug mode is ON';
}
```
📌 2. Use in Config Files
```php
return [
    'name' => env('APP_NAME'),
    'debug' => env('APP_DEBUG', false),
    'version' => env('APP_VERSION', '1.0.0'),
];
```
📌 3. Mail Settings
```php
$mail = new Mailer([
    'driver' => env('MAIL_DRIVER', 'smtp'),
    'host' => env('MAIL_HOST'),
    'port' => env('MAIL_PORT'),
    'username' => env('MAIL_USERNAME'),
    'password' => env('MAIL_PASSWORD'),
]);
```
📌 4. Database Connection
```php
$connection = [
    'host' => env('DB_HOST', 'localhost'),
    'port' => env('DB_PORT', 3306),
    'database' => env('DB_DATABASE'),
    'username' => env('DB_USERNAME'),
    'password' => env('DB_PASSWORD'),
];
```
📌 5. Feature Flagging
```php
if (env('FEATURE_X_ENABLED', false)) {
    // enable feature
}
```
# 🧪 CLI + Environment

For CLI-based tasks (php caremi ...), ensure .env is loaded via bootstrap/*.php.

If creating new CLI commands, include:
```php
$dotenv = Dotenv::createImmutable(BASE_PATH);
$dotenv->safeLoad();
```
# 🧰 Tips for .env.example

    Always update .env.example when new keys are added.

    Set APP_DEBUG=false in the example for safety.

    Never commit your .env file — only .env.example.

# 🚀 Future CLI Support Ideas

You can extend your Caremi CLI with:
```bash
php caremi env:validate
```
Check for missing or empty env keys.
```bash
php caremi env:generate
```
Auto-generate APP_KEY, and optionally update .env.
```bash
php caremi env:backup
```
Backs up .env to .env.backup.YYYYMMDD.

# 📌 Summary
Feature	                 ✅ Implemented
.env file loading	     ✅ via Dotenv::safeLoad()
Required key validation	 ✅ via $dotenv->required()->notEmpty()
Type-safe env() helper	 ✅ using env() in helpers.php
Config file usage	     ✅ via config/app.php
Example file support     ✅ .env.example provided

