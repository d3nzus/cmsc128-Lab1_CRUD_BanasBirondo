<?php
require_once __DIR__ . '/../connector/connector.php';

$sql = "SELECT id, name FROM category";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<option value='" . $row["id"] . "'>" . $row["name"] . "</option>";
    }
}
else {
    echo "0 results";
}

?>