<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Lab1_CRUD</title>
        <link rel="stylesheet" href="../assets/css/app.css">
    </head>
    <body>
        <div class="container mx-auto bg-red-500 p-4">
            <h1 class="text-white">Lab 1 CRUD</h1>
            <?php 
            include __DIR__ . '/../components/tasklist.php';
            include __DIR__ . '/../components/taskform.php';
            ?>
        </div>
    </body>
</html>