	$(document).ready(function() {
		$("#contactForm").submit(function(){
			$.notify({
				// options
				message: 'Processando sua mensagem...',
			},{
				// settings
				element: 'body',
				position: null,
				type: "warning",
				allow_dismiss: true,
				placement: {
					from: "top",
					align: "left"
				},
				offset: 20,
				spacing: 10,
				z_index: 1031,
				delay: 5000,
				timer: 1000,
				animate: {
					enter: 'animated fadeInDown',
					exit: 'animated fadeOutUp'
				}
			});			
			let dados = $( this ).serialize();
			
			$.ajax({
				type: "POST",
				url: "_PHPMailer/index.php",
				data: dados + "&sentMessage=1",
				success: function( response )
				{
					$.notify({
						// options
						title: 'E-mail enviado com sucesso!',
						message: 'Obrigado, logo retornaremos o seu contato.',
					},{
						// settings
						element: 'body',
						position: null,
						type: "success",
						allow_dismiss: true,
						placement: {
							from: "top",
							align: "left"
						},
						offset: 20,
						spacing: 10,
						z_index: 1031,
						delay: 5000,
						timer: 1000,
						animate: {
							enter: 'animated fadeInDown',
							exit: 'animated fadeOutUp'
						}
					});
				}
			});
			
			return false;
		});
	});