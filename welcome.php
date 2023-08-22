<?php
include 'includes/dbconnect.php';
if (!isset($_SESSION)) {
    session_start();
}
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    header("location: index.php");
    exit;
}
$sql = "SELECT employee.*, e_group.g_name FROM employee left join e_group on employee.group_id =
e_group.id where employee.e_id = " . $_SESSION['userid'] . " ";
$result = mysqli_query($conn, $sql);
while ($row1 = mysqli_fetch_array($result))
    extract($row1);
$name;
$g_name;
?>
<!doctype html>
<html>

<head>
    <!-- Required meta tags -->
    <meta>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="style2.css">
    <title>FTS | Home</title>
</head>

<body class="welcome-bg">
    <?php include 'includes/header.php';
    include 'includes/nav.php'; ?>

    <p align="center">&nbsp;</p>
    <div align="center">
        <p class="content">Welcome<br><?php echo $_SESSION['username'];
        if ($g_name != "OTHER") echo " (" . $g_name . ")"; ?> </p>
    </div>
    <?php //include 'includes/footer.php'; 
    ?>
</body>

</html>
