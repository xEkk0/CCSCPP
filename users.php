<!-- Shows a list of users and their emails. -->
<?php
include('config.php');
if(!isset($_SESSION['username'])) die('You must be logged in to access this page.');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link href="<?php echo $design; ?>/style.css" rel="stylesheet" title="Style" />
		<title>List of users</title>
	</head>
	<body>
		<div class="header">
			<a href="<?php echo $url_home; ?>"><img src="<?php echo $design; ?>/images/logo.png" alt="Members Area" /></a>
		</div>
		<div class="content">
This is the list of members:
			<table>
				<tr>
					<th>Id</th>
					<th>Username</th>
				</tr>

<?php
//We get the IDs, usernames and emails of users
$req = mysqli_query($link, 'select id, username, email from users');
while ($dnn = mysqli_fetch_array($req)) {
?>

				<tr>
					<td class="left"><?php echo $dnn['id']; ?></td>
					<td class="left"><a href="profile.php?id=<?php echo $dnn['id']; ?>"><?php echo htmlentities($dnn['username'], ENT_QUOTES, 'UTF-8'); ?></a></td>
				</tr>

<?php
}
?>
			</table>
		</div>
		<div class="foot"><a href="<?php echo $url_home; ?>">Go Home</a></div>
	</body>
</html>
