<?php
class TodoView {
    public static function render($todoItems, $categories) {
        ?>
        <h1>To-Do List</h1>
        <p>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>! <a href="logout.php">Logout</a></p>
        <h2>Your Tasks</h2>
        <?php
        if (empty($todoItems)) {
            echo "<h3>No tasks found!</h3>";
        } else {
            echo "<ul>";
            foreach ($todoItems as $item) {
                ?>
                <li>
                    <h3><?php echo htmlspecialchars($item->title); ?></h3>
                    <p><?php echo htmlspecialchars($item->description); ?></p>
                    <p>Status: <?php echo $item->completed ? 'Completed' : 'Pending'; ?></p>
                </li>
                <?php
            }
            echo "</ul>";
        }
        ?>
        <h2>Add Task</h2>
        <form method="post" action="">
            <input type="text" name="title" placeholder="Title" required>
            <textarea name="description" placeholder="Description"></textarea>
            <select name="category_id">
                <option value="">No category</option>
                <?php foreach ($categories as $cat): ?>
                    <option value="<?php echo $cat->getID(); ?>"><?php echo htmlspecialchars($cat->name); ?></option>
                <?php endforeach; ?>
            </select>
            <button type="submit" name="add">Add</button>
        </form>
        <?php
    }
}
?>