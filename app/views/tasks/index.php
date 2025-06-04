<!DOCTYPE html>
<html>
<head>
    <title>To-Do List</title>
</head>
<body>
    <h1>Tasks</h1>
    <form method="POST" action="/?action=store">
        <input type="text" name="title" placeholder="New task">
        <button type="submit">Add</button>
    </form>
    <ul>
        <?php foreach ($tasks as $task): ?>
            <li>
                <?= htmlspecialchars($task['title']) ?>
                <a href="/?action=delete&id=<?= $task['id'] ?>">Delete</a>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
