<?php

   function CadUser(){
   ?>
   <script type="text/javascript" src="../js/jquery-1.11.1.js"></script>
   <script type="text/javascript" src="../js/ajaxupload.3.5.js" ></script>
   <script type="text/javascript" src="../js/myScripts.js"></script>

   <!-- upload files-->

   <form action="main.php" method="POST">
			<div class='files'></div>
			<div id="upload" >Carregar Foto</div>
			<span id="status" ></span>
			Nome:<br>
			<input type="text" id="userName" name="userName"><br>
			Data Nascimento:<br>
			<input type="text" id="userBirthday" name="usereBirthday"><br>
			Telefone:<br>
			<input type="text" id="userPhone" name="userPhone"><br>
			Bio:<br>
			<textarea placeholder="Digite algo sobre você" id="userBio" name="userBio"
              rows="5" cols="33" >
            </textarea><br>
			<input type="submit" value="alterar" name="enviar" style="background-color:#066; color:#FFF; padding:10px; border:none;">
   </form>
   <?php
   }

   CadUser();//chama user();





   function redimensiona($origem,$destino,$prefixo,$maxlargura=100,$maxaltura=100,$qualidade=80){//Destino sem o nome final do arquivo
			if(!strstr($origem,"http") && !file_exists($origem)){
			echo("Arquivo de origem da imagem inexistente");
			return false;
			}
			//Pegando o nome da imagem sem a pasta
			$partes = explode('/', $origem);
			$img_nome = $partes[sizeof($partes)-1];
			
			
			$ext = strtolower(end(explode(".", $origem)));if($ext == 'jpg' || $ext == 'jpeg'){
			$img_origem = imagecreatefromjpeg($origem);
			}
			elseif ($ext == 'gif'){
			$img_origem = imagecreatefromgif($origem);
			}
			elseif ($ext == 'png'){
			$img_origem = imagecreatefrompng($origem);
			}
			if(!$img_origem){
			echo('Erro ao carregar a imagem, talvez formato nao suportado');
			return false;
			}
			$alt_origem = imagesy($img_origem);
			$lar_origem = imagesx($img_origem);
			$escala = min($maxaltura/$alt_origem, $maxlargura/$lar_origem);
			if($escala < 1){
			$alt_destino = floor($escala*$alt_origem);
			$lar_destino = floor($escala*$lar_origem);
			// Cria imagem de destino
			$img_destino = imagecreatetruecolor($lar_destino,$alt_destino);
			// Redimensiona
			imagecopyresampled($img_destino, $img_origem, 0, 0, 0, 0, $lar_destino, $alt_destino, $lar_origem, $alt_origem);
			imagedestroy($img_origem);
			}
			else {
			$img_destino = $img_origem;
			}
			
			
			$ext = strtolower(end(explode(".", $origem)));
			
			
			if($ext == 'jpg' || $ext == 'jpeg'){
			imagejpeg($img_destino,$destino.$prefixo.$img_nome,$qualidade);
			return true;
			}
			elseif ($ext == 'gif'){
			imagepng($img_destino,$destino.$prefixo.$img_nome);
			return true;
			}
			elseif ($ext == 'png'){
			imagepng($img_destino,$destino.$prefixo.$img_nome);
			return true;
			
			
			}else {
				
			echo('Formato de destino nao suportado');
			return false;
			
			}
	}


?>