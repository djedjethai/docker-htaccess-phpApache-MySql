<?php
namespace OCFram;
/* Namespace alias. */
use \OCFram\PHPMailer;
use \OCFram\Exception;
use \OCFram\SMTP;
use \OCFram\PHPMailerAutoload;


class Mailer
{
  public static function sendMail($destination, $sender, $subject, $body) 
  {
    echo 'destination';
    var_dump($destination);
    echo 'sender';
    var_dump($sender);
    echo 'subject';
    var_dump($subject);
    echo 'body';
    var_dump($body);

//    	$email = new \SendGrid\Mail\Mail();
//	$email->setFrom("djedje.thai.ok@gmail.com", "Example User");
//	$email->setSubject("Sending with Twilio SendGrid is Fun");
//	$email->addTo("djedjethai@gmail.com", "Example User");
//	$email->addContent("text/plain", "and easy to do anywhere, even with PHP");
//	$email->addContent(
//	    "text/html", "<strong>and easy to do anywhere, even with PHP</strong>"
//	);
//	$sendgrid = new \SendGrid('');
//	try {
//	    $response = $sendgrid->send($email);
//	    print $response->statusCode() . "\n";
//	    print_r($response->headers());
//	    print $response->body() . "\n";
//	} catch (Exception $e) {
//	    echo 'Caught exception: ',  $e->getMessage(), "\n";
//	}

    $mail = new PHPMailer;

    // $mail->SMTPDebug = 3;                               // Enable verbose debug output
    $mail->SMTPDebug = 4;
    $mail->isSMTP();   
    $mail->Mailer = "smtp";                                 // Set mailer to use SMTP
    // $mail->Host = 'djedje-PORTEGE-M900';  // Specify main and backup SMTP servers
    $mail->Host = "localhost";
    $mail->SMTPAuth = false;
    $mail->SMTPSecure = false;
    $mail->SMTPAutoTLS = false;
                       // SMTP password
    
    $mail->Port = 25;                                    // as it s the port of the postfix image

    $mail->setFrom($sender);
    $mail->addAddress($destination);     // Add a recipient

    $mail->isHTML(true);                                  // Set email format to HTML

    $mail->Subject = $subject;
    $mail->Body    = $body;
    $mail->CharSet = 'utf-8';
    $mail->AltBody = 'alt body';

    if(!$mail->send()) {
        echo 'Message could not be sent.';
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    } else {
        echo 'Message has been sent';
    } 
  }

  public static function sendMailAuth($student, $key)
  {
	var_dump("http://mediterpourgrandir/auth/confRegistration-".$key."".$student->id().".php");
   
    $destination = $student->email();
    $sender = 'djedjethai@gmail.com';
    $subject = 'Mediter Pour Grandir, confirmation d\'inscription';
    $body = "Bienvenue sur le site de Mediter Pour Grandir,
 
        Pour activer votre compte, veuillez cliquer sur le lien ci dessous
        ou le copier/coller dans votre navigateur internet.
         
        http://mediterpourgrandir/auth/confRegistration-".$key."".$student->id().".php
         
         
        ---------------
        Ceci est un mail automatique, Merci de ne pas y répondre.";
    

    self::sendMail($destination, $sender, $subject, $body);


    /*$mail = new PHPMailer;

    // $mail->SMTPDebug = 3;                               // Enable verbose debug output
    $mail->SMTPDebug = 4;
    $mail->isSMTP();   
    $mail->Mailer = "smtp";                                 // Set mailer to use SMTP
    // $mail->Host = 'djedje-PORTEGE-M900';  // Specify main and backup SMTP servers
    $mail->Host = 'localhost';
    $mail->SMTPAuth = false;
    $mail->SMTPSecure = false;
    $mail->SMTPAutoTLS = false;
                       // SMTP password
    
    $mail->Port = 25;                                    // TCP port to connect to

    $mail->setFrom('djedjethai@gmail.com');
    $mail->addAddress($student->email());     // Add a recipient

    $mail->isHTML(true);                                  // Set email format to HTML

    $mail->Subject = 'Here is the subject';
    $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
    $mail->CharSet = 'utf-8';
    $mail->AltBody = 'alt body';

    if(!$mail->send()) {
        echo 'Message could not be sent.';
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    } else {
        echo 'Message has been sent';
    }*/ 
  }

  public static function sendMailPassword($student, $key)
  {
    $destination = $student->email();
    $sender = 'djedjethai@gmail.com';
    $subject = 'Mediter Pour Grandir';
    $body = "Mediter Pour Grandir est ravie de vous compter parmis ses membres,
 
        Votre nouveau mot de passe est: ".$key.".

        Afin de proteger votre compte, pensez a le modifier des votre prochaine connexion.
         
        ---------------
        Ceci est un mail automatique, Merci de ne pas y répondre.";;

    self::sendMail($destination, $sender, $subject, $body);

   	  /* $mail = new PHPMailer;
      $mail->setFrom('admin@example.com');
      $mail->addAddress($student->email());
      $mail->Subject = 'Message sent by PHPMailer';
      $mail->Body = "Mediter Pour Grandir est ravie de vous compter parmis ses membres,
 
				Votre nouveau mot de passe est: ".$key."
				 
				---------------
				Ceci est un mail automatique, Merci de ne pas y répondre.";
      $mail->IsSMTP();
      $mail->SMTPSecure = 'ssl';
      $mail->Host = 'ssl://smtp.gmail.com';
      $mail->SMTPAuth = true;
      //$mail->Port = 25;
      $mail->Port = 465;

      //Set your existing gmail address as user name
      $mail->Username = $student->email();

      //Set the password of your gmail address here
      $mail->Password = 'xxxxxxxxx';
      if(!$mail->send()) {
        $mail->SMTPDebug = 2;
        echo 'Email is not sent.';
        echo 'Email error: ' . $mail->ErrorInfo;
      } else {
        echo 'Email has been sent.';
      }*/  
  }

  public static function sendMailNotify($user, $news)
  {
    $destination = $user->userEmail();
    $sender = 'djedjethai@gmail.com';
    $subject = 'Mediter Pour Grandir, nouveau message';
    $body = "Mediter Pour Grandir est ravie de vous compter parmis ses membres,

            Il y a une reponse dans la discution '".$news->titre()."'

            Vous pouvez consulter le nouveau message en suivant ce lien.

            ----------- Le lien (a passer en arg) ------------------
         
            ---------------
            Ceci est un mail automatique, Merci de ne pas y répondre.";

    self::sendMail($destination, $sender, $subject, $body);
  }

  public static function sendMailContact($contact)
  {
    $destination = 'djedjethai@gmail.com';
    $sender = $contact->email();
    $subject = 'Mediter Pour Grandir, contact';
    $body = "Email de ".$contact->pseudo().",

            Message: ".$contact->contenu()."";

    self::sendMail($destination, $sender, $subject, $body);  
  }




    /* 
    // this is working, but with the email password so using php mail()
      $mail = new PHPMailer();
      $mail->setFrom('admin@example.com');
      $mail->addAddress($student->email());
      $mail->Subject = 'Message sent by PHPMailer';
      $mail->Body = "Bienvenue sur Mediter Pour Grandir,
 
        Pour activer votre compte, veuillez cliquer sur le lien ci dessous
        ou copier/coller dans votre navigateur internet.
         
        http://mediterpourgrandir/auth/confRegistration-".$key."".$student->id().".php
         
         
        ---------------
        Ceci est un mail automatique, Merci de ne pas y répondre.";
      $mail->IsSMTP();
      $mail->SMTPSecure = 'ssl';
      $mail->Host = 'ssl://smtp.gmail.com';
      $mail->SMTPAuth = true;
      //$mail->Port = 25;
      $mail->Port = 465;

      //Set your existing gmail address as user name
      $mail->Username = $student->email();

      //Set the password of your gmail address here
      $mail->Password = '';
      if(!$mail->send()) {
        $mail->SMTPDebug = 2;
        echo 'Email is not sent.';
        echo 'Email error: ' . $mail->ErrorInfo;
      } else {
        echo 'Email has been sent.';
      }*/

}

    
