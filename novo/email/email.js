	$(document).ready(function() {
		$("#submit").click(function(){
			$.notify({
				// options
				message: 'Processando sua mensagem...',
			},{
				// settings
				element: 'body',
				position: null,
				type: "info",
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
			let dados = $("#contato-form").serialize();
			
			$.ajax({
				type: "POST",
				url: "./email/email.php",
				data: dados,
				success: function( response )
				{
					var retorno = response.split("#*#");
					if(retorno[0] == "1") {
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
					} else {
						$.notify({
							// options
							title: 'Erro. Mensagem não enviada.',
							message: retorno[1],
						},{
							// settings
							element: 'body',
							position: null,
							type: "danger",
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
				}
			});
			
			return false;
		});
	});