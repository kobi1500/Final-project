<?php

/**
 * this class connect to the database and manipulate it;
 */
class connection {

    /**
     *
     * connection string
     */
    private $con;

    /**
     * constractor of connection to db
     */
    function __construct() {
        $this->con = mysqli_connect("localhost", "root", "1234", "final_project");
        mysqli_set_charset($this->con, "utf8");


        if (!$this->con) {
            die("Connection failed: " . mysqli_connect_error());
        }
    }

    /*     * *****************functions of web**********************             */

    /**
     * insert the details of customer to db.
     * @param type $first_name,$last_name,$id_customer,$mail,$subscriber_type,$phone,$choice.]
     * @return insert_id.
     */
    function AddToCustomers($first_name, $last_name, $id_customer, $mail, $subscriber_type, $phone, $choice) {
        $result = $this->con->query("INSERT INTO customers (`first_name`,`last_name`,`id_customer`,`mail`,`subscriber_type`,`phone_number`,`choice`,`register_date`) VALUES ('$first_name','$last_name','$id_customer','$mail','$subscriber_type','$phone','$choice',now());");
        return $this->con->insert_id;
    }

    /**
     * this function is check if the customer is exist in the system,
     * if yes the function return TRUE, otherwise the function return FALSE.
     * @param $id_customer
     * @return boolean
     */
    function CheckCustomer($id_customer) {
        $result = $this->con->query("select * from customers where id_customer=$id_customer");
        if ($result->num_rows == 0) {
            return FALSE;
        }
        return TRUE;
    }

    /**
     * this function is check if the coach is exist in the system,
     * if yes the function return TRUE, otherwise the function return FALSE.
     * @param $id_coach
     * @return boolean
     */
    function CheckCoach($id_coach) {
        $result = $this->con->query("select * from coaches where coach_id=$id_coach");
        if ($result->num_rows == 0) {
            return FALSE;
        }
        return TRUE;
    }

    /**
     * insert the details of coach to db. 
     * @param type $first_name,$last_name,$id_coach,$email,$phone,$trainer_certificate,$specialization.
     */
    function AddCoach($first_name, $last_name, $id_coach, $email, $phone, $trainer_certificate, $specialization) {
        $result = $this->con->query("INSERT INTO coaches (`first_name`,`last_name`,`coach_id`,`email`,`phone`,`trainer_certificate`,`specialization`) VALUES ('$first_name','$last_name','$id_coach','$email','$phone','$trainer_certificate','$specialization');");
    }

    /**
     * insert the details of customer to history_records.
     * @param $scheduleid,$id_customer.
     *
     * 
     */
    function AddHistory($id_customer, $scheduleid) {

        $result = $this->con->query("INSERT INTO history_records (`id_customer`,`scheduleid`,`register_date`) VALUES ($id_customer','$scheduleid',now());");
    }

    /**
     * insert the details of lesson to db.
     * @param type $lesson_name,$lesson_type,$coaches,$max_register,$min_register,$description.
     * @return insert_id.
     */
    function AddLesson($lesson_name, $lesson_type, $coaches, $max_register, $min_register, $description) {

        $this->con->query("INSERT INTO lessons (`lesson_name`,`lesson_type`,`coachid`,`max_register`,`min_register`,`description`) VALUES ('$lesson_name','$lesson_type','$coaches','$max_register','$min_register','$description');");
        return $this->con->insert_id;
    }

    /**
     * this function is check if the lesson is exist in the system,
     * if yes the function return 0, otherwise the function return the id of lesson.
     * @param $lesson_name
     * @return id
     */
    function CheckLesson($lesson_name) {
        $result = $this->con->query("select * from lessons where lesson_name='$lesson_name'");
        if ($result->num_rows == 0) {
            return 0;
        }
        $row = mysqli_fetch_array($result);
        return $row['id'];
    }

    /**
     * this function generate random password
     * Which consists of 4 Characters:small letters or big letters in english or digits.
     * There could be a combination of the two letters and digits.
     * return type.
     */
    function GeneratePassword() {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 4; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass);
    }

    /**
     * this function insert that username and password to table of customers.
     * this function work after that customer received that username and password in mail.
     * @param $user,$password,$id.
     */
    function insertPasswordAndUserName($user, $password, $id) {

        $result = $this->con->query("update customers set user_name='$user' , password='$password' where id_customer='$id';");
    }

    /**
     * this function insert that details of subscribers if the id of subscriber
     * is not exist.
     * @param $customer_id
     */
    function insertSubscribers($customer_id) {
        $result = $this->con->query("select * from subscribers where customerid='$customer_id'");
        if ($result->num_rows == 0) {
            $result = $this->con->query("INSERT INTO subscribers (`customerid`,`datevalidity`) VALUES ('$customer_id',now());");
        }
    }

    /**
     * this function insert that details of tabs if the id of customer that have tab
     * is not exist.
     * @param $id
     */
    function insertCards($id) {
        $result = $this->con->query("select * from tabs where customerid='$id'");
        if ($result->num_rows == 0) {
            $result = $this->con->query("INSERT INTO tabs (`customerid`) VALUES ('$id');");
        }
    }

    /**
     * this function update that card_balance of tabs if the id of customer that have tab
     * is exist.
     * @param $customreid,$duration.
     */
    function UpdateTabs($customerid, $duration) {
        $result = $this->con->query("select * from tabs where customerid='$customerid'");
        $row = mysqli_fetch_array($result);
        $sum = $row['card_balance'] + $duration;
        $result = $this->con->query("update tabs set card_balance='$sum',duration='$duration' where customerid='$customerid'");
    }

    /**
     * this function update that duration_of_renewal of subscribers.
     * this function updates the duration_of_renewal according to the parameter the function receives:duration
     *  and it occurs in the months and according to the id of the customer.
     * @param $id,$duration.
     */
    function UpdateSubscribers($id, $duration) {
        $result = $this->con->query("select * from subscribers where customerid='$id'");
        $row = mysqli_fetch_array($result);
        $result = $this->con->query("UPDATE subscribers SET `datevalidity` = DATE_ADD(`datevalidity` , INTERVAL $duration month) where customerid='$id'");
    }

    /**
     * this function is delete event from the `schedule` table in db.
     * the function get parameter id and execute delete of the record by id.
     * @param type $id
     */
    public function DeleteEvents($id) {
        $result = $this->con->query("UPDATE `schedule` SET `idactive`='2' WHERE `scheduleid`='$id';");
    }

    /**
     * this function is returns all events from `schedule` , `lessons` , `coaches` in db.
     * the function actually performs a union of several tables and returns all the details from these tables.
     * @return result from query.
     */
    public function GetEvents($id) {
        $result = $this->con->query("SELECT * FROM schedule,lessons,lessontype,coaches where schedule.lessonid=lessons.id and lessons.lessontypeid=lessontype.idlessontype  and lessons.coachid=coaches.id and schedule.idactive=$id");
        return $result;
    }

    /**
     * this function is add new event to the `schedule` table in db.
     * The function also returns the last id added to the table.
     * @param type $lessonid
     * @param type $time
     * @param type $date
     * @return insert_id
     */
    public function AddEvent($lessonid, $time, $date) {

        $this->con->query("INSERT INTO `schedule` (`lessonid`, `hour`, `day`) VALUES ('$lessonid', '$time', '$date');");
        return $this->con->insert_id;
    }

    /**
     * this function returns all customers information from the record history table.
     * @return result of query.
     */
    public function GetHistoryRecords() {
        $result = $this->con->query("select * from customers,lessons,schedule,history_records,status where customers.status=status.idstatus and lessons.id=schedule.lessonid and customers.id=history_records.id_customer and history_records.scheduleid=schedule.scheduleid and history_records.idactive=1");
        return $result;
    }

    /**
     * This function returns all details of changes of lessons from different tables.
     * @return result of query.
     */
    public function GetChangesOfLessons() {
        $result = $this->con->query("select * from lessons,coaches where lessons.coachid=coaches.id");
        return $result;
    }

    /**
     *this function counts the number of cancellations according to the
     * id of the lesson and returns the number of cancellations of the lesson.
     * @param $id
     * @return count.
     */
    public function GetCancelLessonById($id) {
        $result = $this->con->query("SELECT count(*) as count FROM lessons,schedule,history_records where lessons.id=schedule.lessonid and history_records.scheduleid=schedule.scheduleid and history_records.idactive=2 and lessons.id=$id");
        $row = mysqli_fetch_array($result);
        return $row['count'];
    }

    /**
     *  this function returns all coaches from `coaches` , `coachtype` tables in db.
     * the function performs a query that merges different tables,coa
     * resulting in a table containing the information from all the tables that have been consolidated.
     * @return result from query.
     */
    public function GetCoaches() {
        $result = $this->con->query("SELECT * FROM coaches,coachtype where coaches.trainer_certificate=coachtype.idCoachType;");
        return $result;
    }

    /**
     * this function returns all coaches and lessons from `coaches` , `lessons` tables in db.
     * the function performs a query that merges different tables,
     * resulting in a table containing the information from all the tables that have been consolidated.
     * @return  result from query.
     */
    public function GetCoachLessons() {
        $result = $this->con->query("SELECT * FROM coaches,lessons,lessontype where coaches.id=lessons.coachid and lessons.lessontypeid=lessontype.idlessontype");
        return $result;
    }

    /**
     * this function returns all lessons details from `lessons` table in db.
     * the function performs a query that which takes all the details from the `lesson` table
     * and returns them.
     * @return  result from query.
     */
    public function GetLessons() {
        $result = $this->con->query("SELECT * FROM lessons;");
        return $result;
    }
    
    /**
     *this function returns all types of lessons that exist in the studio.
     * @return result from query.
     */
        function GetLessonType(){
      $result=$this->con->query("select * from lessontype");
      return $result;
    }

    /**
     * this function returns all coachType details from `coachtype` table in db.
     * the function performs a query that which takes all the details from the `coachtype` table
     * and returns them.
     * @return  result from query.
     */
    public function GetCoachType() {
        $result = $this->con->query("SELECT * FROM coachtype;");
        return $result;
    }

    /**
     * this function returns all CustomerType details from `customertype` table in db.
     * the function performs a query that which takes all the details from the `customertype` table
     * and returns them.
     * @return  result from query.
     */
    public function GetCustomerType() {
        $result = $this->con->query("SELECT * FROM customertype;");
        return $result;
    }

    /**
     * this function returns all Customers details from `customers` table in db.
     * the function performs a query that which takes all the details from the `customers` table
     * and returns them.
     * @return  result from query.
     */
    public function GetCustomers() {
        $result = $this->con->query("SELECT * FROM customers;");
        return $result;
    }

    /**
     * this function returns all subscribers details from `customers` table in db where if the subscriber_type is 1 or 2.
     * because this function returns the subscribers who are on the system and type_subscriber=1 or 2
     * this type of subscriber.
     * @return  result from query.
     */
    public function GetSubscribers() {
        $result = $this->con->query("select * from customers where subscriber_type=1 or subscriber_type=2");
        return $result;
    }

    /**
     * this function returns all choice details from `choice` table in db.
     * the function performs a query that which takes all the details from the `choice` table
     * and returns them.
     * @return  result from query.
     */
    public function GetChoiceType() {
        $result = $this->con->query("SELECT * FROM choice;");
        return $result;
    }

    /**
     * this function is transfer to another page.
     * the function get parameter which is actually a page and redirect by the page.
     * @param $page
     */
    public function Redirect($page) {
        header("Location: $page");
    }

    /**
     * this function returns card_balance  from `tabs` table in db where the customerid equal to the parameter that the function accepts.
     * the function performs a query that which takes that card_balance from the `tabs` table
     * and returns them.
     * @param $option
     * @return  card_balance.
     */
    public function GetOption($option) {
        $result = $this->con->query("select card_balance from tabs where customerid='$option'");
        $row = mysqli_fetch_array($result);
        return $row['card_balance'];
    }

    /**
     * this function returns name from `customers`, `subscribers`,`customertype` table in db.
     * the function performs a query that merges different tables,
     * resulting in a table containing the information from all the tables that have been consolidated.
     * the function get parameter of option. 
     * @param $option
     * @return  name.
     */
    public function GetOptionSubscribers($option) {
        $result = $this->con->query("select name from customers,subscribers,customertype where customers.id=subscribers.customerid and customers.subscriber_type=customertype.idCustomerType and customerid='$option'");
        $row = mysqli_fetch_array($result);
        return $row['name'];
    }

    /**
     * this function returns all customers details from `customers` table in db where if the subscriber_type is 3.
     * because this function returns the owners of the tabs who are on the system.
     * @return  result from query.
     */
    public function GetTabs() {
        $result = $this->con->query("SELECT * FROM customers where subscriber_type=3;");
        return $result;
    }

    /**
     * this function returns all customer information from the system tables for schedule, record history,
     * and customers at a specific rate that customers have subscribed to.
     * the purpose of this function is to provide information about
     *  the customers so that we can send the alerts by rate to the email of each
     *  of the registered trainees for the lesson.
     * @param  $lessonid
     * @return result from query.
     */
    public function GetCustomersByLessonid($lessonid) {

        $result = $this->con->query("SELECT * FROM schedule,history_records,customers where schedule.scheduleid=history_records.scheduleid and history_records.id_customer=customers.id and lessonid=$lessonid");
        return $result;
    }

    /**
     * this function returns the client's id, email, and number of lessons that he had signed up for them.
     * @param  $id
     * @return result from query.
     */
    public function GetAllCustomerByLesson($id) {
        $result = $this->con->query("SELECT  customers.id,customers.mail,count(*) as count FROM lessons,schedule,history_records,customers where lessons.id=schedule.lessonid and schedule.scheduleid=history_records.scheduleid and  history_records.id_customer=customers.id and lessons.id=$id  group by customers.id");
        return $result;
    }
    /**
     * this function returns all information from the tables of lessons, customers,record history, and schedule.
     * the purpose of this function is to return the information about the 
     * customers who have registered to the lessons so that we can display them
     *  in the notification window on the main page.
     * @return  result from query.
     */
    
    public function GetNotification() {
        $result = $this->con->query("select * from history_records,customers,schedule,lessons where history_records.id_customer=customers.id and history_records.scheduleid=schedule.scheduleid and schedule.lessonid=lessons.id");
        return $result;
    }
    
    /**
     *this function adds a new entry to the notification table.
     *the record is built from the fields: customer id, lesson id, title, and message body.
     *in addition, the function returns the id of the new record added to the notification table.
     * @param $idcustomer
     * @param $idlesson
     * @param $title
     * @param $body_message
     * @return id.
     */
      public function InsertNotif($idcustomer, $idlesson, $title, $body_message) {
        $result = $this->con->query("INSERT INTO `notification` (`idcustomer`, `idlesson`, `title`, `body_message`) VALUES ('$idcustomer', '$idlesson', '$title', '$body_message');");
        return $this->con->insert_id;
    }

    /**
     * this function returns all information about coaches, lessons, lesson type, and schedule.
     * the purpose of this function is to display the information that comes
     *  from different tables in the report of inlay lessons.
     * 
     * @return  result from query.
     */
    public function GetInlayLessons() {
        $result = $this->con->query("select * from lessons,coaches,lessontype,schedule where lessons.coachid=coaches.id and lessons.lessontypeid=lessontype.idlessontype and schedule.lessonid=lessons.id and idactive=1");
        return $result;
    }

    /*     * *****************functions of app**********************             */

    /**
     * this function is check if the user is exist in system by username and passowrd.
     * if yes the function print 'pass' and the id of user,
     * otherwise she print 'fail'.
     * @param  $user
     * @param  $password
     */
    public function Login($user, $password) {
        $result = $this->con->query("SELECT * FROM customers where user_name='$user' and password='$password'");
        $row = mysqli_fetch_array($result);
        if ($row['mail'] != "") {
            echo 'pass, ' . $row['id'];
        } else {
            echo 'fail';
        }
    }

    /**
     * this function is reset password of the username by entering email.
     * if the email exist in the system the function print 'pass' and give the password,
     * otherwise she print 'fail'.
     * @param  $email
     */
    public function ResetPassword($email) {
        $result = $this->con->query("SELECT password FROM customers where mail='$email'");
        $row = mysqli_fetch_array($result);
        if ($result->num_rows == 0) {
            echo 'fail';
        } else {
            echo 'pass, ' . " " . $row['password'];
        }
    }

   
   /**
    *this function returns the customer's details according to the type of subscriber.
    *if his subscription is 1 or 2, this means that we have a semi-annual or annual subscription. 
    *in addition to his regular details, his subscription validity and remaining days are added to the end
    * of the subscription period.
    * if this subscription type is 3 it means that it is a subscription type tab type 
    * and this adds to the customer's details and the balance of his tab.
    * @param $id
    * @return result from query.
    */
    public function GetCustomerDetails($id) {
        $output = "";
        $result = $this->con->query("SELECT * FROM customers,customertype where customers.subscriber_type=customertype.idCustomerType and  id=$id");
        if ($result->num_rows > 0) {
            $row = mysqli_fetch_array($result);
            $output = 'pass, ' . $row['first_name'] . ',' . $row['last_name'] . ',' . $row['id_customer'] . ',' . $row['mail'] . ',' . $row['phone_number'] . ',' . $row['name'] . ',' . $row['choice'] . ',' . $row['customer_height'] . ',' . $row['customer_weight'] . ',';
            switch ($row['subscriber_type']) {
                case 1:
                case 2:

                    $result = $this->con->query("SELECT *,datediff(datevalidity,date(now())) as ex FROM customers,customertype,subscribers where customers.subscriber_type=customertype.idCustomerType and customers.id=subscribers.customerid and customers.id=$id");
                    $row = mysqli_fetch_array($result);
                    $date = date_create($row['datevalidity']);
                    $output .= date_format($date, "d-m-Y") . ',' . $row['ex'];
                    break;
                case 3:
                    $result = $this->con->query("SELECT * FROM customers,customertype,tabs where customers.subscriber_type=customertype.idCustomerType and customers.id=tabs.customerid and customers.id=$id");
                    $row = mysqli_fetch_array($result);
                    $output .= $row['duration'];
                    break;
                default:
                    break;
            }
        } else {
            $output = 'fail';
        }
        echo $output;
        return $row;
    }

    /**
     * this function returns that lesson details from `lessons`, `schedule` tables.
     * the function return that lesson details by day.
     * if the day inserted as parameter has lessons, the function print 'pass' and the lesson name and the hour of the lesson and the scheduleid.
     * otherwise, the function print 'fail'.
     * @param  $day
     */
    public function GetLesson($day) {
               $result = $this->con->query("select * from lessons,schedule where lessons.id=schedule.lessonid and day='$day'");
        while ($row = mysqli_fetch_array($result)) {
            if ($result->num_rows == 0) {
                echo "fail";
            } else {
                $date = date_create($row['hour']);
                echo "pass, " . " " . $row['scheduleid'] . "," . " " . $row['lesson_name'] . " " . "," . date_format($date, "H:i") . "," . " ";
            }
        }
    }

    /**
     *this function adds a new entry record to the record table 
     *when the trainee's lesson is recorded through the application.
     * @param $id_customer
     * @param $scheduleid
     */
    public function InsertHistoryRecord($id_customer, $scheduleid) {
        $result = $this->con->query("INSERT INTO `history_records` (`id_customer`, `scheduleid`, `register_date`) VALUES ('$id_customer', '$scheduleid', now());");
    }
    
    /**
     * this function returns all information from a table of tabs according to the customer id.
     * @param $id
     * @return result from query.
     */
    public function GetTabByCustomer($id) {
        $result = $this->con->query("SELECT * FROM tabs where customerid=$id");
        $row = mysqli_fetch_array($result);
        return $row;
    }
    /**
     *this function updates a new card balance according to the customer's Id.
     * @param $card_balance
     * @param $id
     */
    public function UpdateNewCardBalance($card_balance, $id) {

        $result = $this->con->query("UPDATE `tabs` SET `card_balance`='$card_balance' WHERE `id`='$id';");
    }
    /**
     *this function returns all information from the record history table
     *according to the id of the customer and the id of the schedule.
     * @param $id_customer
     * @param $scheduleid
     * @return result from query.
     */
    public function GetHistoryRecored($id_customer, $scheduleid) {

        $result = $this->con->query("SELECT * FROM history_records where id_customer = $id_customer and scheduleid = $scheduleid");
        $row = mysqli_fetch_array($result);
        return $row;
    }
    /**
     * this function updates the records in the record history table to be canceled, 
     * meaning that the registration for the lesson has been canceled by the trainees.
     * @param $id
     */
    public function UpdateActiveHistoryRecored($id) {

        $result = $this->con->query("UPDATE `history_records` SET `idactive`='2' WHERE `id`='$id';");
    }
    /**
     * this function updates the trainee's balance in the tab table to return to 
     * its original position once the trainee has clicked the cancel button in the app.
     * @param $id_customer
     * @param $scheduleid
     */
    public function UpdateCancelLesson($id_customer, $scheduleid) {
        $rowCustomer = $this->GetCustomerDetails($id_customer);

        $rowHistory = $this->GetHistoryRecored($id_customer, $scheduleid);
        $this->UpdateActiveHistoryRecored($rowHistory['id']);
        if ($rowCustomer['subscriber_type'] == 3) {
            $row = $this->GetTabByCustomer($id_customer);
            $card_balance = $row['card_balance'];
            $this->UpdateNewCardBalance($card_balance + 1, $row['id']);
        }
    }
    /**
     * this function updates the trainee's balance in a tab table to drop by 1 after the training,
     * click on the lesson registration button in the application, and the function 
     * checks that the balance on the tab is not 0 or else it will not perform the update.
     * @param $customerid
     */
    public function UpdateCardBalance($customerid) {
        $row = $this->GetCustomerDetails($customerid);

        if ($row['subscriber_type'] == 3) {
            $row = $this->GetTabByCustomer($customerid);


            $card_balance = $row['card_balance'];
            if ($card_balance > 0) {
                $this->UpdateNewCardBalance($card_balance - 1, $row['id']);
            }
        }
    }
    /**
     * this function updates customer information by id.
     * if the update success the function print 'pass',
     * otherwise the function print 'fail'.
     * @param  $id
     * @param  $email
     * @param  $password
     * @param  $height
     * @param  $weight
     */
    public function UpdateCustomers($id, $email, $password, $height, $weight) {
        $result = $this->con->query("UPDATE customers SET  `mail`='$email', `password`='$password' ,`customer_height`='$height', `customer_weight`='$weight' WHERE `id`='$id'");

        if ($this->con->affected_rows > 0) {
            echo "pass, " . "הפרטים עודכנו בהצלחה";
        } else {
            echo "fail, " . "הפרטים לא עודכנו";
        }
    }
    
    /**
     *This function returns all notification according to the customer id.
     *the function checks if the customer id does not exist in the notification so it returns 
     * "fail" otherwise it returns the entire "pass" and all the alerts of the customer.
     * @param  $id
     */
    public function GetNotifcationByIdCustomer($id) {
        $result = $this->con->query("select * from notification where idcustomer=$id");
        $output = "";
        if ($result->num_rows == 0) {
            $output = "fail";
        } else {
           
            while ($row = mysqli_fetch_array($result)) {

                $output .= "pass,"." ".$row['title'] . "," . $row['body_message'] . ",";
            }
        }
        echo $output;
    }

}
