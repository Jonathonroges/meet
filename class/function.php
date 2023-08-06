<?php

$mysqli = conectar();//Inicia uma conexão com o banco de dados

function conectar(){//conecta ao BASE de dados e passa o objeto conexão
  
   //local host
   $servidor = 'localhost';
   $usuario = 'root';
   $senha = '';//sem senha - senha padrão do PhpMyAdmin
   $banco = 'meet';

     //EM PRODUCAO
	 /*
	 $servidor = 'localhost';
	 $usuario = '532830';
	 $senha = '19892008';//sem senha - senha padrão do PhpMyAdmin
	 $banco = '532830';*/
 
	
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


   function formCadUser(){
   ?>
   
   <!-- upload files-->

  <div class="box-cad-user">
	  <div class="container-user">
   <form action="main.php?page=cadUser" method="POST">
	   
	   
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
                    <form action="main.php?page=userLogin" id="form-login-user" method="POST">
						<span>EFETUAR LOGIN</span><br><br>
						<span style='color: #ee0000;' id="result-form"></span><br>
					   <input type="text" id="userEmail" name="userEmail" placeholder="email"><br><br>
					   <input type="password" id="userPassword" name="userPassword" placeholder="senha" ><br>
					   <input type="submit" value="logar" name="opc" id="bt-login-user" >
                    </form>
					<a href="main.php?page=newcaduser">Criar uma conta</a>

				   <?php
           echo "			  
			   </span>
			</div>";

           ?>
            <script type="text/javascript">
				/*validando formulario js*/
				 let formLogin = document.getElementById("form-login-user");
				 let userEmail = document.getElementById("userEmail");
                 let userPassword = document.getElementById("userPassword");
				 let btFormSubmit = document.getElementById("bt-login-user");
                 let resultForm = document.getElementById("result-form");
				 let validar = true;

				 btFormSubmit.addEventListener("click", function(e){
						e.preventDefault();//remove o comportamento de submit da página     
						
						 
						if(userEmail.value == ""){
							
							resultForm.innerHTML = "*Digite seu email";
							validar = false;
							
						 } if(userPassword.value == ""){
							
							resultForm.innerHTML = "*Digite a senha";
							validar = false;
							
						 }
                         //caso a variavel não seja modificada para false
						 if(userPassword.value != "" && userPassword.value != ""){
							validar = true;
							formLogin.submit();//Dispara um submit no formulario 
						 }
						  
							
							
						 
                         
					 });
            </script>
		   <?php

}

function areaUser(){
	
	$mysqli = conectar();

	

	if (!isset($_SESSION))
		session_start(); 
		
      if(!isset($_SESSION['user_id'])){

		$sql = "SELECT * FROM user 
	                 WHERE user_email = '".trim($_POST["userEmail"])."'   
	                 AND  user_password = '".trim($_POST["userPassword"])."'  ";
	}else{
		
		
		$sql = "SELECT * FROM user 
	                 WHERE user_id = ".$_SESSION['user_id']."  ";
	}
	
	
	
	
	// 
				  
	$query = $mysqli->query($sql);
	$numRows =  $query->num_rows;//número de linhas
	//print "->".$_POST["userEmail"]." - ".$_POST["userPassword"]."numRows = ".$numRows ."";
	while (    $dados = $query->fetch_assoc()  ) {
				  //print "usuario encontrado '".$dados["user_name"]."";
				 
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
					   <a href="main.php?page=alteruser&id=<?php print $_SESSION['user_id'];?>" class="box-bt">
						  <span>editar perfil</span>
					  </a>
					  <a href="main.php?page=newpost" class="box-bt">
						 <span>publicar</span>
	                  </a>
	             </div>
                  
             <?php
              
		//Listando postagens
		
		$sql = "SELECT * FROM user_new_post 
		                 WHERE user_new_post_user_id = ".$_SESSION['user_id']." ORDER BY user_new_post_id DESC  ";
                
				$query = $mysqli->query($sql);
				$numRows =  $query->num_rows;//número de linhas
				
				print "<div class='box-post-list'>";
						while (    $dados = $query->fetch_assoc()  ) {
						
                              ?>
							      <a href="main.php?page=openuserpost&post_id=<?php print $dados["user_new_post_id"]; ?>">
								    <div class="box-iten-post" 
							             style="background-image: url('../images/users/media_<?php print $dados["user_new_post_image"] ;?>')">
							        </div>
						          </a>
							 <?php
						}
				print "</div>";



	 }

     //CONTRUINDO LEYOU DA TELA DE LOGIN DO USUÁRIO
	 if($numRows >= 1){//SE ENCONTRAR ALGUMA LINHA
        
		//print "Usuario ID: ".$_SESSION['user_id'];

	 }else{
		//print "USUÁRIO OU SENHA NÃO ENCONTRADOS";
	 }



}

function alterUser(){
	
	$mysqli = conectar();
	if (!isset($_SESSION))//necessário inicializar sessão sempre que uma página nova é criada
	    session_start(); 
	
	$sql = "SELECT * FROM user 
	                 WHERE user_id = ".$_SESSION['user_id']." ";
	// 
				  
	$query = $mysqli->query($sql);
	$numRows =  $query->num_rows;//número de linhas
	//print "->".$_POST["userEmail"]." - ".$_POST["userPassword"]."numRows = ".$numRows ."";
	while (    $dados = $query->fetch_assoc()  ) {

		?>
   
		<!-- upload files-->
	 
	   <div class="box-cad-user">
		   <div class="container-user">
		<form action="main.php?page=updateuser" method="POST">
			
			
				 <BR>Alterar Dados<br><br>
				 

				 <?php 
						//verificando se existe imagem de usuario
						$foto = $dados["user_photo_perfil"];
						print "<div class='files'>";//Necessário para upload da nova imagem
						 if(  file_exists("../images/users/media_".$foto."") ){
							 print " 
										 <img src='../images/users/media_".$foto."'>
										 <input type='hidden' name='arquivo' value='".$foto."'> 
									 
							 ";
						 }else{
							 print "<img src='../images/users/305639912.png'>
							 <input type='hidden' name='arquivo' value='".$foto."'> 
							 ";
						 }

					 print "</div>"	;	
					 ?>


				 <div id='upload' class='carregar-foto' >Alterar Foto</div>
				 <span id="status" ></span>
				 <br>
				 <input type="text" id="userName" name="userName" value="<?php print $dados["user_name"]; ?>"  ><br>
				 <br>
				 <input type="password" id="userPassword" name="userPassword" value="<?php print $dados["user_password"]; ?>" ><br>
				 <br>
				 <input type="text" id="userBirthday" name="usereBirthday" value="<?php print setFormatBrazilianDate_($dados["user_birthday"]); ?>" ><br>
				 <br> 
				 <select name="userSexo" id="userSexo">
				   <?php 
				                           if($dados["user_sexo"] == "male"){
                                             print "<option  selected value='male'>masculino</option>";
										   }else{
											 print "<option  selected value='female'>feminino</option>";
										   }
				                            
									 ?>
				   <option value="male" >masculino</option>
				   <option value="female" >feminino</option>
				 </select><br>
				 <br>
				 <input type="text" id="userPhone" name="userPhone" value="<?php print $dados["user_phone"]; ?>" ><br>
				 <br>
				 <input type="text" id="userEmail" name="userEmail" value="<?php print $dados["user_email"]; ?>"><br>
				 <br>
				 <textarea  id="userBio" name="userBio"
				   rows="5" cols="33"  maxlength ="150"><?php print $dados["user_bio"]; ?>
				 </textarea><br><br>
				 <input type="submit" value="gravar" name="opc" id="bt-enviar-cad-user" >
		</form>
		   </div><!--container-user -->
	  </div>	<!--box-cad-user -->
	 
	 <!-- Ações javaScript-->
	  
	  <script type="text/javascript">
			
			 $("#userPhone").mask("(99) 99999-9999");
			 $("#userBirthday").mask("99/99/9999");
	 </script>
	 
	 
		<?php

          
	}
}

function newPost(){
	
	$mysqli = conectar();
	if (!isset($_SESSION))//necessário inicializar sessão sempre que uma página nova é criada
	    session_start(); 

      ?>

	  <div class="box-new-post">
	        <b>Novo Publicação</b> <br>
			<form action="main.php?page=setnewpostuser" method="POST">
					<div class='files'></div>
					<div id='upload' class='carregar-foto' >carregar imagem</div>
								<span id="status" ></span>
								<textarea  id="new-post-text" name="new-post-text"
								rows="5" cols="33"  maxlength ="500">Descrição da postagem
								</textarea><br>
								<br><br>
					<input type="submit" value="postar" name="opc" id="bt-enviar-cad-user" >
			</form>
    </div>				 
	  <?php

}
function openUserPost($user_id, $post_id){

	
	$mysqli = conectar();
	if (!isset($_SESSION))//necessário inicializar sessão sempre que uma página nova é criada
	    session_start(); 
	
	$sql = "SELECT * FROM user, user_new_post
	                 WHERE user_new_post_id = ".$post_id."
					 AND   user_id = ".$user_id."";
	
				  
	$query = $mysqli->query($sql);
	$numRows =  $query->num_rows;//número de linhas
	
	while (    $dados = $query->fetch_assoc()  ) {
	 ?>
	   <div class="box-user-post-item">
		   <div class="box-image-user-post-item">
		      <image src="../images/users/<?php print $dados["user_new_post_image"] ;?>">
	       </div>
		   <div class="box-info-user-post">
			
				<div class="profile-info-left"> 
							<div class="user-image-profile" 
							     style="background-image: url('../images/users/pequena_<?php print $dados["user_photo_perfil"] ;?>')"> 
							     <div class="moldura-profile-pequena"></div>
							</div>
							<div class="box-info-text-left-profile">
								<?php print $dados["user_name"] ;?>
							</div>
                            <!--like icon -->
							<div class="user-iten-bt-like">
					           <img src="../images/layout/like-black-icon-01.png" style="padding-left:20px;">  
	                        </div>
							<div class="user-iten-bt-msg">
					           <img src="../images/layout/msg-black-icon-01.png" style="padding-left:20px;">  
	                        </div>
						
				</div>	
					
				
					<div class="post-item-info-rigth">
					    <img src="../images/layout/calendario-pequeno-01.png" >
						<?php print separarData($dados["user_new_post_date"]) ;?>
					</div>
				</div>

            
			<div class="post-item-description">
				       <?php print $dados["user_new_post_description"];?>
			</div><!--post-item-description-->


       </div>
	 
	<?php
    
   }//fecha while
     
   
}

//PAGINA FEED
function feeds(){

	
	$mysqli = conectar();
	if (!isset($_SESSION))//necessário inicializar sessão sempre que uma página nova é criada
	    session_start(); 
	
	$sql = "SELECT DISTINCT * FROM user_new_post , user
	                          WHERE user_new_post_user_id = user_id 
	                          ORDER BY user_new_post_id DESC LIMIT 50 ";
	
				  
	$query = $mysqli->query($sql);
	$numRows =  $query->num_rows;//número de linhas
	
	while (    $dados = $query->fetch_assoc()  ) {
	 ?>
	   <div class="feed-box-user-post-item">
		   
			<a href="main.php?page=openuserpost&post_id=<?php print $dados["user_new_post_id"];?>"><!--Abrindo o post -->
			<div class="box-image-user-post-item">
				<image src="../images/users/<?php print $dados["user_new_post_image"] ;?>">
			</div>
			</a>

		   <div class="box-info-user-post">
			
				<div class="profile-info-left"> 
							<div class="user-image-profile" 
							     style="background-image: url('../images/users/pequena_<?php print $dados["user_photo_perfil"] ;?>')"> 
							     <div class="moldura-profile-pequena"></div>
							</div>
							<div class="box-info-text-left-profile">
								<?php print $dados["user_name"] ;?>
							</div>
                            <!--like icon -->
							<div class="user-iten-bt-like">
					           <img src="../images/layout/like-black-icon-01.png" style="padding-left:20px;">  
	                        </div>
							<div class="user-iten-bt-msg">
					           <img src="../images/layout/msg-black-icon-01.png" style="padding-left:20px;">  
	                        </div>
						
				</div>	
					
				
					<div class="post-item-info-rigth">
					    <img src="../images/layout/calendario-pequeno-01.png" >
						<?php print separarData($dados["user_new_post_date"]) ;?>
					</div>
				</div>

            
			<div class="post-item-description">
				       <?php print $dados["user_new_post_description"];?>
			</div><!--post-item-description-->


       </div>
	 
	<?php
    
   }//fecha while
     
   
}

function topMenu(){
	?>
	<div class="box-top-menu">


	        <div class="left-top-menu-itens">
			  <?php
			  $mysqli = conectar();
			  if (!isset($_SESSION))//necessário inicializar sessão sempre que uma página nova é criada
				  session_start(); 
			  
				  $sql = "SELECT * FROM user 
				  WHERE user_id = ".$_SESSION['user_id']." ";
			  
							
			  $query = $mysqli->query($sql);
			  $numRows =  $query->num_rows;//número de linhas
			  
			  while (    $dados = $query->fetch_assoc()  )
			   {
			  ?>
			   	<a href="main.php?page=userLogin">
					<div class="user-image-profile" 
					style="background-image: url('../images/users/pequena_<?php print $dados["user_photo_perfil"] ;?>')"> 
					<div class="moldura-profile-pequena"></div>
					</div>
			    </a>
				<a href="main.php?page=feeds">	
				   <div class="top-menu-itens"><img src="../images/layout/logo-meet-icon-01.jpg"></div> 
			    </a>   
            </div>
			<?php
			   }//fecha while
			?>
		   
			<div class="rigth-top-menu-itens"> 
				<div class="top-menu-itens"><img src="../images/layout/notification-icon-01.jpg"></div>
			<a href="main.php?page=settings">
				<div class="top-menu-itens"><img src="../images/layout/ajustes-icon-01.jpg"></div>
			</a>
			</div>
		</div>
	<?php
}


function footMenu(){
	?>
	<div class="box-foot-menu">
			<a href="main.php?page=feeds">
				<div class="foot-menu-itens"><img src="../images/layout/home-icon-01.jpg"></div>
            </a>
			<a href="main.php?page=search">	
				<div class="foot-menu-itens"><img src="../images/layout/search-icon-01.jpg"></div>
            </a>
			<a href="main.php?page=newpost">
				<div class="foot-menu-itens"><img src="../images/layout/newpost-icon-01.jpg"></div>
            </a>	
			<a href="main.php?page=configuration">
				<div class="foot-menu-itens"><img src="../images/layout/config-icon-01.jpg"></div>
            </a>
    </div>
	<?php
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
	function setFormatBrazilianDate_($date){
		$pieces = explode("-", $date);
		return $pieces[2].'/'.$pieces[1].'/'.$pieces[0];
	}

function separarData($date){
	//yyyy-mm-dd 
	$pieces = explode(" ", $date);
	
	return setFormatBrazilianDate_( $pieces[0] );
}
function separarHora($date){
	//yyyy-mm-dd 
	$pieces = explode(" ", $date);
	return $pieces[1];
}

?>