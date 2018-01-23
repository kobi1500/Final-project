<?php
/**
 *  this code is send the details of subscription from a form to db.
 * rather than show message that update is success.
 * this page is update that date when the validity of subscribers is about to end.
 */
include_once ("../database/connection.php");
$db = new connection();
if (isset($_POST['send'])) {

    $name = $_POST['cn'];
    $duration_of_renewal = $_POST['duration_of_renewal'];
    $db->UpdateSubscribers($name, $duration_of_renewal);
    $message = "העדכון בוצע בהצלחה!";
    echo "<script type='text/javascript'>alert('$message');</script>";
}
?>
<!DOCTYPE html>
<html lang="he">
    <head>
        <meta charset="utf-8">
        <link rel="icon" type="image/x-icon" href="../images/logo.png">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>עדכון מנוי</title>
        <?php include_once './bootstrapInit.html'; ?>

        <script>

            /**
             * This function activates the send button and
             * the input box of the duration_of_renewal when you press the radio button.
             * @param duration_of_renewal
             * @param  send
             
             */
            function openInput(duration_of_renewal, send)
            {
                duration_of_renewal.disabled = false;
                send.disabled = false;
            }

            /**
             * this function by service class: select_subscribers prints the subscriber_type of the customer after 
             * selecting the customer's name.
             * @param val
             */
            function fetch_select(val)
            {
                $.ajax({
                    type: 'post',
                    url: 'select_subscribers.php',
                    data: {
                        get_option: val
                    },
                    success: function (response) {
                        document.getElementById("subscription_type").value = response;
                    }
                });
            }


        </script>

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
        <?php include_once ('header.php'); ?>



        <div class="container-fluid text-center">    
            <div class="row content" style="margin-top:20px;">
                <div class="col-sm-4 sidenav">


                </div>
                <div class="col-sm-4 text-left"> 
                    <h1><center>טופס עדכון מנוי</center> </h1>
                    <br>
                    <!-- form of details -->
                    <form class="form-horizontal" style="width: auto;" method="post" name="form" autocomplete="off">
                        <div>
                            <section  class="ut_f">
                                <fieldset>
                                    <div class="form-group">
                                        <label  class="col-md-4 control-label" for="cn">שם לקוח</label>
                                        <div style="float:right;" class="col-lg-8">
                                            <select id="cn" name="cn" style="width: 200px;" class="form-control input-md" required="" onchange="fetch_select(this.value);">
                                                <option value="">--בחר--</option>
                                                <?php
                                                /**
                                                 * this function returns all subscribers details from `customers` table in db where if the subscriber_type is 1 or 2.
                                                 * because this function returns the subscribers who are on the system and type_subscriber=1 or 2
                                                 * this type of subscriber.
                                                 * and print the first_name and last_name to option select. 
                                                 */
                                                $result = $db->GetSubscribers();
                                                while ($row = mysqli_fetch_array($result)) {
                                                    ?>
                                                    <option value="<?php echo $row['id'] ?>"><?php echo $row['first_name'] . " " . $row['last_name'] ?></option>
                                                <?php } ?>


                                                ?>

                                            </select>
                                        </div> 


                                    </div>
                                    <div class="form-group">

                                        <label class="col-md-4 control-label" for="subscription_type">סוג מנוי</label>  
                                        <div style="float:right;" class="col-lg-8">
                                            <input type="text" id="subscription_type" name="subscription_type" style="width: 200px;"type="text" class="form-control input-md" readonly="">

                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-4 control-label" for="duration_of_renewal">חדש מנוי</label>
                                        <div class="col-md-4" style="width:50px;float:right;margin-right: -60px;"> 
                                            <label class="radio" for="duration_of_renewal" >

                                                <input class="col-md-4 control-label" type="radio" name="radio" onsubmit="" id="renew_subscription" style="width:20px" onclick="openInput(duration_of_renewal, send)">     
                                            </label>

                                        </div> 

                                    </div>
                                    <div class="form-group">
                                        <label  class="col-md-4 control-label" for="duration_of_renewal">משך חידוש</label>
                                        <div style="float:right;" class="col-lg-8">
                                            <select id="duration_of_renewal" name="duration_of_renewal" style="width: 200px;" class="form-control input-md" disabled="" required="">
                                                <option value="">--בחר--</option>
                                                <option value="6">חצי שנה</option>
                                                <option value="12">שנה</option>

                                            </select>
                                        </div>
                                    </div>
                                    <div align="center" style="margin-right:30px;">
                                        <div>  

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

