# Laravel Deployment Steps

## Local Deployment

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve
```

## AWS EC2 Deployment Summary

1. Launch Ubuntu EC2 instance.
2. Install PHP, Composer, MySQL, Nginx.
3. Clone GitHub repository.
4. Configure .env.
5. Run migrations.
6. Point Nginx to Laravel public folder.
7. Add SSL with Certbot.
```
