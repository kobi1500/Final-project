<?php
/**
 *the purpose of this page is to register a new customer into the studio.
*when the system is registered, the system checks whether the customer exists, and if the administrator receives an appropriate notice.
*if the customer is not enrolled in the studio and a message is displayed according to the customer.
*the customer's email is then sent a user name and password. 
 * in addition, there is an examination of the customer's subscription type and according to the
 *selection, the customer enters the appropriate table of the subscriber type.
 */
include_once ("../database/connection.php");
include_once("../PHPMailer-master/mail.php");
$db = new connection();
$mail = new mailConnection();
$first_name = $last_name = $id_customer = $email = $type_subscriber = $email = $phone = $choice = "";
if (isset($_POST['send'])) {

    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $id_customer = $_POST['id_customer'];
    $email = $_POST['mail'];
    $type_subscriber = $_POST['subscriber_type'];
    $phone = $_POST['phone_number'];
    $choice = $_POST['radio'];
    $result = $db->CheckCustomer($id_customer);
    if (!$result) {
        $id = $db->AddToCustomers($first_name, $last_name, $id_customer, $email, $type_subscriber, $phone, $choice);
        $mail->sendMessage($phone, $email, $id_customer);
        $message = "ההרשמה בוצעה בהצלחה המערכת שולחת ברגעים אלה למייל של המתאמן/ת את השם משתמש והסיסמא שלו/ה!";
        echo "<script type='text/javascript'>alert('$message');</script>";
        if ($type_subscriber < 3) {
            $db->insertSubscribers($id);
        } else {
            $db->insertCards($id);
        }
    } else {
        $message = "הלקוח קיים!";
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
        <title>רישום לקוח</title>
        <?php include_once './bootstrapInit.html'; ?>
        <style>

         
            .row.content {min-height:960px;max-height:1280px;}

           
            .sidenav {
                padding-top: 20px;
                background-color: #eee;
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

        <!--A function that calls the header file-->

        <?php include_once ("header.php"); ?>

        <div class="container-fluid text-center">    
            <div class="row content">
                <div class="col-sm-4 sidenav">


                </div>
                <div class="col-sm-4 text-left"> 

                    <br><br>
                    <h1><center>טופס רישום לקוח </center></h1>
                    <br>

                    <!-- form of details-->
                    <form class="form-horizontal" style="width: auto;" method="post" name="form" autocomplete="off">
                        <div>
                            <section class="customer_f">
                                <fieldset>

                                    <!--save the information of the values-->
                                    <!-- Text input-->
                                    <div class="form-group">

                                        <label class="col-md-4 control-label" for="first_name">שם פרטי</label>  
                                        <div class="col-lg-8" style="float:right;">
                                            <input id="first_name" name="first_name" type="text" placeholder="שם פרטי"  pattern="/\p{Hebrew}/u"  style="width: 200px;" class="form-control input-md" value="<?php echo $first_name ?>" required="">


                                        </div>
                                    </div>
                                    <!--save the information of the values-->
                                    <!-- Text input-->
                                    <div class="form-group">
                                        <label class="col-md-4 control-label" for="last_name">שם משפחה</label>  
                                        <div class="col-lg-8" style="float:right;">
                                            <input id="last_name" name="last_name" type="text" placeholder="שם משפחה" pattern="/\p{Hebrew}/u" class="form-control input-md" value="<?php echo $last_name ?>" style="width: 200px;" required="">

                                        </div>
                                    </div>
                                    <!--save the information of the values-->
                                    <!-- Text input-->
                                    <div class="form-group">
                                        <label class="col-md-4 control-label"  for="id_customer">תעודת זהות</label>  
                                        <div class="col-lg-8" style="float:right;">
                                            <input id="id_customer" name="id_customer"  pattern="[0-9]{9}" title="אנא הכנס 9 ספרות" placeholder="תעודת זהות" style="width: 200px;" class="form-control input-md" value="<?php echo $id_customer ?>" required="">

                                        </div>
                                    </div>
                                    <!--save the information of the values-->
                                    <!-- Text input-->
                                    <div class="form-group">
                                        <label class="col-md-4 control-label"  for="mail">אי מייל</label>  
                                        <div class="col-lg-8" style="float:right;">
                                            <input id="mail" name="mail" type="email" placeholder="אימייל" pattern="^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$" style="width: 200px;" value="<?php echo $email ?>" class="form-control input-md" required="">

                                        </div>
                                    </div>


                                    <!--save the information of the values-->
                                    <!-- Text input-->
                                    <div class="form-group">
                                        <label class="col-md-4 control-label" for="subscriber_type">סוג מנוי</label>
                                        <div style="float:right;" class="col-lg-8">

                                            <select id="subscriber_type" name="subscriber_type"  style="width: 200px;" value="<?php echo $type_subscriber ?>" class="form-control input-md" required="">
                                                <option value="">--בחר--</option>
                                                <?php
                                                /**
                                                 * choose the type of the coustomer
                                                 * for example customer with semi-annual subscription
                                                 */
                                                $result = $db->GetCustomerType();
                                                while ($row = mysqli_fetch_array($result)) {
                                                    ?>
                                                    <option value="<?php echo $row['idCustomerType']; ?>"><?php echo $row['name']; ?></option>
                                                <?php }
                                                ?>

                                            </select>
                                        </div>

                                    </div>
                                    <!--save the information of the values-->
                                    <!-- Text input-->
                                    <div class="form-group">

                                        <label  class="col-md-4 control-label" for="phone_number">טלפון</label>

                                        <div class="col-lg-4" style="float:right;">

                                            <input id="phone_number" name="phone_number" placeholder="טלפון" pattern="^\(?\d{3}\)?[-\s]?\d{7}.*?$" title="הכנס  10 ספרות" min="1" max="10" maxlengh="10" value="<?php echo $phone ?>" style="width: 200px;" class="form-control input-md" type="text" required=""> 


                                        </div>


                                    </div>
                                    <?php
                                    /**
                                     * return the type of the selection of the user.
                                     */
                                    $result = $db->GetChoiceType();
                                    while ($row = mysqli_fetch_array($result)) {
                                        ?>
                                        <div class="form-group">
                                            <label class="col-md-4 control-label" for="medical_certificate"><?php echo $row['name'] ?></label>
                                            <div class="col-md-4"> 
                                                <label class="radio" for="medical_certificate" >

                                                    <input class="col-md-4 control-label" type="radio" name="radio" onsubmit="if (!this.checked) {
                                                                alert(אנא בחר אחד מהאפשרויות)}" id="medical_certificate" style="width:20px;float:right;"      <?php if (isset($choice) && $choice == $row['idchoice']) echo "checked"; ?> value="<?php echo $row['idchoice'] ?>"  required=""> 
                                                </label>

                                            </div> 

                                        </div>
                                    <?php }
                                    ?>
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
        <br><br>

        <!--a function that display the footer file-->
        <?php include_once("footer.php"); ?>
    </body>
</html>

