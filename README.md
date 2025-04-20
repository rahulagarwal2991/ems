A Laravel-based RESTful API for managing events, attendees, and event bookings.

## Features
- Event Management (CRUD)
- Attendee Management (CRUD)
- Booking System with Overbooking & Duplicate Protection
- Validations & Error Handling
- Unit and Integration Tests (PHPUnit)
- API Documentation (Postman)

## Setup Instructions
1. Clone the repository
2. Run `composer install`
3. Copy `.env.example` to `.env` and configure DB credentials
4. Run `php artisan key:generate`
5. Run `php artisan migrate`
6. Start the server with `php artisan serve`