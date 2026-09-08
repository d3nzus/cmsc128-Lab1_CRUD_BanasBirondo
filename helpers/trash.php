<?php

require_once __DIR__ . '/../connector/connector.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$taskId = null;
$title = null;
$due_date = null;
$due_time = null;
$priority = null;
$category = null;

function setTask(int $id): void
{
    global $conn, $taskId, $title, $due_date, $due_time, $priority, $category;

    $sql = "SELECT * FROM task WHERE id = ?";
    $statement = $conn->prepare($sql);
    $statement->bind_param("i", $id);

    if (!$statement->execute()) {
        exit('Error fetching task: ' . $statement->error);
    }

    $task = $statement->get_result()->fetch_assoc();
    if ($task === null) {
        exit('Task not found.');
    }

    $taskId = $task['id'];
    $title = $task['title'];
    $due_date = $task['due_date'];
    $due_time = $task['due_time'];
    $priority = $task['priority'];
    $category = $task['category_id'];

    $archiveSql = "INSERT INTO trash_task (id, title, due_date, due_time, priority, category_id) VALUES (?, ?, ?, ?, ?, ?)";
    $archiveStatement = $conn->prepare($archiveSql);
    $archiveStatement->bind_param("issssi", $taskId, $title, $due_date, $due_time, $priority, $category);
    if (!$archiveStatement->execute()) {
        exit('Error moving task to trash: ' . $archiveStatement->error);
    }
    $archiveStatement->close();
    $_SESSION['deleted_task_id'] = $taskId;
    $statement->close();
}

function undoDelete(int $id): void
{
    global $conn;

    $selectSql = "SELECT title, due_date, due_time, priority, category_id FROM trash_task WHERE id = ?";
    $selectStatement = $conn->prepare($selectSql);
    $selectStatement->bind_param("i", $id);
    if (!$selectStatement->execute()) {
        exit('Error finding deleted task: ' . $selectStatement->error);
    }

    $task = $selectStatement->get_result()->fetch_assoc();
    $selectStatement->close();
    if ($task === null) {
        exit('Deleted task not found.');
    }

    $title = $task['title'];
    $due_date = $task['due_date'];
    $due_time = $task['due_time'];
    $priority = $task['priority'];
    $category = $task['category_id'];

    $sql = "INSERT INTO task (id, title, due_date, due_time, priority, category_id) VALUES (?, ?, ?, ?, ?, ?)";
    $statement = $conn->prepare($sql);
    $statement->bind_param("issssi", $id, $title, $due_date, $due_time, $priority, $category);

    if ($statement->execute()) {
        $deleteSql = "DELETE FROM trash_task WHERE id = ?";
        $deleteStatement = $conn->prepare($deleteSql);
        $deleteStatement->bind_param("i", $id);
        $deleteStatement->execute();
        $deleteStatement->close();
        unset($_SESSION['deleted_task_id']);
        header("Location: ../pages/homePage.php");
        exit();
    }

    exit('Error restoring task: ' . $statement->error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'undo') {
    $deletedTaskId = $_SESSION['deleted_task_id'] ?? null;
    if ($deletedTaskId === null) {
        exit('No deleted task to restore.');
    }

    undoDelete((int) $deletedTaskId);
}

?>