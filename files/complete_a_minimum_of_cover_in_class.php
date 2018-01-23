<?php
/**
 * The goal of this page is to attract customers to reach the class in order to complete a minimum quota 
 * of subscribers to the lesson.
 * this happens after the manager looks at the history of the drawings and he sees who
 * recorded the most for the lesson he wants to complete and sends those people the most recorded lesson lesson.
 */
include_once '../PHPMailer-master/mail.php';
include_once '../database/connection.php';
$mail = new mailConnection();
$db = new connection();
if (isset($_POST['send'])) {
    $Choosing_a_class = $_POST['Choosing_a_class'];
    $comment = $_POST['comment'];
    $result = $db->GetAllCustomerByLesson($Choosing_a_class);
    $IsFailToSend = FALSE;
    while ($row = mysqli_fetch_array($result)) {
        if ($row['count'] >= 1) {
            if (!$mail->SendSpeicalMessage($row['mail'], $comment)) {
                $IsFailToSend = TRUE;
                $message = "מייל לא נשלח נסה מאוחר יותר";
                echo "<script type='text/javascript'>alert('$message');</script>";
                break;
            }
        }
    }
    if (!$IsFailToSend) {
        $message = "ההודעה נשלחה בהצלחה!";
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
        <title>השלמת מכסה מינימלית</title>
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

            /* Set black background color, white text and some padding */
            footer {
                background-color: #555;
                color: white;
                padding: 15px;
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

        <!--a function that calls the header file-->
        <?php include_once ('header.php'); ?>

        <div class="container-fluid text-center">    
            <div class="row content" style="margin-top:20px;">
                <div class="col-sm-4 sidenav">


                </div>
                <div class="col-sm-4 text-left">
                    <h1><center>השלמת מכסה מינימלית לשיעור</center></h1>
                    <br>
                    <form action="complete_a_minimum_of_cover_in_class.php" method="post" class="form-horizontal" style="width:auto;" name="form" autocomplete="off">
                        <div>

                            <section  class="Ml_f">
                                <fieldset>



                                    <div class="form-group">
                                        <label  class="col-md-4 control-label" for="Choosing_a_class">בחירת שיעור</label>
                                        <div style="float:right;" class="col-lg-8">

                                            <select id="Choosing_a_class" name="Choosing_a_class" style="width: 200px;" class="form-control input-md" required="">
                                                <option value="">--בחר--</option>

                                                <?php
                                                /**
                                                 * this function returns all lessons details from `lessons` table in db.
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




                                    <div class="form-group">

                                        <label style="font-size:20px;"  class="col-md-4 control-label" for="comment">תוכן הודעה:</label>

                                        <textarea class="form-label" rows="3"  id="comment"style="width: 400px;height: 200px;" name="comment" required=""></textarea>
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


