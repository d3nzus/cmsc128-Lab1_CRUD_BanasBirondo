<ul>

<?php
require_once __DIR__ . '/../connector/connector.php';

$sql = "SELECT
task.title,
task.id,
task.due_date,
task.due_time,
task.priority,
category.name
FROM task
LEFT JOIN category ON task.category_id = category.id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<tr>
            <td>{$row["title"]}</td>
            <td>{$row["due_date"]}</td>
            <td>{$row["due_time"]}</td>
            <td>{$row["priority"]}</td>
            <td>{$row["name"]}</td>";
        echo "</tr>";
    }
}
else {
    echo "<li>0 results</li>";
}
?>

</ul>