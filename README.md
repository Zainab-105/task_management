# Task Management Application
This application provides secure task management for teams, featuring OAuth2 authentication and role-based access control. Admin can manage Tasks and Users, Managers can assign tasks, and employees can manage their own tasks.

## 🚀Features
* Managers/Employee can register through home page. 

* User Management: Admin can create users with Manager OR Employee role based on their responsibilities within the organization.

* Task Management: Admin/Manager can create, update, view and delete tasks and specify a due date for each task and assign it to specific Employee. Employee will be notified via E-mail about the task assigned.

* Task Completion: Employee can update the status of task to Done once they finish working on them. Admin/Manager can review the task and mark it as Closed. This provides a visual indicator of the progress made on each task.

## 🚀Installation

Follow these steps to set up and run the project locally:

1. Clone the repository:
2. Switch to the repo folder and Install Composer & NPM Dependencies:
```bash
composer install
npm install && npm run dev
```
3. Create a copy of the .env.example file and rename it to .env.
```bash
cp .env.example .env
```
4. Generate an application key:
```bash
php artisan key:generate
```
5. Set up your environment variables in the .env file, like your database connection details.
6. Run Migrations and Seeders:
```bash
php artisan migrate --seed
```
7. Start the Development Server:
```bash
php artisan serve
```
8. Welcome aboard! 😎 Access the application with below credentials in your browser and start managing tasks with ease!

Use the below credentials to login
> Admin
>> Email: admin@admin.com | Password: Admin@123

> Manager
>> Email: manager@manager.com | Password: Manager@123

> Employee
>> Email: employee@employee.com | Password: Employee@123

## 🚀About Me
Reach out to me via:
[Linkedin](https://www.linkedin.com/in/sanjna-choksi/)
