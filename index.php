<?php
	session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Wall Registration</title>
	<link rel="stylesheet" href="style.css">
</head>
<body>
	<div id="container">
		<?php if (!empty($_SESSION['errors'])): ?>
			<?php foreach($_SESSION['errors'] as $error): ?>
				<p class="error"><?= $error; ?></p>
			<?php endforeach; ?>
			<?php unset($_SESSION['errors']); ?>
		<?php endif; ?>
		<div id="logout">
			<button><a href="process.php">Log out</a></button>
		</div>
		<div id="registration">
			<h2>Register</h2>
			<form action="process.php" method="post">
				<input type="hidden" name="action" value="register">
				<label for="first_name">First name:</label>
				<input type="text" name="first_name">
				<label for="last_name">Last name:</label>
				<input type="text" name="last_name">
				<label for="email">Email address:</label>
				<input type="text" name="email">
				<label for="password">Password:</label>
				<input type="password" name="password">
				<label for="confirm_password">Confirm Password:</label>
				<input type="password" name="confirm_password">
				<input type="submit" value="Register!">
			</form>
		</div>
		<div id="login">
			<h2>Login</h2>
			<form action="process.php" method="post">
				<input type="hidden" name="action" value="login">
				<label for="email">Email address:</label>
				<input type="text" name="email">
				<label for="password">Password:</label>
				<input type="password" name="password">
				<input type="submit" value="Log in!">
			</form>
		</div>
	</div>
</body>
</html>