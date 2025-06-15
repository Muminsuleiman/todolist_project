<?php
include_once __DIR__ . "/../app/models/user.php";
session_start();

$error = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    if (UserModel::loadByUsername($username)) {
        $error = "Username already exists";
    } else {
        $user = new UserModel();
        $user->username = $username;
        $user->password = password_hash($password, PASSWORD_DEFAULT);
        $user->role = "user";
        $user->save();
        $_SESSION['user_id'] = $user->getID();
        $_SESSION['username'] = $user->username;
        $_SESSION['role'] = $user->role;
        header("Location: index.php");
        exit;
    }
}
?>
<h1>Register</h1>
<?php if ($error): ?>
    <p style="color:red;"><?php echo htmlspecialchars($error); ?></p>
<?php endif; ?>
<form method="post" action="">
    <input type="text" name="username" placeholder="Username" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit">Register</button>
</form>