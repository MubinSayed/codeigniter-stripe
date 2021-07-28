# Codeigniter Stripe Integration (Ajax Call)
Simple Stripe Payment Gateway Integration In Codeigniter

![Payment Page](/screenshot/payment_page.png?raw=true)


### Demo
```
https://codeigniter-stripe.herokuapp.com/
```

### Framework Used
- Codeigniter 3.1.10
- Bootstrap 4

### Setup

- Create Stripe Account and get publishable and secret key.
- Paste the keys in config.php
```php
/*Stripe Config*/
$config['stripe_key'] = 'YOUR_PUBLISHABLE_KEY';
$config['stripe_secret'] = 'YOUR_SECRET_KEY';
```
- Update the application folder directory in .htaccess

```
RewriteEngine On
RewriteBase /APPLICATION_FOLDER_NAME
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ /APPLICATION_FOLDER_NAME/index.php/$1 [L]
<IfModule mod_env.c>
    SetEnv CI_ENV development
</IfModule>
```
- Create database name as `ci_stripe` and import database/ci_stripe.sql in it. 
