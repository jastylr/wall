<?php
	session_start();
	require_once('connection.php');

	if (!isset($_SESSION['user']) || $_SESSION['user']['is_logged_in'] == false)
	{
		session_destroy();
		header('Location: index.php');
		exit;
	}

	// Get all messages
	$message_query = "SELECT messages.id as message_id, messages.message, messages.user_id, DATE_FORMAT(messages.created_at, '%M %D, %Y') as message_date,
									 CONCAT(users.first_name, ' ', users.last_name) as name
									 FROM messages
									 JOIN users ON messages.user_id = users.id
									 ORDER BY messages.created_at DESC";
	$messages = fetch_all($message_query);

	$comment_query = "SELECT comments.id as comment_id, comments.comment, DATE_FORMAT(comments.created_at, '%M %D, %Y') as comment_date, comments.user_id, comments.message_id,
										CONCAT(users.first_name, ' ', users.last_name) as name
										FROM comments
										JOIN users ON comments.user_id = users.id
										ORDER BY comments.created_at DESC";
	$comments = fetch_all($comment_query);
	
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Wall</title>
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

		<?php if (!empty($_SESSION['messages'])): ?>
			<?php foreach($_SESSION['messages'] as $message): ?>
				<p class="success"><?= $message; ?></p>
			<?php endforeach; ?>
			<?php unset($_SESSION['messages']); ?>
		<?php endif; ?>
		<div id="logout">
			<button><a href="process.php">Log out</a></button>
		</div>
		<h2>Welcome, <?= $_SESSION['user']['first_name']; ?></h2>
		<form action="process.php" method="post">
			<input type="hidden" name="action" value="post_message">
			<label for="message">Post a message<label>
			<textarea rows="5" cols="60" name="message" placeholder="Leave a message..."></textarea>
			<input type="submit" value="Post message">
		</form>
		<?php if(!empty($messages)): ?>
			<ul>
			<?php foreach($messages as $message): ?>							
				<li>
					<h3><?= $message['name'] . ' - ' . $message['message_date']; ?></h3>
					<p><?= $message['message']; ?></p>

					<ul>
						<?php foreach($comments as $comment): ?>
							<?php if ($comment['message_id'] == $message['message_id']): ?>
								<li>
									<h4><?= $comment['name'] . ' - ' . $comment['comment_date']; ?></h3>
									<p><?= $comment['comment']; ?></p>
								</li>
							<?php endif; ?>
						<?php endforeach; ?>
						<li>
							<form action="process.php" method="post">
								<input type="hidden" name="action" value="post_comment">
								<input type="hidden" name="message_id" value="<?=$message['message_id']?>">
								<label for="comment">Post a comment<label>
								<textarea rows="5" cols="60" name="comment" placeholder="Leave a comment..."></textarea>
								<input type="submit" value="Post comment">
							</form>
						</li>
					</ul>
				</li>								
			<?php endforeach;?>
			</ul>
		<?php endif; ?>
	</div>
</body>
</html>