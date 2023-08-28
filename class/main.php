<?php
if(!isset($_SESSION))//necessário inicializar sessão sempre que uma página nova é criada
session_start();

if(!isset($_SESSION['user_id']))
          $_SESSION['user_id'] = NULL; 

//session_start();//inicializo a sessao
  include "function.php";//Para recortar a imagem
  $mysqli = conectar();//Inicia uma conexão com o banco de dados
?>
 <!--Função principal-->
 <html>
	 <head>
		  <meta http-equiv="Content-Type" content="text/html;charset=utf-8">
		  <meta name="viewport" content="width=device-width, initial-scale=1.0">
		    <link href="../styles/style.css" rel="stylesheet">
		    <script type="text/javascript" src="../js/jquery-1.11.1.js"></script>
			<script type="text/javascript" src="../js/ajaxupload.3.5.js" ></script>
			<script type="text/javascript" src="../js/myScripts.js"></script>
			<script type="text/javascript" src="../js/cdn.es.gov.br_scripts_jquery_jquery-maskedinput_1.4.1_jquery.maskedinput-1.4.1.min.js"></script>
            
			<!-- -->
			

		  <title>meet</title>
	 </head>
	 <body>
	    <div class="box-main-center">	
		 <div class="main">
			
			 <?php
			
			    if(isset($_GET["page"])){//Pecisa estar logado para acessar as páginas
					
					

							if($_GET["page"] == "cadUser"){
								
									$sql = "INSERT INTO user (       
									user_name    ,
									user_tagname ,
									user_password,
									user_birthday,
									user_sexo    ,
									user_phone   ,
									user_email   ,
									user_bio     ,
									user_photo_perfil
									)
									values(
									'".$_POST['userName']."'      ,
									'".$_POST['tag-name']."'      ,
									'".$_POST['userPassword']."'  ,
									'".setFormatAmericanDate(   trim($_POST['usereBirthday'] )  )."' ,
									'".$_POST['userSexo']."'      ,
									'".$_POST['userPhone']."'     ,
									'".$_POST['userEmail']."'     ,
									'".$_POST['userBio']."'       ,
									'".$_POST['arquivo']."'             
									)"; 
									

									$query = $mysqli->query($sql);
									print " <div class='box-info-center'>
												<span> 
												Dados Gravados com sucesso!
												</span>
										    </div>";

							//redirecionando para a página de inicio do usuario
							
							$sql = "SELECT * FROM user 
							WHERE user_tagname = '".trim($_POST['tag-name'])."'  ";
							$query = $mysqli->query($sql);
							$numRows =  $query->num_rows;
							$dados = $query->fetch_assoc();

                            //abre a tela de Usuário

							$_SESSION['user_id'] = $dados["user_id"]; 
                            areaUser( $dados["user_id"] );
							



							}if($_GET["page"] == "updateuser"){
								
								
								$sql = "UPDATE  user SET user_photo_perfil = '".$_POST['arquivo']."',
								                         user_photo_perfil_blob = '".$_POST['blob-image']."',
								                         user_name = '".$_POST['userName']."',
                                                         user_password =  '".$_POST['userPassword']."',
														 user_birthday =  '".setFormatAmericanDate(   trim($_POST['usereBirthday'] )  )."',
														 user_sexo     =  '".$_POST['userSexo']."',
														 user_phone    =  '".$_POST['userPhone']."',
														 user_email    =  '".$_POST['userEmail']."',
														 user_bio      =  '".$_POST['userBio']."'
								                         WHERE user_id = ".$_SESSION['user_id']."";
								$query = $mysqli->query($sql);
								print "  <div class='box-info-center'>
								          <p><p>
								          <span> 
								            Dados alterados com sucesso!
								          </span>
						                </div>";
									  ?>
									<script>
										//redireciona a página (Refresh)
										window.location.href = "main.php?page=userLogin";
									</script>
									<?php


							
							}if($_GET["page"] == "setnewpostuser"){
								
								        $mysqli = conectar();
										
										
										$sql = "INSERT INTO user_new_post (       
											user_new_post_user_id    ,
											user_new_post_image,
											user_new_post_blob_image,
											user_new_post_description,
											user_new_post_date,
											user_new_post_arquivar   
											)
											values(
											".$_SESSION['user_id'].",
											'".$_POST['arquivo']."'  ,
											'".$_POST['blob-image']."'  ,
											'".$_POST['new-post-text']."',
											now(),
											'no' )"; 
										
										$query = $mysqli->query($sql);
										
										
										print "<div class='box-info-center'>
												   <p>
												    <p>
										            <span> 
													   Publicaçâo efetuada!
												    </span>
											     </div>";

											?>
											<script>
												//redireciona a página (Refresh)
												window.location.href = "main.php?page=userLogin";
											</script>
											<?php

							}if($_GET["page"] == "userLogin"){
								
								$mysqli = conectar();
								$userId = NULL;

								if(!isset($_SESSION)){//necessário inicializar sessão sempre que uma página nova é criada
								
								   //session_start(); 
								   $userId = NULL;//se não houver logado, usuario é NULL(Inexistente)
							   
								}else{
									
									$userId = $_SESSION['user_id'];    
								}
								 if(isset($_GET["userid"]))//está entrando como usuario buscando abrir um perfil de outra pessoa
                                   areaUser( $_GET["userid"] );
								 else
								  areaUser( $userId );
							}
							if($_GET["page"] == "alteruser"){
								
								alterUser();

							}if($_GET["page"] == "newcaduser"){
								
								formCadUser();
							}
							if($_GET["page"] == "newpost"){
								
								newPost();

							}if($_GET["page"] =="openuserpost"){
								
								
								
								openUserPost( $_GET["user_id"], $_GET["post_id"] );//Metodo dentro de function.php
							
							}if($_GET["page"] =="feeds"){
								
                                ?>
								 <div class="box-update-feeds" id="box-update-feeds"></div>

                                      <?php print feeds(); ?>

	                            <?php
								 
								

							}if($_GET["page"] =="search"){
							  
								
								 
								 searcUse();
							
							}if($_GET["page"] =="configuration"){
								
								
								print "<p>configuration";

							}if($_GET["page"] =="settings"){
								
								
								print "<p>settings";
							
							}if($_GET["page"] =="logoff"){
								
								//destruindo a SESSAO
								session_start();
								unset($_SESSION['user_id']);
								session_destroy();
								?>
								<script>
									window.location.href = "main.php";
								</script>
								<?php
							}if($_GET["page"] =="removepost"){
								
								$mysqli = conectar();
								

								 $sql = "DELETE  FROM user_new_post   
								                 WHERE user_new_post_id = ".$_GET["post_id"];
			                     $query = $mysqli->query($sql);
								 print "<p><p>Postagem Removida com sucesso!";

								
							}if($_GET["page"] =="setlike"){
								
								print $_GET["postid"];
								
							}
							if($_GET["page"] =="editImageCropper"){
								
								cropperImage();
								
							}if($_GET["page"] =="notification"){
								
								notification();
								
							}if($_GET["page"] =="aboutauthor"){
								
								aboutAuthor();
								
							}
							
							          if (isset($_SESSION) && isset($_SESSION['user_id']) ){ //necessário inicializar sessão sempre que uma página nova é criada
											
											topMenu();//desenha o topo    
											footMenu();//Desenha o footMenu	
										}
				}else{
					
                   //CadUser();//chama user();
                    windowLoginUser();

				}
			    

                
			 ?>
			
		 </div><!-- fecha div main -->
		</div><!-- fecha box-main-center--> 


          <script>



           
			
	   /*
	   for(let i=0; i< setMessage.length; i++ ){
					   
					   setMessage[i].addEventListener("click", function(e){
					   e.preventDefault();
					   alert("clicou");


					   });
		   }*/
			//Acões gerais
			//Lendo os feeds
           
			
            let boxUpdateFeeds = document.getElementById("box-update-feeds");
			let topInfoUpdateFeeds = document.getElementById("top-info-updateFeeds");

			setInterval(function () {
				    // alert("Foi");
                        let url = 'requisicoesajax.php?page=checarnewpost&usernewpostid='+<?php print $_SESSION['user_new_post_id'];?> ;
						let xhr = new XMLHttpRequest();
						xhr.open("GET", url, true);
						xhr.onreadystatechange = function() {
							if (xhr.readyState == 4) {
								if (xhr.status = 200)
									 console.log(xhr.responseText);
									 
									 if(xhr.responseText != "no"){//[no] não recarregue nada
									    //updateFeeds.innerHTML = xhr.responseText;//atualiza a tela de feeds se houver nova postagem
									    boxUpdateFeeds.innerHTML = xhr.responseText;
									
									
										//getMsgTex.value = "";//lempa o texto do input
									//setando o novo icone de like vermelho like
									 }else{
										topInfoUpdateFeeds.style.backgroundColor = "#FFFF00";
									 }
								}
							}
							xhr.send();


			}, 8000);
			

			
	

			

            


		  </script>



	 </body>
 </html>




