<!-- Home page. App starts here. -->
<?php
include('config.php');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="<?php echo $design; ?>/style.css" rel="stylesheet" title="Style" />
        <link href="stylesheets/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet"/>
        <link href="stylesheets/fontawesome/css/all.css" rel="stylesheet"/>
        <title>Members Area</title>
    </head>
    <body>
    	<div class="header">
        	<a href="<?php echo $url_home; ?>"><img src="<?php echo $design; ?>/images/logo.png" alt="Members Area" /></a>
	    </div>
        <div class="content">
<?php
//We display a welcome message, if the user is logged, we display it username
?>
<b>
Welcome to Le-Chat
<?php
if(isset($_SESSION['username'])) {
	echo ' '.htmlentities($_SESSION['username'], ENT_QUOTES, 'UTF-8');}
?>

		<br />
Safe and sound messaging system for you and your friends.
</b>
<br />
<br />
<?php
//If the user is logged, we display links to edit his infos, to see his pms and to log out
if (isset($_SESSION['username'])) {
	echo 'You can <a href="users.php" class="text-warning">see the list of users</a>.<br /><br />';

	//We count the number of new messages the user has
	$nb_new_pm = mysqli_fetch_array(mysqli_query($link, 'select count(*) as nb_new_pm from pm where ((user1="'.$_SESSION['userid'].'" and user1read="no") or (user2="'.$_SESSION['userid'].'" and user2read="no")) and id2="1"'));
	//The number of new messages is in the variable $nb_new_pm
	$nb_new_pm = $nb_new_pm['nb_new_pm'];
	//We display the links
?>

<a href="edit_infos.php" class="text-warning">Edit my personnal information</a><br />
<a href="list_pm.php" class="text-warning">My personnal messages (<?php echo $nb_new_pm; ?> unread)</a><br />
<a class="btn btn-danger my-3" href="login.php"><i class="fa fa-sign-out-alt"></i> Logout</a>
<?php
}
else {
//Otherwise, we display a link to log in and to Sign up
?>
<div class="row pl-5" >
	<div class="col-3">
		<a class="btn btn-warning"  href="sign_up.php"> <i class="fa fa-user-plus"></i> Sign up</a>
	</div>
	<div class="col-3">
		<a class="btn btn-warning"  href="login.php"> <i class="fa fa-sign-in-alt"></i> Log in</a>
	</div>
</div>
<?php
}
?>
		</div>
	</body>
</html>
