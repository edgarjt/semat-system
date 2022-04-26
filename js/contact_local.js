var id ;
var tabla ;
var id_tabla ;
var accion ;
var usuario;
var insertar;
var disiplina;
var actividad;
var referencia;
var fotografia;
var descripcion;
var utm_n;
var utm_e;
var porcentaje;
var id_actividad;
var actividad;
var id_concepto;

function clic(g){
	cadena = g.split("-");
	id=cadena[0];
	tabla=cadena[1];
	id_tabla=cadena[2];
	accion = cadena[3];
	usuario= cadena[4];
	insertar= cadena[5];
	disiplina =cadena[6];
	actividad = cadena[7];
    referencia= cadena[8];
    fotografia= cadena[9];
    descripcion =cadena[10];
    utm_n =cadena[11];
    utm_e =cadena[12];
    porcentaje= cadena[13];
    id_actividad=cadena[14];
    actividad2= cadena[15];
    id_concepto= cadena[16];
   
	
}

jQuery(function ($) {
	var contact = {
		message: null,

		init: function () {

		
			
			$('#contact-form input.contact, #contact-form a.contact').click(function (e) {
				e.preventDefault();

				$.get("comentario.php?id="+id+"&id_ducto="+tabla+'&accion='+accion+'&usuario='+usuario+'&insertar='+insertar+'&disiplina='+disiplina+'&actividades='+actividad+'&referencia='+referencia+'&fotografia='+fotografia+'&descripcion='+descripcion+'&utm_n='+utm_n+'&utm_e='+utm_e+'&porcentaje='+porcentaje+'&id_actividad='+id_actividad+'&actividad='+actividad2+'&id_concepto='+id_concepto, function(data){
					// create a modal dialog with the dat
					$(data).modal({
						closeHTML: "<a href='#' title='Close' class='modal-close'>x</a>",
						position: ["15%",],
						overlayId: 'contact-overlay',
						containerId: 'contact-container',
						onOpen: contact.open,
						onShow: contact.show,
						onClose: contact.close
					});
				});
						
			});

	
	
	},
		open: function (dialog) {
			// dynamically determine height
			var h = 430;
			if ($('#contact-subject').length) {
				h += 2;
			}
			if ($('#contact-cc').length) {
				h += 2;
			}

			var title = $('#contact-container .contact-title').html();
			$('#contact-container .contact-title').html('Cargando...');
			dialog.overlay.fadeIn(100, function () {
				dialog.container.fadeIn(100, function () {
					dialog.data.fadeIn(100, function () {
						$('#contact-container .contact-content').animate({
							height: h
						}, function () {
							$('#contact-container .contact-title').html(title);
							$('#contact-container form').fadeIn(100, function () {
								$('#contact-message').focus();

							});
						});
					});
				});
			});
		},
		show: function (dialog) {
			$('#contact-container .contact-send').click(function (e) {
				e.preventDefault();
				// validate form
				if (contact.validate()) {
					var msg = $('#contact-container .contact-message');
					msg.fadeOut(function () {
						msg.removeClass('contact-error').empty();
					});
					$('#contact-container .contact-title').html('Guardando...');
					$('#contact-container form').fadeOut(100);
					$('#contact-container .contact-content').animate({
						height: '80px'
					}, function () {
						$('#contact-container .contact-loading').fadeIn(100, function () {
							$.ajax({
								url: 'comentario.php',
								data: $('#contact-container form').serialize() + '&action=send',
								type: 'post',
								cache: false,
								dataType: 'html',
								success: function (data) {
									$('#contact-container .contact-loading').fadeOut(100, function () {
										$('#contact-container .contact-title').html('Comentario registrado con éxito');
										msg.html(data).fadeIn(100);
										





										$('#contact-container .contact-message').fadeOut();
										$('#contact-container .contact-title').html('Comentario registrado con éxito...');
										$('#contact-container form').fadeOut(100);
										$('#contact-container .contact-content').animate({
											height: 10
										}, function () {
											dialog.data.fadeOut(100, function () {
												dialog.container.fadeOut(100, function () {
													dialog.overlay.fadeOut(100, function () {
														$.modal.close();
													});
												});
											});
										});


									});
								},
								error: contact.error
							});
						});
					});
				}
				else {
					if ($('#contact-container .contact-message:visible').length > 0) {
						var msg = $('#contact-container .contact-message div');
						msg.fadeOut(100, function () {
							msg.empty();
							contact.showError();
							msg.fadeIn(100);
						});
					}
					else {
						$('#contact-container .contact-message').animate({
							height: '30px'
						}, contact.showError);
					}
					
				}
			});
		},
		close: function (dialog) {
			$('#contact-container .contact-message').fadeOut();
			$('#contact-container .contact-title').html('Procesando...');
			$('#contact-container form').fadeOut(100);
			$('#contact-container .contact-content').animate({
				height: 40
			}, function () {
				dialog.data.fadeOut(100, function () {
					dialog.container.fadeOut(100, function () {
						dialog.overlay.fadeOut(100, function () {
							$.modal.close();
						});
					});
				});
			});
		},
		error: function (xhr) {
			alert(xhr.statusText);
		},
		validate: function () {
			contact.message = '';
			if (!$('#contact-container #contact-message').val()) {
				contact.message += 'Tu comentario es requerido. ';
			}

			if (contact.message.length > 0) {
				return false;
			}
			else {
				return true;
			}
		},
		showError: function () {
			$('#contact-container .contact-message')
				.html($('<div class="contact-error"></div>').append(contact.message))
				.fadeIn(100);
		}
	};

	contact.init();

});