
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

?>
<h1 class='text-white'>Task List</h1>
<form class = "p-4 bg-cyan-700 rounded-xl m-4" action = "homepage.php" method="GET">
    <label for='order'> Order By: </label>
    <select class = "bg-cyan-300 border-0 rounded-md" name='order' id='order' onchange='this.form.submit()'>
        <option value = 'id'<?php echo ($order === 'id') ? 'selected' : '' ?>>ID</option>
        <option value = 'title' <?php echo ($order === 'title') ? 'selected' : '' ?>>Title</option>
        <option value = 'due_date' <?php echo ($order === 'due_date') ? 'selected' : '' ?>>Due Date</option>
        <option value = 'due_time' <?php echo ($order === 'due_time') ? 'selected' : '' ?>>Due Time</option>
        <option value = 'priority' <?php echo ($order === 'priority') ? 'selected' : '' ?>>Priority</option>
        <option value = 'category' <?php echo ($order === 'category') ? 'selected' : '' ?>>Category</option>
    </select>
    <label for='asc_desc'> Order: </label>
    <select class = "bg-cyan-300 border-0 rounded-md"name='asc_desc' id='asc_desc' onchange='this.form.submit()'>
        <option value = 'ASC'<?php echo ($asc_desc === 'ASC') ? 'selected' : '' ?>>ascending</option>
        <option value = 'DESC' <?php echo ($asc_desc === 'DESC') ? 'selected' : '' ?>>descending</option>
    </select>
</form>


<table class = 'border-4 text-cyan-100 mb-5'>
    <thead class = 'border-4'>
        <tr>
            <th class = "p-4 bg-cyan-950"> Title </th>
            <th class = "p-4 bg-cyan-950"> Due Date</th>
            <th class = "p-4 bg-cyan-950"> Due Time</th>
            <th class = "p-4 bg-cyan-950"> Priority</th>
            <th class = "p-4 bg-cyan-950"> Category</th>
            <th class = "p-4 bg-cyan-950"> Actions</th>
        </tr>
    </thead>
    <tbody>


            
<?php if ($taskList->num_rows > 0): ?>
    <?php while($task = $taskList->fetch_assoc()): ?>
    <?php
        $prio = $task["priority"];
        $color = match($prio){
            "low" => "rgb(234 179 8)",
            "med" => "rgb(249 115 22)",
            "high" => "rgb(239 68 68)",
            default => "blue"
        };
        $prioClass = "bg-$color-500";
    ?>
        <!--edit and delete button passes the task ID-->
        <tr class="border-b-2">
            <td class = "p-4 bg-cyan-800">
                <?= htmlspecialchars($task["title"]) ?>
            </td>
            <td class = "p-4 bg-cyan-800">
                <?= htmlspecialchars($task["due_date"]) ?>
            </td>
            <td class = "p-4 bg-cyan-800">
                <?= htmlspecialchars($task["due_time"]) ?>
            </td>
            <td class = "p-4 bg-cyan-800" style = "background-color: <?= htmlspecialchars($color) ?>">
                <?= htmlspecialchars($task["priority"]) ?>
            </td>
            <td class = "p-4 bg-cyan-800">
                <?= htmlspecialchars($task["category"]) ?>
            </td>
            <td class = "p-4 bg-cyan-800 space-y-1">
                <?php echo"
                <form 
                    class = 'actions' 
                    id = 'del{$task["id"]}' 
                    action='../helpers/deleteTask.php' 
                    method = 'post'
                >
                    <input type = 'text' style = 'display:none' name = 'TaskID' value = {$task["id"]}>
                    <button class = 'w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-2 rounded' type = 'button' onclick = 'confirmDel(\"del{$task["id"]}\")'>Delete</button>
                </form>
                <form 
                    class = 'actions' 
                    action='editForm.php' 
                    method = 'post'
                >
                    <input type = 'text' style = 'display:none' name = 'TaskID' value = {$task["id"]}>
                    <button class = 'w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-2 rounded' type = 'submit'>Edit</button>
                </form>"?>
            </td>
        </tr>
    <?php endwhile?>
<?php else: ?>
        <td> Zero Results </td>
<?php endif ?>

    </tbody>
</table>


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




