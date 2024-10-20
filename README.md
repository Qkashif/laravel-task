Laravel & Vue.js SPA Project
Overview
This project is a Single Page Application (SPA) built using Laravel as the backend and Vue.js 3 for the frontend. The project is designed to provide separate views for admins and users, handle authentication via Laravel Sanctum, and offer CRUD functionality for categories and products, along with other features.

Features
Authentication: Basic authentication using Laravel Sanctum, with an admin login and custom login functionality.
Admin Dashboard: CRUD operations for managing categories and products.
Frontend: Users can view product categories, view products, and leave comments on products.
Vue.js 3 SPA: A modern SPA structure using the Options API.
Tailwind CSS: Tailwind CSS.
Queue and Mail: Admin notifications via email on user registration, handled through queued jobs.
Data Table: Pagination, search, and filter capabilities using DataTables.
Prerequisites
PHP >= 8.0
Node.js & npm
Composer
Laravel 9.x
Vue.js 3
Vite
MySQL
Installation
Clone the Repository:

Install PHP Dependencies:
composer install
Install Node.js Dependencies:
npm install
Environment Setup:

Duplicate the .env.example file and rename it to .env.
Update your .env file with the necessary database and mailer configurations.
Generate Application Key:

php artisan key:generate
Setup Database:
Create a database in MySQL.
Update your .env file with the database credentials.
Run migrations to set up the tables:

php artisan migrate
Database Seeding: Seed the database to create the first admin user:

php artisan db:seed --class=AdminUserSeeder
This creates the first admin user with the following credentials:

Email: admin@admin.com
Password: password


Build the Frontend:


npm run dev
Project Structure
The project is divided into two main parts: the Admin Dashboard and the Frontend.

1. Admin Dashboard:
Access the admin dashboard at /admin.
Only users with is_admin set to true can access this section.
The admin can manage categories and products (CRUD operations).

2. Frontend:
Users can view the product categories and product details.
Users can leave comments on products, which are visible to other users.
Authentication & Authorization
Laravel Sanctum is used for user authentication.
Admin and user authentication flows are separated.
The first user is created as an admin via seeding.
Admin User Login
Admin Login is implemented using a custom login method and checks for the is_admin field.


Vue.js SPA Structure
Folder Structure:
resources/js/adminside: Contains all admin-specific Vue components and files.
resources/js/frontside: Contains frontend components.
resources/js/router: Vue Router setup for SPA routing.
resources/js/store: Vuex (if required for state management).

resources/views: Blade templates.
Main Vue Components:
AdminDashboard.vue: Admin panel for managing categories and products.
CategoryList.vue: DataTable for listing categories with CRUD options.
ProductForm.vue: Create and edit products, assign multiple categories, and upload multiple images.
ProductDetailPage.vue: Frontend view for product details, with commenting functionality.


API Structure
Laravel API Routes
/api/categories: CRUD for categories.
/api/products: CRUD for products, with multiple category assignments and image uploads.
/api/products/{product}/comments: API to add comments to a product.

Mail & Queue Setup
Mail: When a new user registers, an email is sent to the admin using queued jobs for efficient delivery.
Queue Configuration: Set QUEUE_CONNECTION=database in .env. Ensure the queue worker is running:

php artisan queue:work
Running the Project
Run the Development Server:
php artisan serve

npm run dev

Using DataTables in Vue
DataTables are applied to the category and product listing pages using DataTables.net library. Make sure you include the necessary CSS and JS files in your components for proper styling and functionality.

Adding DataTables in Vue Component:

import 'datatables.net-dt/css/jquery.dataTables.min.css';
import 'datatables.net';

mounted() {
  $(this.$refs.myTable).DataTable();
}



Validation: A separate validation service class is used for form validation.
API Responses: All API responses are formatted using Laravel API resources.
Image Uploads: Implemented simple multiple image upload functionality without plugins.
php artisan storage:link
