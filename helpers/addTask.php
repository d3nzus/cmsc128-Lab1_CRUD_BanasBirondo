<?php
require_once __DIR__ . '/../connector/connector.php';
require_once __DIR__ . '/../debug/debug.php';

$title = trim($_GET['title'] ?? '');
$time = $_GET['time'] ?? '';
$date = $_GET['date'] ?? '';
$priorityValues = [
    '0' => 'low',
    '1' => 'med',
    '2' => 'high'
];
$priority = $priorityValues[$_GET['priority'] ?? ''] ?? null;
$categoryId = filter_input(INPUT_GET, 'category', FILTER_VALIDATE_INT);

if ($title === '' || $time === '' || $date === '' || $priority === null || $categoryId === false || $categoryId === null) {
    exit('Invalid task details.');
}

$sql = 'INSERT INTO task (title, due_date, due_time, priority, category_id) VALUES (?, ?, ?, ?, ?)';
$statement = $conn->prepare($sql);
$statement->bind_param('ssssi', $title, $date, $time, $priority, $categoryId);

if ($statement->execute()) {
    header("Location: ../pages/homePage.php");
    exit();
} else {
    console_log('Error adding task: ' . $statement->error);
}

$statement->close();
$conn->close();
?>