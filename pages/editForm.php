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
        <h1 class="text-white">Lab 1 CRUD</h1>
        <?php
        require_once __DIR__ . '/../connector/connector.php';

        $taskId = filter_input(INPUT_POST, 'TaskID', FILTER_VALIDATE_INT);
        if ($taskId === false || $taskId === null) {
            console_log('Invalid task ID.');
            exit();
        }

        $statement = $conn->prepare('SELECT * FROM task WHERE id = ?');
        $statement->bind_param('i', $taskId);
        $statement->execute();
        $row = $statement->get_result()->fetch_assoc();
        $statement->close();

        if (!$row) {
            console_log('Task not found.');
            exit();
        }

        $priorityValues = ['low' => '0', 'med' => '1', 'high' => '2'];
        ?>
        <form action="../helpers/updateTask.php" method="post">
            <input type="hidden" name="TaskID" value="<?= (int) $row['id'] ?>">

            <table class="border-4 text-white">
                <tr>
                    <td class="p-4">Title:</td>
                    <td class="p-4"><input class="p-2 text-black" type="text" name="title"
                            value="<?= htmlspecialchars($row['title'], ENT_QUOTES, 'UTF-8') ?>" required></td>
                </tr>
                <tr>
                    <td class="p-4">Time:</td>
                    <td class="p-4"><input class="p-2 text-black" type="time" name="time"
                            value="<?= htmlspecialchars($row['due_time'], ENT_QUOTES, 'UTF-8') ?>" required></td>
                </tr>
                <tr>
                    <td class="p-4">Date:</td>
                    <td class="p-4"><input class="p-2 text-black" type="date" name="date"
                            value="<?= htmlspecialchars($row['due_date'], ENT_QUOTES, 'UTF-8') ?>" required></td>
                </tr>
                <tr>
                    <td class="p-4">Priority:</td>
                    <td class="p-4">
                        <input type="radio" name="priority" value="2" <?= $row['priority'] === 'high' ? 'checked' : '' ?>>
                        High<br>
                        <input type="radio" name="priority" value="1" <?= $row['priority'] === 'med' ? 'checked' : '' ?>>
                        Mid<br>
                        <input type="radio" name="priority" value="0" <?= $row['priority'] === 'low' ? 'checked' : '' ?>>
                        Low
                    </td>
                </tr>
                <tr>
                    <td class="p-4">Category:</td>
                    <td class="p-4">
                        <select class="p-2 text-black" name="category" required>
                            <?php
                            $categories = $conn->query('SELECT id, name FROM category');
                            while ($category = $categories->fetch_assoc()):
                                ?>
                                <option value="<?= (int) $category['id'] ?>" <?= (int) $category['id'] === (int) $row['category_id'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($category['name'], ENT_QUOTES, 'UTF-8') ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </td>
                </tr>
            </table>
            <button class="bg-gray-500 px-4 py-2 font-bold text-white" type="button" onclick="history.back()">Cancel</button>
            <input class="bg-blue-500 px-4 py-2 font-bold text-white" type="submit" value="Update Task">
        </form>
        <?php
        $conn->close();
        ?>
    </div>
</body>

</html>