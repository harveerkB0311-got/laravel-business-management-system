# Laravel Business Management System

A recruiter-attractive Laravel SaaS-style project for managing clients, invoices, payments, and dashboard analytics.

## Features
- Client management CRUD
- Invoice management
- Invoice item calculations
- Stripe payment checkout integration
- MySQL database schema
- REST API routes
- Clean MVC architecture

## Tech Stack
- Laravel
- PHP
- MySQL
- Stripe API
- REST APIs

## Setup Commands

```bash
composer create-project laravel/laravel laravel-business-management-system
cd laravel-business-management-system
composer require stripe/stripe-php
```

Copy these files into your Laravel project.

## .env Example

```env
DB_DATABASE=business_management
DB_USERNAME=root
DB_PASSWORD=

STRIPE_KEY=your_stripe_publishable_key
STRIPE_SECRET=your_stripe_secret_key
```

## Run Project

```bash
php artisan migrate
php artisan serve
```

## GitHub Description

Full-stack Laravel SaaS project with client management, invoices, Stripe payments, REST APIs, MySQL database, and dashboard-ready architecture.

