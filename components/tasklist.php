
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


echo "<h1 class='text-white'>Task List</h1>
            <table class = 'border-4'>
                <thead class = 'border-4'>
                    <tr>
                        <th class = 'p-4'> Title </th>
                        <th class = 'p-4'> Due Date</th>
                        <th class = 'p-4'> Due Time</th>
                        <th class = 'p-4'> Priority</th>
                        <th class = 'p-4'> Category</th>
                    </tr>
                </thead>
                <tbody>";


if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $prio = $row["priority"];
        $class = "p-4";
        $color = match($prio){
            "low" => "yellow",
            "med" => "orange",
            "high" => "red",
            default => "blue"
        };
        echo "<tr>
            <td class = {$class}>{$row["title"]}</td>
            <td class = {$class}>{$row["due_date"]}</td>
            <td class = {$class}>{$row["due_time"]}</td>
            <td class = {$class} style = 'background-color:{$color}'>{$row["priority"]}</td>
            <td class = {$class}>{$row["name"]}</td>";
        echo "</tr>";
    }
}
else {
    echo "<td> Zero Results </td>";
}

echo "    </tbody>
            </table>";

?>


