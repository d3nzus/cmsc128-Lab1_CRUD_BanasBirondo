<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lab1_CRUD</title>
    <link rel="stylesheet" href="../assets/css/app.css?v=<?= filemtime(__DIR__ . '/../assets/css/app.css') ?>">
</head>

<body>
    <div class="flex min-h-screen w-full flex-col items-center justify-center bg-red-500 p-4 text-center">
        <h1 class="text-white">Lab 1 CRUD</h1>
        <h3>New Task:</h3>

    <form action="../helpers/addTask.php" method="get">
        <table style="width:100%">
            <tr>
                <td class="tlabel">Title:</td>
                <td><input type="text" name="title" required></td>
            </tr>
            <tr>
                <td class="tlabel">Time</td>
                <td><input type="time" name="time" required></td>
            </tr>
            <tr>
                <td class="tlabel">Date</td>
                <td><input type="date" name="date" required></td>
            </tr>
            <tr>
                <td class="tlabel"></td>
                <td><input type="radio" name="priority" value="2"> High<br>
                    <input type="radio" name="priority" value="1"> Mid<br>
                    <input type="radio" name="priority" value="0"> Low</td>
            </tr>
            <tr>
                <td class="tlabel">Categories</td>
                <td>
                    <select class="expand" name="category">
                        <option value="" disabled="">--Select Category--</option>
                        <?php
                            require_once __DIR__ . '/../helpers/allCategories.php';
                            ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td class="tlabel"></td>
                <td><input type="submit"></td>
            </tr>
        </table>
    </form>
    </div>
</body>

</html>