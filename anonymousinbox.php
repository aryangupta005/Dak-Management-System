<?php
$login = false;
$showError = false;
include 'includes/dbconnect.php';
if($_SERVER["REQUEST_METHOD"] == "POST")
{
$username = $_POST["username"];
 $password = $_POST["password"];
 $sql = "select employee.*, e_group.g_name, role.short_name as rolename from ( ( employee join e_group on
employee.group_id = e_group.id ) join role on employee.role_id = role.id ) where username='$username' AND
password='$password' AND status = 1 ";
 $result = mysqli_query($conn, $sql);
while($row1= mysqli_fetch_array($result))
extract($row1);
$e_id;
$name;
$group_id;
 $role_id;
$num = mysqli_num_rows($result);
 if ($num == 1)
{
 $login = true;
 session_start();
 $_SESSION['loggedin'] = true;
 $_SESSION['userid'] = $e_id;
$_SESSION['username'] = $name;
$_SESSION['groupid'] = $group_id;
$_SESSION['rolename'] = $rolename; //here rolename is short name
$_SESSION['showAlert']=false;
$_SESSION['showError']=false;
 header("location: welcome.php");
}
else
{
$showError = "Invalid Credentials";
 }
}
?>
<!doctype html>
<html lang="en">
 <head>
 <!-- Required meta tags -->
 <meta charset="utf-8">
 <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link href="includes/style2.css" rel="stylesheet" type="text/css" />
<title>FTS | Login</title>
</head>
<body class="login-bg">
<div align="center" style="padding:10px 10px 10px 10px; top:0; ">
<p align="center">
<img src="image/drdo_logo.png" width="120" height="120">
<img src="image/banner.png" width="800" height="120" />
<img src="image/logocfees123.png" width="" height="120">
</p>
</div>
<p>&emsp;</p>
<p>&emsp;</p>
<p>&emsp;</p>
<div align="center">
<div align="center" class="login-container">
<h3> DAK MANAGEMENT SYSTEM </h3>
<?php
if($login){
echo ' <div class="alert-success">
<strong>Success!</strong> You are logged in
</div> ';
}
if($showError){
echo ' <div class="alert-error">
<strong>Error!</strong> '. $showError.'
</div> ';
}
?>
<form method="post">
<div class="login-fields" >
<label>Username</label>
<input type="text" id="username" name="username">
</div>
<div class="login-fields">
<label >Password</label>
<input type="password" id="password" name="password">
</div>
<button type="submit" class="login-button">Login</button>
</form><br>
</div>
</div>
<div class="footer">
<p>Designed &amp; Maintained by QRS&amp;IT Group <br> <a style="font-size:14px;">Version :
1.0</a></p>
</div>
</body>
</html>