<?php include 'includes/dbconnect.php';
header("Refresh:180 ; url=" . $_SERVER['PHP_SELF'] . " ");
?>
<html>

<head>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="style2.css">
    <script src="./includes/filter.js"></script>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->

    <title>FTS | Outbox</title>
</head>

<body class="outbox-bg">
    <?php include 'includes/header.php';
    include 'includes/nav.php'; ?>
    <p>&nbsp;</p>
    <p align="center" class="font36"><img src="image/outbox2.png" width="80" height="80"> OUTBOX <img src="image/outbox2.png" width="80" height="80"></p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <?php
    if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
        header("location: login.php");
        exit;
    }
    ?>
    <p align="right">
        <input id="myInput" type="text" onKeyUp="myFunction()" placeholder="Search for mail" title="Type">
    </p>
    <p align="center">
    <table class="table1">
        <thead>
            <tr>
                <td> S.NO </td>
                <td> PROJECT NAME/NO. </td>
                <td> FILE NAME </td>
                <td> INITIATOR </td>
                <!--<td> GROUP </td>-->
                <td> RECEIVER </td>
                <td> DOCKET NUMBER </td>
                <td> FILE SENT TIME </td>
                <td> VIEW FILE </td>
            </tr>
        </thead>
        <tbody id="myTable">
            <?php $sql = "SELECT file_track.*, daks.*, initr.name as initiatorname, e_group.g_name, desig.name as designame,
project.proj_name, receiver.name as receiver_name FROM ( ( ( ( ( ( file_track left JOIN daks on file_track.f_id = daks.dak_id ) left JOIN employee as initr ON daks.e_id = initr.e_id ) left JOIN e_group ON initr.group_id = e_group.id ) left JOIN desig
ON initr.desig_id = desig.id ) left JOIN project ON daks.proj_id = project.id ) left JOIN employee as receiver ON
file_track.receiver_id = receiver.e_id )
where file_track.sender_id = " . $_SESSION['userid'] . " and daks.f_status = 1 order by file_track.sender_timestamp DESC";
            $result = mysqli_query($conn, $sql);
            $i = 1;
            while ($row = mysqli_fetch_array($result)) {
            ?>

                <tr class="table1row">
                    <td align="center"> <?php //echo "$i" ;
                                        ?></td>
                    <td> <?php echo $row["proj_name"]; ?></td>
                    <td><?php echo $row["file_name"]; ?></td>
                    <td><?php echo $row["initiatorname"] . ',<br>' . $row["designame"] . ',<br>'
                            . $row["g_name"]; ?></td>

                    <!-- <td><?php //echo $row["g_name"]; 
                                ?></td>-->
                    <td><?php echo $row["receiver_name"]; ?></td>
                    <td><?php echo $row["docket_no"]; ?></td>
                    <td><?php echo date('d-m-Y h:i A', strtotime($row["sender_timestamp"])); ?></td>
                    <td align="center"> <button class="ini-button" id="myButton" onclick="location.href='view.php?ftid=<?php echo $row['ft_id'] . "&fileid=" . $row['dak_id'] . "&page=outbox"; ?>'">VIEW</button></td>
                </tr>
            <?php $i++;
            } ?>
        </tbody>
    </table>
    </p>
    <?php //include 'includes/footer.php'; 
    ?>
</body>

</html>