# CMSC 128 Lab 1 — CRUD To-do list
A simple CRUD (Create, Read, Update, Delete) web application built as Lab 1 for CMSC 128.

## Tech Stack

| Layer | Choice | Why |
|---|---|---|
| Backend | PHP | Lightweight, and we already had experience with it in CMSC 127 |
| Database | MySQL | Relational structure fits tabular CRUD data well, and it's bundled with XAMPP, so no separate DB server setup is required. |
| Styling | Tailwind CSS | Utility-first classes let us style quickly without writing separate CSS files, compiled locally via `npm run build:css`. |
| Local server | XAMPP (Apache + MySQL) | Standard, easy-to-install stack for local PHP development on Windows/macOS/Linux without configuring Apache/MySQL manually. |


## Requirements

- [Node.js and npm](https://nodejs.org/) 
- [XAMPP](https://www.apachefriends.org/) 

## Setup & Run Locally

1. **Clone the repo** into your XAMPP `htdocs` folder:

   ```bash
   cd /path/to/xampp/htdocs
   git clone https://github.com/d3nzus/cmsc128-Lab1_CRUD_BanasBirondo
   cd cmsc128-Lab1_CRUD_BanasBirondo
   ```

2. **Install dependencies:**

   ```bash
   npm install
   ```

3. **Set up the database:**
   - Open phpMyAdmin (`localhost/phpmyadmin`) via XAMPP.
   - Create a database (e.g. `cmsc128_lab1`).
   - Import the schema from `/database/schema.sql` (adjust path to match your repo).
   - Update your DB credentials in `config.php` (or wherever your connection settings live).

4. **Start XAMPP** and turn on **Apache** and **MySQL** from the control panel.

5. **Build Tailwind CSS:**

   ```bash
   npm run build:css
   ```

   Use `npm run watch:css` instead if you want it to rebuild automatically while you edit.

6. **Open the app** in your browser:

   ```
   http://localhost/cmsc128-Lab1_CRUD_BanasBirondo/
   ```

## CRUD Operations

This app exposes CRUD through PHP scripts that query MySQL directly 

Example query used inside `addTask.php`:

```php
$sql = 'INSERT INTO task (title, due_date, due_time, priority, category_id) VALUES (?, ?, ?, ?, ?)';
$statement = $conn->prepare($sql);
$statement->bind_param('ssssi', $title, $date, $time, $priority, $categoryId);
```

## Project Structure

```
cmsc128-Lab1_CRUD_BanasBirondo/
├── assets 
│     └── css
│         ├── app.css
|         └── input.css        
├── components
│     ├── addButton.php
|     ├── tasklist.php
|     └── undoButton.php 
├── config
|     └── config.php
├── connector
|     └── connector.php           
├── database
|     ├── db_builder.sql
|     └── runBuilder.php 
├── debug
|     └── debug.php           
├── helpers
│     ├── addTask.php
|     ├── allCategories.php
|     ├── deleteTask.php
|     ├── undoDelete.php
|     └── updateTask.php 
├── pages
│     ├── addForm.php
|     ├── editForm.php
|     └── homePage.php                 
└── index.php               
```

## Authors

- Renz Frederick Banas
- Yuan Miguel Birondo