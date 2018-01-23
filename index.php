<?php
/**
 *this class is actually the main page of the site.
 *from here you can see the classes in the studio,
 *club alerts that the club sends or navigates to other pages on the site.
 * this page has a top and bottom: at the top there is a toolbar that allows navigation to all parts of the site.
 *at the bottom are shortcuts to the main pages on the site, contact the development team and reports produced on the site.
 */
include_once './database/connection.php';
$db = new connection();
?>

<!DOCTYPE html>
<html lang="he">
    <head>
   <meta charset="UTF-8">
        <link rel="icon" type="image/x-icon" href="images/logo.png">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>shapeIt</title>
        <?php include_once './bootstrapInit.html'; ?>
        <link rel='stylesheet' href='fullcalendar-3.4.0/lib/cupertino/jquery-ui.min.css' />
        <link href='fullcalendar-3.4.0/fullcalendar.min.css' rel='stylesheet' />
        <link href='fullcalendar-3.4.0/fullcalendar.print.min.css' rel='stylesheet' media='print' /> 

        <script src='fullcalendar-3.4.0/lib/jquery.min.js'></script>
        <script src='fullcalendar-3.4.0/lib/moment.min.js'></script>
        <script src='fullcalendar-3.4.0/fullcalendar.js'></script>
        <script src='fullcalendar-3.4.0/locale/he.js'></script>   



  
  <style>
    /* Remove the navbar's default margin-bottom and rounded borders */ 
    .navbar {
      margin-bottom: 0;
      border-radius: 0;
      border-style: none; 
 
    }
    
    /* Set height of the grid so .sidenav can be 100% (adjust as needed) */
    .row.content {height: 450px}
    
    /* Set gray background color and 100% height */
    .sidenav {
      padding-top: 20px;
      background: #eee !important;
      height: 100%;
    }
    
    /* Set black background color, white text and some padding */
  
    
    /* On small screens, set height to 'auto' for sidenav and grid */
    @media screen and (max-width: 767px) {
      .sidenav {
        height: auto;
    
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
                width:500px;
            height:600px;
            }

  </style>
  
            <script>
                $(document).ready(function () {


                    $('#calendar').fullCalendar({
                        theme: true,
                        eventColor: '#00BFF0',

                        header: {// layout header
                            left: 'month,agendaWeek,listWeek',
                            center: '',
                            right: '',
                        },

                        isRTL: true,
                        eventLimit: true, // for all non-agenda views

                        navLinks: true,

                        events: [

<?php
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
 

<nav class="navbar navbar-default">
   <?php include_once ('header.php'); ?>
  
</nav>
     

  <div style="margin:0;width:100%;" class="main_pic" style="margin-top: -48px;">
                <img src="images/main_pic.jpg" alt=""style="margin: 0;width: 100%;height: 75%;padding-bottom: 26px;margin-top: -1px;"/>
            </div>
<div class="container"> 
  <div class="row content">
    <div class="col-sm-3 sidenav">
  
               
    
                        <div  style="width:auto;">
                             <h4 style="width:200px;">התראות</h4>
                            &nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp;

                    <marquee style="margin-left:40px;width:300px;height:400px; "  class="marquee" onMouseOver="this.scrollAmount = 0" onMouseOut="this.scrollAmount = 2" bgcolor="#ffffff"  scrollamount="2" direction="up" loop="true"  >
                        <font size="+1"><strong>
   <?php
                                $result = $db->GetNotification();
                                while ($row = mysqli_fetch_array($result)) {

 $date = date_create($row['register_date']);

                                    echo "המתאמן" . " " . $row['first_name'] . " " . $row['last_name'] ." ". "נרשם לשיעור" . " " . $row['lesson_name'] . " " . "בתאריך" . " " .  date_format($date, "d-m-Y") ."<br><br>";
                                }
                                ?>
                        </strong></font><p>
                    </marquee >

                    </div>


    </div>
    <div class="col-sm-6 text-left"> 
           <div style="height:40px;">
            

            </div>
       <div>
                <div id='calendar' class='myCalendar'></div>

            </div>
    </div>
    <div class="col-sm-3 sidenav" style="margin-top: -25px;">
          <h3 >שלום מנהל סטודיו GSN</h3>
   
</div>

  </div>
<div class="container-fluid text-center">  
</div>
   </div>
    <div>
<?php include_once 'footer.php';?>
    </div>

</body>
</html>
