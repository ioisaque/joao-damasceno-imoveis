<?php

include("./class.phpmailer.php");
include("./class.smtp.php"); // note, this is optional - gets called from main class if not already loaded
	
$nome = (isset($_POST["nome"])) ? $_POST["nome"] : "";
$email = (isset($_POST["email"])) ? $_POST["email"] : "";
$mensagem = (isset($_POST["mensagem"])) ? $_POST["mensagem"] : "";

if($nome != "" and $email != "" and $mensagem != "") {
	ob_start();
	require_once ('./mensagem.tpl.php');
	$html_message = ob_get_contents();
	ob_end_clean();

	$mail             = new PHPMailer();

	$mail->IsSMTP();
	$mail->SMTPAuth   = true;       
	$mail->SMTPSecure = "ssl";  
	$mail->Host       = "smtp.gmail.com";  
	$mail->Port       = 465;              

	$mail->Username   = "nao-responda@snt6.com.br";
	$mail->Password   = "sige1234";   

	$mail->CharSet = 'utf-8';

	//$mail->AddAddress($email,$nome);
	$mail->AddAddress('isaque.costa@sige.pro.br','Isaque Costa');
	//$mail->addReplyTo("nao-responda@sige.pro.br", "Divulgação Online");
	$mail->From       = "nao-responda@sige.pro.br";
	$mail->FromName   = "Divulgação Online";
	$mail->Subject    = "FORMULARIO DE CONTATO DO SITE";
	$mail->AltBody    = utf8_decode("RETORNO DE FORMULARIO: [$nome], [$email], [$mensagem]");
	$mail->WordWrap   = 50; // set word wrap

	$mail->IsHTML(true); // send as HTML

	$mail->MsgHTML(utf8_decode($html_message));
if(!$mail->Send()) {
  echo "0#*#Problema no envio: RETORNO DE FORMULARIO: [$nome], [$email], [$mensagem] : ".$mail->ErrorInfo;
} else {
  echo "1#*#Mensagem enviada com sucesso.";
}
} else {
	echo "0#*#Favor preencher todos os campos obrigatorios. RETORNO DE FORMULARIO: [$nome], [$email], [$mensagem]";
}

?>