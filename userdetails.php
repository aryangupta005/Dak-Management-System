<?php
 include 'includes/dbconnect.php';
session_start();
if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!=true){
 header("location: login.php");
 exit;
}
$sql = "SELECT employee.*, e_group.g_name, desig.name as designame, role.role_name
FROM ( ( ( employee left join e_group on employee.group_id = e_group.id )
 left join desig on employee.desig_id = desig.id )
 left join role on employee.role_id = role.id ) where employee.e_id = ".$_SESSION['userid']." ; " ;
$result = mysqli_query($conn, $sql);
while($row = mysqli_fetch_array($result))
extract($row);
$password;
if(isset($_POST['changepass'])) // post submit
{
/*if( strlen($_POST['new_pass']) <= 8 )
{
echo "<script type='text/javascript'> window.onload = function(){alert('!! Password Must be at least 8
characters !!'); } </script>" ;
}
else
{*/
if( $password == $_POST['old_pass'] ) //check old password
{
if( $_POST['new_pass'] == $_POST['conf_pass'] ) //check confirm password{
$query="update employee set password = '".$_POST['new_pass']."' where
e_id=".$_SESSION['userid']." ; ";
echo $query;
$result=mysqli_query($conn, $query);
echo "<script type = 'text/javascript'> window.onload = function() {alert('Password
Changed Successfully'); } </script>" ;
header('Refresh:0; url=includes/signout.php');
}
else
{
echo "<script type = 'text/javascript'> window.onload = function() {alert('!! Password
does not Match !!'); } </script>" ;
} // confirm password end
}
else
{
echo "<script type = 'text/javascript'> window.onload = function() {alert('!! Invalid Password !!'); } </script>" ;
} // old password end
/*}*/
}
?>
<html>
 <head>
 <!-- Required meta tags -->
 <meta charset="utf-8">
 <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
 <!-- Bootstrap CSS -->
 <link rel="stylesheet" href="includes/style.css" >
<link rel="stylesheet" href="includes/style2.css" >
<title>FTS | User Details</title>
</head>
<body class='close-bg'>
 <?php include 'includes/header.php';
 include 'includes/nav.php'; ?>
<p>&nbsp;</p>
<p align="center" class="font36"> <img src="image/userdet2.png" width="80" height="80">User Details<img
src="image/userdet2.png" width="80" height="80"></p>
<p>&nbsp;</p>
<?php $sql = "SELECT employee.*, e_group.g_name, desig.name as designame, role.role_name
FROM ( ( ( employee left join e_group on employee.group_id = e_group.id )
 left join desig on employee.desig_id = desig.id )
 left join role on employee.role_id = role.id ) where employee.e_id = ".$_SESSION['userid']." ; " ;
$result = mysqli_query($conn, $sql);
while($row = mysqli_fetch_array($result))
extract($row);
?>
<p align="center">
<table class="table2">
<tr>
<td class="finfo">Name</td>
 <td><?php echo $name; ?></td>
</tr>
<tr>
<td class="finfo">Group</td>
 <td><?php echo $g_name; ?></td>
</tr>
<tr>
<td class="finfo">Designation</td>
 <td><?php echo $designame; ?></td>
</tr>
</table>
</p>
<p align="center" class="font36"> <img src="image/changepass3.png" width="70" height="70">Change Password<img src="image/changepass3.png" width="70" height="70"></p>
<p align="center">
<form method="post">
<table align="center" class="table2">
<tr>
<td>Old Password</td>
 <td><input name="old_pass" type="password" required></td>
</tr>
<tr>
<td>New Password</td>
 <td><input name="new_pass" type="password" required></td>
</tr>
<tr>
<td>Confirm Password</td>
 <td><input name="conf_pass" type="password" required></td>
</tr>
<tr align="center">
<td colspan="2"><button class="ini-button" type="submit" name="changepass">change
password</button></td>
</tr>
</table>
</form>
</p>
<p>&nbsp;</p>
</body>
</html>