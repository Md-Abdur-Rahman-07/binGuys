<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

$mail = new PHPMailer(true);
if($_SERVER["REQUEST_METHOD"] == "POST")
{
    $first_name = htmlspecialchars($_POST['firstname']);
    $last_name = htmlspecialchars($_POST['lastname']);
    $email = htmlspecialchars($_POST['email']);
    $phone_number=htmlspecialchars($_POST['phone']);
    $home_zip_code=htmlspecialchars($_POST['zipcode']);
    $availability=$_POST['availability'];
    $about=htmlspecialchars($_POST['about']);
    $resoans=htmlspecialchars($_POST['reasons']);

    try {
        //Server settings
        // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication

        $mail->Username   = 'contact@thebinguys.co';                     //SMTP username
        $mail->Password   = 'aubckvunjbdvbyvj';                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
        $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
    
        $mail->addAddress('contact@thebinguys.co');     //Add a recipient
    

        $mail->isHTML(true);                                  
        $mail->Subject = "New Applicant: {$first_name} {$last_name}";
        $mail->Body    = 
            "<p>First Name: {$first_name}</p>".
            "<p>Last Name: {$last_name}</p>".
            "<p>Phone: {$phone_number}</p>".
            "<p>Email: {$email}</p>".
            "<p>Home Zip Code: {$home_zip_code}</p>".
            "<b>Availability: </b>".
            '<ul>'. implode('<br>',$availability).'</ul>'.
            "<p>Tell us about your self: {$about}</p>
            <p>Why do you want to join Breezy?: {$resoans}</p>";
        try{

            $mail->send();
        }
        catch(Exception $e){
            header("Location: ../about.html?type=error&message=Something went wrong. Check email you entered");
            exit();
        }
        echo $mail->Body;
        $mail->clearAddresses();
        print_r($mail->getToAddresses());
        $mail->addAddress("{$email}");

        $mail->Subject="Thank you for your Application!";
        $mail->Body = "
            <h3>Hi {$first_name},</h3>
            
            <p>Thank you for applying to join the Breezy team! We've received your application and are currently reviewing your information.<br><br>

            Our team will be in touch soon with an update on the next steps. In the meantime, feel free to reach out if you have any questions.<br><br>

            We appreciate your interest in becoming part of Breezy and look forward to connecting with you!<br><br>

            Stay Breezy,<br>
            The Breezy Team</p>
        ";
        $mail->send();
        header("Location: ../about.html?type=success&message=Your from has been submitted successfully! Thank you for Contacting with us.");
    } catch (Exception $e) {
        header("Location: ../about.html?type=error&message=Something went wrong. Check email you entered");
    }
}
else{
    header("Location: ../about.html");
}
?>