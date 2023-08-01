<?php


  //session_start();//inicializo a sessao
  include "function.php";//Para recortar a imagem
    $dir = "../images/users/";//estou no diretório externo (index.php), portanto, devo sair (../) e entrar no diretório
	 /* 
	  if(!file_exists($dir)){
		   umask(0);
			mkdir($dir,  0777, true);
		}
	  
  } */

/*
if(!file_exists()){
	mkdir("/path/to/my/dir", 0700);
}*/

$uploaddir = $dir; 
$file = $uploaddir.basename($_FILES['uploadfile']['name']); 
 
if (move_uploaded_file($_FILES['uploadfile']['tmp_name'], $file)) { 
     redimensiona($file,$dir,"media_",$maxlargura=300,$maxaltura=300,$qualidade=100);
	 redimensiona($file,$dir,"pequena_",$maxlargura=50,$maxaltura=80,$qualidade=100);
     //removendo imagem original
	// unlink($file); 
return "success"; 

  
} else {
	return  "error";
	
}
?>