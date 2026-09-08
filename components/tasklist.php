
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
$headerClass = "p-4";
$taskItemClass = "p-4";

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


<table class = 'border-4'>
    <thead class = 'border-4'>
        <tr>
            <th class = <?= htmlspecialchars($headerClass) ?>> Title </th>
            <th class = <?= htmlspecialchars($headerClass) ?>> Due Date</th>
            <th class = <?= htmlspecialchars($headerClass) ?>> Due Time</th>
            <th class = <?= htmlspecialchars($headerClass) ?>> Priority</th>
            <th class = <?= htmlspecialchars($headerClass) ?>> Category</th>
        </tr>
    </thead>
    <tbody>


            
<?php if ($taskList->num_rows > 0): ?>
    <?php while($task = $taskList->fetch_assoc()): ?>
    <?php
        $prio = $task["priority"];
        $color = match($prio){
            "low" => "yellow",
            "med" => "orange",
            "high" => "red",
            default => "blue"
        };
    ?>
        <!--edit and delete button passes the task ID-->
        <tr>
            <td class = <?= htmlspecialchars($taskItemClass) ?>>
                <?= htmlspecialchars($task["title"]) ?>
            </td>
            <td class = <?= htmlspecialchars($taskItemClass) ?>>
                <?= htmlspecialchars($task["due_date"]) ?>
            </td>
            <td class = <?= htmlspecialchars($taskItemClass) ?>>
                <?= htmlspecialchars($task["due_time"]) ?>
            </td>
            <td class = <?= htmlspecialchars($taskItemClass) ?>>
                <?= htmlspecialchars($task["priority"]) ?>
            </td>
            <td class = <?= htmlspecialchars($taskItemClass) ?>>
                <?= htmlspecialchars($task["category"]) ?>
            </td>
            <td>
                <?php echo"
                <form class = 'actions' id = 'del{$task["id"]}' action='../helpers/deleteTask.php' method = 'post'>
                    <input type = 'text' style = 'display:none' name = 'TaskID' value = {$task["id"]}>
                    <button type = 'button' onclick = 'confirmDel(\"del{$task["id"]}\")'>Delete</button>
                </form>
                <form class = 'actions' action='editForm.php' method = 'post'>
                    <input type = 'text' style = 'display:none' name = 'TaskID' value = {$task["id"]}>
                    <button type = 'submit'>Edit</button>
                </form>"?>
            </td>
        </tr>
    <?php endwhile?>
<?php else: ?>
        <td> Zero Results </td>
<?php endif ?>

    </tbody>
</table>";


<script>
// confirm function
function confirmDel(id){
    if (confirm("Confirm Deletion")){
        document.getElementById(id).submit();
        return true;
    }
    return false;
}
</script>




