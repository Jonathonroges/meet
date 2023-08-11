<?php
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
			<link rel="stylesheet"
				href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css"
				/>
				<link
				rel="stylesheet"
				href="https://cdnjs.cloudflare.com/ajax/libs/cropper/2.3.4/cropper.min.css"/>

		  <title>meet</title>
	 </head>
	 <body>
		 <div class="main">
			 <?php
			 
			    if(isset($_GET["page"])){
					
					if(!isset($_SESSION))//necessário inicializar sessão sempre que uma página nova é criada
					session_start(); 
							if($_GET["page"] == "cadUser"){
								
									$sql = "INSERT INTO user (       
									user_name    ,
									user_password,
									user_birthday,
									user_sexo    ,
									user_phone   ,
									user_email   ,
									user_bio     ,
									user_photo_perfil,
									user_photo_perfil_blob
									)
									values(
									'".$_POST['userName']."'      ,
									'".$_POST['userPassword']."'  ,
									'".setFormatAmericanDate(   trim($_POST['usereBirthday'] )  )."' ,
									'".$_POST['userSexo']."'      ,
									'".$_POST['userPhone']."'     ,
									'".$_POST['userEmail']."'     ,
									'".$_POST['userBio']."'       ,
									'".$_POST['arquivo']."'       ,      
									'".$_POST['blob-image']."'
									)"; 
									

									$query = $mysqli->query($sql);
									print "<div class='box-info-center'>
												<span> 
												Dados Gravados com sucesso!
												</span>
										</div>";


							}if($_GET["page"] == "updateuser"){
								
								if (!isset($_SESSION))//necessário inicializar sessão sempre que uma página nova é criada
	                            session_start(); 
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
								print "<div class='box-info-center'>
								          <p><p>
								          <span> 
								            Dados alterados com sucesso!
								          </span>
						              </div>";
							
							}if($_GET["page"] == "setnewpostuser"){
								
								        $mysqli = conectar();
										if(!isset($_SESSION))//necessário inicializar sessão sempre que uma página nova é criada
										session_start(); 
										
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

							}if($_GET["page"] == "userLogin"){
								
								$mysqli = conectar();
								$userId = NULL;

								if(!isset($_SESSION)){//necessário inicializar sessão sempre que uma página nova é criada
								
								   session_start(); 
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
								
								if(!isset($_SESSION))//necessário inicializar sessão sempre que uma página nova é criada
								session_start(); 
								openUserPost( $_GET["user_id"], $_GET["post_id"] );//Metodo dentro de function.php
							
							}if($_GET["page"] =="feeds"){
								
								feeds();

							}if($_GET["page"] =="search"){
							  
								if(!isset($_SESSION))//necessário inicializar sessão sempre que uma página nova é criada
								 session_start(); 
								 
								 searcUse();
							
							}if($_GET["page"] =="configuration"){
								
								if(!isset($_SESSION))//necessário inicializar sessão sempre que uma página nova é criada
								 session_start(); 
								print "<p>configuration";

							}if($_GET["page"] =="settings"){
								
								if(!isset($_SESSION))//necessário inicializar sessão sempre que uma página nova é criada
								 session_start(); 
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
								if(!isset($_SESSION))//necessário inicializar sessão sempre que uma página nova é criada
								 session_start(); 

								 $sql = "DELETE  FROM user_new_post   
								                 WHERE user_new_post_id = ".$_GET["post_id"];
			                     $query = $mysqli->query($sql);
								 print "<p><p>Postagem Removida com sucesso!";

								
							}if($_GET["page"] =="setlike"){
								
								print $_GET["postid"];
								
							}
							
							
							


							
							

							
							if (isset($_SESSION)){ //necessário inicializar sessão sempre que uma página nova é criada
							
							topMenu();//desenha o topo    
							footMenu();//Desenha o footMenu	
						  }
				}else{
					
                   //CadUser();//chama user();
                    windowLoginUser();

				}
			    

                
			 ?>
		 </div>
	 </body>
 </html>

