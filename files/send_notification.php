<?php
/**
 * the purpose of this page is to send messages to the trainers according to the lesson.
 *so that the messages are sent to all trainees according to the lesson to which they are registered.
 */
include_once '../PHPMailer-master/mail.php';
include_once '../database/connection.php';
$db = new connection();
$mail = new mailConnection();
if (isset($_POST['send'])) {
    $choose_lesson = $_POST['choose_lesson'];
    $comment = $_POST['comment'];
    $title = $_POST['title'];
    $result = $db->GetCustomersByLessonid($choose_lesson);
    while ($row = mysqli_fetch_array($result)) {
        $db->InsertNotif($row['id'], $choose_lesson, $title, $comment);
    }
    $mail->SendMultiMail($choose_lesson, $comment);
    $message = "ההודעה נשלחה בהצלחה!";
    echo "<script type='text/javascript'>alert('$message');</script>";
}
?>
<!DOCTYPE html>
<html lang="he">
    <head>
        <meta charset="UTF-8">
        <link rel="icon" type="image/x-icon" href="../images/logo.png">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>שליחת הנחיות לשיעור</title>
        <?php include_once './bootstrapInit.html'; ?>
        <style>


            .row.content {min-height:960px;max-height:1280px;}

            .sidenav {
                padding-top: 20px;
                background: #eee !important;
                height: 100%;
            }



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
        <!--a function that calls the header file-->
        <?php include_once ('header.php'); ?>


        <div class="container-fluid text-center">    
            <div class="row content" style="margin-top:20px;">
                <div class="col-sm-4 sidenav">


                </div>
                <div class="col-sm-4 text-left"> 
                    <h1 style="margin-right:20px;"><center> שליחת הנחיות לשיעור</center></h1>
                    <br>
                    <form class="form-horizontal" style="width: auto;" method="post" action="send_notification.php" autocomplete="off">
                        <div>

                            <section class="sl_f" >
                                <fieldset style="margin:0px;padding: 0px;">

                                    <div class="form-group" align="right">
                                        <label  class="col-md-4 control-label"  for="choose_lesson">בחירת שיעור</label>
                                        <div class="col-lg-8">


                                            <select id="choose_lesson" name="choose_lesson" style="width: 200px;" class="form-control input-md" required="">
                                                <option value="">--בחר--</option>
                                                <?php
                                                /**
                                                 *  this function returns all lessons details from `lessons` table in db.
                                                 * the function performs a query that which takes all the details from the `lesson` table
                                                 * and returns them.
                                                 */
                                                $result = $db->GetLessons();
                                                while ($row = mysqli_fetch_array($result)) {
                                                    ?>
                                                    <option value="<?php echo $row['id']; ?>"><?php echo $row['lesson_name']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group" >

                                        <label class="col-md-4 control-label" for="title" pattern="/\p{Hebrew}/u">כותרת</label>  
                                        <div class="col-lg-8">
                                            <input  name="title" style="width: 200px;"type="text"   class="form-control input-md" required="">

                                        </div>
                                    </div>
                                    <div class="form-group">


                                        <label style="font-size:16px;"  class="col-md-4 control-label" for="comment">תוכן הודעה:</label>

                                        <textarea class="form-label" rows="3"  id="comment" style="width: 400px;height: 200px;" name="comment" required=""></textarea>
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
