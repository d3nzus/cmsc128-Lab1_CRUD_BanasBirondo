<ul>

<?php
require_once __DIR__ . '/../connector/connector.php';

$sql = "SELECT * FROM task";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<tr>
            <td>{$row["title"]}</td>
            <td>{$row["due_date"]}</td>
            <td>{$row["due_time"]}</td>
            <td>{$row["priority"]}</td>
            <td>{$row["category_id"]}</td>";
        echo "</tr>";
    }
}
else {
    echo "<li>0 results</li>";
}
?>

</ul>