<?php
    include "function.php";//Para recortar a imagem
    $mysqli = conectar();
    if(!isset($_SESSION))//necessário inicializar sessão sempre que uma página nova é criada
       session_start();

    if($_GET["page"] =="setlike"){
                                    
        print $_GET["postid"];
        //inserindo like
        //verificando se já possui o like do usuario
        $sql = "SELECT  * FROM likes
	                          WHERE like_user_id = ".trim($_SESSION['user_id'])."
                              AND 
                              like_post_id = ".trim($_GET["postid"])." ";
	
		$query = $mysqli->query($sql);
        $numRows =  $query->num_rows;//número de linhas
        
        if($numRows < 1){//se não houver like ainda do usuário, gravamos o like
            $sql = "INSERT INTO likes (like_user_id, like_post_id) 
                           values( ".$_SESSION['user_id'].", ".trim($_GET["postid"]).")";
            $query = $mysqli->query($sql);
           // print "inseriu";
        }

        
    }if($_GET["page"] =="setmessage"){
       
        print "".$_GET["useid"]."-".$_GET["msg"];
        $sql = "INSERT INTO post_message (message_user_id,
                                     message_post_id,	
                                     message_text,
                                     message_date) 
                              values( ".$_SESSION['user_id'].",
                                      ".$_GET["postid"].",
                                      '".$_GET["msg"]."',
                                      NOW())";
        $query = $mysqli->query($sql);

    }
?>