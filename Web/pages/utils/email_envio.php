<?php
require '../phpmailer/PHPMailerAutoload.php';

function envia_email($to,$subject,$link){
	$mail = new PHPMailer;

	//$mail->SMTPDebug = 3;                               // Enable verbose debug output

	$mail->isSMTP();                                      // Set mailer to use SMTP
	$mail->Host = 'email-ssl.com.br';  // Specify main and backup SMTP servers
	$mail->SMTPAuth = true;                               // Enable SMTP authentication
	$mail->Username = 'dmp@btime.com.br';                 // SMTP username
	$mail->Password = 'dmpbrasil';                           // SMTP password
	$mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
	$mail->Port = 465;                                    // TCP port to connect to

	$mail->From = 'dmp@btime.com.br';
	$mail->FromName = 'DMP Mailer';
	//$mail->addAddress('mmartini@btime.com.br', 'Miqueias Martini');     // Add a recipient
	$mail->addAddress($to, '');               // Name is optional
	//$mail->addReplyTo('info@example.com', 'Information');
	//$mail->addCC('cc@example.com');
	//$mail->addBCC('bcc@example.com');

	//$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
	//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
	$mail->isHTML(true);                                  // Set email format to HTML

	$body = "<h2>DMP Brasil</h2><br><br><h4>Para recuperar a sua senha, clique <a href='$link'>aqui</a></h4>";
	$mail->Subject = utf8_decode($subject);
	$mail->Body    = $body;
	$mail->AltBody = $body;

	if(!$mail->send()) {
		return false;
//		echo 'Mensagem não pode ser enviada !!!';
//		echo 'Mailer Error: ' . $mail->ErrorInfo;
	} else {
//		echo 'Mensagem enviada com sucesso';
		return true;
	}

}
?>