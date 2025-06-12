# JSON Schema for PHP

[![tests](https://github.com/asokol1981/json-schema-php/workflows/tests/badge.svg)](https://github.com/asokol1981/json-schema-php/actions) [![codecov](https://codecov.io/gh/asokol1981/json-schema-php/branch/main/graph/badge.svg)](https://codecov.io/gh/asokol1981/json-schema-php) [![downloads](https://img.shields.io/packagist/dt/asokol1981/json-schema-php.svg)](https://packagist.org/packages/asokol1981/json-schema-php)

**json-schema-php** is an object-oriented PHP library for generating [JSON Schema](https://json-schema.org/) documents (Draft-07).

It allows you to programmatically build JSON schemas using a fluent, expressive API — no need to manually write arrays or JSON.

---

## Features

- Full support for JSON Schema Draft-07
- Fluent interface for intuitive schema building
- Support for all schema types:
  - object, array, string, number, integer, boolean, null
  - enum, const, ref, if/then/else, not, allOf, anyOf, oneOf
- Schema composition and nesting
- JSON serialization via toArray() or json_encode()

---

## Installation

### Composer

```bash
composer require asokol1981/json-schema-php
```

### VCS

If the package is not available on Packagist, you can install it by adding the following to your `composer.json`:

```json
{
  "repositories": [
    {
      "type": "vcs",
      "url": "https://github.com/asokol1981/json-schema-php"
    }
  ],
  "require": {
    "asokol1981/json-schema-php": "dev-main"
  }
}
```

Then run:

```bash
composer update
```

⚠️ Make sure your project allows the dev-main version or use a specific tag (e.g. ^1.0) once available.

## Usage

```php
use ASokol1981\JsonSchema\Draft07\ObjectSchema;
use ASokol1981\JsonSchema\Draft07\StringSchema;
use ASokol1981\JsonSchema\Draft07\IntegerSchema;

$schema = (new ObjectSchema([
    'name' => (new StringSchema())->minLength(1),
    'age' => (new IntegerSchema())->minimum(0)
]))->setRequired('name');

echo json_encode($schema, JSON_PRETTY_PRINT);
```

Output:

```json
{
  "type": "object",
  "properties": {
    "name": {
      "type": "string",
      "minLength": 1
    },
    "age": {
      "type": "integer",
      "minimum": 0
    }
  },
  "required": ["name"]
}
```

## Directory Structure

Schemas are organized under the ASokol1981\JsonSchema\Draft07 namespace, including:

- StringSchema
- ObjectSchema
- ArraySchema
- AllOfSchema, AnyOfSchema, NotSchema, RefSchema, etc.

## 🛠️ Makefile Commands

To simplify local development, the following `make` commands are available:

### 📦 Installation

```bash
make install
```

Builds the Docker container, starts it in the background, and installs Composer dependencies.

---

### 🏗️ Build Image

```bash
make build
```

Builds the Docker image with the tag `asokol1981/json-schema-php`.

---

### ▶️ Start Container

```bash
make start
```

Starts the container in detached mode.

---

### ⏹️ Stop Container

```bash
make stop
```

Stops and removes the container (volumes are preserved).

---

### 🧹 Uninstall

```bash
make uninstall
```

Stops and removes the container, associated volumes, and the Docker image.

---

### 🐚 Shell Access

```bash
make exec -- bash
```

Runs a command inside the container.
Be sure to use `--` to separate `make` arguments from the actual command:

```bash
make exec -- php -v
```

---

### 🎼 Composer

```bash
make composer -- require --dev phpunit/phpunit
```

Executes a Composer command inside the container.
Example: install PHPUnit as a dev dependency.

---

### ✅ Run Tests

```bash
make test
```

Runs tests and shows code coverage summary in the terminal.

---

### 📊 HTML Coverage Report

```bash
make coverage
```

Generates a code coverage report in HTML format and saves it in the `coverage/` directory.

---

### 🧱 Artisan

```bash
make artisan -- list
```

Executes an Artisan command inside the container.

---

### 🧹 Code Style Fix

```bash
make php-cs-fixer
```

Runs PHP-CS-Fixer inside the container to automatically fix coding style issues according to the defined `.php-cs-fixer.dist.php` configuration.

---

### ✅ Validate Codecov Configuration

You can validate `codecov.yml` configuration using:

```bash
make codecov-validate
```

This command checks the syntax and structure of the `codecov.yml` file using Codecov’s validation API.
It helps catch errors before pushing changes.

---

**ℹ️ Note:**
When passing arguments to `exec`, `composer`, `artisan`, `test`, or `coverage` targets, **always prefix them with `--`** so `make` doesn't interpret them as its own flags.

## Roadmap

- Support for newer drafts (e.g. 2020-12)

## License

MIT © [asokol1981](https://github.com/asokol1981)
