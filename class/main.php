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
			 
			    if(isset($_POST["opc"])){
					

							if($_POST["opc"] == "gravar"){
								
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
										</div>	 
											
											";
							}
							if($_POST["opc"] == "logar"){
							
								areaUser();
							}
					

				}else{
					
					//CadUser();//chama user();
                    windowLoginUser();

				}
			    
			 ?>
		 </div>
	 </body>
 </html>

<?php


?>