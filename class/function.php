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
   mysqli_query($mysqli,"SET NAMES 'utf8mb4'");
   mysqli_query($mysqli,'SET character_set_connection=utf8mb4');
   mysqli_query($mysqli,'SET character_set_client=utf8mb4');
   mysqli_query($mysqli,'SET character_set_results=utf8mb4');
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
		
		//print "->>>nao existe".$_POST["userEmail"]." <<- ";
		
		$sql = "SELECT * FROM user 
	                 WHERE user_email = '".strtolower( trim($_POST["userEmail"])  )."'   
	                 AND  user_password = '".trim($_POST["userPassword"])."'  ";
	}else{
		
		//print "->>>existe".$_POST["userEmail"]." <<- ";
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

						<div class="box-moldura-profile" >
						        <img src="<?php print $dados["user_photo_perfil_blob"] ;?>" class="user-image-profile"> 
								
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
							      <a href="main.php?page=openuserpost&user_id=<?php print $dados["user_new_post_user_id"];?>&post_id=<?php print $dados["user_new_post_id"];?>">
								    <div>
										 <img src="<?php print $dados["user_new_post_blob_image"] ;?>" class="box-iten-post">
							             
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
	 
         
		<!--import para cortar imagem -->
		<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/0.8.1/cropper.min.js"></script>

	   <div class="box-cad-user">
		   <div class="container-user">
		<form action="main.php?page=updateuser" method="POST">
			
			
				 <BR>Alterar Dados<br><br>
				 

				 <?php 
						//verificando se existe imagem de usuario
						$foto = $dados["user_photo_perfil_blob"];
						print "<div class='files' id='files'>";//Necessário para upload da nova imagem
						 if( strlen($foto) >10 ){
							 print " 
										 <img src='".$foto."'>
										 <input type='hidden' name='arquivo' value='".$foto."'>
										 <input type='hidden' id='blob-image' name='blob-image' value='".$foto."'>
									 
							 ";
						 }else{
							 print "<img src='../images/users/305639912.png'>
							 <input type='hidden' name='arquivo' value='".$foto."'>
							 <input type='hidden' id='blob-image' name='blob-image' value=''> 
							 ";
						 }

					 print "</div>"	;	
					 ?>
                    <input type='hidden' id='blob-image' name='blob-image' value='<?php print $foto;?> '>
				 <br>
				    <br>após recarrecar nova foto, clique em cortar<br> 
                    <input type="button" value="cortar" id="button-cortar">
				 <br>
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

		<!--import para cortar imagem -->
		<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/0.8.1/cropper.min.js"></script>
	  <div class="box-new-post">
	        <b>Nova Publicação</b> <br>
			<form action="main.php?page=setnewpostuser" method="POST">
					<div class='files' id="files">
						<img src="" id="img-arquivo" value="">
						   
					</div>
                    <!-- Armazena a imagem em blob no banco de dados-->
					<input type='hidden' id='blob-image' name='blob-image' value=''>

					<div id='upload' class='carregar-foto' >carregar imagem</div>
								<span id="status" ></span>
								<textarea  id="new-post-text" name="new-post-text"
								rows="5" cols="33"  maxlength ="500">Descrição da postagem
								</textarea><br>
								<br><br>
				
					   <input type="button" value="cortar" id="button-cortar">
                    		
					<input type="submit" value="postar" name="opc" id="bt-enviar-cad-user" >
			</form>
            <script>
				

			</script>

            
			
			
                        
    </div>				 
	  <?php

}
function openUserPost($user_id, $post_id){
	
	$gerenciarPost = false;
	
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
		      <image src="<?php print $dados["user_new_post_blob_image"] ;?>">
	       </div>

		   <?php 
		    if($dados["user_new_post_user_id"] == $_SESSION['user_id'])
			 {
				$gerenciarPost = true;
				?>
				
					<div class="box-user-post-settings">
					    <div class="box-user-post-menu-expand">

						   
							deseja realmente excluir? <br>
							<a href="main.php?page=removepost&post_id=<?php print $dados["user_new_post_id"] ;?>">
							    sim 
							</a> 
							<a href="#" class="bt-close-expand-options-feed">
							    não 
							</a> 

			            </div>
						   <img src="../images/layout/svg/remove-01.svg" width="25" class="bt-remove-post">
						
						
				   </div>
					

		   <?php
		   }//fecha if 
		   ?>


		   <div class="box-info-user-post">
			
				<div class="profile-info-left"> 
							<div > 
							    <img src="<?php print $dados["user_photo_perfil_blob"] ;?>" class="user-image-profile">
							</div>
							<div class="box-info-text-left-profile">
								<?php print $dados["user_name"] ;?>
							</div>
                            <!--like icon -->
							<div class="user-iten-bt-like">
					           <img src="../images/layout/svg/heart-like-icon-01.svg" width="25" style="padding-left:20px;">  
	                        </div>
							<div class="user-iten-bt-msg">
					           <img src="../images/layout/svg/message-icon-01.svg" width="25" style="padding-left:20px;">  
	                        </div>
						
				</div>	
					
				
					<div class="post-item-info-rigth">
					    <img src="../images/layout/svg/calendar-icon-01.svg" width="25" >
						<?php print separarData($dados["user_new_post_date"]) ;?>
					</div>
				</div>

            
			<div class="post-item-description">
				       <?php print $dados["user_new_post_description"];?>
			</div><!--post-item-description-->

			<div class="box-feeds-comentarios">
				<div class="box-input-text-comentario">
				    <img src="<?php print $dados["user_photo_perfil_blob"] ;?>" class="user-image-profile-feed-message" > 
					<input type="text" value="" name="input-feed-message" id="input-message-<?php print $dados["user_new_post_id"];?>" placeholder="comentar" >
				    <a href="#" id="publicar-<?php print $dados["user_new_post_id"];?>" class="bt-feed-publicar"> publicar</a>
				</div>
				
				<!-- Lista de comentarios-->
				<br>
				 <span class="title-feeds-messages">Comentarios</span>
				<br>
				<div class="box-list-feed-messages" id="msg-<?php print $dados["user_new_post_id"];?>">
				</div>
		   </div>





			    <?php
                   //função para listar comentarios
				   listMessages(   $dados["user_new_post_id"] , $gerenciarPost );//gerenciar é true|false para gerenciar os posts relacionados a minha postagem
                ?>

       </div><!--fim box-info-user-post -->
	  
       <script>
        let remoElement = document.querySelector(".bt-remove-post");
		let boxUserPost = document.querySelector(".box-user-post-menu-expand");
		let closeboxUserPost = document.querySelector(".bt-close-expand-options-feed");
		
		
		remoElement.addEventListener("click", function(e){
			boxUserPost.style.visibility = "visible";
		});

		closeboxUserPost.addEventListener("click", function(e){
			boxUserPost.style.visibility = "hidden";
		});

	   </script>

	<?php
    
   }//fecha while
     
   
   jsPostMessage();//chamo a função para ações javascript das mensagens | adicionar msg | excluir




}

//PAGINA FEED
function feeds(){

	
	$mysqli = conectar();
	if (!isset($_SESSION))//necessário inicializar sessão sempre que uma página nova é criada
	    session_start(); 

	$userImag = "";
	$userName = "";
	$userCreatePost = "";
	$gerenciarPost = false;//para saber se posso gerenciar (excluir etc) as informações do post
	
	$sql = "SELECT DISTINCT * FROM user_new_post , user
	                          WHERE user_new_post_user_id = user_id 
	                          ORDER BY user_new_post_id DESC LIMIT 50 ";
	
				  
	$query = $mysqli->query($sql);
	$numRows =  $query->num_rows;//número de linhas
	
	while (    $dados = $query->fetch_assoc()  ) {

		
			   if($dados["user_new_post_user_id"] == $_SESSION['user_id']){
				   $gerenciarPost = true;
			   }else{
				$gerenciarPost = false;
			   }
		
		$userCreatePost = $dados["user_new_post_user_id"];//quem criu o post

	 ?>
	   <div class="feed-box-user-post-item">
		   
			<a href="main.php?page=openuserpost&user_id=<?php print $dados["user_new_post_user_id"];?>&post_id=<?php print $dados["user_new_post_id"];?>"><!--Abrindo o post -->
			<div class="box-image-user-post-item">
				<image src="<?php print $dados["user_new_post_blob_image"] ;?>">
			</div>
			</a>

		   <div class="box-info-user-post">
			
				<div class="profile-info-left"> 
							<div> 
							   <img src="<?php print $dados["user_photo_perfil_blob"] ;?>" class="user-image-profile-feed"> 
							</div>
							<div class="box-info-text-left-profile">
								<?php print $dados["user_name"] ;?>
							</div>
                            <!--like icon -->

							<?php

							    
								$sql1 = "SELECT  * FROM likes
								WHERE like_user_id = ".trim($_SESSION['user_id'])."
								AND 
								like_post_id = ".$dados["user_new_post_id"]." ";
								$query1 = $mysqli->query($sql1);
								$numRows =  $query1->num_rows;//número de linhas
								if($numRows >= 1){
                                   
									//já deu like
									?>
								<div class="user-iten-bt-like" id="like-<?php print $dados["user_new_post_id"]; ?>">
								    <img src="../images/layout/svg/heart-like-icon-active.svg" width="25" style="padding-left:20px;">  
								    </div>
							    <?php

								}else{
							?>
								<div class="user-iten-bt-like" id="like-<?php print $dados["user_new_post_id"]; ?>">
								<img src="../images/layout/svg/heart-like-icon-01.svg" width="25" style="padding-left:20px;">  
								</div>
							<?php
							}
						
							//numero de curtidas
							$sql2 =   "SELECT  * FROM likes
									   WHERE like_post_id = ".$dados["user_new_post_id"]." ";
									   $query2 = $mysqli->query($sql2);
									   $numLikes =  $query2->num_rows;//número de linhas
									   print "".$numLikes;
							?>
                            
							
							<div class="user-iten-bt-msg" id="message-<?php print $dados["user_new_post_id"]; ?>">
					           <img src="../images/layout/svg/message-icon-01.svg" width="25" style="padding-left:20px;">  
	                        </div>

							<?php
								$sql3 =   "SELECT  * FROM post_message
										WHERE message_post_id = ".$dados["user_new_post_id"]." ";
										$query3 = $mysqli->query($sql3);
										$numMsg =  $query3->num_rows;//número de linhas
										print "&nbsp;&nbsp;".$numMsg;
							?>
						
				</div>	
					
				
					<div class="post-item-info-rigth">
					    <img src="../images/layout/svg/calendar-icon-01.svg" width="25" >
						<?php print separarData($dados["user_new_post_date"]) ;?>
					</div>
				</div>

            
			<div class="post-item-description">
				       <?php print $dados["user_new_post_description"];?>
			</div><!--post-item-description-->
			<!--Comentarios -->
            <?php
			//buscando foto de usuario logado
			 $sql = "SELECT * FROM user
			         WHERE user_id = ".$_SESSION['user_id']."";

		  
			$query3 = $mysqli->query($sql);
			$numRows =  $query3->num_rows;//número de linhas
            $dados1 = $query3->fetch_assoc();
			
			$userImag = $dados1["user_photo_perfil_blob"];//passa a foto do usuario para um scopo Global
			$userName = $dados1["user_name"];//passa a foto do usuario para um scopo Global
			

						?> 



			<div class="box-feeds-comentarios">
				<div class="box-input-text-comentario">
				    <img src="<?php print $dados1["user_photo_perfil_blob"] ;?>" class="user-image-profile-feed-message" > 
					<input type="text" value="" name="input-feed-message" id="input-message-<?php print $dados["user_new_post_id"];?>" placeholder="comentar" >
				    <a href="#" id="publicar-<?php print $dados["user_new_post_id"];?>" class="bt-feed-publicar"> publicar</a>
				</div>
				
				<!-- Lista de comentarios-->
				<br>
				 <span class="title-feeds-messages">Comentarios</span>
				<br>
				<div class="box-list-feed-messages" id="msg-<?php print $dados["user_new_post_id"];?>">
				</div>
				<!--lendo lista de mensagens  -->
				<?php
                   //função para listar comentarios
				   listMessages(   $dados["user_new_post_id"] , $gerenciarPost );//gerenciar é true|false para gerenciar os posts relacionados a minha postagem
                ?>
			</div>


       </div>

   <?php
    
   }//fecha while
     
   jsPostMessage();//chamo a função para ações javascript das mensagens | adicionar msg | excluir
   
   
}


function jsPostMessage(){
  ?>
	<script>

	/* PERCORRENDO OS LIKES E ADICIONANDO O NOVO ICONE*/
	   //RASTREANDOCOMENTARIOS PARA ADICIONA-LO NA POSIÇÃO CERTA
	let itenLike = document.querySelectorAll('.user-iten-bt-like');
	
	for(let i=0; i< itenLike.length; i++ ){

			itenLike[i].addEventListener("click", function(e){
				//alert(this.id);
			//pegando apenas o id
			let likeId = this.id.split("-");
				//alert('id:'+likeId[1]); 
			   //Ajax função
				
				let url = 'requisicoesajax.php?page=setlike&postid='+likeId[1]+'';
				let xhr = new XMLHttpRequest();
				xhr.open("GET", url, true);
				xhr.onreadystatechange = function() {
					if (xhr.readyState == 4) {
						if (xhr.status = 200)
							console.log(xhr.responseText);
							//setando o novo icone de like vermelho like
							let setActiveLike = document.getElementById("like-"+likeId[1]);
								setActiveLike.innerHTML = " <img src='../images/layout/svg/heart-like-icon-active.svg' width='25' style='padding-left:20px;'>";
						}
					}
					xhr.send();
			});
		}//fecha o for();


		/* PERCORRENDO OS COMENTARIOS E ADICIONANDO UM NÓ*/
	   //RASTREANDO COMENTARIOS PARA ADICIONA-LO NA POSIÇÃO CERTA
	   let setMessage = document.querySelectorAll('.bt-feed-publicar');
	   
	   for(let i=0; i< itenLike.length; i++ ){
					
					setMessage[i].addEventListener("click", function(e){
					e.preventDefault();
					
					//verificando valor do input tex
					//alert(this.id);
					

					let message = this.id.split("-");//separando [id]
					//alert(message[1].trim());
					let getBoxMgs =  document.getElementById("msg-"+message[1].trim());
					
					let getMsgTex =  document.getElementById("input-message-"+message[1].trim());
					//alert(getMsgTex.value);
					if( getMsgTex.value != ""){
					  
						let html = " <img src='<?php print $userImag; ?>' "+
										 "class='user-image-profile-feed-message'>"+
										 "<b><?php print $userName; ?></b> "+
										 " "+getMsgTex.value+" ";
										 
										   getBoxMgs.innerHTML = html;

										  //gravando os comentarios
										let url = 'requisicoesajax.php?page=setmessage&useid=<?php print $_SESSION['user_id']; ?>&postid='+message[1].trim()+'&msg='+getMsgTex.value+'&usercreatepost=<?php print $userCreatePost;?>';
										let xhr = new XMLHttpRequest();
										xhr.open("GET", url, true);
										xhr.onreadystatechange = function() {
											if (xhr.readyState == 4) {
												if (xhr.status = 200)
													//console.log(xhr.responseText);
													getMsgTex.value = "";//lempa o texto do input
													//setando o novo icone de like vermelho like
													
												}
											}
											xhr.send();
					   }

					});
	   
	   }//fecha o for();
</script>

<script>
	  /* PERCORRENDO OS COMENTARIOS E REMOVENDO*/
	   //RASTREANDO BUTÃO DE REMOVER COMENTARIOS PARA REMOVE-LOS
	   let getOptiontMessage = document.querySelectorAll('.container-message-rigth-actions');
	   
	   for(let i=0; i< getOptiontMessage.length; i++ ){
			
			
				 getOptiontMessage[i].addEventListener("click", function(e){
				 //e.preventDefault();
				 let messageId = this.id.split("-");//separando [id]
				 //alert(messageId[1].trim());
				 //removendo visualização
				 
				 let messasgeOptionsExpand =  document.getElementById("messasgeOptionsExpand-"+messageId[1].trim() );
				 let style = window.getComputedStyle(messasgeOptionsExpand);
					//alert(style.getPropertyValue('visibility'));
					
					if(style.getPropertyValue('visibility') === "visible"){//caso esteja visivel, fecha
						messasgeOptionsExpand.style.visibility = "hidden";
					}else{
						messasgeOptionsExpand.style.visibility = "visible";
					}
					
					 

					//evento no icone da lixeira
					messasgeOptionsExpand.addEventListener("click", function(e){
						
							  let getBoxMsg =  document.getElementById("linemgsid-"+messageId[1].trim());
								getBoxMsg.innerHTML = "";
								messasgeOptionsExpand.style.visibility = "hidden";//esconse o box options
								//gravando os comentarios
								
								let url = 'requisicoesajax.php?page=deletemessage&messageid='+messageId[1].trim();
													let xhr = new XMLHttpRequest();
													xhr.open("GET", url, true);
													xhr.onreadystatechange = function() {
														if (xhr.readyState == 4) {
															if (xhr.status = 200)
																//console.log(xhr.responseText);
																getMsgTex.value = "";//lempa o texto do input
																//setando o novo icone de like vermelho like
																
															}
														}
														xhr.send();
								

					})

				 
			
				 })
				 
		}//fecha for

   </script>
 <?php

}


function listMessages( $post_id, $gerenciarPost ){//passa o id do post e se posso gerenciar os comentarios
	$mysqli = conectar();
	if (!isset($_SESSION))//necessário inicializar sessão sempre que uma página nova é criada
	    session_start(); 
       // print "->".$post_id."<-<p>";
		
		$sql = "SELECT DISTINCT  * FROM post_message , user_new_post, user
				WHERE  message_post_id 	 = ".trim($post_id)." 
				AND    message_user_id  = user_new_post_user_id 
				AND    user_id = message_user_id	
					   GROUP BY message_id 
					   ORDER BY message_id DESC LIMIT 50";
        
		

		$query = $mysqli->query($sql);
		$numRows =  $query->num_rows;//número de linhas

		while (    $dados = $query->fetch_assoc()  ) {
           ?>
            <div class="box-container-message" id="linemgsid-<?php print $dados["message_id"]; ?>" >
				<div class="container-message-left">
				    <img src='<?php print $dados["user_photo_perfil_blob"]; ?>' class='user-image-profile-feed-message'>
			        <div class="container-message-rigth">
				   <?php
				      print "<span class='msg-user-neme-text-name'>
					            ".$dados["user_name"]."
					         </span>
					         ".$dados["message_text"]."
							 <span class='msg-user-neme-text-date'>
							    ".separarData($dados["message_date"])." as ".separarHora($dados["message_date"])."
							 </span>
								"; 
					?>
					 
				</div>
			</div>
				

			<?php
			     

			  // if(   $dados["message_user_id"] == $_SESSION['user_id'] ||  $userCreatePost == $dados["message_user_id"]){

                if(   $gerenciarPost ||  $dados["message_user_id"] == $_SESSION['user_id']  ){ 
			 ?>
				<div class="container-message-rigth-actions" id="mgsid-<?php print $dados["message_id"]; ?>" >
				      <img src="../images/layout/svg/more-finfo-icon-01.svg" width="25" >
					  
					  <div class="box-messasge-options-expand" id="messasgeOptionsExpand-<?php print $dados["message_id"]; ?>">
					     <img src="../images/layout/svg/remove-01.svg" width="25" >
				      </div>
				</div>
			<?php
			   }//fecha o if
			 ?>
			</div>

			<?php
       }//final do while
      
	   




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
					
					<div class="user-image-profile">
					   <img src="<?php print $dados["user_photo_perfil_blob"] ;?>" class="user-image-profile-top"> 
					</div>
				</a>

				<a href="main.php?page=feeds">	
				   <div class="top-menu-itens"><img src="../images/layout/logo-meet-icon-01.jpg"></div> 
			    </a>   
            </div><!--fecha left-top-menu-itens -->



			<?php
			   }//fecha while
			?>
		   
			<div class="rigth-top-menu-itens"> 
				<div class="top-menu-itens"><img src="../images/layout/svg/notification-icon-01.svg" width="25"></div>
			<a href="main.php?page=settings">
				<div class="top-menu-itens"><img src="../images/layout/svg/settings-icon-01.svg" width="25"></div>
			</a>
			<a href="main.php?page=logoff">
				<div class="top-menu-itens"><img src="../images/layout/svg/logoff-icon-01.svg" width="25"> </div>
			</a>
			</div>
		</div>
	<?php
}


function footMenu(){
	?>
	<div class="box-foot-menu">
			<a href="main.php?page=feeds">
				<div class="foot-menu-itens"><img src="../images/layout/svg/home-icon-01.svg" width="25"></div>
            </a>
			<a href="main.php?page=search">	
				<div class="foot-menu-itens"><img src="../images/layout/svg/search-icon.svg" width="25" ></div>
            </a>
			<a href="main.php?page=newpost">
				<div class="foot-menu-itens"><img src="../images/layout/svg/new-post-icon.svg" width="25"></div>
            </a>	
			<a href="main.php?page=configuration">
				<div class="foot-menu-itens"><img src="../images/layout/svg/more-finfo-icon-01.svg" width="25"></div>
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