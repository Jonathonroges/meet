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
                                     message_temp_id,	
                                     message_text,
                                     message_date,
                                     message_user_create_post) 
                              values( ".$_SESSION['user_id'].",
                                      ".$_GET["postid"].",
                                      '".$_GET["messagetempid"]."',
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
        //GERA UM NUMERO TEMPORARIO, POIS QUANDO ADICIONAMOS DINAMICAMENTE, BASTA PEGAR ESSE NUMERO QUE FOI GERADO AINDA NO BROSER E REMOVER ATRASVEZ DE REFERENCIA
        //AO GERAR UMA MENSAGEM COM O DOM, GERAMOS ESSE NÚMERO, QUE PODE SER REMOVIDA EM TEMPO REAL, E NO BANCO DE DADOS
        
        print "--->".trim($_GET["messagetempid"])."---";
        
        $sql = "DELETE FROM post_message WHERE message_temp_id = '".trim($_GET["messagetempid"])."' ";
        $query = $mysqli->query($sql);

    
    }if($_GET["page"] =="deletenotification"){
        
        //print "->".$_GET["messageid"];
        $sql = "DELETE FROM notifications WHERE notifications_id = ".$_GET["notificationid"]."";
        $query = $mysqli->query($sql);

    
    }if($_GET["page"] =="searcuser"){
        
        //print "->data".$_GET["data"];
        
        //selecionando usuario local
        $sql1 = "SELECT * FROM user WHERE 	user_id = ".$_SESSION['user_id']." ";
        $query1 = $mysqli->query($sql1);
        $numRows =  $query1->num_rows;//número de linhas
        $dados1 = $query1->fetch_assoc() ;
        
        $userLatitude  = trim((float)$dados1["user_latitude"]);
        $userLongitude = trim((float)$dados1["user_longitude"]);


        $sql = "SELECT * FROM user 
	                     WHERE 	user_tagname LIKE '%".strtolower( trim( $_GET["data"] )  )."%' 
                         LIMIT 20 ";
        $query = $mysqli->query($sql);
        $numRows =  $query->num_rows;//número de linhas
        
        while (    $dados = $query->fetch_assoc()  ) {
        
                  //print "nome: ".$dados["user_name"]."<br>";
            ?>
                <a href="main.php?page=userLogin&userid=<?php print $dados["user_id"]; ?>">
                        <div class="box-resul-searc-list">
                        <?php
                        if( file_exists("../images/users/pequena_".$dados["user_photo_perfil"]) ){
                        ?>  
                            <img src="../images/users/pequena_<?php print $dados["user_photo_perfil"] ;?>"> 
                            <?php 
                            }else{
                     print "<img src='../images/users/avatar-003.png' width='50'> "; 
                            } ?>   
                        
                        
                        
                        
                        <span class="searc-title-user-name">
                            <?php 
                                print $dados["user_tagname"]."
                                      
                                ";
                               $lat1 = 0.0;
                               $lon1 = 0.0;
                               $lat2 = 0.0;
                               $lon2 = 0.0;
                               $lon = 0.0;

                                $lat1 = $userLatitude;
                                $lon1 = $userLongitude;
                                $lat2 = $dados["user_latitude"];
                                $lon2 = $dados["user_longitude"];
                                
                                
                               
                               
                               /*
                                print "<br>->".$lat1."<-<br>
                                       ->".$lon1."<-<br>
                                       ->".$lat2."<-<br>
                                       ->".$lon2."<-<br>";*/
                                 
                                       $lat1 = deg2rad($lat1);
                                       $lat2 = deg2rad($lat2);
                                       $lon1 = deg2rad($lon1);
                                       $lon2 = deg2rad($lon2);
                               
                                       $dist = (6371 * acos(cos($lat1) * cos($lat2) * cos($lon2 - $lon1) + sin($lat1) * sin($lat2)));
                                       print "
                                        <br><b>Está a ".number_format($dist, 1, '.', '')."Km</b>";//quilometros
            
                                 

                            ?>
                            </span>
                          </div>
                        </a>



            <?php
        }


    
    
    
   


    }
    
    
    
    
    
    if($_GET["page"] =="validausertagname"){
    
        $sql = "SELECT * FROM user WHERE user_tagname = '".trim($_GET["tagname"])."' ";
            $query = $mysqli->query($sql);
            $numRows =  $query->num_rows;//número de linhas
            $dados = $query->fetch_assoc();
            if($numRows >= 1){
              print "1";
                     
            }else{

               print "0";
            }

            
    }if($_GET["page"] =="setcoordenadas"){
        
        $mysqli = conectar();
        if (!isset($_SESSION))//necessário inicializar sessão sempre que uma página nova é criada
            session_start(); 
            $sql = "UPDATE  user SET    user_latitude = '".$_GET['latitude']."',
                                        user_longitude = '".$_GET['longitude']."'
                                        WHERE user_id = ".$_SESSION['user_id']."";
            $query = $mysqli->query($sql);
    
    
    }if($_GET["page"] =="checarnewpost"){
    
            
             
             //buscando id do ultimo post
             
            $sql = "SELECT * FROM user_new_post ORDER BY user_new_post_id DESC ";
            $query = $mysqli->query($sql);
            $numRows =  $query->num_rows;//número de linhas
            $dados = $query->fetch_assoc();

            //print "SESSAO->>>>>".$_SESSION['user_new_post_id']."dados: ".$dados["user_new_post_id"];

            if( trim($dados["user_new_post_id"]) > trim($_SESSION['user_new_post_id'])){
               
                feeds();//e depos chama feeds
                
                $_SESSION['user_new_post_id'] = $dados["user_new_post_id"];//Atribuo o novo valor a SESSAO
            
            }else{
                print "no";
            }  

           




    
    }if($_GET["page"] =="editimagecropper"){
        
       // The file
           print "scr = ".$_GET["src"]."<br>
                  left = ".$_GET["left"]."<br>
                  top = ".$_GET["top"]."  
                  fatorZoom = ".$_GET["zoom"]."    
           ";
            
            $filename = "../images/users/media_".$_GET["src"];
            $percent = 0.5;
            

            // Content type
            //header('Content-Type: image/jpeg');
            
            // Get new dimensions
            $lista = array();
            $lista = getimagesize($filename);
            
            $larguraOriginal = $lista[0];//obtemos a largura
            $alturaOriginal = $lista[1];//obtemos a largura - [2]ipo(GIF,PNG,JPEG,SWF,PSD,BPM) - [3] é uma string com o height="yyy" width="xxx" correto que pode ser usado diretamente numa tag IMG.

           // print "->W :".$larguraOriginal." -> ".$alturaOriginal." <br>";

            $newwidth = 600;//crio uma imagem quadrada
            $newheight = 600;//crio uma imagem quadrada


           //MEUS CALCULOS
           $y_origem =  (int)$_GET["top"];
           $x_origem =  (int)$_GET["left"];
           $zoom_origem =  (int)$_GET["zoom"];
           $imgZoomFactor =  (int)$_GET["zoom"];
           $neWidth = (int)$_GET["newidth"];
           $newHeight = (int)$_GET["newheight"];

           
          if($imgZoomFactor <=0)
             $imgZoomFactor = 0;//não deixa o zoom ser negativo e a imagem escapar da tela
          
          
             // $x_result =  300;
           //$y_result =  ($larguraOriginal  * $alturaOriginal)/300;
          



            // Resample
            $image_p = imagecreatetruecolor(200  , 200);
            
            $image = imagecreatefromjpeg($filename);
           
         


            $imageName = "../images/users/croppers/".time().'.jpg';  //diretorio a ser gravado     
           
            imagecopyresampled($image_p,//imagem criada para adicionar a imagem destino
                            $image,//imagem origem a que é carregada
                            0,//posição x da imagem destino 
                            0,//distancia y do topo a ser desenhada a imagem origem em relação a imagem destino criada 
                            $x_origem,//afasta a imagem destino em direcao a esquerda da imagem criada para acopla-la
                            $y_origem,//afasta a imagem destino em direcao ao topo da imagem criada para acopla-la
                            $neWidth,//nova largura tamanho da imagem criada - (achatamento)destino, createfrom dentro da imagecreatetruecolor
                            $neWidth,//nova altura tamanho da imagem criada - destino, createfrom dentro da imagecreatetruecolor
                            300  ,//zoom a partis da orimgem(x=0) widht, quanto menor, maior o zoom, considerando sempre as dimensoes originais
                            300 
                             );//zoom a partir da origem (y=0) heiht, quanto menor, maior o zoom,considerando sempre as dimensoes originais

            // Output
            

            print "X:".$x_origem.", Y:".$y_origem.", zoom:".$zoom_origem.", src_w:".$neWidth.", src_h:".$newHeight;
            imagejpeg($image_p, $imageName, 90);
           

    }
    
    
?>