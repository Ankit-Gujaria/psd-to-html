<?php 
    require("PHPMailerAutoload.php");

    function sendmail($recipents, $subject, $body, $attachment=""){
        $mail = new PHPMailer;
        //$mail->SMTPDebug = 4;                               // Enable verbose debug output

        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = Config::SMTP_HOST;  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = Config::SMTP_EMAIL;                 // SMTP username
        $mail->Password = Config::SMTP_PASS;                           // SMTP password
        $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 587;                                    // TCP port to connect to

        $mail->setFrom(Config::SMTP_EMAIL, 'Helperland');
        foreach($recipents as $recipent){
            $mail->addAddress($recipent);     // Add a recipient
        }
    
        $mail->addReplyTo(Config::SMTP_EMAIL);

        if(!empty($attachment)){
            $mail->addAttachment($attachment);    // Optional name
        }
        $mail->isHTML(true);                                  // Set email format to HTML

        $mail->Subject = $subject;
        $mail->Body    = $body;

        if(!$mail->send()) {
            return 'Mailer Error: ' . $mail->ErrorInfo;
        } else {
            return 'Message has been sent';
        }

    }

?>