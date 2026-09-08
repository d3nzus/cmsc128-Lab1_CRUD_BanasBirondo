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
        <h3 class="text-white">New Task:</h3>

    <form action="../helpers/addTask.php" method="get">
        <table class="border-4 text-white">
            <tr>
                <td class="p-4">Title:</td>
                <td class="p-4"><input class="p-2 text-black" type="text" name="title" required></td>
            </tr>
            <tr>
                <td class="p-4">Time:</td>
                <td class="p-4"><input class="p-2 text-black" type="time" name="time" required></td>
            </tr>
            <tr>
                <td class="p-4">Date:</td>
                <td class="p-4"><input class="p-2 text-black" type="date" name="date" required></td>
            </tr>
            <tr>
                <td class="p-4">Priority:</td>
                <td class="p-4"><input type="radio" name="priority" value="2"> High<br>
                    <input type="radio" name="priority" value="1"> Mid<br>
                    <input type="radio" name="priority" value="0"> Low</td>
            </tr>
            <tr>
                <td class="p-4">Category:</td>
                <td class="p-4">
                    <select class="p-2 text-black" name="category" required>
                        <option value="" disabled="">--Select Category--</option>
                        <?php
                            require_once __DIR__ . '/../helpers/allCategories.php';
                            ?>
                    </select>
                </td>
            </tr>
        </table>
        <button class="bg-gray-500 px-4 py-2 font-bold text-white" type="button" onclick="history.back()">Cancel</button>
        <input class="bg-blue-500 px-4 py-2 font-bold text-white" type="submit" value="Add Task">
    </form>
    </div>
</body>

</html>