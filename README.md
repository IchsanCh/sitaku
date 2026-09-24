# EXAVRO

EXAVRO is a web-based platform for managing automatic notifications for employees and applicants.

The application provides a centralized interface for managing notification data, users, and related processes. The notification automation itself is handled by a separate service.

## Features

- Employee notification management
- Applicant notification management
- User authentication and authorization
- Notification data management
- Dashboard for monitoring notification activity
- Admin and user management
- Responsive web interface

## Tech Stack

- Laravel
- PHP
- MySQL
- Tailwind CSS
- daisyUI
- Vite

## Architecture

EXAVRO consists of two main parts:

```text
EXAVRO
├── Web Application
│   ├── Frontend
│   └── Backend / API
│
└── Automation Service
    └── Handles scheduled notification delivery
```
