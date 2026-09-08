<?php
require_once __DIR__ . '/../helpers/trash.php';

    echo '<form action="../helpers/trash.php" method="post">
        <input type="hidden" name="action" value="undo">
        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Undo Delete</button>
    </form>';
?>