<?php
require_once __DIR__ . '/../connector/connector.php';

$priorityValues = [
	'0' => 'low',
	'1' => 'med',
	'2' => 'high'
];

$taskId = filter_input(INPUT_POST, 'TaskID', FILTER_VALIDATE_INT);
$categoryId = filter_input(INPUT_POST, 'category', FILTER_VALIDATE_INT);
$priority = $priorityValues[$_POST['priority'] ?? ''] ?? null;
$title = trim($_POST['title'] ?? '');
$date = $_POST['date'] ?? '';
$time = $_POST['time'] ?? '';

if ($taskId === false || $taskId === null || $categoryId === false || $categoryId === null || $priority === null || $title === '' || $date === '' || $time === '') {
	exit('Invalid task details.');
}

$sql = 'UPDATE task SET title = ?, due_date = ?, due_time = ?, priority = ?, category_id = ? WHERE id = ?';
$statement = $conn->prepare($sql);
$statement->bind_param('ssssii', $title, $date, $time, $priority, $categoryId, $taskId);

if ($statement->execute()) {
    header("Location: ../pages/homePage.php");
    exit();
} else {
    console_log('Error editing task: ' . $statement->error);
}

$statement->close();
$conn->close();
?>