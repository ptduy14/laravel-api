# Laravel API

An e-commerce API built following REST architectural standards using the Laravel Framework. This project includes features such as user authentication with JWT, OAuth2 authorization, role-based access control, and resource management.

<a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a>

## Introduction

This project is an e-commerce API designed to manage users, products, orders, and authentication. It is built with the Laravel framework, leveraging JWT for secure authentication and OAuth2 for authorization.

Check latest update version here: https://github.com/ptduy14/laravel-api-v2

## Features

- User authentication with JWT
- OAuth2 authorization
- Role-based access control
- Resource management (users, products, orders)
- RESTful API design

## Technologies Used

- Laravel Framework
- JWT-Auth
- PHP
- MySQL

## Requirements

- PHP >= 8.1
- Composer
- MySQL
- Laravel >= 10

## API Endpoints

### Authentication
- Register: `POST /api/auth/register`
- Login: `POST /api/auth/login`
- Logout: `POST /api/auth/logout` (requires `auth:jwt` middleware)

### Users

- Get All Users: `GET /api/users` (requires `role:admin|super-admin` middleware)
- Get User by ID: `GET /api/users/{id}` (requires `role:admin|super-admin` middleware)
- Create User: `POST /api/users` (requires `role:admin|super-admin` middleware)
- Update User: `PUT /api/users/{id}` (requires `auth:jwt` middleware)
- Delete User: `DELETE /api/users/{id}` (requires `role:super-admin` middleware)
- Update User Role: `PUT /api/users/{id}/roles` (requires `role:super-admin` middleware)
- Get User Profile: `GET /api/users/profile` (requires `auth:jwt` middleware)
- Get User Orders: `GET /api/users/{id}/orders` (requires `role:user` middleware)
- Get User Order by `ID: GET /api/users/{id}/orders/{id_order}` (requires `role:user` middleware)
- Create User Order: `POST /api/users/{id}/orders` (requires `role:user` middleware)
- Update User Order Status: `PUT /api/users/{id}/orders/{id_order}` (requires `role:user` middleware)
- Get User Cart: `GET /api/users/{id}/carts`
- Add Product to Cart: `POST /api/users/{id}/carts/products/{id_product}`
- Update Product in Cart: `PUT /api/users/{id}/carts/products/{id_product}`
- Delete Product from Cart: `DELETE /api/users/{id}/carts/products/{id_product}`

### Categories

- Get All Categories: `GET /api/categories`
- Get Category by ID: `GET /api/categories/{id}`
- Create Category: `POST /api/categories` (requires `role:admin|super-admin` middleware)
- Update Category: `PUT /api/categories/{id}` (requires `role:admin|super-admin` middleware)
- Delete Category: `DELETE /api/categories/{id}` (requires `role:admin|super-admin` middleware)
- Get Products of Category: `GET /api/categories/{id}/products`

### Products

- Get All Products: `GET /api/products`
- Get Product by ID: `GET /api/products/{id}`
- Create Product: `POST /api/products` (requires `role:admin|super-admin` middleware)
- Update Product: `PUT /api/products/{id}` (requires `role:admin|super-admin` middleware)
- Delete Product: `DELETE /api/products/{id}` (requires `role:admin|super-admin` middleware)
- Get Product Detail: `GET /api/products/{id}/details`
- Create Product Detail: `POST /api/products/{id}/details` (requires `role:admin|super-admin` middleware)
- Update Product Detail: `PUT /api/products/{id}/details` (requires `role:admin|super-admin` middleware)
- Delete Product Detail: `DELETE /api/products/{id}/details` (requires `role:admin|super-admin` middleware)

### Additional Notes

Middleware:
- `auth:api`: Use Passport for OAuth2 authentication..
- `auth:jwt`:Use JWT for authentication.
- `role`:Check the user's permissions, for example `role:super-admin`, `role:admin|super-admin`, `role:user`
