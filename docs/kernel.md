# 🗂️ Careminate Framework — Project Structure & File Tree Guide

This section expands on the core bootstrap documentation by providing a **complete file and folder layout** for the Careminate framework.  
It shows where each component fits and how the framework evolves from a simple bootstrap to a modular architecture.

---

## 🧱 Root Project Structure

```
careminate/
├── app/
│   ├── Exceptions/
│   │   ├── Handler.php
│   │   └── AuthException.php
│   ├── Http/
│   │   ├── Kernel.php
│   │   ├── Controllers/
│   │   │   └── HomeController.php
│   │   └── Middleware/
│   │       └── Authenticate.php
│   ├── Models/
│   │   └── User.php
│   └── Providers/
│       └── AppServiceProvider.php
│
├── bootstrap/
│   ├── app.php
│   └── performance.php
│
├── config/
│   ├── app.php
│   ├── database.php
│   └── logging.php
│
├── public/
│   ├── index.php
│   └── .htaccess
│
├── resources/
│   ├── views/
│   │   └── welcome.caremi.php
│   ├── lang/
│   │   ├── en/
│   │   │   └── messages.php
│   │   └── ar/
│   │       └── messages.php
│   └── assets/
│       └── css/
│           └── app.css
│
├── routes/
│   ├── web.php
│   └── api.php
│
├── storage/
│   ├── cache/
│   ├── logs/
│   │   └── careminate.log
│   ├── sessions/
│   └── views/
│
├── vendor/
│   └── autoload.php
│
├── .env
├── composer.json
├── caremi (CLI tool)
└── README.md
```

---

## 🧩 Folder-by-Folder Breakdown

### **1. `app/`**
Houses the main **application logic** — controllers, models, middleware, and exception handlers.

| Subfolder | Purpose |
|------------|----------|
| `Exceptions/` | Centralized exception management (`Handler`, `AuthException`) |
| `Http/` | Core HTTP kernel, controllers, middleware |
| `Models/` | Eloquent-like ORM models |
| `Providers/` | Service providers for dependency injection and bootstrapping |

---

### **2. `bootstrap/`**
Contains early-stage initialization scripts that prepare the environment before the kernel runs.

| File | Purpose |
|------|----------|
| `app.php` | Loads `.env`, defines constants, autoloads dependencies |
| `performance.php` | Logs execution time, useful for debugging and performance tracking |

---

### **3. `config/`**
Stores all configuration files, allowing environment-specific overrides.

| File | Purpose |
|------|----------|
| `app.php` | Core application settings (timezone, locale, debug mode) |
| `database.php` | Database connection credentials and drivers |
| `logging.php` | Logging channels and handlers |

---

### **4. `public/`**
The **only web-accessible directory**.  
Contains the front controller (`index.php`) and web assets.

| File | Purpose |
|------|----------|
| `index.php` | Main entry point that bootstraps the framework and dispatches requests |
| `.htaccess` | Redirects all traffic through `index.php` (for Apache) |

---

### **5. `resources/`**
Contains **user-facing resources** like views, language files, and static assets.

| Subfolder | Description |
|------------|--------------|
| `views/` | Templates rendered by the Caremi engine |
| `lang/` | Multi-language translations |
| `assets/` | CSS, JS, and images |

---

### **6. `routes/`**
Holds route definitions that map URLs to controllers or closures.

| File | Purpose |
|------|----------|
| `web.php` | Handles browser-based routes (e.g. `/`, `/contact`) |
| `api.php` | Handles RESTful API routes (`/api/users`) |

---

### **7. `storage/`**
Contains **runtime-generated files** — logs, sessions, cache, and compiled views.

| Folder | Purpose |
|---------|----------|
| `logs/` | Application and error logs |
| `sessions/` | File-based session storage |
| `cache/` | Cached configuration or query results |
| `views/` | Compiled view templates for faster rendering |

---

### **8. `vendor/`**
Contains all **Composer-managed dependencies** and the `autoload.php` file.

---

### **9. Root Files**
| File | Description |
|------|--------------|
| `.env` | Environment configuration |
| `composer.json` | Dependency and autoload management |
| `caremi` | Command-line interface (CLI) entry script |
| `README.md` | Project documentation |

---

### **10. Handle Exceptions**
```php
try {
    // app execution
} catch (AuthException $e) {
    (new Handler())->render($request, $e)->send();
} catch (\Throwable $e) {
    (new Handler())->render($request, $e)->send();
}
```

## **11. throw AuthException**
throw new AuthException("Access denied.");

### **12. Careminate\Exceptions\Handler.php — Global Exception Handler**
Features

Centralized handling for all application exceptions

Detects debug mode (APP_DEBUG)

Renders HTML or JSON based on Accept headers

Handles both AuthException and generic errors

Example (Debug Mode ON)
```php 
{
  "error": "RuntimeException",
  "message": "Undefined variable",
  "file": "/path/to/file.php",
  "line": 42,
  "trace": [],
  "status": 500
}
```
## **13.Example (Debug Mode OFF)**
```php 
{
  "error": "Server Error",
  "message": "Something went wrong. Please try again later.",
  "status": 500
}
```

## 🧮 Example Flow Diagram

Below is a simplified flow showing how a request moves through Careminate:

```
Request
  │
  ▼
public/index.php
  │
  ▼
bootstrap/app.php
  │
  ▼
app/Http/Kernel.php
  │
  ▼
routes/web.php
  │
  ▼
Controller Action
  │
  ▼
Response Rendered
  │
  ▼
User's Browser
```

---

## 🧰 CLI Integration — `caremi` Tool

The Careminate CLI tool allows developers to **manage and scaffold** parts of the application efficiently.

### Example Commands
```bash
php caremi make:controller HomeController --resource
php caremi make:model User
php caremi migrate
php caremi app:down
php caremi app:up
```

### Command Categories
| Category | Examples |
|-----------|-----------|
| `make:` | Scaffold files (controllers, models, commands) |
| `app:` | Maintenance commands |
| `view:` | Clear compiled views |
| `cache:` | Manage caches |
| `help` | View command list |

---

## 🔧 Development Workflow Summary

| Step | Command | Description |
|------|----------|--------------|
| 1️⃣ | `composer install` | Installs dependencies |
| 2️⃣ | `cp .env.example .env` | Copies and customizes environment config |
| 3️⃣ | `php -S localhost:8000 -t public` | Starts the local dev server |
| 4️⃣ | `php caremi help` | Lists all available commands |
| 5️⃣ | `php caremi make:controller TestController` | Creates a new controller |

---

## 🌍 Multi-Language Example (`resources/lang/`)

### `resources/lang/en/messages.php`
```php
return [
    'welcome' => 'Welcome to Careminate!',
    'error_401' => 'Unauthorized Access',
];
```

### `resources/lang/ar/messages.php`
```php
return [
    'welcome' => 'مرحبًا بك في كيرمينايت!',
    'error_401' => 'دخول غير مصرح به',
];
```

Usage inside controllers or views:
```php
echo trans('messages.welcome');
```

---

## 🧭 Future Additions Roadmap

| Feature | Description | Status |
|----------|--------------|---------|
| 🧩 Service Providers | Modular loading of services | ✅ Implemented |
| 🔐 Validation System | Custom rules, error bags | ✅ Implemented |
| 🗄️ Database ORM | Fluent query builder with PDO | ✅ Implemented |
| ⚙️ Migrations | Database schema management | ✅ Implemented |
| 🧰 CLI Enhancements | Command discovery and stubs | ✅ Implemented |
| 🧱 Routing System | Resourceful and API routes | ✅ Implemented |
| 🧭 Middleware | Request filtering | 🔜 Planned |
| 📡 Event System | Global event dispatching | 🔜 Planned |
| 🧑‍💻 View Engine | Caremi template syntax | ✅ Implemented |

---

## 🏁 Summary

Careminate’s foundation now includes:

- ✅ Environment management (`.env`)
- ✅ Global exception handling
- ✅ Request/Response lifecycle
- ✅ Modular directory structure
- ✅ CLI and service provider system
- ✅ Expandable bootstrap and kernel
- ✅ Ready-to-extend architecture

---

## 🧾 Conclusion

This structure ensures a scalable, organized, and extensible PHP framework foundation.  
It provides a clear path for future modules such as middleware, routing, ORM, and templating.
