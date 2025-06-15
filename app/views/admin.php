<?php
class AdminView {
    public static function render($users) {
        ?>
        <h1>Admin Panel</h1>
        <h2>All Users</h2>
        <ul>
        <?php foreach ($users as $user): ?>
            <li><?php echo htmlspecialchars($user->username); ?> (<?php echo htmlspecialchars($user->role); ?>)</li>
        <?php endforeach; ?>
        </ul>
        <?php
    }
}
?>