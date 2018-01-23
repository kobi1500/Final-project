<?php
/**
 * this class is show to the manager that report of customers
 * that exist in studio.
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
        <title>דוח לקוחות</title>
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
                width: 80%;
                border-color:#e1e1d0
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
            <div class="row content">
                <div class="col-sm-1 sidenav">
                </div>
    <div class="col-sm-10 text-left"style="margin-top:30px;">  
                <div class="container-fluid text-center">  
                    <h3 align="right"  style="margin-right:120px;">דוח לקוחות </h3>
                    <!--table-->
                    <center>
                        <table border="1" style="margin-right: 30px;">

                            <tr>

                                <th><center>שם</center></th>
                            <th><center>שם משפחה</center></th>
                            <th><center>תעודת זהות</center></th>
                            <th><center>מייל</center></th>
                            <th><center>סוג מנוי</center></th>
                            <th><center>טלפון</center></th>
                            <th><center>אישור רפואי</center></th>
                            <th><center>תאריך רישום</center></th>

                            </tr>
                            <!-- 
                            this code is print in dynamically the data of customers table in db.
                            the table will grow as long as there is information in the table of db.
                            date format changed to Israeli format
                            -->
                            <?php
                            $result = $db->GetCustomers();
                            while ($row = mysqli_fetch_array($result)) {
                                ?>
                                <tr>


                                    <td><?php echo $row['first_name'] ?></td>
                                    <td><?php echo $row['last_name'] ?></td>
                                    <td><?php echo $row['id_customer'] ?></td>
                                    <td><?php echo $row['mail'] ?></td>
                                    <td><?php echo $row['subscriber_type'] ?></td>
                                    <td><?php echo $row['phone_number'] ?></td>
                                    <td><?php echo $row['choice'] ?></td>
                                    <td><?php
                                        $date = date_create($row['register_date']);
                                        echo date_format($date, "d-m-Y")
                                        ?></td>
                                </tr>

                                <?php
                            }
                            ?>
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
  <div style="height:40px;">

        </div>

        <!--a function that display the footer file-->
        <?php include_once("footer.php"); ?>
    </body>
</html>