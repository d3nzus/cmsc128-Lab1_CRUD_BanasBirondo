
<?php
require_once __DIR__ . '/../connector/connector.php';

$order = $_GET['order'] ?? 'id';
$asc_desc = $_GET['asc_desc'] ?? 'ASC';
$sql = "SELECT
task.title,
task.id,
task.due_date,
task.due_time,
task.priority,
category.name as category
FROM task
LEFT JOIN category ON task.category_id = category.id
ORDER BY {$order} {$asc_desc}; 
";

$taskList = $conn->query($sql);

$class = "p-4";
//TODO: Put classes for header in rows into proper variables
//TODO: Rearrange so that there's no need to spam ECHO


?>
<h1 class='text-white'>Task List</h1>
<form action = "homepage.php" method="GET">
    <label for='order'> Order By: </label>
    <select name='order' id='order' onchange='this.form.submit()'>
        <option value = 'id'<?php echo ($order === 'id') ? 'selected' : '' ?>>ID</option>
        <option value = 'title' <?php echo ($order === 'title') ? 'selected' : '' ?>>Title</option>
        <option value = 'due_date' <?php echo ($order === 'due_date') ? 'selected' : '' ?>>Due Date</option>
        <option value = 'due_time' <?php echo ($order === 'due_time') ? 'selected' : '' ?>>Due Time</option>
        <option value = 'priority' <?php echo ($order === 'priority') ? 'selected' : '' ?>>Priority</option>
        <option value = 'category' <?php echo ($order === 'category') ? 'selected' : '' ?>>Category</option>
    </select>
    <label for='asc_desc'> Order: </label>
    <select name='asc_desc' id='asc_desc' onchange='this.form.submit()'>
        <option value = 'ASC'<?php echo ($asc_desc === 'ASC') ? 'selected' : '' ?>>ascending</option>
        <option value = 'DESC' <?php echo ($asc_desc === 'DESC') ? 'selected' : '' ?>>descending</option>
    </select>
</form>

<?php
echo "<table class = 'border-4'>
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

            

if ($taskList->num_rows > 0) {
    while($task = $taskList->fetch_assoc()) {
        $prio = $task["priority"];
        $color = match($prio){
            "low" => "yellow",
            "med" => "orange",
            "high" => "red",
            default => "blue"
        };
        //edit and delete button passes the task ID
        echo "<tr>
            <td class = {$class}>{$task["title"]}</td>
            <td class = {$class}>{$task["due_date"]}</td>
            <td class = {$class}>{$task["due_time"]}</td>
            <td class = {$class} style = 'background-color:{$color}'>{$task["priority"]}</td>
            <td class = {$class}>{$task["category"]}</td>
            <td>
                <form class = 'actions' id = 'del{$task["id"]}' action='../helpers/deleteTask.php' method = 'post'>
                    <input type = 'text' style = 'display:none' name = 'TaskID' value = {$task["id"]}>
                    <button type = 'button' onclick = 'confirmDel(\"del{$task["id"]}\")'>Delete</button>
                </form>
                <form class = 'actions' action='editForm.php' method = 'post'>
                    <input type = 'text' style = 'display:none' name = 'TaskID' value = {$task["id"]}>
                    <button type = 'submit'>Edit</button>
                </form>
            </td>
            ";
            
        echo "</tr>";
    }
}
else {
    echo "<td> Zero Results </td>";
}

echo "    </tbody>
            </table>";

// confirm function
echo"
<script>
function confirmDel(id){
    if (confirm(\"Confirm Deletion\")){
        document.getElementById(id).submit();
        return true;
    }
    return false;
}
</script>
";
?>



