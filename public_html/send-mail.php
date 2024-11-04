<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require_once "vendor/autoload.php";

//print_r($_POST); die;
$errors = [];
$data = [];
 
if (empty($_POST['name'])) {
    $errors['name'] = 'Name is required.';
}

/*if (empty($_POST['email'])) {
    $errors['email'] = 'Email is required.';
}*/

if (empty($_POST['phone'])) {
    $errors['phone'] = 'Phone is required.';
}elseif(!preg_match("/^[0-9]{10}+$/", $_POST['phone'])) {
   $errors['phone'] = 'Enter Valid Phone No';
}



if (!empty($errors)) {
    $data['success'] = false;
    $data['errors'] = $errors;
} else {
    
    $mail = new PHPMailer(true);
    
    $mail->isSMTP();
    $mail->SMTPDebug = 2; 
    $mail->Host = 'smtp.hostinger.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'support@carpartssolutions.com';
    $mail->Password = 'support@12345678%R';
    $mail->SMTPSecure = 'SSL';
    $mail->Port = 587;
      $mail->From = "support@carpartssolutions.com";
    $mail->FromName = "Services Inquiry by ".$_POST['name'];
    $mail->addAddress("support@carpartssolutions.com", "New Inquiry by ".$_POST['name']);
    $mail->isHTML(true);
    $mail->Subject = "carpartssolutions.com";
    $message = '<html><body>';
    $message .= '<table rules="all" style="border-color: #666;" cellpadding="10">';
    $message .= "<tr style='background: #eee;'><td colspan='2'><strong>Services</strong> </td></tr>";
    $message .= "<tr><td><strong>Name:</strong> </td><td>" . $_POST['name']. "</td></tr>";
    $message .= "<tr><td><strong>Email:</strong> </td><td>" . $_POST['email'] . "</td></tr>"; 
    $message .= "<tr><td><strong>Phone:</strong> </td><td>" . $_POST['phone'] . "</td></tr>";
    if(!empty($_POST['interested_in'])){
        $message .= "<tr><td><strong>Interested In:</strong> </td><td>" . $_POST['interested_in'] . "</td></tr>";
    }
    
    if(!empty($_POST['time_slot'])){
        $message .= "<tr><td><strong>Time Slot:</strong> </td><td>" . $_POST['time_slot'] . "</td></tr>";
    }
    if(!empty( $_POST['message'])){
        $message .= "<tr><td><strong>Message:</strong> </td><td>" . $_POST['message'] . "</td></tr>";
    }
    $message .= "</table>";
    $message .= "</body></html>";
    $mail->Body = $message;
    $mail->send();
    echo "Mailer Error: " . $mail->ErrorInfo;
    $data['success'] = true;
    $data['message'] = 'Enquery Submited Successfully!';
    //die;
}

//die;
header("Location: thank-you.html");
?>