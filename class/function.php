<?php

$mysqli = conectar();//Inicia uma conexão com o banco de dados

function conectar(){//conecta ao BASE de dados e passa o objeto conexão
  
   //local host
   $servidor = 'localhost';
   $usuario = 'root';
   $senha = '';//sem senha - senha padrão do PhpMyAdmin
   $banco = 'meet';
 
	
	// Conecta-se ao banco de dados MySQL
	
	$mysqli = new mysqli($servidor, $usuario, $senha, $banco);
	//gravando com ascentuação
   mysqli_query($mysqli,"SET NAMES 'utf8'");
   mysqli_query($mysqli,'SET character_set_connection=utf8');
   mysqli_query($mysqli,'SET character_set_client=utf8');
   mysqli_query($mysqli,'SET character_set_results=utf8');
	// Caso algo tenha dado errado, exibe uma mensagem de erro
	 if (mysqli_connect_errno()) trigger_error(mysqli_connect_error());
   
	  return $mysqli;//retorna um objeto conexão
   }


   function CadUser(){
   ?>
   
   <!-- upload files-->

  <div class="box-cad-user">
	  <div class="container-user">
   <form action="main.php" method="POST">
	   
	   
			<BR>CADASTRO<BR>
		   <div class='files'></div>
			<div id="upload" class="carregar-foto" >Carregar Foto</div>
			<span id="status" ></span>
			<br>
			<input type="text" id="userName" name="userName" placeholder="Nome" ><br>
			<br>
			<input type="password" id="userPassword" name="userPassword" placeholder="senha" ><br>
			<br>
			<input type="text" id="userBirthday" name="usereBirthday" value="__/__/____" placeholder="data nascimento"><br>
	        <br> 
			<select name="userSexo" id="userSexo">
		      <option value="male">masculino</option>
		      <option value="female" selected>feminino</option>
		    </select><br>
			<br>
			<input type="text" id="userPhone" name="userPhone" placeholder="telefone"><br>
	        <br>
			<input type="text" id="userEmail" name="userEmail" placeholder="email"><br>
			<br>
			<textarea  id="userBio" name="userBio"
              rows="5" cols="33"  maxlength ="150">Digite algo sobre você
            </textarea><br><br>
			<input type="submit" value="gravar" name="opc" id="bt-enviar-cad-user" >
   </form>
	  </div><!--container-user -->
 </div>	<!--box-cad-user -->

<!-- Ações javaScript-->
 
 <script type="text/javascript">
	    $("#userBirthday").mask("99/99/9999");
		$("#userPhone").mask("(99) 99999-9999");
</script>


   <?php
   }

function windowLoginUser(){
	echo "<div class='box-info-center'>
	           <span> 
	              ";
                   ?>
                    <form action="main.php" method="POST">
						<span>EFETUAR LOGIN</span><br><br>
					   <input type="text" id="userEmail" name="userEmail" placeholder="email"><br><br>
					   <input type="password" id="userPassword" name="userPassword" placeholder="senha" ><br>
					   <input type="submit" value="logar" name="opc" id="bt-login-user" >
                    </form>

				   <?php
           echo "			  
			   </span>
			</div>";
}

function areaUser(){

	 $mysqli = conectar();
	
	$sql = "SELECT * FROM user 
	                 WHERE user_email = '".trim($_POST["userEmail"])."'   
	                 AND  user_password = '".trim($_POST["userPassword"])."'  ";
	// 
				  
	$query = $mysqli->query($sql);
	$numRows =  $query->num_rows;//número de linhas
	//print "->".$_POST["userEmail"]." - ".$_POST["userPassword"]."numRows = ".$numRows ."";
	while (    $dados = $query->fetch_assoc()  ) {
				  //print "usuario encontrado '".$dados["user_name"]."";
				  if (!isset($_SESSION))
				  session_start(); 
				  $_SESSION['user_id'] = $dados["user_id"] ;
                   ?>
                  <div class='box-geral-profile'>
                        
				        <div class="box-info-tex-profile">
							<br><br>
						    <span class="text-info-name"> <?php print $dados["user_name"];  ?></span><br>
							<span class="text-info-bio">  <?php print $dados["user_bio"];  ?></span>	
						</div>

						<div class="box-moldura-profile"
								style="background-image: url('../images/users/media_<?php print $dados["user_photo_perfil"] ;?>'" >
								<div class="moldura-round-profile"></div>
						</div>
	             </div>	
				 
				 <div class="box-action-profile">
					<div class="box-bt"><span>Editar perfil</span></div>
					<div class="box-bt"><span>publicar</span></div>
	             </div>
                  


				  <?php
                  



	 }

     //CONTRUINDO LEYOU DA TELA DE LOGIN DO USUÁRIO
	 if($numRows >= 1){//SE ENCONTRAR ALGUMA LINHA
        
		//print "Usuario ID: ".$_SESSION['user_id'];

	 }else{
		print "USUÁRIO OU SENHA NÃO ENCONTRADOS";
	 }



}


   





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

	function setFormatAmericanDate($date){
		//yyyy-mm-dd 
		$pieces = explode("/", $date);
		
		return $pieces[2].'-'.$pieces[1].'-'.$pieces[0];
		
	}



?>