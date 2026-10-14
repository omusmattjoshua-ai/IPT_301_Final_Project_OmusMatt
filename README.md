# Medical Laboratory Management System

A Laravel and Bootstrap application for managing laboratory doctors, patients, test catalog entries, lab orders, and results.

## Features

- CRUD screens for doctors, patients, lab tests, lab orders, and lab results
- Dashboard counts and the five newest lab orders
- Lab orders connect a patient and doctor with one or more tests
- Result values are entered from the associated order and cannot be changed for cancelled orders
- Foreign-key protection prevents deleting doctors, patients, or tests used by an order; deleting an order cascades to its results
- Validation, responsive Bootstrap 5 forms and tables, pagination, and delete confirmations
- Realistic factories and seeded sample records

## Database structure

There are exactly five application tables:

1. `doctors`: contact, specialization, unique medical license number, and unique email
2. `patients`: personal and contact information
3. `lab_tests`: test catalog, category, price, normal range, and unit
4. `lab_orders`: patient, doctor, date, status, and remarks
5. `lab_results`: a lab order's test and its result value, date, and remarks; unique per order and test

Doctors and patients each have many lab orders. A lab order belongs to a doctor and patient and has many results. A lab test has many results. The `lab_results` table connects orders and tests. Laravel's built-in framework migrations are also retained and are separate from these five application tables.

## Requirements

- PHP 8.3 or newer
- Composer
- SQLite (included with PHP) or another Laravel-supported database

## Setup

```sh
composer install
```

Copy the example environment file and create an application key:

```sh
copy .env.example .env
php artisan key:generate
```

The example configuration uses SQLite at `database/database.sqlite`. Create an empty file at that path if it does not exist, or set the database variables in `.env` for your database server. Then run:

```sh
php artisan migrate:fresh --seed
php artisan serve
```

Open the local URL shown by Artisan (usually `http://127.0.0.1:8000`). Sample data includes 10 doctors, 30 patients, 15 tests, 40 orders, and at least 80 results.

## Tests

```sh
php artisan test
```
