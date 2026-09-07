<ul>

<?php
require_once __DIR__ . '/../connector/connector.php';

$sql = "SELECT * FROM task";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<li>" . $row["title"] . "</li>";
    }
}
else {
    echo "<li>0 results</li>";
}
?>

</ul>