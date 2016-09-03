<?php

include('../../config.php');

// Get values from form
$name=$_POST['name'];
$phone=$_POST['phone'];
$email=$_POST['email'];
$message=$_POST['message'];

$to = $form_email;
$subject = "Email Enquiry from $name on $site_name";
$message = " Name: " . $name . "\r\n Phone: " . $phone . "\r\n Email: " . $email . "\r\n Message: ". $message;

$from = "form-enquiry";
$headers = "From:" . $from . "\r\n";
$headers .= "Content-type: text/plain; charset=UTF-8" . "\r\n"; 

if(@mail($to,$subject,$message,$headers))
{
  print "Thanks for your enquiry. We have now received it. Please press back button.";

}else{
  echo "Error! Please try again.";
}



?>