<?php
/**
 * in this page you can see the details about the canceled lesson bu coaches,
 * the reason , date and the name of the coaches.
 */
include_once '../database/connection.php';
$db = new connection();
?>
<!DOCTYPE html>
<html lang="he">
    <head>
        <meta charset="UTF-8">
        <link rel="icon" type="image/x-icon" href="../images/logo.png">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>דוח ביטול שיעורים על ידי מאמנים</title>
        <?php include_once './bootstrapInit.html'; ?>
        <style>
            /* Set height of the grid so .sidenav can be 100% (adjust as needed) */
            .row.content {min-height:960px;max-height:1280px;}

            /* Set gray background color and 100% height */
            .sidenav {
                padding-top: 20px;
                background-color: #eee;
                height: 100%;
            }

            /* On small screens, set height to 'auto' for sidenav and grid */
            @media screen and (max-width:1280px) {
                .sidenav {
                    height: auto;
                    padding: 15px;
                }
                .row.content {height:auto;} 
            }
            table {
                border-collapse: collapse;
                width: 60%;
                border-color:#e1e1d0;

            }

            th, td {
                text-align: center;
                padding: 5px;

            }

            tr:nth-child(even){background-color: #d9d9d9}

            th {
                background-color: #4d94ff;
                color: white;
            }
        </style>
    </head>

    <body dir="rtl"> 
        <!--A function that calls the header file-->
        <?php include_once ('header.php'); ?>
        <div class="container-fluid text-center">    
            <div class="row content" >
                <div class="col-sm-2 sidenav">
                </div>

            <div class="col-sm-8 text-left"style="margin-top:30px;"> 
                <div class="container-fluid text-center"> 

                    <h3 align="center" style="margin-right:-170px;">דוח ביטול שיעורים על ידי מאמנים </h3>


                    <!--table-->
                    <center> 
                        <table border="1">

                            <tr>
                                <th><center>שם מאמן</center></th>
                            <th><center>תעודת זהות</center></th>
                            <th><center>שם שיעור שבוטל</center></th>
                            <th><center>תאריך שיעור</center></th>
                            </tr>

                            <!--Connects a few wizards in the database and returns 
                            the information about the canceled classes by coaches-->

                            <?php
                            $result = $db->GetEvents(2);

                            while ($row = mysqli_fetch_array($result)) {
                                ?>
                                <tr>
                                    <td><center><?php echo $row['first_name'] . ' ' . $row['last_name'] ?></center></td>
                                <td><center><?php echo $row['coach_id'] ?></center></td>
                                <td><center><?php echo $row['lesson_name'] ?></center></td>
                                <td><center><?php
                                    $date = date_create($row['day']);
                                    echo date_format($date, "d-m-Y")
                                    ?></center></td>


                                </tr>
                            <?php } ?>
                        </table>

                    </center>
                    <div>
                        <div align="center" style="margin-top:20px;margin-right: 25px;">
                            <button class="btn btn-primary" onclick="window.history.back()"> חזור</button>
                        </div>
                    </div>
                </div>


                

            </div>
            <div class="col-sm-2 sidenav">

                </div>
        </div>
        </div>
       
        <!--a function that display the footer file-->
        <?php include_once("footer.php"); ?>
    </body>
</html>