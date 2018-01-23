

<html>
    <head>
        <meta charset="utf-8">
         <meta name="viewport" content="width=device-width, initial-scale=1">
       
        <?php include_once './bootstrapInit.html' ?>
        
    </head>
    <body>
 

        <div class="header-bottom"style="width:auto">
<div class="container-fluid text-center" >
    <div class="header-bottom_left">
        <i class="phone"> </i><span><?php
        date_default_timezone_set("Asia/Jerusalem");
        echo date("d/m/y")." "."|"."  ". date("H:i");?></span>
			</div>

    	<div class="social">	
			   <ul>
                                <a href="https://www.facebook.com/gil.negrin.9?fref=ts" target="_blank"><i class="fa fa-facebook-square "style="font-size: 20px;"></i></a></li>
				  <li class="twitter"><a href="#"><i class="fa fa-twitter"style="font-size: 20px;"></i></a></li>
                                  <li class="instagram "><a href="https://www.instagram.com/explore/locations/562465197271711/gsn-/" target="_blank"><i class="fa fa-instagram "style="font-size: 20px;"></i></a></li>	
                                  <li class="home"><a href="../index.php"><i class="fa fa-home"style="font-size: 20px;"></i></a></li>
                               
			   </ul>
		   </div>
   </div> 
</div>  
        
        
        <div class="container-fluid text-center">    
  <div class="row content" style="height:120px;">
     <div class="col-sm-2 " style="background: #72d0f4;margin:0;padding:0;height:120px;">
    <div  >
        <img src="images/logo.png" style="width:124px;height:95px;margin-top:20px;">
         </div>
    </div>
    <div class="col-sm-10 text-right"  style="background: #72d0f4;margin:0;padding:0;height:120px;">
            <nav class="nav navbar-nav  navbar-right" style="width:100%;">
     <div class="menu" style="width: 100%;margin-top:20px;">
        
     <div class="container">

        <div class="container-fluid">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
           
          </div>
          <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right" >
              
                <li class="dropdown" >
                <a   style="width: 185px;color:#fff;" href="#" class="dropdown-toggle" data-toggle="dropdown" role="button">כרטיסיות/מנויים <span class="caret"></span></a>
                <ul class="dropdown-menu"  > 
                    <li ><a href="files/update_tab.php" style="text-align: right;">עדכון כרטיסיות</a></li>
                    <li><a href="files/subscription_update.php" style="text-align: right;">עדכון מנוי ללקוחות</a></li>
                </ul>
              </li>
            
                     <li class="dropdown">
                <a href="#" style="width: 120px;color:#fff;" class="dropdown-toggle" data-toggle="dropdown" role="button">הרשמות <span class="caret"></span></a>
                <ul class="dropdown-menu"style="padding: 5px;">
                    <li><a href="files/customer_register.php" style="text-align: right; ">רישום לקוח</a></li>
                    <li><a href="files/coach_register.php" style="text-align: right">רישום מאמן</a></li>
                </ul>
              </li>
             
          
                    <li class="dropdown">
                <a href="#" style="width: 155px;color:#fff;" class="dropdown-toggle" data-toggle="dropdown" role="button">מערכת שעות <span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><a href="files/events.php" style="text-align: right;">מערכת שעות</a></li>
                    <li><a href="files/register_lesson.php" style="text-align: right">רישום שיעורים למאגר</a></li>
                 
                </ul>
              </li>
             
              <li class="dropdown">
                <a href="#" style="width: 175px;color:#fff;" class="dropdown-toggle" data-toggle="dropdown" role="button">שליחת התראות <span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><a href="files/send_notification.php" style="text-align: right">הנחיות לשיעור</a></li>
                    <li><a href="files/complete_a_minimum_of_cover_in_class.php" style="text-align: right"> השלמת מכסה מינימלית<br> לשיעור</a></li> 
                </ul>
              </li>
                <li class="dropdown">
                <a href="#" style="width: 105px;color:#fff;" class="dropdown-toggle" data-toggle="dropdown" role="button">דוחות <span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><a href="files/customer_report.php" style="text-align: right">דוח לקוחות</a></li>
                    <li><a href="files/lesson_report.php" style="text-align: right"> דוח שיעורים</a></li> 
                    <li><a href="files/coach_report.php" style="text-align: right">דוח מאמנים</a></li>
                    <li><a href="files/report_history_lesson.php" style="text-align: right"> דוח היסטוריית<br> רישומים</a></li> 
                    <li><a href="files/changes_report.php" style="text-align: right"> דוח שינויים</a></li> 
                    <li><a href="files/cancel_lesson_by_coaches_report.php" style="text-align: right;"> דוח ביטול שיעורים<br> על ידי מאמנים</a></li> 
                    <li><a href="files/inlay_Lesson_report.php" style="text-align: right"> דוח שיבוץ שיעורים</a></li> 
                </ul>
              </li>
            </ul>
              
          </div>
        </div>
   
     </div> 
          </div>
            </nav>
    </div>

  </div>
            
</div>       
        
    
        

    </body>
</html> 