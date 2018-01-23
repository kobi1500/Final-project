<?php
/**
 * this page is report of history records of lessons.
 * this report show that all the details about the history of the records.
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
        <title>דוח היסטוריית רישומים</title>
        <?php include_once './bootstrapInit.html'; ?>
        <style>

            .row.content {min-height:960px;max-height:1280px;}

            .sidenav {
                padding-top: 20px;
                background-color: #eee;
                height: 100%;
            }

            @media screen and (max-width:1280px) {
                .sidenav {
                    height: auto;
                    padding: 15px;
                }
                .row.content {height:auto;} 
            }
            table {
                border-collapse: collapse;
                width: 80%;
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
            <div class="row content" style="margin-top:80px;">
                <div class="col-sm-1 sidenav">
                </div>


                <div class="col-sm-10 text-left"style="margin-top:30px;"> 
                    <div class="container-fluid text-center">  

                        <h3 align="right" style="margin-right:120px;">דוח היסטוריית רישומים </h3>
                        <!--table-->
                        <center>
                            <table border="1" style="margin-right: 30px;" >

                                <tr>
                                    <th><center>שם</center></th>
                                <th><center>שם משפחה</center></th>
                                <th><center>שם שיעור</center></th>
                                <th><center>תאריך רישום</center></th>
                                <th><center>סטטוס לקוח</center></th>



                                </tr>
                                <?php
                                /**
                                 * this function returns all customers information from the record history table.
                                 */
                                $result = $db->GetHistoryRecords();
                                while ($row = mysqli_fetch_array($result)) {
                                    ?>

                                    <tr>

                                        <td><?php echo $row['first_name'] ?> </td>
                                        <td><?php echo $row['last_name'] ?> </td>
                                        <td><?php echo $row['lesson_name'] ?> </td>
                                        <td><?php
                                            $date = date_create($row['register_date']);
                                            echo date_format($date, "d-m-Y")
                                            ?> </td>
                                        <td><?php echo $row['statusname'] ?> </td>

                                    </tr>
                                <?php }
                                ?> 
                                <tr>
                                </tr>
                            </table>

                        </center>


                        <div>
                            <div align="center" style="margin-top:20px;margin-right: 20px;">
                                <button class="btn btn-primary" onclick="window.history.back()"> חזור</button>
                            </div>
                        </div>
                    </div>




                </div>
                <div class="col-sm-1 sidenav">

                </div>
            </div>
        </div>
        <!--a function that display the footer file-->
<?php include_once("footer.php"); ?>
    </body>
</html>