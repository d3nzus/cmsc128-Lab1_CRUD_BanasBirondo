<?php
session_start();

require_once __DIR__ . '/database/runBuilder.php';

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Lab1_CRUD</title>
        <link rel="stylesheet" href="assets/css/app.css">
    </head>
    <body>
        <div class="container mx-auto p-4">
            <h1 class="text-white">Task List</h1>
            <table class = "border-4">
                <thead class = "border-4">
                    <tr>
                        <th class = "p-4"> Title </th>
                        <th class = "p-4"> Due Date</th>
                        <th class = "p-4"> Due Time</th>
                        <th class = "p-4"> Priority</th>
                        <th class = "p-4"> Category</th>
                    </tr>
                </thead>
                <tbody>
                    <?php include 'components/tasklist.php';?>
                </tbody>
            </table>
        </div>
    </body>
</html>