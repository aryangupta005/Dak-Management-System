<?php
include 'includes/dbconnect.php';
if(!isset($_SESSION))
 {
 session_start();
 }
?>
<div class="header-bg-dark nav" >
<ul>
 <li> <a style="cursor:default;">CFEES</a> </li>
 <li > <a href="welcome.php">Home</a> </li>

 <?php if($_SESSION['rolename'] != "RS")
 {?>
 <li > <a href="inbox.php">Incoming DAKs</a> </li>
 <li > <a href="outbox.php">Outgoing DAKs</a> </li>
 <?php } ?>

 <li > <a href="userdetails.php">User Details</a> </li>
 <li > <a href="includes/signout.php">Sign out(<?php echo $_SESSION['username'];?>)</a> </li> </ul>
</div>