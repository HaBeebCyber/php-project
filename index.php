<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo List</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Todo List</h2>
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <input type="text" name="task" placeholder="Enter task...">
            <input type="submit" value="Add Task">
        </form>

        <table>
            <tr>
                <th>Task</th>
                <th>Action</th>
            </tr>
            <?php
            $mysqli = new mysqli("localhost", "username", "password", "todo_list");

            if ($mysqli->connect_error) {
                die("Connection failed: " . $mysqli->connect_error);
            }

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $task = $_POST["task"];
                if (!empty($task)) {
                    $sql = "INSERT INTO tasks (task_name) VALUES ('$task')";
                    $result = $mysqli->query($sql);
                    if (!$result) {
                        echo "Error: " . $sql . "<br>" . $mysqli->error;
                    }
                }
            }

            $sql = "SELECT * FROM tasks";
            $result = $mysqli->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr><td>{$row['task_name']}</td><td><button class='delete-btn' onclick='deleteTask({$row['id']})'>Delete</button></td></tr>";
                }
            } else {
                echo "<tr><td colspan='2'>No tasks yet</td></tr>";
            }

            $mysqli->close();
            ?>
        </table>
    </div>

    <script>
        function deleteTask(taskId) {
            if (confirm("Are you sure you want to delete this task?")) {
                window.location.href = "delete.php?id=" + taskId;
            }
        }
    </script>
</body>
</html>
