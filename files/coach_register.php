<?php
/**
 * this code is send the details of coach from a form to db.
 * rather than show message that register is success.

 */
include_once '../database/connection.php';
$db = new connection();
$first_name = $last_name = $id_coach = $email = $phone = $trainer_certificate = $specialization = "";
if (isset($_POST['send'])) {
    $first_name = $_POST['fn'];
    $last_name = $_POST['ln'];
    $id_coach = $_POST['id'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $trainer_certificate = $_POST['Trainers_certificate'];
    $specialization = $_POST['type_of_specialization'];
    $result = $db->CheckCoach($id_coach);
    if (!$result) {
        $db->AddCoach($first_name, $last_name, $id_coach, $email, $phone, $trainer_certificate, $specialization);
        $message = "ההרשמה בוצעה בהצלחה!";
        echo "<script type='text/javascript'>alert('$message');</script>";
    } else {
        $message = "המאמן קיים!";
        echo "<script type='text/javascript'>alert('$message');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="he">
    <head>
        <meta charset="UTF-8">
        <link rel="icon" type="image/x-icon" href="../images/logo.png">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>רישום מאמן</title>
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

        <!--A function that calls the header file-->

        <?php include_once ('header.php'); ?>

        <!-- the form of registration -->


        <div class="container-fluid text-center">    
            <div class="row content" style="margin-top:20px;">
                <div class="col-sm-4 sidenav">


                </div>
                <div class="col-sm-4 text-left"> 
                    <h1><center>טופס רישום מאמן</center></h1>
                    <br>
                    <form class="form-horizontal" style="width: auto;" method="post" name="form" autocomplete="off">
                        <div>  
                            <section class="coach_f">
                                <fieldset>
                                    <!-- Text input-->
                                    <div class="form-group" >

                                        <label class="col-md-4 control-label" for="fn" pattern="/\p{Hebrew}/u">שם פרטי</label>  
                                        <div class="col-lg-8">
                                            <input id="fn" name="fn" style="width: 200px;"type="text" placeholder="שם פרטי" value="<?php echo $first_name ?>" class="form-control input-md" required="">

                                        </div>
                                    </div>

                                    <!-- Text input-->
                                    <div class="form-group" >
                                        <label  class="col-md-4 control-label" for="ln">שם משפחה</label>  
                                        <div class="col-lg-8" style="float:right;">
                                            <input id="ln" name="ln" style="width: 200px;" type="text" placeholder="שם משפחה" value="<?php echo $last_name ?>" class="form-control input-md" pattern="/\p{Hebrew}/u" required="">

                                        </div>
                                    </div>
                                    <!-- Text input-->
                                    <div class="form-group" >
                                        <label  class="col-md-4 control-label" for="id">תעודת זהות</label>  
                                        <div style="float:right;" class="col-lg-8">
                                            <input id="id" name="id" style="width: 200px;"   pattern="[0-9]{9}" title="אנא הכנס 9 ספרות"  placeholder="תעודת זהות" value="<?php echo $id_coach ?>" class="form-control input-md" required="">
                                        </div>
                                    </div>

                                    <!-- Text input-->
                                    <div class="form-group">
                                        <label  class="col-md-4 control-label" for="email">אי מייל</label>  
                                        <div style="float:right;" class="col-lg-8">
                                            <input id="email" name="email" style="width: 200px;" type="email" placeholder="אימייל" value="<?php echo $email ?>" pattern="^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$" class="form-control input-md" required="">
                                        </div>
                                    </div>
                                    <div class="form-group" >

                                        <label  class="col-md-4 control-label" for="phone">טלפון</label>
                                        <div class="col-lg-4" style="float:right;">

                                            <input id="phone" name="phone" placeholder="טלפון" style="width: 200px;" value="<?php echo $phone ?>" pattern="^\(?\d{3}\)?[-\s]?\d{7}.*?$" title="הכנס  10 ספרות" min="1" max="10" maxlengh="10"  class="form-control input-md" type="tel" required="">
                                        </div>
                                    </div>
                                    <!-- Text input-->
                                    <div class="form-group" >
                                        <label  class="col-md-4 control-label" for="Trainers_certificate">תעודת מאמן</label>
                                        <div style="float:right;" class="col-lg-8">
                                            <select id="Trainers_certificate" name="Trainers_certificate" style="width: 200px;" value="<?php echo $trainer_certificate ?>" class="form-control input-md" required="">
                                                <option value="">--בחר--</option>

                                                <!--return the type of the coach.
                                                for example type 1 ,type 2 or type 3-->

                                                <?php
                                                $result = $db->GetCoachType();
                                                while ($row = mysqli_fetch_array($result)) {
                                                    ?>
                                                    <option value="<?php echo $row['idCoachType'] ?>"><?php echo $row['name'] ?></option>    
                                                <?php } ?>

                                            </select>
                                        </div>
                                    </div>

                                    <!-- Text input-->
                                    <div class="form-group" >
                                        <label  class="col-md-4 control-label" for="type_of_specialization">סוג התמחות</label>  
                                        <div  style="float:right;" class="col-lg-8">
                                            <input id="type_of_specialization" name="type_of_specialization" value="<?php echo $specialization ?>" style="width: 200px;" type="text" placeholder="סוג התמחות" class="form-control input-md" required=""> 
                                        </div>
                                    </div>
                                    <div>
                                        <div align="center">  

                                            <button class="btn btn-primary text-center" name="send">שלח</button>
                                            <button class="btn btn-primary text-center" onclick="window.history.back()"> חזור</button>
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

        <?php include_once("footer.php"); ?>
    </body>
</html>

