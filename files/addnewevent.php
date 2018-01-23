<?php
/**
 * the page is adding lesson to the calendar, in addition, there is a table of existing classes that shows 
 * the details of the lessons that exist in the calendar.
 * after adding an event, the page directs to the Hours panel, if the event fails, a message is displayed accordingly.  
 * in addition, there is an option to switch to the deletion of an event
 */
include_once '../database/connection.php';
$db = new connection();

if (isset($_POST["submit"])) {
    $lessonid = $_POST["lesson"];
    $hour = $_POST["hour"];
    $day = $_POST["currday"];
    $date = date_create($day);
    $row = $db->AddEvent($lessonid, $hour, date_format($date, "Y-m-d"));
    if ($row > 0) {
        $db->Redirect('events.php');
    }
    $message = "האירוע לא התווסף!";
    echo "<script type='text/javascript'>alert('$message');</script>";
}
?>
<!DOCTYPE html>
<html>
    <head>


        <link rel="icon" type="image/x-icon" href="../images/logo.png">
        <title>הוספת שיעור חדש</title>

        <?php include_once './bootstrapInit.html'; ?>
        <!-- Display the model when you click the Add Lesson button-->
        <script>
            $("div[id^='myModal']").each(function () {

                var currentModal = $(this);

                //click confirm
                currentModal.find('.closed').click(function () {
                    currentModal.modal('hide');
                    currentModal.closest("div[id^='myModal']").nextAll("div[id^='myModal']").first().modal('show');
                });



            });
        </script>

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
    </head>

    <body dir="rtl">

        <!--
       This model gives you the option to add events to the calendar
        by entering details such as the date of the time and the name of the lesson
        -->
        <!-- Modal -->

        <div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">פרטי השיעור</h4>
                    </div>
                    <div class="modal-body">
                        <form role="form" method="POST" action="addnewevent.php?day=<?php echo $_GET['day'] ?>">

                            <div class="form-group">
                                <label for="exampleInputPassword1">שם השיעור</label>
                                <select id="name" name="lesson" style="width: 200px;" class="form-control input-md" required="" onchange="fetch_select(this.value);">
                                    <option value="">--בחר--</option>
                                    <?php
                                    $result = $db->GetLessons();
                                    while ($row = mysqli_fetch_array($result)) {
                                        ?>
                                        <option value="<?php echo $row['id'] ?>"><?php echo $row['lesson_name'] ?></option>
                                    <?php }
                                    ?>
                                </select>
                            </div> 
                            <div class="form-group">
                                <label for="exampleInputPassword1">שעת השיעור</label>
                                <input type="time" class="form-control" name="hour" required=""
                                       id="exampleInputPassword1"/>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">יום</label>
                                <input type="text" readonly="" class="form-control" name="currday" value="<?php
                                $date = date_create($_GET['day']);
                                echo date_format($date, "d-m-Y");
                                ?>">
                            </div>
                            <br><br>
                            <input type='submit'  class="btn btn-primary" value='שלח' data-toggle="modal" data-target="#myModal3" name="submit"/>
                            <button type="button" style="margin-right:10px;" class="btn btn-primary closed" data-dismiss="modal">סגור</button>
                        </form>
                    </div>
                    <div class="modal-footer">



                    </div>
                </div>
            </div>
        </div>








        <!--A function that calls the header file-->
        <?php include_once ('header.php'); ?>

        <div class="container-fluid text-center">    
            <div class="row content">
                <div class="col-sm-1 sidenav">


                </div>
                <div class="col-sm-10 text-center" style="margin-top:30px;"> 

                    <h3 style="margin-right:-450px;">שיעורים קיימים</h3>


                    <!-- table-->
                    <center>
                        <table border="1">

                            <tr>
                                <th><center>שם שיעור</center></th>
                            <th><center>סוג שיעור</center></th>
                            <th><center> מאמן</center></th>
                            <th><center>שעה</center></th>
                            <th><center>יום</center></th>




                            </tr>
                            <!-- 
                            this code is print in dynamically the data of db.
                            the table will grow as long as there is information in the table of db.
                            -->
                           <?php
                            $result = $db->GetEvents(1);
                            while ($row = mysqli_fetch_array($result)) {
                                ?>

                                <tr> 
                                    <td><?php echo $row['lesson_name'] ?></td> 
                                    <td><?php echo $row['name'] ?></td> 
                                    <td><?php echo $row['first_name'] . " " . $row['last_name'] ?></td> 
                                    <td><?php echo $row['hour'] ?></td> 
                                    <td><?php
                                        $date = date_create($row['day']);
                                        echo date_format($date, "d-m-Y");
                                        ?></td>
                                </tr>
                            <?php }
                            ?>
                        </table>
             
               


                <!--Function buttons, adding lesson and deleting lesson-->
               
                    <div  id="submit-button">
                        <div>
                            <button class="btn btn-primary text-left" style="margin:10px;" data-toggle="modal" data-target="#myModal1" data-backdrop="static" data-keyboard="false">
                                הוסף שיעור חדש
                            </button>

                            <a href="deleteEvent.php"><button class="btn btn-primary text-left"  name="delete">   מחק שיעור </button></a>


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