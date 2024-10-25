# Full Stack Employee Management Application

This is a Laravel-based employee management application where users can view, search, filter, and manage employee records. The application provides a smooth user experience for both web and mobile platforms, with features including file uploads, datepickers, and advanced search filters.

## Features

-   **View and Search Employees**: Users can view and search through the list of employees using a dynamic table.
-   **Sort and Filter**: Employee data can be sorted and filtered based on the desired columns.
-   **Add New Employees**: A form with validations for adding new employees.
-   **Upload Photo and Documents**: Users can upload an employee's photo and appointment documents.
-   **Responsive Design**: The application works well on both mobile and desktop platforms.
-   **API Access**: Provides an API endpoint for fetching employee data.
-   **Seeder for Dummy Data**: Includes a seeder to populate the database with dummy employee records.

## Installation

### 1. Clone the repository

```bash
git clone https://github.com/hendriwhyu/interview-employee-list.git
cd <project-folder>
```

### 2. Install dependencies

```bash
composer install
npm install
npm run dev
```

### 3. Set up environment variables

Copy the `.env.example` file to `.env` and adjust your environment variables as necessary (e.g., database credentials).

```bash
cp .env.example .env
```

### 4. Run database migrations and seeders

Run the following command to create the database tables and seed them with dummy data:

```bash
php artisan migrate --seed
```

### 5. Create storage link

Laravel requires a symbolic link from `public/storage` to `storage/app/public` to serve uploaded files. Run the following command to create the link:

```bash
php artisan storage:link
```

### 6. Run the application

```bash
php artisan serve
```

Your application should now be up and running.

## Technologies Used

-   **Laravel**: Backend framework for building the application.
-   **jQuery**: For dynamic interactions (e.g., file uploads, datepickers).
-   **Bootstrap 5**: For responsive UI design.
-   **Select2**: For searchable dropdowns.
-   **Dropzone.js**: For drag-and-drop file uploads.
-   **FileInput.js**: For advanced file input handling.
-   **DataTables**: For displaying and searching the employee list.

## API Example

### GET /api/employees

```json
{
    "status": "success",
    "message": "Success get data employees",
    "data": [
        {
            "id": 1,
            "name": "Burley King",
            "email": "nhuels@example.net",
            "position": "Sys Admin",
            "phone_number": "0854042335",
            "photo": "https://via.placeholder.com/400x400.png/00dd88?text=people+Faker+illo",
            "created_at": "2024-10-24T09:45:50.000000Z",
            "updated_at": "2024-10-24T09:45:50.000000Z"
        }
    ]
}
```

## Resources

-   [Select2 Documentation](https://select2.org/)
-   [DataTables Documentation](https://datatables.net/)
-   [DateRangePicker Documentation](https://www.daterangepicker.com/)
-   [FileInput.js Documentation](https://plugins.krajee.com/file-input)
-   [Dropzone.js Documentation](https://www.dropzone.dev/)

## Author

-   [Hendri Wahyu Perdana](https://github.com/hendriwhyu)
