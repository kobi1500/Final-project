<?php
/**
 *  this code is send the details of lesson from a form to db.
 * rather than show message that register is success.
 * this page is register of new lesson to db of studio.
 */
include_once '../database/connection.php';
$db = new connection();
if (isset($_POST['send'])) {
    $lesson_name = $_POST['name_lesson'];
    $lesson_type = $_POST['lesson_type'];
    $coach = $_POST['coach'];
    $min = $_POST['min'];
    $max = $_POST['max'];
    $description = $_POST['description'];
    $row = $db->CheckLesson($lesson_name);
    if ($row > 0) {
        $message = "השיעור קיים במאגר!";
        echo "<script type='text/javascript'>alert('$message');</script>";
    } else {
        $row = $db->AddLesson($lesson_name, $lesson_type, $coach, $max, $min, $description);
        if ($row > 0) {
            $message = "השיעור התווסף למאגר בהצלחה!";
            echo "<script type='text/javascript'>alert('$message');</script>";
        } else {
            $message = "השיעור לא התווסף אנה נסה שנית!";
            echo "<script type='text/javascript'>alert('$message');</script>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="he">
    <head>
        <meta charset="UTF-8">
        <link rel="icon" type="image/x-icon" href="../images/logo.png">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>רישום שיעור למאגר</title>
        <?php include_once './bootstrapInit.html'; ?>
         
  <style>
    /* Remove the navbar's default margin-bottom and rounded borders */ 
    .navbar {
      margin-bottom: 0;
      border-radius: 0;
      border-style: none; 
 
    }
    
    /* Set height of the grid so .sidenav can be 100% (adjust as needed) */
    .row.content {min-height:960px;max-height:1280px;}
    
    /* Set gray background color and 100% height */
    .sidenav {
      padding-top: 20px;
      background: #eee !important;
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
            function ChangeMaxValue(min, max)
            {

                if (min.value > max.value)
                {
                    max.value = min.value;
                }
            }
        </script>
    </head>
    <body dir="rtl"> 
        <!--A function that calls the header file-->
        <?php include_once ('header.php'); ?>
        <br><br>
      
        
        
<div class="container-fluid text-center">    
    <div class="row content" >
    <div class="col-sm-4 sidenav">
     

    </div>
         <div class="col-sm-4 text-left"style="margin-top:20px;"> 
             <h1 style="margin-right:50px;"><center>הכנסת שיעור למאגר</center> </h1>
         
        <!-- form of details -->
        <form action="register_lesson.php" method="post" class="form-horizontal" style="width: auto;" name="form" autocomplete="off">
            <div>
                <section class="rl_f">
                    <fieldset>
                        
                        <!-- Text input-->
                        <div class="form-group">

                            <label class="col-md-4 control-label" for="name_lesson">שם שיעור</label>  
                            <div class="col-lg-8" style="float:right;">
                                <input id="name_lesson" name="name_lesson" type="text"   style="width: 200px;" class="form-control input-md" required="">


                            </div>
                        </div>

                        
                        <!-- Text input-->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="lesson_type">סוג שיעור</label>  
                            <div class="col-lg-8" style="float:right;">
                                <select id="lesson_type" name="lesson_type" type="text"  class="form-control input-md" style="width: 200px;" required="">
                                            <?php
                                            /**
                                             * this function returns all types of lessons that exist in the studio.
                                             */
                                            $result = $db->GetLessonType();
                                            while ($row = mysqli_fetch_array($result)) {
                                                ?>
                                                <option value="<?php echo $row['idlessontype'] ?>"><?php echo $row['name'] ?></option>
                                            <?php }
                                            ?>
                                            </select>

                            </div>
                        </div>

                        <!-- Text input-->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="coach">מאמן</label>
                            <div style="float:right;" class="col-lg-8">

                                <select id="coach" name="coach" style="width: 200px;" class="form-control input-md" required="">
                                    <option value="">--בחר--</option>
                                    <?php
                                    /**
                                     * this function returns all coaches from `coaches` , `coachtype` tables in db.
                                     * the function performs a query that merges different tables,
                                     * resulting in a table containing the information from all the tables that have been consolidated.
                                     * and print the first_name and last_name to option select.        

                                     */
                                    $result = $db->GetCoaches();
                                    while ($row = mysqli_fetch_array($result)) {
                                        ?>
                                        <option value="<?php echo $row['id'] ?>"><?php echo $row['first_name'] . ' ' . $row['last_name'] ?></option>
                                    <?php }
                                    ?>

                                </select>
                            </div>
                        </div>

                        <!-- Text input-->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="min">מינימום נרשמים</label>  
                            <div class="col-lg-8" style="float:right;">
                                <input id="min" name="min" type="number"  min="1" style="width: 200px;" class="form-control input-md" required="" onkeydown="ChangeMaxValue(this, maximum)" >

                            </div>
                        </div>

                        <!-- Text input-->
                        <div class="form-group">
                            <label class="col-md-4 control-label"  for="max">מקסימום נרשמים</label>  
                            <div class="col-lg-8" style="float:right;">
                                <input id="maximum" name="max" type="number"  value="1" style="width: 200px;" class="form-control input-md" required="">

                            </div>
                        </div>
                        

                        <!-- Text input-->
                        <div style=" float: right;margin-top: 5px; margin-right: -10px;" class="col-sm-4">

                            <label style="font-size:16px;" for="description">תיאור שיעור:</label>

                            <textarea class="form-label" rows="3"  id="comment" style="width: 400px;height: 200px;" name="description" required=""></textarea>
                        </div>
                        <div style="margin-top:260px;margin-left: 10px;">
                            <div align="center">  

                    <button class="btn btn-primary text-left" name="send">שלח</button>
                    <button class="btn btn-primary text-left" onclick="window.history.back()"> חזור</button>
                </div>
            </div> 
                           </fieldset>
   
                </section>
            </div>

          
        </form>
    </div>
    <div class="col-sm-4 sidenav">
 
    </div>
  </div>
</div>

        <!--a function that display the footer file-->
        <?php include_once ('footer.php'); ?>        
    </body>
</html> 