<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    
    require 'PHPMailer/src/Exception.php';
    require 'PHPMailer/src/PHPMailer.php';
    require 'PHPMailer/src/SMTP.php';

    //Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

if($_SERVER["REQUEST_METHOD"] == "POST")
{
    $first_name = htmlspecialchars($_POST['firstname']);
    $last_name = htmlspecialchars($_POST['lastname']);
    $email = htmlspecialchars($_POST['email']);
    $phone_number=htmlspecialchars($_POST['phone']);
    $property_name=htmlspecialchars($_POST['propertyname']);
    $property_address=htmlspecialchars($_POST['propertyaddress']);
    $comment=htmlspecialchars($_POST['comments']);

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
    
        $mail->addAddress('contact@thebinguys.co');      //Add a recipient
    

        $mail->isHTML(true);                                  
        $mail->Subject = "New inquiry: {$first_name}";
        $mail->Body    = "
            <p>First Name: {$first_name}</p>
            <p>Last Name: {$last_name}</p>
            <p>Phone: {$phone_number}</p>
            <p>Email: {$email}</p>
            <p>Property Name: {$property_name}</p>
            <p>Property Address: {$property_address}</p>
            <p>Comments: {$comment}</p>
        ";
        try{

            $mail->send();
        }
        catch(Exception $e){
            header("Location: ../contact.html?type=error&message=Something went wrong. Check email you entered");
            exit();
        }
        $mail->clearAddresses();
        print_r($mail->getToAddresses());
        $mail->addAddress("{$email}");

        $mail->Subject="We received your Quote Request";
        $mail->Body = "
            <h3>Hi {$first_name},</h3>
            
            <p>Thank you for submitting a inquiry through our website!</p>
            
            <p>This is an automatic response to let you know that we have received your information and our team will reach out to you as soon as possible. You can expect a response in 24 hours!</P>
            
            <p>Please feel free to reply to this email if you have any extra details about your request that can help us assist you better.</p>

            <p>Best Regards,<br>
            The Breezy Team <p>
        ";
        $mail->send();
        header("Location: ../contact.html?type=success&message=Your from has been submitted successfully! Thank you for Contacting with us.");
    } catch (Exception $e) {
        header("Location: ../contact.html?type=error&message=Something went wrong. Check email you entered");
    }
}
else{
    header("Location: ../contact.html");
}
?>