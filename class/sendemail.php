<?php
 // emails para quem será enviado o formulário
 $emailenviar = "jhonny.roges@gmail.com";
 $destino = "jhonny.roges@gmail.com";
 $assunto = "Contato pelo Site";

 // É necessário indicar que o formato do e-mail é html
     $headers  = 'MIME-Version: 1.0' . "\r\n";
     $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
     $headers .= 'From: jonathon <jhonny.roges@gmail.com>';
 //$headers .= "Bcc: $EmailPadrao\r\n";

 $enviaremail = mail($destino, $assunto, "arquivo", $headers);
 if($enviaremail){
 $mgm = "E-MAIL ENVIADO COM SUCESSO! <br> O link será enviado para o e-mail fornecido no formulário";
 echo " ".$mgm;
 } else {
 $mgm = "ERRO AO ENVIAR E-MAIL!";
 echo "".$mgm;
 }

?>