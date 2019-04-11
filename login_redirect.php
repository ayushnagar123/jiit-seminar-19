<?php
session_start();
$email = $_POST['email']; #get users email via post method from a login form
include("database.php"); #establish connection with database
function Redirect($url, $permanent = false) #function to redirect to a page
{
    if (headers_sent() === false)
    {
        header('Location: ' . $url, true, ($permanent === true) ? 301 : 302);
    }

    exit();
}
$query = "SELECT userid, password FROM users WHERE email = '$email';";
$result = mysqli_query($conn, $query);
if(mysqli_num_rows($result) > 0) #if a user with such an email exists
{
	$row = mysqli_fetch_assoc($result);
	if($_POST['pass'] == $row['password']) #compare passwords
	{
		$_SESSION['userid'] = $row['userid'];
		unset($_SESSION['login-error']);
		Redirect('continue.php', false); #redirect to desired page

	}
	else #password doesn't match
	{
		$_SESSION['login-error'] = 'Wrong Password!';
		Redirect('login.php', false); #redirect to login page
	}
}
else #no user found with such an email
{
	$_SESSION['login-error'] = 'No User Found!';
	Redirect('login.php', false); #redirect to login page
}
?>
