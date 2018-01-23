<?php
/**
 * this class is report of changes lessons.
 * this report show that all  lessons which were changes by the manager or coaches.
 * by coaches.
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
        <title>דוח שינויים</title>
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
                width: 50%;
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
                <div class="col-sm-1 sidenav">
                </div>


                <div class="col-sm-10 text-left"style="margin-top:30px;"> 
                    <div class="container-fluid text-center">  
                        <h3 align="right" style="margin-right:265px;">דוח שינויים </h3>

                        <!--table-->
                        <center>
                            <table border="1">

                                <tr>
                                    <th><center>שם שיעור</center></th>
                                <th><center>מאמן בשיעור</center></th>
                                <th><center>כמות מתוכננת</center></th>
                                <th><center>כמות ביטולים</center></th>



                                </tr>
                                  <?php
                            /**
                             * a function that gives the information of the lesson information that each
                             *  which transfers any coach.
                             * the function also provides information about the amount of cancellations of the lessons.
                             */
                            $result = $db->GetCoachLessons();
                            while ($row = mysqli_fetch_array($result)) {
                                ?>

                                <tr>

                                    <td><?php echo $row['lesson_name'] ?> </td>
                                    <td><?php echo $row['first_name']." ". $row['last_name'] ?> </td>
                                    <td><?php echo $row['max_register'] ?> </td>
                                    <td><?php echo $db->GetCancelLessonById($row['id']) ?></td>
                                </tr>
                            <?php }
                            ?>
                            </table>

                        </center>
                        <div>
                            <div align="center" style="margin-top:20px;margin-right: 25px;">
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