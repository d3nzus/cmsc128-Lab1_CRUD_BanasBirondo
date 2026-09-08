<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Lab1_CRUD</title>
        <link rel="stylesheet" href="../assets/css/app.css?v=<?= filemtime(__DIR__ . '/../assets/css/app.css') ?>">
    </head>
    <body>
        <div class="flex min-h-screen w-full flex-col items-center justify-center bg-gray-700 p-4 text-center">
            <h1 class="text-white text-4xl">Lab 1 CRUD</h1>
            <?php 
            include __DIR__ . '/../components/tasklist.php';
            include __DIR__ . '/../components/addButton.php';
            include __DIR__ . '/../components/undoButton.php';
            ?>
        </div>
    </body>
</html>