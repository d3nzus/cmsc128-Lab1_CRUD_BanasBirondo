<h3>New Task:</h3>

    <form action="/../helpers/addTask.php" method="get">
        <table style="width:100%">
            <tr>
                <td class="tlabel">Title:</td>
                <td><input type="text" name="name" required></td>
            </tr>
            <tr>
                <td class="tlabel">Time</td>
                <td><input type="number" name="time" required></td>
            </tr>
            <tr>
                <td class="tlabel">Date</td>
                <td><input type="number" name="date" required></td>
            </tr>
            <tr>
                <td class="tlabel"></td>
                <td><input type="radio" name="priority" value="2"> High<br>
                    <input type="radio" name="priority" value="1"> Mid<br>
                    <input type="radio" name="priority" value="0"> Low</td>
            </tr>
            <tr>
                <td class="tlabel">Categories</td>
                <td>
                    <select class="expand" name="department">
                        <option value="" disabled="">--Select Category--</option>
                        <?php
                            require_once __DIR__ . '/../helpers/allCategories.php';
                            ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td class="tlabel"></td>
                <td><input type="submit"></td>
            </tr>
        </table>
    </form>