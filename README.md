# Online Project Task Management System



## Overview

The Online Project Task Management System is a comprehensive web-based platform designed to streamline project and task management within organizations. It provides a unified login system with role-based access for Admin and Employee users. The application is built on the robust Laravel framework and features a modern, mobile-responsive interface styled with Tailwind CSS.

## Features

### Admin Panel
- **Dashboard:** A central hub for monitoring key metrics, project statuses, and employee activities.
- **Project Management:** Create, update, and manage all projects, including assigning employees, setting deadlines, and defining priority levels.
- **Employee Management:** Add, edit, and view employee profiles, task assignments, and performance metrics.
- **Notifications:** Trigger real-time notifications and email alerts on task assignments and status changes.
- **Reports & Analytics:** Generate visual charts and reports on task completion rates, pending work, and deadlines.

### Employee Panel
- **Dashboard:** A personalized view of assigned projects with project details, progress indicators, and deadlines.
- **Project Information:** Update task progress, add comments, upload supporting files, and log time spent on tasks.
- **Reminders:** Receive alerts for approaching or overdue deadlines.
- **Search & Filter:** Quickly find tasks by project, date, or status.

## Technical Stack

- **Front-End:** HTML, Tailwind CSS, JavaScript (with optional Alpine.js)
- **Back-End:** Laravel (PHP)
- **Database:** MySQL

## Getting Started

### Prerequisites

- PHP >= 8.1
- Composer
- Node.js & npm
- MySQL or MariaDB

### Installation

1.  **Clone the repository:**
    ```bash
    git clone [https://github.com/Codexwarez/tms.git](https://github.com/Codexwarez/tms.git)
    cd tms
    ```

2.  **Install PHP dependencies:**
    ```bash
    composer install
    ```

3.  **Install Node.js dependencies and compile assets:**
    ```bash
    npm install
    npm run dev
    ```

4.  **Configure your `.env` file:**
    -   Copy the example environment file: `cp .env.example .env`
    -   Generate an application key: `php artisan key:generate`
    -   Update the database credentials in the `.env` file.

5.  **Create the MySQL database:**
    ```bash
    mysql -u root -p -e "CREATE DATABASE tms;"
    ```

6.  **Run database migrations and seeders:**
    ```bash
    php artisan migrate --seed
    ```

7.  **Start the local development server:**
    ```bash
    php artisan serve
    ```

The application will be available at `http://127.0.0.1:8000`.

### Default Login Credentials

**Admin**
- **Email:** `admin@example.com`
- **Password:** `password`

**Staff**
- **Email:** `staff@example.com`
- **Password:** `password`

## Contribution

We welcome contributions! Please feel free to open issues or submit pull requests.

## License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details.
