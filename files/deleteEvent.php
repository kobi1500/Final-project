<?php
/**
 *
*this class contains the function of deleting the lesson.
*when entering, there is a table showing the inlaid lessons.
*when you click the Delete Lesson button, a lesson deletion option is displayed
*when clicked there is a confirmation message and when the lesson is approved, the lesson is deleted from the calendar
*if you do not want to delete the lesson, press cancel and a message appears according to the actions.
 */
include_once '../database/connection.php';
$db = new connection();
?>
<!DOCTYPE html>
<html>
    <head>



        <title>מחיקת שיעור</title>
        <meta charset="UTF-8">
        <link rel="icon" type="image/x-icon" href="../images/logo.png">
        <meta name="viewport" content="width=device-width, initial-scale=1">
      <?php include_once './bootstrapInit.html';?>
        <style>
            table {
                border-collapse: collapse;
                width: 60%;
                border-color:#e1e1d0;

            }

            th, td {
                text-align: center;
                padding: 5px;
                width: 8px;
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

            /* Set black background color, white text and some padding */


            /* On small screens, set height to 'auto' for sidenav and grid */
            @media screen and (max-width: 1280px) {
                .sidenav {
                    height: auto;
                    padding: 15px;
                }
                .row.content {height:auto;} 
            }
        </style>
        <script>
            function deletefunc()
            {

                if (!confirm('האם אתה בטוח שברצונך למחוק את השיעור?')) {
                    alert("השיעור לא נמחק מהמערכת שעות!");
                    return false;

                } else {
                    alert("השיעור נמחק מהמערכת שעות!");
                    window.location.href = "deleteEvent.php";
                }


            }
        </script>
    </head>
    <body dir="rtl">

    <!--A function that calls the header file-->
<?php include_once ('header.php'); ?>
    
     <div class="container-fluid text-center">    
            <div class="row content">
                <div class="col-sm-1 sidenav">


                </div>
                <div class="col-sm-10 text-center"style="margin-top:30px;"> 

        <h3 style="margin-right:-410px;">שיעורים קיימים</h3>
<!--table-->
    <center>
        <table border="1" style="margin-right: 30px;" >

            <tr>
                
            <th><center>שם שיעור</center></th>
            <th><center>סוג שיעור</center></th>
            <th><center> מאמן</center></th>
            <th><center>שעה</center></th>
            <th><center>יום</center></th>
            <th><center>מחק</center></th>



            </tr>

<?php
/**
*this function is a combination of several tables from the database
*returns a large table consisting of the three weights used
*from the table we extract the relevant information and use it as necessary
*for example, printing the fields.
 */
$result = $db->GetEvents(1);
while ($row = mysqli_fetch_array($result)) {
    ?>

                <tr>   
                   
                    <td><?php echo $row['lesson_name'] ?></td>
                    <td><?php echo $row['name'] ?></td>
                    <td><?php echo $row['first_name']." ".$row['last_name'] ?></td>
                    <td><?php echo $row['hour'] ?></td>
                    <td><?php
            $date = date_create($row['day']);
            echo date_format($date, "d-m-Y")
            ?>

                    <td><a href="generalcommands.php?func=deleteevent&id=<?php echo $row['scheduleid'] ?>" onclick="return deletefunc()">מחק</a></td>
                </tr>
                    <?php } ?>

        </table>

    </center>
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