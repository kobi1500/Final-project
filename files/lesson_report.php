<?php
/**
 * this page is report of lessons.
 * this report show that all  the details about the lessons that existing in the system.
 */
include_once '../database/connection.php';
$db = new connection();
?>
<!DOCTYPE html>
<html lang=he>
    <head>
        <meta charset="UTF-8">
        <link rel="icon" type="image/x-icon" href="../images/logo.png">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>דוח שיעורים</title>
        <?php include_once './bootstrapInit.html'; ?>
        <style>

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
        </style>
    </head>

    <body dir=rtl> 
        <!--A function that calls the header file-->
        <?php include_once ('header.php'); ?>

        <div class="container-fluid text-center">    
            <div class="row content" >
                <div class="col-sm-2 sidenav">
                </div>

            
            <div class="col-sm-8 text-left"style="margin-top:30px;"> 
                <div class="container-fluid text-center">  
                    <h3 align="right" style="margin-right:85px;">דוח שיעורים </h3>
                    <!--table-->
                    <center>

                        <table border="1">      
                            <tr>

                                <th><center>שם שיעור</center></th>
                            <th><center>סוג שיעור</center></th>
                            <th><center>מאמן</center></th>
                            <th><center>תיאור שיעור</center></th>


                            </tr>




                            <?php
                            /**
                             * A function that gives the information of the lesson information that each
                             *  which transfers any coach.
                             */
                            $result = $db->GetCoachLessons();
                            while ($row = mysqli_fetch_array($result)) {
                                ?>

                                <tr>

                                    <td><?php echo $row['lesson_name'] ?> </td>
                                    <td><?php echo $row['name'] ?> </td>
                                    <td><?php echo $row['first_name'] . " " . $row['last_name'] ?> </td>
                                    <td><?php echo $row['description'] ?> </td>
                                </tr>
                            <?php }
                            ?>
                        </table>

                    </center>

                    <div>
                        <div align="center" style="margin:10px;">
                            <button class="btn btn-primary text-left" onclick="window.history.back()"> חזור</button>
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