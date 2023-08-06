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

		  <title>meet</title>
	 </head>
	 <body>
		 <div class="main">
			 <?php
			 
			    if(isset($_GET["page"])){
					
                            
							if($_GET["page"] == "cadUser"){
								
									$sql = "INSERT INTO user (       
									user_name    ,
									user_password,
									user_birthday,
									user_sexo    ,
									user_phone   ,
									user_email   ,
									user_bio     ,
									user_photo_perfil)
									values(
									'".$_POST['userName']."'      ,
									'".$_POST['userPassword']."'  ,
									'".setFormatAmericanDate(   trim($_POST['usereBirthday'] )  )."' ,
									'".$_POST['userSexo']."'      ,
									'".$_POST['userPhone']."'     ,
									'".$_POST['userEmail']."'     ,
									'".$_POST['userBio']."'       ,
									'".$_POST['arquivo']."')"; 
									

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
								          <span> 
								            Dados alterados com sucesso!
								          </span>
						              </div>";
							
							}if($_GET["page"] == "setnewpostuser"){
								
										if(!isset($_SESSION))//necessário inicializar sessão sempre que uma página nova é criada
										session_start(); 
										
										$sql = "INSERT INTO user_new_post (       
											user_new_post_user_id    ,
											user_new_post_image,
											user_new_post_description,
											user_new_post_date    ,
											user_new_post_arquivar   
											)
											values(
											".$_SESSION['user_id'].",
											'".$_POST['arquivo']."'  ,
											'".$_POST['new-post-text']."',
											now(),
											'no' )"; 
										
										$query = $mysqli->query($sql);
										
										
										print "<div class='box-info-center'>
												<span> 
													Publicaçâo efetuada!
												</span>
											</div>";

							}if($_GET["page"] == "userLogin"){
								
								areaUser();
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
								openUserPost( $_SESSION['user_id'], $_GET["post_id"] );//Metodo dentro de function.php
							
							}if($_GET["page"] =="feeds"){
								
								feeds();
							}if($_GET["page"] =="search"){
							  
								print "<p>Search";
							
							}if($_GET["page"] =="configuration"){
								
								print "<p>configuration";

							}if($_GET["page"] =="settings"){
								
								print "<p>settings";
							}
							
							

							
							
					

				}else{
					
                   //CadUser();//chama user();
                    windowLoginUser();

				}
			    
                topMenu();//desenha o topo    
				footMenu();//Desenha o footMenu	
			 ?>
		 </div>
	 </body>
 </html>

<?php


?>