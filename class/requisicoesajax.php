<?php
    include "function.php";//Para recortar a imagem
    $mysqli = conectar();
    if(!isset($_SESSION))//necessário inicializar sessão sempre que uma página nova é criada
       session_start();

    if($_GET["page"] =="setlike"){
                                    
       // print $_GET["postid"];
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

                

                    //Inserindo notificação
                        $sql = "INSERT INTO notifications (
                            notifications_user_id,
                            notification_sender_id,
                            notifications_type,	
                            notifications_description,
                            notifications_view,
                            notifications_deleteded,
                            notifications_date) 
                    values( ".trim($_GET["userdestinacao"]).",
                            ".$_SESSION['user_id'].",
                            'like',
                            'Curtiu seu post',
                            'no',
                            'no',
                            NOW() )";
                           $query = $mysqli->query($sql);



        }

        
    }if($_GET["page"] =="setmessage"){
       
        print "".$_GET["useid"]."-".$_GET["msg"];
        $sql = "INSERT INTO post_message (message_user_id,
                                     message_post_id,	
                                     message_text,
                                     message_date,
                                     message_user_create_post) 
                              values( ".$_SESSION['user_id'].",
                                      ".$_GET["postid"].",
                                      '".$_GET["msg"]."',
                                      NOW(),
                                      ".$_GET["usercreatepost"].")";
        $query = $mysqli->query($sql);

        //ADICIONANDO TAMBEM NOTIFICAÇÃO QUE EXISTE UMA NOVA MENSAGEM
        
                        $sql = "INSERT INTO notifications (
                            notifications_user_id,
                            notification_sender_id,
                            notifications_type,	
                            notifications_description,
                            notifications_text,
                            notifications_view,
                            notifications_deleteded,
                            notifications_date) 
                    values( ".trim($_GET["userdestinacao"]).",
                            ".$_SESSION['user_id'].",
                            'message',
                            'Envio uma menssagem',
                            '".$_GET["msg"]."',
                            'no',
                            'no',
                            NOW() )";
        $query = $mysqli->query($sql);


    }if($_GET["page"] =="deletemessage"){
        
        //print "->".$_GET["messageid"];
        $sql = "DELETE FROM post_message WHERE message_id = ".$_GET["messageid"]."";
        $query = $mysqli->query($sql);

    
    }if($_GET["page"] =="searcuser"){
        
        //print "->data".$_GET["data"];
        $sql = "SELECT * FROM user 
	                     WHERE user_name LIKE '%".strtolower( trim( $_GET["data"] )  )."%' 
                         LIMIT 20 ";
        $query = $mysqli->query($sql);
        $numRows =  $query->num_rows;//número de linhas
        
        while (    $dados = $query->fetch_assoc()  ) {
        
                  //print "nome: ".$dados["user_name"]."<br>";
            ?>
                <a href="main.php?page=userLogin&userid=<?php print $dados["user_id"]; ?>">
                        <div class="box-resul-searc-list">
                            <img src="../images/users/media_<?php print $dados["user_photo_perfil"] ;?>" class="user-image-profile-feed">
                            <span class="searc-title-user-name">
                            <?php print $dados["user_name"] ;?>
                            </span>
                        </div>
                </a>    
            <?php

        }


    }if($_GET["page"] =="editimagecropper"){
        
       // The file
           print "scr = ".$_GET["src"]."<br>
                  left = ".$_GET["left"]."<br>
                  top = ".$_GET["top"]."     
           ";
            
            $filename = $_GET["src"];
            $percent = 0.5;
            

            // Content type
            //header('Content-Type: image/jpeg');
            
            // Get new dimensions
            $lista = array();
            $lista = getimagesize($filename);
            
            $larguraOriginal = $lista[0];//obtemos a largura
            $alturaOriginal = $lista[1];//obtemos a largura - [2]ipo(GIF,PNG,JPEG,SWF,PSD,BPM) - [3] é uma string com o height="yyy" width="xxx" correto que pode ser usado diretamente numa tag IMG.

           // print "->W :".$larguraOriginal." -> ".$alturaOriginal." <br>";

            $newwidth = 300;//crio uma imagem quadrada
            $newheight = 300;//crio uma imagem quadrada

            // Resample
            $image_p = imagecreatetruecolor($newwidth, $newheight);
            
            $image = imagecreatefromjpeg($filename);
            $imageName = "../images/users/croppers/".time().'.jpg';  //diretorio a ser gravado     
            imagecopyresampled($image_p,//imagem criada para adicionar a imagem destino
                            $image,//imagem origem a que é carregada
                            0,//posição x da imagem destino 
                            0,//distancia y do topo a ser desenhada a imagem origem em relação a imagem destino criada 
                            0,//afasta a imagem destino em direcao a esquerda da imagem criada para acopla-la
                            0,//afasta a imagem destino em direcao ao topo da imagem criada para acopla-la
                            300,//nova largura tamanho da imagem criada - (achatamento)destino, createfrom dentro da imagecreatetruecolor
                            400,//nova altura tamanho da imagem criada - destino, createfrom dentro da imagecreatetruecolor
                            200,//zoom a partis da orimgem(x=0) widht, quanto menor, maior o zoom, considerando sempre as dimensoes originais
                            300);//zoom a partir da origem (y=0) heiht, quanto menor, maior o zoom,considerando sempre as dimensoes originais

            // Output
            
            imagejpeg($image_p, $imageName, 90);
           

    }
    
    
?>