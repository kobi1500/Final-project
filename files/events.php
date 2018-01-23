<?php
/**
 * this page displays the calendar.
 * there is a possibility of selecting the display of the calendar: daily, weekly, or monthly.
 * in the calendar you can see the lessons inlaid in the different dates. 
 */
include_once '../database/connection.php';
$db = new connection();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <link rel="icon" type="image/x-icon" href="../images/logo.png">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php include_once './bootstrapInit.html'; ?>
        <link rel='stylesheet' href='../fullcalendar-3.4.0/lib/cupertino/jquery-ui.min.css' />
        <link href='../fullcalendar-3.4.0/fullcalendar.min.css' rel='stylesheet' />
        <link href='../fullcalendar-3.4.0/fullcalendar.print.min.css' rel='stylesheet' media='print' /> 



        <script src='../fullcalendar-3.4.0/lib/jquery.min.js'></script>
        <script src='../fullcalendar-3.4.0/lib/moment.min.js'></script>
        <script src='../fullcalendar-3.4.0/fullcalendar.js'></script>
        <script src='../fullcalendar-3.4.0/locale/he.js'></script>     


        <title>מערכת שעות</title>

        <style>

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

            .fc-day:hover{background: #ccffff;cursor: pointer;}  /* Changing default behavior of the calendar: adding pointer cursor and changing background color on hover */
            .fc-event:hover {
                border-color: #ccffff;
                cursor: pointer;
            }
            .fc-event:hover .fc-content {
                color: #ccffff;            
                cursor: pointer;
            }

            .fc-today{
                background: #ccffff !important;
                border: none !important;
                border-top: 1px solid #ddd !important;
                font-weight: bold;
            }



            #calendar {
                max-width: 900px;
                margin: 0 auto;
            }


        </style>
        <!--this script build the calendar, and presents her style -->
        <script>
            $(document).ready(function () {


                $('#calendar').fullCalendar({
                    theme: true,
                    eventColor: '#00BFF0',

                    header: {
                        left: 'next,prev today',
                        center: 'title',
                        right: 'month,agendaDay,agendaWeek'


                    },

                    isRTL: true,
                    eventLimit: true, // for all non-agenda views



                    eventClick: function (event, jsEvent, view) {

                        var getDate = moment(event.start).format();
                        window.location.href = "http://localhost/Final_Project/files/addnewevent.php?day=" + getDate;

                    },

                    dayClick: function (date, jsEvent, view) {
                        var getDate = date.format();
                        window.location.href = "http://localhost/Final_Project/files/addnewevent.php?day=" + getDate;


                    },

                    navLinkDayClick: function (date, jsEvent, view) {
                        var getDate = date.format();
                        window.location.href = "http://localhost/Final_Project/files/addnewevent.php?day=" + getDate;
                    },

                    navLinks: true,

                    events: [

<?php
/**
 * this function shows the events in the calendar
 */
$result = $db->GetEvents(1);
while ($row = mysqli_fetch_assoc($result)) {
    ?>

                            {title: '<?php echo $row['lesson_name'] ?>', start: '<?php echo $row['day'] ?>'},

<?php }
?>

                    ]


                })

            });

        </script>



    </head>
    <body dir="rtl">
        <!--A function that calls the header file-->
        <?php include_once ('header.php'); ?>
        <br><br><br>
        <div class="container-fluid text-center">    
            <div class="row content">
                <div class="col-sm-1 sidenav">


                </div>
                <div class="col-sm-10 text-left" style="margin-top:20px;"> 
                    <!-- the position of the calendar-->
                    <div id='calendar' class='myCalendar'></div>
                </div>
                <div class="col-sm-1 sidenav">

                </div>
            </div>
        </div>

        <!--a function that display the footer file-->
        <?php include_once ('footer.php'); ?>
    </body>  
</html>

