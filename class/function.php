<?php

$mysqli = conectar();//Inicia uma conexão com o banco de dados

function conectar(){//conecta ao BASE de dados e passa o objeto conexão
  
   

     //EM PRODUCAO - freewebhosting
	 /*
	 $servidor = 'localhost';
	 $usuario = '532830';
	 $senha = '19892008';//sem senha - senha padrão do PhpMyAdmin
	 $banco = '532830';*/


	 //local host
	 $servidor = 'localhost';
	 $usuario = 'root';
	 $senha = '';//sem senha - senha padrão do PhpMyAdmin
	 $banco = 'meet';

	 /*
	 //EM PRODUCAO -  000Webhost
	 $servidor = 'localhost';
	 $usuario = 'id19182302_apoloone';
	 $senha = 'Jr.19892008';//sem senha - senha padrão do PhpMyAdmin
	 $banco = 'id19182302_apoloonedb';*/

 
	
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


	$mysqli = conectar();

	if (!isset($_SESSION))
		session_start(); 

   ?>
   
   <!-- upload files-->

  <div class="box-cad-user">
	   
	  <div class="container-user">
   <form action="main.php?page=cadUser" method="POST" id="form-cadastro-user">
	   
	   
			<BR>NOVO CADASTRO<BR>
			
		   <div class='files'></div>
		    <div id="attachment" class="attachment">
			    <div id='upload' class='carregar-foto' ></div>
            </div> 
			
			<span id="status" ></span>
			<br>
			<input type="text" id="userName" name="userName" placeholder="Nome de usuário" maxlength="25" ><br>
			<input type="hidden" id="user-tag-name" name="user-tag-name" value="false"/>
			<input type="hidden" id="tag-name" name="tag-name" value=""/>
			<span id="result-user-name"></span>
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
              rows="5" cols="33"  maxlength ="150">Digite algo sobre você</textarea><br><br>
			<input type="submit" value="gravar" name="opc" id="bt-enviar-cad-user" >
   </form>
	  </div><!--container-user -->
	      <div class="box-guia-modal-cad-user" id="box-guia-modal-cad-user">
			<div class="info-text-modal" id="info-text-modal">
				Te guiaremos nessa etapa<br>
				Vamos começar?
			</div>
		   <div class="close-modal" id="close-modal">[fechar]</div>
         </div><!--box-guia-modal-cad-user -->

 </div>	<!--box-cad-user -->

<!-- Ações javaScript-->
 
 <script type="text/javascript">
	    $("#userBirthday").mask("99/99/9999");
		$("#userPhone").mask("(99) 99999-9999");
     
		//pegando o objeto form
		let formCadastro = document.getElementById("form-cadastro-user");
		let btEnviar = document.getElementById("bt-enviar-cad-user");
		let userNameResult = document.getElementById("result-user-name");
		let userNameEditText = document.getElementById("userName");
		let userTagNameValida = document.getElementById("user-tag-name");//para saber se valida = true, ou false
		let tagName = document.getElementById("tag-name");
		let userPassword = document.getElementById("userPassword");
		let userBirthday = document.getElementById("userBirthday");
		let userPhone = document.getElementById("userPhone");
		let userEmail = document.getElementById("userEmail");
		let textAreaBio = document.getElementById("userBio");
		let boxModalInfo = document.getElementById("box-guia-modal-cad-user");
		let closeModal = document.getElementById("close-modal");
		let infoTextModal = document.getElementById("info-text-modal");
		
		let valida = true;
		


		let trataNome;
		
		userNameEditText.addEventListener("keyup", function(){
			  
			 
			 /* 
			  for(let i=0; i< this.value.length; i++ ){
				trataNome+=trataNome[i];
			  }*/
			 
			  
		});

		userNameEditText.addEventListener("blur", function(e){
			  let trataNome = userNameEditText.value.replace(/ /g, ""); 
			  trataNome = trataNome.toLowerCase();
              
			   //pesquisando no banco de dados se já existe algum usuario com esse userName
			   let url = 'requisicoesajax.php?page=validausertagname&tagname='+trataNome+'';
				let xhr = new XMLHttpRequest();
				xhr.open("GET", url, true);
				xhr.onreadystatechange = function() {
					if (xhr.readyState == 4) {
						if (xhr.status = 200)
							//console.log(xhr.responseText);
							userNameResult.innerHTML = xhr.responseText;
							if(xhr.responseText == "1" ){
								boxModalInfo.style.visibility = "visible";
								infoTextModal.innerHTML = "Usuario "+trataNome+" já existe! Tente outro";
								userTagNameValida.value = "false";//seta o input para false para não deixar cadastrar usuarios com registros iguais
								valida = false;
								//userNameEditText.focus();
								
							}else{
								
								userTagNameValida.value = "true";//usuario válido
								boxModalInfo.style.visibility = "visible";
								infoTextModal.innerHTML = "Seu nome de usuario será "+trataNome+"";
								userNameResult.innerHTML = "usuario <b>@"+trataNome+"</b>";
								tagName.value = trataNome;
							}
							if(trataNome.length < 4 || trataNome == ""){//não digitou
								userTagNameValida.value = "false";//seta o input para false para não deixar cadastrar usuarios com registros iguais
								valida = false;
								//userNameEditText.focus();
							}
							//alert(xhr.responseText);
							  
						}
					}
					xhr.send();
             

			});
           //fecha janelinha modal
			closeModal.addEventListener("click", function(e){
						e.preventDefault();//remove
						boxModalInfo.style.visibility = "hidden";
						
				
			});


		
		btEnviar.addEventListener("click", function(e){
						e.preventDefault();//remove
						
                        valida = true;

                        if(userTagNameValida.value == "false"){
							
							boxModalInfo.style.visibility = "visible";
							infoTextModal.innerHTML = "Nome de usuário não informado ou invalido";
							//userNameEditText.focus();
							valida = false;

						}else if(userPassword.value.length < 6){
							
							boxModalInfo.style.visibility = "visible";
							infoTextModal.innerHTML = "Password de, no mínimo, 6 caracteres!";
							//userPassword.focus();
							valida = false;
						}
						if(userBirthday.value == ""){
							
							boxModalInfo.style.visibility = "visible";
							infoTextModal.innerHTML = "Data de nascimento vazio!";
							//userBirthday.focus();
							valida = false;

						}if(userPhone.value == ""){
							
							boxModalInfo.style.visibility = "visible";
							infoTextModal.innerHTML = "Telefone vazio!";
							//userPhone.focus();
							valida = false;
						
						}if(userEmail.value == ""){
							
							boxModalInfo.style.visibility = "visible";
							infoTextModal.innerHTML ="Email vazio!";
							//userEmail.focus();
							valida = false;
						
						}if(textAreaBio.value =="Digite algo sobre você" || textAreaBio.value ==""){
							
							boxModalInfo.style.visibility = "visible";
							infoTextModal.innerHTML ="Digite algo sobre você!";
							//textAreaBio.focus();
							valida = false;

						}
                        //não há nada de errado nos if´s
						if(valida){
							//finalmente, executa o submite
							formCadastro.submit();
						} 
						
                       
        });

	             //tratando o textArea
	            textAreaBio.addEventListener("focus", function(e){
                   // alert(textAreaPost.value);
					if(textAreaBio.value =="Digite algo sobre você"){
					   textAreaBio.value = "";
					}
				});

                textAreaBio.addEventListener("blur", function(e){
					alert("->"+textAreaPost.value+"<-")
					/*if(textAreaPost.value ==""){
						textAreaBio.value = "Digite algo sobre você?";
						textAreaBio.focus();
					}*/
				});



				





		
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

function areaUser( $userId ){
	
	$mysqli = conectar();

	

	 
		
      if( $userId == NULL){
		
		//print "->>>nao existe".$_POST["userEmail"]." <<- ";
		
		$sql = "SELECT * FROM user 
	                 WHERE user_email = '".strtolower( trim($_POST["userEmail"])  )."'   
	                 AND  user_password = '".trim($_POST["userPassword"])."'  ";
					 $userId = "logado";
	}else{
		
		//print "->>>existe".$_POST["userEmail"]." <<- ";
		$sql = "SELECT * FROM user 
	                 WHERE user_id = ".$userId."  ";
	}
	
	
	
	
	// 
				  
	$query = $mysqli->query($sql);
	$numRows =  $query->num_rows;//número de linhas
	//print "->".$_POST["userEmail"]." - ".$_POST["userPassword"]."numRows = ".$numRows ."";
	while (    $dados = $query->fetch_assoc()  ) {
				  //print "usuario encontrado '".$dados["user_name"]."";
				 if($userId == "logado"){
				     $_SESSION['user_id'] = $dados["user_id"] ;//só atribui se ele logar pela primeira vez
					 $userId = $_SESSION['user_id'];
				 }  
				   ?>
                  <div class='box-geral-profile'>
                        
				        <div class="box-info-tex-profile">
							<br><br>
						        <span class="text-info-name"> <?php print $dados["user_name"];  ?></span><br>
							                          <?php print "@".$dados["user_tagname"];  ?><br>
							    <span class="text-info-bio">  <?php print $dados["user_bio"];  ?></span>	
						

                            <!-- Área de localização-->
                            <?php
										//selecionando usuario local - SESSION
										$sql1 = "SELECT * FROM user WHERE 	user_id = ".$_SESSION['user_id']." ";
										$query1 = $mysqli->query($sql1);
										$numRows =  $query1->num_rows;//número de linhas
										$dados1 = $query1->fetch_assoc() ;


										$lat1 = $dados1["user_latitude"];;
										$lon1 = $dados1["user_longitude"];
										$lat2 = $dados["user_latitude"];
										$lon2 = $dados["user_longitude"];

										$lat1 = deg2rad($lat1);
										$lat2 = deg2rad($lat2);
										$lon1 = deg2rad($lon1);
										$lon2 = deg2rad($lon2);
								
										$dist = (6371 * acos(cos($lat1) * cos($lat2) * cos($lon2 - $lon1) + sin($lat1) * sin($lat2)));
										print "
										<br><b>
										<img src='../images/layout/svg/location-2-icon-inactive.svg' width='15'>
										Está a ".(number_format($dist, 1, '.', ''))." Km</b>";//quilometros
						    ?>
						</div><!--fecha box-info-tex-profile -->





						<?php
						if(file_exists("../images/users/media_".$dados["user_photo_perfil"])){
						?>
						<div class="box-moldura-profile" >
						        <img src="../images/users/media_<?php print $dados["user_photo_perfil"] ;?>" class="user-image-profile"> 
								
						</div>
                        <?php

                        

						}//fecha if file_exists
						?>


	             </div>	
				  
            
                <?php
				//só mostra os botoes de alterar e postar se o usuario logado for o mesmo da sessão
				 if(trim($dados["user_id"]) === trim($_SESSION['user_id'])){
                ?>
						<div class="box-action-profile">
							<a href="main.php?page=alteruser&id=<?php print $_SESSION['user_id'];?>" class="box-bt">
								<span>editar perfil</span>
							</a>
							<a href="main.php?page=newpost" class="box-bt">
								<span>publicar</span>
							</a>
						</div>
				<?php
				}//fim do if
				?>		
                  
             <?php
              
		//Listando postagens
		
		$sql = "SELECT * FROM user_new_post 
		                 WHERE user_new_post_user_id = ".$userId." ORDER BY user_new_post_id DESC  "; //.$_SESSION['user_id'] , $userId
                
				$query = $mysqli->query($sql);
				$numRows =  $query->num_rows;//número de linhas
				
				print "
				       
				       <div class='box-post-list' id='box-post-list'>";
						while (    $dados = $query->fetch_assoc()  ) {
						
                              ?>
							    <a href="main.php?page=openuserpost&user_id=<?php print $dados["user_new_post_user_id"];?>&post_id=<?php print $dados["user_new_post_id"];?>">
								    
								<?php
								   if(file_exists("../images/users/media_".$dados["user_new_post_image"])){
								?>
								      <div style="background-image: url('../images/users/media_<?php print $dados["user_new_post_image"] ;?>');" class="box-iten-post" >
								      </div><!--fim div box-iten-post -->
								<?php
								   }//fim do if file_exists 
								?>	 
							             
							        
						        </a>
							 <?php
						}
				print "</div><!--fecha div box-post-list -->";



	 }

     //CONTRUINDO LEYOU DA TELA DE LOGIN DO USUÁRIO
	 if($numRows >= 1){//SE ENCONTRAR ALGUMA LINHA
        
		//print "Usuario ID: ".$_SESSION['user_id'];

	 }else{
		//print "USUÁRIO OU SENHA NÃO ENCONTRADOS";
	 }
      ?>
		<script>
         //distribuindo itens (fotos com largura proporcionalmente)
		 
	
		 let getWidthContainer = document.getElementById("box-post-list");
		 let get_w;

		 resizeImages();

         window.addEventListener("resize", function(e){
		      
			resizeImages();
			//result.innerHTML =  ">>>>"+(limpaNumero/3)+"<<<<<" ;
		});
		
        function resizeImages(){//redimencionando imagens para assumirem largura da view
			var w =   window.getComputedStyle(getWidthContainer).width;
                var list = document.querySelectorAll(".box-iten-post");
                var  subdivide;//para saber em quanto devo dividir as iamgens na tela
				if(list.length<=1){
					subdivide = 1;
				}else if(list.length == 2){
					subdivide = 2
				}else{
					subdivide = 3;
				}
 

			        for(var i=0; i < list.length; i++){
						let limpaNumero = w.substring(0,w.length-2);
						list[i].style.width = ''+((limpaNumero)/subdivide).toFixed(2)+'';
						list[i].style.height = ''+((limpaNumero)/subdivide).toFixed(2)+'';
					}
		}
		 












			//pegando geolocalização
			if("geolocation" in navigator){
				
                navigator.geolocation.getCurrentPosition(function(position){
                  
                   // console.log("Latitude:"+position.coords.latitude+" <br>longitude"+position.coords.longitude);
                    
					let url = 'requisicoesajax.php?page=setcoordenadas&latitude='+position.coords.latitude+'&longitude='+position.coords.longitude+'';
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

                     //console.log(position);
            

				 }, function(error){
					alert(error);
				});


			}else{
				alert("ops! geolocalização nao possivel")
			}
		</script>


    <?php


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
						$foto = $dados["user_photo_perfil"];
						print "<div class='files' id='files'>";//Necessário para upload da nova imagem
						 
						if(file_exists("../images/users/pequena_".$foto))
						{
							 print " 
										 <img src='../images/users/pequena_".$foto."'>
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
				    
				 <br>
                 
				 <div id="attachment" class="attachment" >
					Alterar Imagem
				   <div id='upload' class='carregar-foto' ></div>
				 </div>

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

		$sql = "SELECT * FROM user
		                 WHERE user_id = ".$_SESSION['user_id']."";//$user_id , $_SESSION['user_id']
		
	 
		$query = $mysqli->query($sql);
		$numRows =  $query->num_rows;//número de linhas

		$dados = $query->fetch_assoc();

      ?>

		<!--import para cortar imagem -->
		
	  <div class="box-new-post">
	        <br><b>Nova Publicação</b> <br>
			<form action="main.php?page=setnewpostuser" method="POST" id="form-new-post" enctype="multipart/form-data">

			        <?php print $dados["user_tagname"]; ?> 
			        <textarea id="new-post-text"  
					          name="new-post-text"
							  class="new-post-text" 
							  maxlength ="500"
							  >O que está rolando?</textarea> 

					<div class='files' id="files">
						<!--<img src="../images/layout/default-image-post.jpg" id="img-arquivo" value="">-->
					</div>
                    <!-- Armazena a imagem em blob no banco de dados-->
					<input type='hidden' id='blob-image' name='blob-image' value=''>
					<span id="status" ></span>
					<div id="attachment" class="attachment">
					   <div id='upload' class='carregar-foto' ></div>
                     </div>  
					   
						<input type="submit" value="postar" name="opc" id="bt-enviar-cad-user" >
			</form>


            <script>

                 const textAreaPost = document.getElementById("new-post-text");
				 const btPostar = document.getElementById("bt-enviar-cad-user");
				 const formNewPost = document.getElementById("form-new-post");
				 
				 
				      // textAreaPost.focus();//seta o foco no elemento textArea

				
                 
				 textAreaPost.addEventListener("focus", function(e){
                   // alert(textAreaPost.value);
					if(textAreaPost.value =="O que está rolando?"){
						textAreaPost.value = "";
					}
				});

				textAreaPost.addEventListener("blur", function(e){
					if(textAreaPost.value ==""){
						textAreaPost.value = "O que está rolando?";
					}
				});

               //validando momento de postaGEM
			   btPostar.addEventListener("click", function(e){

				    e.preventDefault();

					if(textAreaPost.value == "O que está rolando?" || textAreaPost.value == ""){
						//alert("Digite algo");
						document.getElementById("status").innerHTML = "<b>Digite algo</b>";

						textAreaPost.focus();
					}else{
						formNewPost.submit();//Executa o submite
					}
				});



			</script>

            
			
			
                        
    </div>				 
	  <?php

}
function openUserPost($user_id, $post_id){
	
	if (!isset($_SESSION))//necessário inicializar sessão sempre que uma página nova é criada
	    session_start(); 
	
		$gerenciarPost = false;
	
	$mysqli = conectar();
	
	
	$sql = "SELECT * FROM user, user_new_post
	                 WHERE user_new_post_id = ".$post_id."
					 AND   user_id = ".$user_id."";//$user_id , $_SESSION['user_id']
					 
				  
	$query = $mysqli->query($sql);
	$numRows =  $query->num_rows;//número de linhas
	
	while (    $dados = $query->fetch_assoc()  ) {
	 ?>
	   <div class="box-user-post-item">
		   
		    <?php
			   if(file_exists("../images/users/".$dados["user_new_post_image"])){
			?>
	            <div class="box-image-user-post-item">
		          <image  src="../images/users/media_<?php print $dados["user_new_post_image"] ;?>">
	            </div>

			<?php
			   }//fim do file_exists
			?>	

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
							    <img src="../images/users/media_<?php print $dados["user_photo_perfil"] ;?>" class="user-image-profile">
							</div>
							<div class="box-info-text-left-profile">
								<?php print $dados["user_tagname"] ;?>
							</div>
                            <!--like icon -->
							<div class="user-iten-bt-like">
							 &nbspcurtidas  
	                        </div>
                            <?php
							//numero de curtidas
							$sql2 =   "SELECT  * FROM likes
									   WHERE like_post_id = ".$dados["user_new_post_id"]." ";
									   $query2 = $mysqli->query($sql2);
									   $numLikes =  $query2->num_rows;//número de linhas
									   print "".$numLikes;
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
             

            <?php
						
						
						$sql1 = "SELECT * FROM user, user_new_post
						WHERE user_new_post_id = ".$post_id."
						AND   user_id = ". $_SESSION['user_id']."";//$user_id , $_SESSION['user_id']
						
					
			            $query1 = $mysqli->query($sql1);
			            $numRows =  $query1->num_rows;//número de linhas
						$dados1 = $query1->fetch_assoc(); 
			?>

			<div class="box-feeds-comentarios">
				<div class="box-input-text-comentario">
				    <img src="../images/users/media_<?php print $dados1["user_photo_perfil"] ;?>" class="user-image-profile-feed-message" > 
					<input type="text" value="" name="input-feed-message" id="input-message-<?php print $dados["user_new_post_id"];?>" placeholder="comentar" >
				    <input type="hidden" id="userdestinacao-<?php print $dados["user_new_post_id"];?>" value="<?php print $dados["user_id"];?>">
					<a href="#" id="publicar-<?php print $dados["user_new_post_id"];?>" class="bt-feed-publicar"> publicar</a>
				</div>
				
				<!-- Para Adicionar o post dinamicamente-->
				


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
	
    ?>
	<?php


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
						
						<?php
						if(file_exists("../images/users/media_".$dados["user_new_post_image"])){
						?>
							
							<div class="box-image-user-post-item">
								<image src="../images/users/<?php print $dados["user_new_post_image"];?>">
							</div>
						
						<?php
						}//fim defile_exists 
						?>
					
					</a>

					<div class="box-info-user-post">
						
							<div class="profile-info-left"> 
										<a href="main.php?page=userLogin&userid=<?php print $dados["user_id"]; ?>">
											<div> 
											<img src="../images/users/media_<?php print $dados["user_photo_perfil"] ;?>" class="user-image-profile-feed"> 
											</div>
										</a>		
										
											<div class="box-info-text-left-profile">
												<?php print $dados["user_tagname"] ;?>
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
										<!--PARA CAPTURAR USUARIO DO LIKE -->
										<input type="hidden" id="likeuserdestinacao-<?php print $dados["user_new_post_id"];?>" value="<?php print $dados["user_id"];?>" >
										
										
										
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
									
							</div><!-- fecha div profile-info-left-->	
								
							
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
									<img src="../images/users/pequena_<?php print $dados1["user_photo_perfil"] ;?>" class="user-image-profile-feed-message" > 
									<input type="text" value="" name="input-feed-message" id="input-message-<?php print $dados["user_new_post_id"];?>" placeholder="comentar" >
									<input type="hidden" id="userdestinacao-<?php print $dados["user_new_post_id"];?>" value="<?php print $dados["user_id"];?>">
									<input type="hidden" id="tempemgsid-<?php print $dados["user_new_post_id"];?>" value="<?php print rand();?>" >
									<a href="#" id="publicar-<?php print $dados["user_new_post_id"];?>" class="bt-feed-publicar"> publicar</a>
								</div>
							
								<!-- Lista de comentarios-->
								<br>
								<span class="title-feeds-messages">Comentarios</span>
								<!--Div temperaria para receber comentarios -->
                                <div class="box-temp-line-msg" id="boxtemplinemsg-<?php print $dados["user_new_post_id"]; ?>"></div>

								<br>
								
								<!--lendo lista de mensagens  -->
								<?php
								//função para listar comentarios
								listMessages(   $dados["user_new_post_id"] , $gerenciarPost );//gerenciar é true|false para gerenciar os posts relacionados a minha postagem
								?>
						</div><!-- fecha div box-feeds-comentarios -->
        </div><!--feed-box-user-post-item -->

   <?php
    
   }//fecha while
     
  


	//saber o ultimo post lido
	$sql = "SELECT  * FROM user_new_post ORDER BY user_new_post_id DESC LIMIT 10 ";
	
				  
	$query = $mysqli->query($sql);
	$numRows =  $query->num_rows;//número de linhas
	$dados = $query->fetch_assoc();
	//sabendo qual post foi lido por ultimo
	$_SESSION['user_new_post_id'] = $dados["user_new_post_id"];
	//print "ultimo post :".$_SESSION['user_new_post_id'];

    jsPostMessage();//chamo a função para ações javascript das mensagens | adicionar msg | excluir
   
}





function jsPostMessage(){


	//trazendo as informações do usuario logado
	$mysqli = conectar();
	if (!isset($_SESSION))//necessário inicializar sessão sempre que uma página nova é criada
		session_start(); 

	$userImag = "";
	$userName = "";
	
	
	
	$sql = "SELECT  * FROM  user WHERE user_id = ".$_SESSION['user_id']." ";
	
				
	$query = $mysqli->query($sql);
	$numRows =  $query->num_rows;//número de linhas
	$dados = $query->fetch_assoc();
		
	

  ?>
	<script>

	/* PERCORRENDO OS LIKES E ADICIONANDO O NOVO ICONE*/
	   //RASTREANDOCOMENTARIOS PARA ADICIONA-LO NA POSIÇÃO CERTA
	let itenLike = document.querySelectorAll('.user-iten-bt-like');
	
	//for(let i=0; i< itenLike.length; i++ ){

		$( "body" ).delegate( ".user-iten-bt-like", "click", function(e){
			//itenLike[i].addEventListener("click", function(e){
				//alert(this.id);
			//pegando apenas o id
			let likeId = this.id.split("-");
				//alert('id:'+likeId[1]); 
			   //Ajax função
			   let userDestinacao = document.getElementById("userdestinacao-"+likeId[1]);//para quem a menssagem é enviada
				//alert("->"+userDestinacao.value);
				let url = 'requisicoesajax.php?page=setlike&postid='+likeId[1]+'&userdestinacao='+userDestinacao.value+'';
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
		//}//fecha o for();


		/* PERCORRENDO OS COMENTARIOS E ADICIONANDO UM NÓ*/
	   //RASTREANDO COMENTARIOS PARA ADICIONA-LO NA POSIÇÃO CERTA
	   let setMessage = document.querySelectorAll('.bt-feed-publicar');
	   
	  // for(let i=0; i< itenLike.length; i++ ){
					

		


					//setMessage[i].addEventListener("click", function(e){
				$( "body" ).delegate( ".bt-feed-publicar", "click", function(e){
					e.preventDefault();
					
                    

					//verificando valor do input tex
					//alert(this.id);
					

					let message = this.id.split("-");//separando [id]
					alert(message[1].trim());
					let getBoxMgs =  document.getElementById("msg-"+message[1].trim());
					let userDestinacao = document.getElementById("userdestinacao-"+message[1].trim());//para quem a menssagem é enviada
					//alert("->"+userDestinacao.value);


					let getMsgTex =  document.getElementById("input-message-"+message[1].trim());
                    //pegando o container geral das mensagens
					
					
					let boxtemplinemsg =  document.getElementById("boxtemplinemsg-"+message[1].trim());
					
					//let getLineIndexMsg =  document.getElementById("linemgsid-");



					//alert(getMsgTex.value);
					if( getMsgTex.value != ""){//verifica se o campo está vazio
					  
						

										let messageTemoId = (Math.random() * 100);//GERA UM NUMERO RANDOMICO PARA ALOCAÇÃO E CAPTURA DE ELEMENTOS EM TEMPO DE EXECUÇÃO E CRIAÇÃO DINAMICA

												let html = "<div class='box-container-message' id='linemgsid-"+messageTemoId+"' >"+
																	"   <div class='container-message-left'>"+
																	"        <input  type='hidden' id='tempemgsid-"+messageTemoId+"' value='"+messageTemoId+"'>"+
																			"  <div class='box-round-img-user'"+
																				   "style='background-image: url(../images/users/pequena_<?php print $dados["user_photo_perfil"] ;?>);' >"+	
																					"<div class='layer-roud-white-img-user-icon'></div>"+
																			  "</div>"+
												                             
												                              "<b><?php print  $dados["user_tagname"]; ?></b> "+
																			  "<br> "+getMsgTex.value+" "+
										                              " </div>"+
										                              
										                    "          <div class='container-message-rigth-actions' id='mgsid-"+messageTemoId+"' >"+
										                     "               <img src='../images/layout/svg/more-finfo-icon-01.svg' width='25' >"+
															 "             <div class='box-messasge-options-expand' id='messasgeOptionsExpand-"+messageTemoId+"'>"+
															 "               <img src='../images/layout/svg/remove-01.svg' width='25' >"+
															 "            </div>"+
															 "         </div>"+
															 " </div>";

										  //adicionando elementos DOM dinamicamente
										  
										  var newLineMsg = document.createElement("div");					 
										      newLineMsg.innerHTML = html;
											  boxtemplinemsg.appendChild(newLineMsg);
                                             
										  //gravando os comentarios
										
										let url = 'requisicoesajax.php?page=setmessage&useid=<?php print $_SESSION['user_id']; ?>&userdestinacao='+userDestinacao.value+'&postid='+message[1].trim()+'&msg='+getMsgTex.value+'&usercreatepost=<?php print  $_SESSION['user_id'];?>&messagetempid='+messageTemoId+'';
										let xhr = new XMLHttpRequest();
										xhr.open("GET", url, true);
										xhr.onreadystatechange = function() {
											if (xhr.readyState == 4) {
												if (xhr.status = 200)
													//console.log(xhr.responseText);
													//getBoxMgs.innerHTML = html;//desenha o html dinamicamente
													getMsgTex.value = "";//lempa o texto do input
													//setando o novo icone de like vermelho like
													
												}
											}
											xhr.send(); 
											
					   }

					});
	   
	  // }//fecha o for();
</script>

<script>
	  /* PERCORRENDO OS COMENTARIOS E REMOVENDO*/
	   //RASTREANDO BUTÃO DE REMOVER COMENTARIOS PARA REMOVE-LOS
	   let getOptiontMessage = document.querySelectorAll('.container-message-rigth-actions');
	   
	   //for(let i=0; i< getOptiontMessage.length; i++ ){
			
		$( "body" ).delegate( ".container-message-rigth-actions", "click", function(e){
				 //getOptiontMessage[i].addEventListener("click", function(e){
				 //e.preventDefault();
				 let messageId = this.id.split("-");//separando [id]
				// alert(""+messageId[1].trim());
				 //removendo visualização
				 
				 let messasgeOptionsExpand =  document.getElementById("messasgeOptionsExpand-"+messageId[1].trim() );
				 let style = window.getComputedStyle(messasgeOptionsExpand);
					//alert(style.getPropertyValue('visibility'));
					
                    //escondendo todos os elemento, caso tenha algum abert(visivel)
					let getMessageOptionsExpand = document.querySelectorAll('.box-messasge-options-expand');
				    	
					 

					if(style.getPropertyValue('visibility') === "visible"){//caso esteja visivel, fecha
						messasgeOptionsExpand.style.visibility = "hidden";
					}else{

						for(let i=0; i< getMessageOptionsExpand.length; i++ ){ 
					        getMessageOptionsExpand[i].style.visibility = "hidden";
					    }
						messasgeOptionsExpand.style.visibility = "visible";
					}
					
					 

					//evento no icone da lixeira
					$( "body" ).delegate( ".box-messasge-options-expand", "click", function(e){
					//messasgeOptionsExpand.addEventListener("click", function(e){
						     
						      

							  let getBoxMsg  =  document.getElementById("linemgsid-"+messageId[1].trim());
							  let tempeMgsid =  document.getElementById("tempemgsid-"+messageId[1].trim());
							 // alert(">>>"+messageId[1].trim());
                              //alert("DEL>>>>"+tempeMgsid.value);
								 
								messasgeOptionsExpand.style.visibility = "hidden";//esconse o box options
								//gravando os comentarios
								
								
								
                               // alert("DEL=>"+messageId[1].trim());
								e.stopPropagation();//evita a propagação de eventos a elementos pai

								let url = 'requisicoesajax.php?page=deletemessage&messagetempid='+messageId[1].trim();
													let xhr = new XMLHttpRequest();
													xhr.open("GET", url, true);
													xhr.onreadystatechange = function() {
														if (xhr.readyState == 4) {
															if (xhr.status = 200)
															    
															    getBoxMsg.innerHTML = "";//remove a linha
																console.log(xhr.responseText);
																//getMsgTex.value = "";//limpa o texto do input
																//setando o novo icone de like vermelho like
																//alert("msg-id: "+messageId[1].trim());
															}
														}
														xhr.send();
								

							
								

					});

					e.stopPropagation();//evita a propagação de eventos a elementos pai
			
				 })
				 
		//}//fecha for

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
               
			   ?>
		            <span class="title-feeds-messages">Comentarios
				       <img src="../images/layout/svg/message-icon-01.svg" width="15" style="padding-left:6px;">  
					 <?php print $numRows; ?>
	                </span>
               
		<div class="box-main-messages" > 
		
		<!-- Necessário para as menssagens dinâmicas-->
		<div class="box-temp-line-msg" id="boxtemplinemsg-<?php print $post_id; ?>"></div>

		            <?php
		while (    $dados = $query->fetch_assoc()  ) {
           ?>
		            
					
					
					<div class="box-container-message" id="linemgsid-<?php print $dados["message_temp_id"]; ?>" >
						
							
								
								<div class="container-message-left">
									<a href="main.php?page=userLogin&userid=<?php print $dados["user_id"]; ?>">    
										<div class="box-round-img-user"
											style="background-image: url('../images/users/pequena_<?php print $dados["user_photo_perfil"] ;?>');" >	
											<div class="layer-roud-white-img-user-icon"></div>
									
										</div>
									</a>  
										
										<div class="container-message-rigth">
									<?php
										print "<span class='msg-user-neme-text-name'>
													".$dados["user_tagname"]."
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
									<div class="container-message-rigth-actions" id="mgsid-<?php print $dados["message_temp_id"]; ?>" >
										<img src="../images/layout/svg/more-finfo-icon-01.svg" width="25" >
										
										<div class="box-messasge-options-expand" id="messasgeOptionsExpand-<?php print $dados["message_temp_id"]; ?>">
											<img src="../images/layout/svg/remove-01.svg" width="25" >
										</div>
									</div>
								<?php
								}//fecha o if
								?>
					</div><!--fecha div box-container-message -->

			<?php
       }//final do while
    ?>
	</div><!--fecha div box-main-messages -->
	<?php

} 



function searcUse(){

	$mysqli = conectar();
	if (!isset($_SESSION))//necessário inicializar sessão sempre que uma página nova é criada
		session_start(); 
	    ?>

        <div class="box-geral-search">
            <div class="box-input-search">
			    <img src="../images/layout/svg/search-icon.svg" width="20" style="padding-left:12px;">
				<input type="text" value="" id="inputsearc" placeholder="buscar" maxlength="20">
            </div>
			<div class="box-searc-results" id="box-searc-results"><!-- Aonde sera carregada os resultados da pesquisa-->
            </div>

        </div><!--fecha box-geral-search -->

        <script type="text/javascript">
			
            let inputSearc = document.getElementById("inputsearc");
			    inputSearc.addEventListener("keyup", function(e){
                
					let boxSearcResults = document.getElementById("box-searc-results");
				 	    
					     
						 let url = 'requisicoesajax.php?page=searcuser&data='+this.value.trim();
						 let xhr = new XMLHttpRequest();
						 xhr.open("GET", url, true);
						 xhr.onreadystatechange = function() {
							if (xhr.readyState == 4) {
								if (xhr.status = 200)
									//console.log(xhr.responseText);
									boxSearcResults.innerHTML = xhr.responseText; //tras os resultados
									//setando o novo icone de like vermelho like
									
								}
							}
							xhr.send();
                        

				});
		</script>

	<?php
}


function cropperImage(){
 
	$mysqli = conectar();
	if (!isset($_SESSION))//necessário inicializar sessão sempre que uma página nova é criada
		session_start(); 
		$sql = "SELECT * FROM user_new_post 
		WHERE user_new_post_user_id = ".$_SESSION['user_id']." ";
	
				  
		$query = $mysqli->query($sql);
		$numRows =  $query->num_rows;//número de linhas
		
		 $dados = $query->fetch_assoc();

		 //abrindo apenas uma imagem

		 //style="background-image: url('../images/users/media_<?php print $dados["user_new_post_image"] ;?>');"
		 ?>
		    <div class="box-geral-img" >
                 <img src="../images/users/media_<?php print $dados["user_new_post_image"] ;?>">
				 <input type="hidden" id="imagefile" value="../images/users/media_<?php print $dados["user_new_post_image"] ;?>">

		   <div class="select-area-image" id="select-area-image">
           </div>	
			</div>
            <span id="infos"></span>

			<a href="requisicoesajax.php.php?page=cropperimage" id="croppar">
              [ cropper ]    
		   </a>


           <script>
			 let elementMove = document.getElementById("select-area-image");
			 let info = document.getElementById("infos");
			 
			 let mLeft =  0;//inicializo
			 let mTop =   0;//inicializo

			 infos.innerText = 'Touch ends [top:'+mTop+' ] [left:'+mLeft+' ]';
			 
			 elementMove.addEventListener('touchstart', function(e) {
					infos.innerText = 'Touch begins';
				});

				elementMove.addEventListener('touchend', function(e) {
					elementMove
					
					mLeft = parseInt(elementMove.style.left);
					mTop = parseInt(elementMove.style.top);	
					infos.innerText = 'Touch ends [top:'+mTop+' ] [left:'+mLeft+' ]';
	                		
				});
                
				let Ox = 1;
				
				elementMove.addEventListener('touchmove', function(e) {

					             ox = Math.round( e.touches[0].clientX -100);
                                 oy = Math.round( e.touches[0].clientY -100);

					            var x = Math.round( e.touches[0].clientX -100)+"px";
								var y = Math.round(e.touches[0].clientY - 100)+"px";

								if(ox  > 0 && ox < 235){
									this.style.left = x  ;
 								   

								}if(oy  > 0 && oy < 180){
								    this.style.top =  y  ;//100 é a distancoa do topo
								}
								infos.innerHTML = "x:"+x+" "+y+" ";


				});


			 /*
			 var touchElement = document.getElementById('select-area-image');
             var outputElement = document.getElementById('output');
             
			 function mousedown(){

			 move.addEventListener("mousemove", mousemove);
			 move.addEventListener("mouseup", mouseup);

			  function mousemove(e){
						        var x = e.clientX-100+"px";
								var y = e.clientY-100+"px";
								this.style.left = x ;
								this.style.top = y ;

                                
								let infos = document.getElementById("infos");
								    infos.innerHTML = "x:"+e.clientX+" , y:"+e.clientY+"";

					}


					function mouseup(){
					   move.removeEventListener("mousemove", mousemove);
					}
                
				
			  }
			   */
			  
				
                    
					
               
				  
			 
              /*
			 move.addEventListener("mouseup", function(){
                move.removeEventListener("mousemove", mousemove);
					
                });*/
                
				let imgsrc = document.getElementById("imagefile").value;
            
				let croppar = document.getElementById("croppar");
				croppar.addEventListener("click", function(e){
					e.preventDefault();
                    //alert("Licou");
					let url = 'requisicoesajax.php?page=editimagecropper&src='+imgsrc+'&left='+mLeft+'&top='+mTop+'';
						 let xhr = new XMLHttpRequest();
						 xhr.open("GET", url, true);
						 xhr.onreadystatechange = function() {
							if (xhr.readyState == 4) {
								if (xhr.status = 200)
									//console.log(xhr.responseText);
									info.innerHTML = "->>"+xhr.responseText; //tras os resultados
									//setando o novo icone de like vermelho like
									
								}
							}
							xhr.send();

				});



		   </script>

		 <?php
		

	

}



function notification(){
	
	    $mysqli = conectar();
	if (!isset($_SESSION))//necessário inicializar sessão sempre que uma página nova é criada
		session_start(); 

		$sql = "SELECT * FROM notifications, user 
		        WHERE   user_id = notifications_user_id
				AND notifications_user_id = ".$_SESSION['user_id']."
				ORDER BY notifications_id DESC
				LIMIT 30 ";
	
				  
			$query = $mysqli->query($sql);
			$numRows =  $query->num_rows;//número de linhas
			

             ?>
			  <div class="box-geral-notifications">
				<div class="title-notifications">Últimas Notificações</div>
			 <?php
					while (    $dados = $query->fetch_assoc()  )
					{
						

						$sql1 = "SELECT * FROM  user 
						WHERE   user_id = ".$dados["notification_sender_id"]."";
			
						
						$query1 = $mysqli->query($sql1);
						//$numRows =  $query1->num_rows;//número de linhas
						$dados1 = $query1->fetch_assoc();

						?>
						<div class="notification-lines" id="notificationlines-<?php print $dados["notifications_id"];?>" >
								<div class=notifications-right-itens>
								  
								  <div class="box-round-img-user"
								      style="background-image: url('../images/users/pequena_<?php print $dados1["user_photo_perfil"] ;?>');" >	
								      <div class="layer-roud-white-img-user-icon"></div>
					              </div> 

									<b><br><?php print $dados1["user_name"]; ?></b>&nbsp 
									<?php print $dados["notifications_description"]; ?>
									: <?php print $dados["notifications_text"]; ?><br>
									<?php 
									   print separarData($dados["notifications_date"]). " 
									   <br>as ".separarHora($dados["notifications_date"]);  
									?>
					            </div>
								<div>
									



				                <div class="container-message-rigth-actions" id="mgsid-<?php print $dados["notifications_id"]; ?>" >
									<img src="../images/layout/svg/more-finfo-icon-01.svg" width="25" >
									
									<div class="box-messasge-options-expand" id="messasgeOptionsExpand-<?php print $dados["notifications_id"]; ?>">
										<img src="../images/layout/svg/remove-01.svg" width="25" >
									</div>
								</div>


							</div>
					    </div>

						<?php
						

					}//fecha while fetch_assoc()


                    ?>

					<script>
					/* PERCORRENDO AS NOTIFICACOES E REMOVENDO*/
					 //RASTREANDO BUTÃO DE REMOVER NOTIFICACOES PARA REMOVE-LOS
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
								  
								  //escondendo todos os elemento, caso tenha algum abert(visivel)
								  let getMessageOptionsExpand = document.querySelectorAll('.box-messasge-options-expand');
									  
								   
			  
								  if(style.getPropertyValue('visibility') === "visible"){//caso esteja visivel, fecha
									  messasgeOptionsExpand.style.visibility = "hidden";
								  }else{
			  
									  for(let i=0; i< getMessageOptionsExpand.length; i++ ){ 
										  getMessageOptionsExpand[i].style.visibility = "hidden";
									  }
									  messasgeOptionsExpand.style.visibility = "visible";
								  }
								  
								   
			  
								  //evento no icone da lixeira
								  messasgeOptionsExpand.addEventListener("click", function(e){
									  
											let getBoxMsg =  document.getElementById("notificationlines-"+messageId[1].trim());
											  getBoxMsg.innerHTML = "";
											  messasgeOptionsExpand.style.visibility = "hidden";//esconse o box options
											  //gravando os comentarios
											  
											  let url = 'requisicoesajax.php?page=deletenotification&notificationid='+messageId[1].trim();
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

                  //ATUALIZANDO O STATUS DAS NOTIFICAÇÕES PARA VISTO
				  $mysqli = conectar();//inicializa conexao
				if (!isset($_SESSION))//necessário inicializar sessão sempre que uma página nova é criada
					session_start();
					   $sql = "UPDATE  notifications SET notifications_view = 'yes'
					                                 WHERE notifications_user_id = ".$_SESSION['user_id'];
				
						$query = $mysqli->query($sql);
						$numRows =  $query->num_rows;//número de linhas
						
						





				?>
				</div><!-- fecha div box-geral-notifications-->
				<?php

}


function verificarNotifications($user_id){
	
	$mysqli = conectar();//inicializa conexao
	if (!isset($_SESSION))//necessário inicializar sessão sempre que uma página nova é criada
      	session_start();
	$sql = "SELECT * FROM notifications 
		             WHERE   notifications_user_id = ".$user_id."
					 AND notifications_view = 'no' ";
	
				  
			$query = $mysqli->query($sql);
			$numRows =  $query->num_rows;//número de linhas
			$dados = $query->fetch_assoc();
			return $numRows;

            
}


function topMenu(){
	?>
	<div class="box-top-menu">


	            <div class="left-top-menu-itens">
						<?php
						$mysqli = conectar();
						
						
							$sql = "SELECT * FROM user 
							WHERE user_id = ".$_SESSION['user_id']." ";
						
										
						$query = $mysqli->query($sql);
						$numRows =  $query->num_rows;//número de linhas
						
						while (    $dados = $query->fetch_assoc()  )
						{
						?>
								<a href="main.php?page=userLogin">
									
								<?php
									if(file_exists("../images/users/".$dados["user_photo_perfil"])){
									?>
										<div class="user-image-profile">
											
											<div class='container-img-user' 
											     style="background-image: url('../images/users/media_<?php print $dados["user_photo_perfil"];?>');"  >
											</div><!--fim div box-iten-post -->


										</div>
									
									<?php
									}else{
										?>
									<div class="user-image-profile">
										<img src="../images/users/305639912.png" class="user-image-profile-top"> 
									</div>
									<?php

									}//fecha if file_exists
									?>
								</a>
							

							<a href="main.php?page=feeds">	
							<div class="top-menu-itens"><img src="../images/layout/logo-meet-icon-01.jpg"></div> 
							</a>   

                            <div class="top-info-updateFeeds" id="top-info-updateFeeds">
                               [ update feeds ]
							</div><!--updateFeeds -->

                </div><!--fecha left-top-menu-itens -->



			<?php
			   }//fecha while
			?>
		   
				<div class="rigth-top-menu-itens"> 
							<a href="main.php?page=notification">
								<div class="top-menu-itens">
									
									<?php 
									$numNotifications =  verificarNotifications( trim($_SESSION['user_id']) );
									if($numNotifications > 0){
										
										?>
											<img src="../images/layout/svg/notifications-actived-icon.svg" width="25">
											<?php
											print $numNotifications; 
									}else{
										?>
											<img src="../images/layout/svg/notification-icon-01.svg" width="25">
										<?php
									}      
									?>
								</div>	
							</a>
						
						
					
					
						<a href="main.php?page=settings">
						   <div class="top-menu-itens"><img src="../images/layout/svg/settings-icon-01.svg" width="25"></div>
						</a>
						<a href="main.php?page=logoff">
						   <div class="top-menu-itens"><img src="../images/layout/svg/logoff-icon-01.svg" width="25"> </div>
						</a>
			    </div><!--fecha div rigth-top-menu-itens -->
	</div><!--fecha div box-top-menu -->
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