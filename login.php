<!-- Authenticate a registered user. -->
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
        <title>login</title>
    </head>
    <body>
    	<div class="header">
        	<a href="<?php echo $url_home; ?>"><img src="<?php echo $design; ?>/images/logo.png" alt="Members Area" /></a>
	    </div>
<?php
//If the user is logged, we log him out
if(isset($_SESSION['username']))
{
	//We log him out by deleting the username and userid sessions
	unset($_SESSION['username'], $_SESSION['userid']);
?>
<div class="message text-danger">User logged out.</div>
<?php
}
else
{
	$ousername = '';
	//We check if the form has been sent
	if(isset($_POST['username'], $_POST['password']))
	{
		//We remove slashes depending on the configuration
		if(get_magic_quotes_gpc())
		{
			$ousername = stripslashes($_POST['username']);
			$username  = mysqli_real_escape_string($link, stripslashes($_POST['username']));
			$password  = stripslashes($_POST['password']);
		}
		else
		{
			$username = mysqli_real_escape_string($link, $_POST['username']);
			$password = $_POST['password'];
		}
		//We get the password of the user
		$req = mysqli_query($link, 'select password,id,salt from users where email="'.$username.'"');
		$dn  = mysqli_fetch_array($req);
		$password = hash("sha512", $dn['salt'].$password); // Hash with the salt to match database.
		//We compare the submited password and the real one, and we check if the user exists
		if ($dn['password'] == $password and mysqli_num_rows($req)>0) {
			//If the password is good, we dont show the form
			$form = false;
			//We save the user name in the session username and the user Id in the session userid
			$_SESSION['username'] = $_POST['username'];
			$_SESSION['userid'] = $dn['id'];
?>
<div class="message text-success">Logged in succesfully.</div>
<?php
		}
		else {
			//Otherwise, we say the password is incorrect.
			$form    = true;
			$message = 'The username or password is incorrect.';
		}
	}
	else $form = true;
	if($form) {
		//We display a message if necessary
		if(isset($message)) echo '<div class="message">'.$message.'</div>';

	//We display the form
?>
<div class="content">
    <form action="login.php" method="post">
        <h3 class="center mb-5"><i class="fa fa-sign-in-alt"> Login</i> </h3>
        <div class="container-fluid center">
        	<div class="row form-group">
				<div class="col-4">
            	<label for="email">Email</label>
            	</div>

            	<div class="col-5">
            	<input class="form-control" type="text" name="username" id="username" value="<?php echo htmlentities($ousername, ENT_QUOTES, 'UTF-8'); ?>" />
            	</div>
            </div>
        
		<div class="row form-group">
				<div class="col-4">
	            	<label for="password">Password</label>
	            </div>

	            <div class="col-5">
	            	<input class="form-control" type="password" name="password" id="password" /><br />
	            </div>
            </div>
            <input class="btn btn-warning" type="submit" value="Log in" />
		</div>
    </form>
</div>
<?php
	}
}
?>
		<div class="foot"><a class="btn btn-light" href="<?php echo $url_home; ?>"><i class="fa fa-home"></i> Home</a></div>
	</body>
</html>
