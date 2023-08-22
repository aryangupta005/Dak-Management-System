<?php
include 'includes/dbconnect.php';
if (!isset($_SESSION)) {
    session_start();
}

$activePage = basename($_SERVER['PHP_SELF']);
?>

<div class="header-bg-dark nav">
    <a style="cursor: default;">CFEES<br>DAK MANAGEMENT SYSTEM</a>
    <ul>
        <li><a <?php if ($activePage == "welcome.php") echo 'class="active"'; ?> href="welcome.php">Home</a></li>
        <?php if ($_SESSION['rolename'] != "RS") { ?>
            <li><a <?php if ($activePage == "inbox.php") echo 'class="active"'; ?> href="inbox.php">Incoming DAKs</a></li>
            <li><a <?php if ($activePage == "outbox.php") echo 'class="active"'; ?> href="outbox.php">Outgoing DAKs</a></li>
        <?php } ?>
        <li><a <?php if ($activePage == "userdetails.php") echo 'class="active"'; ?> href="userdetails.php">User Details</a></li>
        <li><a href="includes/signout.php">Sign out<br>(<?php echo $_SESSION['username']; ?>)</a></li>
    </ul>
</div>
