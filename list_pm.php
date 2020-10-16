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
        <title>Personnal Messages</title>
    </head>
    <body>
    	<div class="header">
        	<a href="<?php echo $url_home; ?>"><img src="<?php echo $design; ?>/images/logo.png" alt="Members Area" /></a>
	    </div>
        <div class="content">
<?php
//We check if the user is logged
if(isset($_SESSION['username']))
{
//We list his messages in a table
//Two queries are executes, one for the unread messages and another for read messages
$req1 = mysqli_query($link, 'select m1.id, m1.title, m1.timestamp, count(m2.id) as reps, users.id as userid, users.username from pm as m1, pm as m2,users where ((m1.user1="'.$_SESSION['userid'].'" and m1.user1read="no" and users.id=m1.user2) or (m1.user2="'.$_SESSION['userid'].'" and m1.user2read="no" and users.id=m1.user1)) and m1.id2="1" and m2.id=m1.id group by m1.id order by m1.id desc');
$req2 = mysqli_query($link, 'select m1.id, m1.title, m1.timestamp, count(m2.id) as reps, users.id as userid, users.username from pm as m1, pm as m2,users where ((m1.user1="'.$_SESSION['userid'].'" and m1.user1read="yes" and users.id=m1.user2) or (m1.user2="'.$_SESSION['userid'].'" and m1.user2read="yes" and users.id=m1.user1)) and m1.id2="1" and m2.id=m1.id group by m1.id order by m1.id desc');
?>
<h3 class="center"><i class="fa fa-inbox"> Inbox </i> </h3>

<a href="new_pm.php" class="btn btn-warning mb-4" class="link_new_pm">New Message</a><br />
<h3>Unread Messages(<?php echo intval(mysqli_num_rows($req1)); ?>):</h3>
<div class="container">
        <div class="row">
    	<div class="col-3"> Title </div>
        <div class="col-3"> Nb. Replies </div>
        <div class="col-3"> Participant </div>
        <div class="col-3"> Date of creation</div>
        </div>
<?php
//We display the list of unread messages
while($dn1 = mysqli_fetch_array($req1))
{
?>
	<div class="row">
    	<div class="col-3 left"><a href="read_pm.php?id=<?php echo $dn1['id']; ?>"><?php echo htmlentities($dn1['title'], ENT_QUOTES, 'UTF-8'); ?></a></div>
    	<div class="col-3"><?php echo $dn1['reps']-1; ?></div>
    	<div class="col-3"><a href="profile.php?id=<?php echo $dn1['userid']; ?>"><?php echo htmlentities($dn1['username'], ENT_QUOTES, 'UTF-8'); ?></a></div>
    	<div class="col-3"><?php echo date('Y/m/d H:i:s' ,$dn1['timestamp']); ?></div>
    </div>
<?php
}
//If there is no unread message we notice it
if(intval(mysqli_num_rows($req1))==0)
{
?>
	<tr>
    	<td colspan="4" class="center">You have no unread message.</td>
    </tr>
<?php
}
?>

</div>
<br />
<h3>Read Messages(<?php echo intval(mysqli_num_rows($req2)); ?>):</h3>
<div class="container">
	<div class="row">
    	<div class="col-3">Title</div>
        <div class="col-3">Nb. Replies</div>
        <div class="col-3">Participant</div>
        <div class="col-3">Date or creation</div>
    </div>
<?php
//We display the list of read messages
while($dn2 = mysqli_fetch_array($req2))
{
?>
	<div class="row">
    	<div class=" col-3 left"><a href="read_pm.php?id=<?php echo $dn2['id']; ?>"><?php echo htmlentities($dn2['title'], ENT_QUOTES, 'UTF-8'); ?></a></div>
    	<div class="col-3"><?php echo $dn2['reps']-1; ?></div>
    	<div class="col-3"><a href="profile.php?id=<?php echo $dn2['userid']; ?>"><?php echo htmlentities($dn2['username'], ENT_QUOTES, 'UTF-8'); ?></a></div>
    	<div class="col-3"><?php echo date('Y/m/d H:i:s' ,$dn2['timestamp']); ?></div>
    </div>
<?php
}
//If there is no read message we notice it
if(intval(mysqli_num_rows($req2))==0)
{
?>
	<tr>
    	<td colspan="4" class="center">You have no read message.</td>
    </tr>
<?php
}
?>
</div>
<?php
}
else
{
	echo 'You must be logged to access this page.';
}
?>
		</div>
		<div class="foot"><a class="btn btn-light" href="<?php echo $url_home; ?>"> <i class="fa fa-home"></i>  Home</a></div>
	</body>
</html>