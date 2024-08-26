# Laravel Attendance System

This project is a Laravel-based attendance system designed for general use. It features face recognition, geolocation, and flexible shift management. The system is ideal for organizations needing an efficient way to track attendance, manage schedules, and handle absences.

## Features

- **Face Recognition**: Users can clock in and out using face recognition technology.
- **Geolocation**: Ensures that attendance is recorded only when users are at the specified location.
- **Absence Management**: Users can provide reasons and evidence for absences.
- **User-Friendly Interface**: Built with Filament to provide a clean and intuitive admin panel.

## Tech Stack

- **Laravel 11.x**: The PHP framework used to build the application.
- **Filament 3**: Used for the admin interface and resource management.
- **MySQL 8.0**: The database system used to store all records.
- **Sanctum**: For API authentication.

## Installation

1. **Clone the repository**:
   ```bash
   git clone https://github.com/IlhamGhaza/laravel-attendace.git
   cd laravel-attendace
   ```

2. **Install dependencies**:
   ```bash
   composer install
   npm install
   ```

3. **Copy the `.env.example` file to `.env`**:
   ```bash
   cp .env.example .env
   ```

4. **Generate application key**:
   ```bash
   php artisan key:generate
   ```

5. **Set up your database**:
   - Update the `.env` file with your database credentials.
   - Run migrations and seeders:
     ```bash
     php artisan migrate --seed
     ```

6. **Serve the application**:
   ```bash
   php artisan serve
   ```

## Usage

- **Admin Panel**: Manage shifts, schedules, and attendance records via the Filament interface.
- **Attendance Tracking**: Users can log in via face recognition and geolocation.

## API

This project includes an API built with Laravel Sanctum and Orion for handling CRUD operations.

## Contributing

Contributions are welcome! Please follow the standard GitHub flow:

1. Fork the repository.
2. Create a new branch.
3. Make your changes.
4. Submit a pull request.

## License

This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for details.
[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)


## Contact

For any inquiries, please contact Ilham Ghaza at [Email](cb7ezeur@selenakuyang.anonaddy.com).

