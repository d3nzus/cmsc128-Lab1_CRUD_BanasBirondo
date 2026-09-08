<?php
    echo '<form action="../helpers/undoDelete.php" method="post">
        <input type="hidden" name="action" value="undo">
        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Undo</button>
    </form>';
?>