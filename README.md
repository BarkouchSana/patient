# Healthcare Platform

## Overview

comprehensive healthcare platform that connects patients with healthcare providers. The application offers user profiles, appointment management, medical record access, and more in a modern, user-friendly interface.

## Table of Contents

1. [Getting Started](#getting-started)
   - [Prerequisites](#prerequisites)
   - [Installation](#installation)
   - [Environment Configuration](#environment-configuration)
2. [Backend API Documentation](#backend-api-documentation)
   - [Authentication Endpoints](#authentication-endpoints)
   - [Patient Endpoints](#patient-endpoints)
   - [Profile Management Endpoints](#profile-management-endpoints)
3. [Frontend Documentation](#frontend-documentation)
   - [Key Features](#key-features)
   - [Component Structure](#component-structure)
4. [Development Guidelines](#development-guidelines)
5. [Testing](#testing)
6. [Future Improvements](#future-improvements)

## Getting Started

### Prerequisites

- PHP 8.1 or higher
- Composer
- Node.js 16+ and npm
- MySQL/MariaDB
- Web server (Apache/Nginx)

### Installation

#### Backend (Laravel)

1. Clone the repository
   ```bash
   git clone https://github.com/yourusername/sanaa.git
   cd sanaa/patient/laravel-backend
   ```

2. Install dependencies
   ```bash
   composer install
   ```

3. Create a copy of the environment file and generate an application key
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. Configure your database connection in the `.env` file
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=sanaa
   DB_USERNAME=root
   DB_PASSWORD=your_password
   ```

5. Run migrations and seed the database
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

6. Start the development server
   ```bash
   php artisan serve
   ```

#### Frontend (Angular)

1. Navigate to the frontend directory
   ```bash
   cd ../angular-frontend
   ```

2. Install dependencies
   ```bash
   npm install
   ```

3. Configure the environment files in `src/environments/` to point to your backend URL

4. Start the development server
   ```bash
   ng serve
   ```

5. Access the application at `http://localhost:4200`

### Environment Configuration

The backend requires the following environment variables:

```
APP_URL=http://localhost:8000
FRONTEND_URL=http://localhost:4200
JWT_SECRET=your_jwt_secret_key
JWT_TTL=60 # JWT token time-to-live in minutes
```

## Backend API Documentation

### Authentication Endpoints

#### Register a new user

```
POST /api/auth/register
```

Request body:
```json
{
  "name": "John Doe",
  "email": "john@example.com",
  "password": "securepassword",
  "password_confirmation": "securepassword"
}
```

Response:
```json
{
  "status": "success",
  "message": "User registered successfully",
  "data": {
    "user": {
      "id": 1,
      "email": "john@example.com",
      "name": "John Doe",
      "created_at": "2023-04-29T12:34:56.000000Z"
    },
    "access_token": "eyJ0eXAiOiJKV1..."
  }
}
```

#### Login

```
POST /api/auth/login
```

Request body:
```json
{
  "email": "john@example.com",
  "password": "securepassword"
}
```

Response:
```json
{
  "status": "success",
  "message": "Login successful",
  "data": {
    "user": {
      "id": 1,
      "email": "john@example.com",
      "name": "John Doe"
    },
    "access_token": "eyJ0eXAiOiJKV1..."
  }
}
```

#### Logout

```
POST /api/auth/logout
```

Headers:
```
Authorization: Bearer {access_token}
```

Response:
```json
{
  "status": "success",
  "message": "Successfully logged out"
}
```

#### Get authenticated user

```
GET /api/auth/user
```

Headers:
```
Authorization: Bearer {access_token}
```

Response:
```json
{
  "status": "success",
  "data": {
    "user": {
      "id": 1,
      "name": "John Doe",
      "email": "john@example.com",
      "created_at": "2023-04-29T12:34:56.000000Z"
    }
  }
}
```

### Patient Endpoints

#### Get patient profile

```
GET /api/patient/profile
```

Headers:
```
Authorization: Bearer {access_token}
```

Response:
```json
{
  "status": "success",
  "data": {
    "id": 1,
    "user_id": 1,
    "name": "John",
    "surname": "Doe",
    "email": "john@example.com",
    "birthdate": "1990-01-01",
    "gender": "Male",
    "address": "123 Main St, City",
    "emergency_contact": "Jane Doe, (555) 123-4567",
    "marital_status": "Married",
    "blood_type": "O+",
    "nationality": "American",
    "profile_image": "/storage/profile_images/user_1.jpg",
    "registration_date": "2023-01-01"
  }
}
```

### Profile Management Endpoints

#### Update patient profile

```
PUT /api/patient/profile
```

Headers:
```
Authorization: Bearer {access_token}
```

Request body:
```json
{
  "name": "John",
  "surname": "Doe",
  "birthdate": "1990-01-01",
  "gender": "Male",
  "address": "123 Main St, City",
  "emergency_contact": "Jane Doe, (555) 123-4567",
  "marital_status": "Married",
  "blood_type": "O+",
  "nationality": "American"
}
```

Response:
```json
{
  "status": "success",
  "message": "Profile updated successfully",
  "data": {
    "id": 1,
    "user_id": 1,
    "name": "John",
    "surname": "Doe",
    "birthdate": "1990-01-01",
    "gender": "Male",
    "address": "123 Main St, City",
    "emergency_contact": "Jane Doe, (555) 123-4567",
    "marital_status": "Married",
    "blood_type": "O+",
    "nationality": "American",
    "profile_image": "/storage/profile_images/user_1.jpg"
  }
}
```

#### Update profile image

```
POST /api/patient/profile/image
```

Headers:
```
Authorization: Bearer {access_token}
Content-Type: multipart/form-data
```

Request body:
```
profile_image: [file upload]
```

Response:
```json
{
  "status": "success",
  "message": "Profile image updated successfully",
  "data": {
    "profile_image": "/storage/profile_images/user_1_1682779456.jpg"
  }
}
```

## Frontend Documentation

### Key Features

- **User Authentication**: Login, registration, and protected routes
- **Profile Management**: View and edit personal information
- **Responsive Design**: Mobile-first approach for all screen sizes

### Component Structure

The application follows a modular architecture:

```
src/app/
├── core/                    # Core services, guards and models
│   ├── guards/              # Route guards
│   ├── interceptors/        # HTTP interceptors
│   ├── models/              # Data models
│   └── services/            # Core services
├── features/                # Feature modules
│   ├── auth/                # Authentication feature
│   ├── dashboard/           # Dashboard feature
│   └── profile/             # Profile feature
│       ├── components/
│       │   ├── profile-edit/
│       │   └── profile-view/
│       └── profile.component.ts
├── shared/                  # Shared modules, components, directives
│   ├── components/
│   ├── directives/
│   └── helpers/
└── app.component.ts         # Root component
```

## Development Guidelines

1. **Coding Standards**
   - Follow Angular style guide
   - Use type safety with TypeScript
   - Document public methods and interfaces

2. **Git Workflow**
   - Use feature branches
   - Write meaningful commit messages
   - Create pull requests for code review

3. **Error Handling**
   - Implement global error handling for HTTP requests
   - Log errors to the console in development
   - Display user-friendly error messages

## Testing

### Running Tests

```bash
# Backend tests
cd laravel-backend
php artisan test

# Frontend tests
cd angular-frontend
ng test
```

## Future Improvements

Below are suggestions to enhance this application:

### User Experience Improvements

1. **Consistent Design System**
   - Implement a design system with reusable components
   - Create a shared color palette and typography system
   - Extract common styles to a global stylesheet

2. **Loading States and Feedback**
   - Add skeleton loaders instead of simple spinners
   - Implement toast notifications for system messages
   - Add micro-interactions and transitions

3. **Responsive Design Enhancements**
   - Improve tablet view with optimized layouts
   - Test on various screen sizes

4. **Accessibility Improvements**
   - Add proper ARIA labels
   - Ensure keyboard navigation
   - Test with screen readers

### Technical Improvements

1. **State Management**
   - Implement NgRx/Redux for complex state management
   - Create proper loading/error states

2. **Performance Optimization**
   - Lazy load images
   - Implement virtual scrolling for long lists
   - Add HTTP request caching

3. **Form Handling**
   - Add more sophisticated form validations
   - Implement auto-save functionality
   - Add confirmation dialogs before discarding changes

4. **Testing**
   - Add unit tests for services and components
   - Implement end-to-end tests
   - Add visual regression testing

### Feature Enhancements

1. **User Profile**
   - Add user preferences section
   - Implement security features (password change, 2FA)
   - Add profile completeness indicator

2. **Patient Features**
   - Implement appointment scheduling
   - Add medical history timeline
   - Create a dashboard with health metrics
   - Add document management for medical records

3. **Communication Tools**
   - In-app messaging with healthcare providers
   - Notification preferences
   - Feedback/rating system

4. **Data Visualization**
   - Charts and graphs for health metrics
   - Interactive visualizations for medical data
   - Printable reports

## License

This project is licensed under the MIT License - see the LICENSE file for details.