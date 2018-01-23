<?php
/**
 *  this code is send the details of tabs from a form to db.
 * rather than show message that update is success.
 * this page is update that card balance when the card balance of customers is about to end.
 */
include_once '../database/connection.php';
$db = new connection();

if (isset($_POST['send'])) {
    $name = $_POST['name'];
    $duration = $_POST['duration_of_renewal'];
    $db->UpdateTabs($name, $duration);
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
        <title>עדכון כרטיסייה</title>

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
             * this function by service class: select prints the balance of the tab after 
             * selecting the customer's name.
             * @param val
             */
            function fetch_select(val)
            {
                $.ajax({
                    type: 'post',
                    url: 'select.php',
                    data: {
                        get_option: val
                    },
                    success: function (response) {
                        document.getElementById("card_balance").value = response;
                    }
                });
            }


        </script>

    </head>
    <body dir="rtl"> 

        <!--A function that calls the header file-->
        <?php include_once ('header.php'); ?>
        <br><br>


        <div class="container-fluid text-center">    
            <div class="row content">
                <div class="col-sm-4 sidenav">


                </div>
                <div class="col-sm-4 text-left"> 
                    <h1><center>טופס עדכון כרטיסייה</center> </h1>
                    <br>
                    <!-- form of details -->
                    <form class="form-horizontal" style="width: auto;" method="post" name="form" autocomplete="off">
                        <div>
                            <section class="su_f">
                                <fieldset>
                                    <div class="form-group">
                                        <label class="col-md-4 control-label" for="name">שם לקוח</label>
                                        <div style="float:right;" class="col-lg-8">
                                            <select id="name" name="name" style="width: 200px;" class="form-control input-md" required="" onchange="fetch_select(this.value);">
                                                <option value="">--בחר--</option>
                                                <?php
                                                /**
                                                 * this function returns all customers details from `customers` table in db where if the subscriber_type is 3.
                                                 * because this function returns the owners of the tabs who are on the system.  
                                                 * and print the first_name and last_name to option select.        
                                                 */
                                                $result = $db->GetTabs();
                                                while ($row = mysqli_fetch_array($result)) {
                                                    ?>
                                                    <option value="<?php echo $row['id'] ?>"><?php echo $row['first_name'] . " " . $row['last_name'] ?></option>
                                                <?php } ?>


                                                ?>

                                            </select>
                                        </div> 


                                    </div>
                                    <div class="form-group">

                                        <label class="col-md-4 control-label" for="card_balance">יתרת כרטיסייה</label>  
                                        <div style="float:right;" class="col-lg-8">
                                            <input type="number" id="card_balance" name="card_balance" style="width: 200px;"type="text" class="form-control input-md" readonly="">

                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-4 control-label" for="renew_subscription">חדש כרטיסייה</label>
                                        <div class="col-md-4" style="width:50px;float:right;margin-right: -60px;"> 
                                            <label class="radio" for="renew_subscription" >

                                                <input class="col-md-4 control-label" type="radio" name="radio" onsubmit="" id="renew_subscription" style="width:20px" onclick="openInput(duration_of_renewal, send)">     
                                            </label>

                                        </div> 

                                    </div>
                                    <div class="form-group">
                                        <label  class="col-md-4 control-label" for="duration_of_renewal">משך חידוש</label>
                                        <div style="float:right;" class="col-lg-8">
                                            <select id="duration_of_renewal" name="duration_of_renewal" style="width: 200px;" class="form-control input-md" required="" disabled="" >
                                                <option value="">--בחר--</option>
                                                <option value="10">10 ניקובים</option>
                                                <option value="20">20 ניקובים</option>
                                                <option value="30">30 ניקובים</option>

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
