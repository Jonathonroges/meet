// JavaScript Document

$( document ).ready(function() {

	uploadsFile();
});


function uploadsFile(){
	
	
	    var btnUpload = $('#upload');
		var status = $('#status');
		var count = 0;
		
		
		
		
		
		new AjaxUpload(btnUpload, {
			// Arquivo que fará o upload, lembrando que preciso pular um diretório
			action: '../class/upload-file.php',
			//Nome da caixa de entrada do arquivo
			name: 'uploadfile',
			onSubmit: function(file, ext){//nome e extenção
				
				 if (! (ext && /^(jpg|png|jpeg|gif|pdf|doc)$/.test(ext))){ 
                    // verificar a extensão de arquivo válido
					status.text('Somente JPG, PNG, GIF, PDF são permitidas');
					
					return false;//se a extenção for invalida
				}
				status.text('aguarde...');
				
			},
			onComplete: function(file, response){
				
			 
				
				//Limpamos o status
				status.text('');//Tira o valor enviando
				//Adicionar arquivo carregado na lista
				if(response =="success"){
					
					$(".files").html("<div class='post-box-arq'>"+
					"<br>"+
					"<img src='../images/users/"+file+"' id='img-arquivo'> <br>  "+
					
					"<input type='hidden' id='arquivo' name='arquivo' value='"+file+"'></div>  ").addClass('success');
					 //count++;//Incremento valor do contador para saber quantas imagens foram upadas
				} else{
					//alert(">>>>"+response+" <<<<<");
					$(".files").html("<div class='post-box-arq'>"+
					"<br>"+
					"<img src='../images/users/"+file+"' id='img-arquivo'> <br>"+
					"<input type='hidden' id='arquivo' name='arquivo' value='"+file+"'></div>  ").addClass('success');

					
					

				}


			
				 

			}
		});
		


	
}