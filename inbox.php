<?php
include 'includes/dbconnect.php';
header("Refresh:180 ; url=" . $_SERVER['PHP_SELF'] . " ");
date_default_timezone_set("Asia/Kolkata");
$timestamp1 = date('Y-m-d H:i:s');
if (isset($_GET['ftid'])) {
    $sql = " update file_track set ft_status = 1, receiver_timestamp='$timestamp1' where ft_id = " . $_GET['ftid'] . " ;";
    $result = mysqli_query($conn, $sql);
    /*if($result)
{echo "true";}
else
{echo "false";}*/
}
?>
<html>

<head>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="style2.css">
    <script src="includes/filter.js"></script>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <title>FTS | Inbox</title>
</head>

<body class="inbox-bg">
    <?php include 'includes/header.php';
    include 'includes/nav.php'; ?>
    <p>&nbsp;</p>
    <p align="center"class="font36"><strong><img src="image/inbox1.png" alt="da" width="80" height="80"></strong>
        INBOX <strong><strong><img src="image/inbox1.png" alt="da" width="80" height="80"></strong></strong></p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <!-- Filtering and searching options -->
    <form class="searchbar" align="left" style="background:url(image/bgg61.jpg);
    margin: 30px; padding: 10px">
    <input type="radio" id="searchBySubject" value="searchBySubject" onclick="document.getElementById('search1').style.display='grid';" name="searchfilter">
    <label for="searchBySubject">Search by Subject</label>
    <div id="search1" style="display:none;">
        <p>
            <input id="myInput" type="text" onKeyUp="myFunction()" placeholder="Search .." title="Type">
        </p>
    </div>
    <input type="radio" id="searchByLetterDate" value="searchByLetterDate" onclick="document.getElementById('search2').style.display='grid';" name="searchfilter"><label for="searchByLetterDate">Search by Letter Date</label>
    <div id="search2" style="display:none;">
        <p>
            :Between <input id="fromdate" type="date" name="fromdate"> and <input id="todate" type="date" name="todate">
        </p>
        <button align="center" style="width: 200px" onKeyUp="filterByLetterDate()">Search</button>
    </div>
        <input type="radio" id="searchByLetterNo" value="searchByLetterNo" onclick="document.getElementById('search3').style.display='grid';" name="searchfilter">
        <label for="searchByLetterNo">Search by Letter Number</label>
        <div id="search3" style="display:none;">
            <p>
                <input id="letterno" type="text" onKeyUp="filterByLetterno" placeholder="Search" name="letterno">
            </p>
        </div>
        <input type="radio" id="searchByDocketDate" value="searchByDocketDate" onclick="document.getElementById('search4').style.display='grid';" name="searchfilter"><label for="searchByDocketDate">Search by Docket date</label>
        <div id="search4" style="display:none;">
            <p>
            : Between <input id="fromdate" type="date" name="fromdate"> and <input id="todate" type="date" name="todate">
            </p>
            <button align="center" style="width: 200px" onKeyUp="filterByDocketDate()">Search</button>
        </div>
        <input type="radio" id="searchByReply" value="searchByReply" onclick="document.getElementById('search5').style.display='grid';" name="searchfilter">
        <label for="searchByReply">Search by reply</label>
        <div id="search5" style="display:none;">
            <p>
                <input type="radio" id="yesreplied" name="yesreplied" value="yes">
                <label for="yesreplied">YES</label>
                <input type="radio" id="noreplied" name="noreplied" value="no">
                <label for="noreplied">NO</label>
            </p>
        </div>
        <input type="radio" id="searchByReplyType" value="searchByReplyType" onclick="document.getElementById('search6').style.display='grid';" name="searchfilter">
        <label for="searchByReplyType">Search by reply type</label>
        <div id="search6" style="display:none;">
            <p>
                <select name="replytypes" id="replytypes">
                    <option value="Search by reply type" disabled selected hidden>
                    <option value="NFA">NFA</option>
                    <option value="Reply">Reply</option>
                    <option value="Approval">Approval</option>
                </select>
            </p>
        </div>
        <input type="radio" id="searchByLetterMode" value="searchByLetterMode" onclick="document.getElementById('search7').style.display='grid';" name="searchfilter"><label for="searchByLetterMode">Search by Letter mode</label>
        <div id="search7" style="display:none;">
        <p>
            <select name="lettermodes" id="lettermodes">
                <option value="Search by letter mode" disabled selected hidden>
                <option value="letter">Letter</option>
                <option value="FAX">FAX</option>
                <option value="email">E-mail</option>
            </select>
        </p>
    </div>
    <input type="radio" id="searchByMeMarkedLetters" value="searchByMeMarkedLetters" onclick="$('search8').show(); showMeMarkedLetters(<?php echo $_SESSION['username']; ?>);" name="searchfilter">
    <label for="searchByMeMarkedLetters">Search Letters marked for me</label>
    </form>
    <p align="center">
    <table class="table1">
        <thead>
            <tr>
                <td> S. NO. </td>
                <td> SENDER </td>
                <td> CATEGORY </td>
                <td> DAK_ID </td>
                <td> ESTABLISHMENT NAME </td>
                <td> DOCKET DATE </td>
                <td> DESCRIPTION </td>
                <td> FILE NAME </td>
                <td> MARK DATE </td>
                <td> REPLY TYPE </td>
                <td> REMARK</td>
                <td> MARKED TO </td>
                <td> REPLIED (Yes/No) </td>
                <td> REPLIED ACTION </td>
            </tr>
        </thead>
        <tbody id="myTable">
            <?php $sql = "SELECT daks.*,file_track.*, daks.sender, daks.cat_id as category, daks.dak_id, daks.org_id, daks.description, daks.file_name, daks.mark_date, daks.reply_type, daks.f_remark, daks.marked_to, daks.replied_action, daks.docket_date
FROM ( ( ( ( ( ( daks left JOIN file_track on file_track.f_id = daks.dak_id ) left JOIN employee as initr ON daks.e_id = initr.e_id ) left JOIN e_group ON initr.group_id = e_group.id ) left JOIN desig ON initr.desig_id = desig.id ) left JOIN project ON daks.proj_id = project.id ) left JOIN employee as sendr ON file_track.sender_id = sendr.e_id )  where file_track.receiver_id =" . $_SESSION['userid'] . " ORDER BY
file_track.sender_timestamp DESC";
 $result = mysqli_query($conn, $sql);
            $i = 1;
            while ($row = mysqli_fetch_array($result)) {
            ?>
                <tr>
                    <td align="center"> 
                        <?php //echo "$i" ;
                                        ?></td>
                    <td><?php echo $row["sender"]; ?></td>
                    <td><?php echo $row["category"]; ?></td> 
                    <td><?php echo $row["dak_id"]; ?></td> 
                    <td><?php echo $row["org_id"]; ?></td> 
                    <td><?php echo date('d-m-Y h:i A', strtotime($row["docket_date"])); ?></td>
                    <td><?php echo $row["description"]; ?></td> 
                    <td><?php echo $row["file_name"]; ?></td> 
                    <td><?php echo date('d-m-Y h:i A', strtotime($row["mark_date"])); ?></td> 
                    <td><?php echo $row["reply_type"]; ?></td>
                    <td><?php echo $row["f_remark"]; ?></td>
                    <td><?php echo $row["marked_to"]; ?></td>
                    <!--<td><?php //echo $row["g_name"]; 
                            ?></td> -->
                    <td align="center"><button class="ini-button" id="myButton" onclick="location.href='view.php?ftid=<?php echo $row['ft_id'] . "&fileid=" . $row['dak_id'] . "&page=inbox"; ?>'"> MARK </button></td>        
                      <td><?php echo $row["replied_action"]; ?>
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
