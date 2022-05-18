$(function(){

/******
	  création cagnotte
	  *************/

	  /*
	  * Choix catégorie de cagnotte
	  * Type de cagnotte est défini selon type

	  * Cagnotte SOLIDAIRE = automatiquement PUBLIQUE ==> cacher le choix déroulant
		* Cagnotte PERSONNELLE = cagnotte PUBLIQUE ou PRIVÉE au choix (on doit pouvoir choisir)
		*/

	  $('.lst-type .item').on('click', function(){
			var choix_categ = $(this).find('input[name="sous-categ"]').val();
			var categ = $(this).find('input[name="categ"]').val();

			var categorie_c = $(this).find('input[name="sous-categ"]').data('categorie');

			if( categorie_c == "Personnelle" ){
				/* Afaka misafidy oe publique sa privée */
				$('#type_cagnotte').removeClass( 'disabled' );
				$('#type_cagnotte').val(text.list_priv);

				$('#frais_cagnotte').show();
				$('#frais_cagnotte').text(text.list_frais_6);

				$('#cat_cagnotte').val(text.list_perso);

				$('.info-prive').removeClass('hidden');
				$('.info-publique').addClass('hidden');

			}else if( categorie_c == "Solidaire" ){
				/* Tonga dia publique systématiquement */
				$('#type_cagnotte').val(text.list_pub);
				$('#type_cagnotte').removeClass('disabled');
				$('#type_cagnotte').addClass('disabled');

				$('#frais_cagnotte').show();
				$('#frais_cagnotte').text(text.list_frais_3);

				$('#cat_cagnotte').val(text.list_solid);

				$('.info-publique').removeClass('hidden');
				$('.info-prive').addClass('hidden');

			}

			$('#sous-Categ').val( choix_categ );
			$('#categ').val( categ );

		});

		$('#type_cagnotte').on('change', function(){
			var valera = $(this).val();

			if( valera == text.list_priv){
				$('.info-prive').removeClass('hidden');
				$('.info-publique').addClass('hidden');
			}else if( valera == text.list_pub ){
				$('.info-publique').removeClass('hidden');
				$('.info-prive').addClass('hidden');
			}

		});

		$('.lst-choix-cond-part .item').on('click', function(){
			var condPart = $(this).find('input[name="participation_cagnotte"]').val();

			$('#condParticip').val( condPart );
		});

	  $('#creer-cagnotte').click(function(e){
	  	$('#loader').addClass('working');

	  	var form_data = new FormData( $('#form-creation-cagnotte')[0] );

	  	if( $('.illustration_cagnotte.mobile-only:visible').length ){
	  		//form_data.delete('cin_value');
	  		//form_data.delete('illustration');
	  		form_data.append('device', 'mobile');

	  	} else {// if( $('.illustration_cagnotte.desk-only:visible').length  ){
	  		form_data.delete('cin_value_mobile');
	  		form_data.delete('illustration_mobile');
	  		form_data.append('device', 'desktop');

	  	}

	  	form_data.append('action', 'create_cagnotte');

	  	//console.log(form_data);

		// if(cin_value){
		// 	form_data.append('cin_value', cin_value);
		// }else{
		// 	form_data.append('cin_value', '');
		// }


	  	$.ajax({
	  		url: ajaxurl,
	  		data: form_data,
        contentType: false,
        processData: false,
        type:"POST",
	  	}).done(function(resp){
	  		$('#loader').removeClass('working');
				var patt = new RegExp("^http");
				if( patt.test(resp) ){
					//window.location = resp;
					//$('#creer-cagnotte-popup').trigger('click');
					$.fancybox.open({
						src : '#pp-felicitation',
						beforeClose: function() {
						    window.location = resp;
						}
					});
				}else{
		  		$('ul#response').addClass('error').html(resp);
		  		setTimeout(function() {
		  			$('ul#response').removeClass('error').html('');
		  		}, 10000 );
				}
	  	});

	  	return false;
	  });

	  $('#pp-felicitation .link').click(function(){
	  	$.fancybox.close();
	  });

	   /******
	  participation
	  *************/
	  $('#participate').click(function(){
	  	$('#loader').addClass('working');
	  	var id = $(this).data('id');
	  	var url = $(this).data('url');
	  	$.ajax({
	  		url: ajaxurl,
	  		type: 'POST',
	  		data: {
	  			'action' : 'redirect_single',
	  			'id' : id
	  		}
	  	}).done(function(resp){
	  		if (resp = 'success'){
	  			console.log('redirecting...');
	  			window.location = url;
	  		}else{
	  			console.log(resp);
	  		}
	  		$('#loader').removeClass('working');
	  	});

	  	return false;
	  });

	  /*
	  * Participation
	  */

	  function calcul_devise_en_mga( montant, $devise, taux_eu, taux_liv, taux_cad, taux_usd ){
	  	if( 'eu' == $devise ){
	  		return montant * taux_eu;
  		}else if( 'liv' == $devise ){
  			return montant * taux_liv;
  		}else if( 'cad' == $devise ){
				return montant * taux_cad;
  		}else if( 'usd' == $devise ){
  			return montant * taux_usd;
  		}
	  }

	  $('#choix-devise').on('change',function(){
	  	var change_mga_eu  = $('#change-mga-eu').val();
	    var change_mga_usd = $('#change-mga-usd').val();
	    var change_mga_liv = $('#change-mga-liv').val();
	    var change_mga_cad = $('#change-mga-cad').val();

	  	var $devise = $(this).val();
	  	var $montant= $('#donation').val();

	  	if( 'mga' != $devise ){
	  		/* affichéna ny montant équivalent en ariary */
	  		var $montant_converti = calcul_devise_en_mga( $montant, $devise, change_mga_eu, change_mga_liv, change_mga_cad, change_mga_usd );

	  		$('.change-texte').text( text.conf_montant_devise + $montant_converti + ' MGA');
	  	}else{
	  		$('.change-texte').text('');
	  	}

	  });

	  $('#donation').on('keyup',function(){
	  	var change_mga_eu  = $('#change-mga-eu').val();
	    var change_mga_usd = $('#change-mga-usd').val();
	    var change_mga_liv = $('#change-mga-liv').val();
	    var change_mga_cad = $('#change-mga-cad').val();

	  	var $devise = $('#choix-devise').val();
	  	var $montant= $(this).val();

	  	if( 'mga' != $devise ){
	  		/* affichéna ny montant équivalent en ariary */
	  		var $montant_converti = calcul_devise_en_mga( $montant, $devise, change_mga_eu, change_mga_liv, change_mga_cad, change_mga_usd );

	  		$('.change-texte').text(text.conf_montant_devise + $montant_converti + ' MGA');
	  	}else{
	  		$('.change-texte').text('');
	  	}

	  });

	  $('#creer-participation').click(function(e){
	  	var fname = $('#fname').val();
	  	var lname = $('#lname').val();
	  	var mail = $('#mail').val();
	  	var phone = $('.iti__selected-dial-code').html()+$('#phone').val();
	  	var phone_33 = $('.iti__selected-dial-code').html()+$('#phone').val();
	  	var condition = $('#condition').val();
	  	var donation = $('#donation').val();
	  	var devise = $('#choix-devise').val();
	  	var message = $('#message').val();
	  	var accord 				= $('#accord:checked').val();
	  	var maskIdentite = $('#masque1:checked').val();

	  	if (maskIdentite != "on"){
	  		maskIdentite = "off";
	  	}
	  	var maskParticipation = $('#masque2:checked').val();
	  	if (maskParticipation != "on"){
	  		maskParticipation = "off";
	  	}

	  	var paiement = $('input[name="selector"]:checked').val();
	  	var idCagnotte = $('input[name="id_cagnotte"]').val();

	  	// if ( devise == 'mga' && paiement == 'paypal' ){
	  	// 	$('#open_conf').trigger('click');
	  	// 	$('#popup_conf').addClass('warning_popup');
	  	// 	$('#popup_conf .conf_titre').text('Attention !');
	  	// 	$('#popup_conf .conf_text').text('La devise MGA n\'est pas supportée par Paypal. Veuillez en choisir une autre.');

	  	// 	return false;
	  	// }else if ( devise != 'mga' ){
	  	// 	if ( paiement == 'orange' || paiement == 'telma' || paiement == 'airtel' ){
		  // 		$('#open_conf').trigger('click');
		  // 		$('#popup_conf').addClass('warning_popup');
		  // 		$('#popup_conf .conf_titre').text('Attention !');
		  // 		$('#popup_conf .conf_text').text('Les paiements par mobile money ne peuvent être effectués qu\'en MGA.');

		  // 		return false;
	  	// 	}
	  	// }

	  	$('#loader').addClass('working');

	  	$.ajax({
	  		url: ajaxurl,
	  		type: 'POST',
	  		data: {
	  			'action':'creer_participation',
	  			'fname': fname,
	  			'lname': lname,
	  			'mail': mail,
	  			'phone':phone,
	  			'phone33':phone_33,
	  			'donation': donation,
	  			'condition':condition,
	  			'devise': devise,
	  			'message': message,
	  			'maskIdentite' : maskIdentite,
	  			'maskParticipation': maskParticipation,
	  			'paiement' : paiement,
	  			'idCagnotte' : idCagnotte,
	  			'accord' : accord
	  		}
	  	}).done( function(resp){

	  		$('#loader').removeClass('working');
	  		var patt = new RegExp("^\<li\>");
	  		var url = new RegExp("^http");
	  		var popup_airtel = new RegExp('^trigger_popup=popup_airtel');

	  		if( url.test(resp) ){
				 	console.log('redirect...');
				 		window.location = resp;
				 }

				if( patt.test(resp) ){
			  		$('ul#response').addClass('error').html(resp);
				  		setTimeout(function() {
				  			$('ul#response').removeClass('error').html('');
				  		}, 10000 );
				 }

				 if( popup_airtel.test(resp) ){
				 	$('input[name="all_datas"]').val( resp );
				 	$('#popup_airtel_trig').trigger('click');
				 }

	  	} );


	  	return false;
	  });

	  /* Fin participation *///

	  $('#airtelinput').on('submit', function(){
	  	var infos = $('input[name="all_datas"]').val();
	  	var num_airtel = $('input[name="num_airtel"]').val();
	  	$('#loader').addClass('working');
	  	$.ajax(ajaxurl, {
	  		type: "POST",
	      data: {
	      	'action':'pay_airtel',
	      	'infos' : infos,
	      	'num_airtel': num_airtel
	      },
	      success: function(resp){
	      	$('#loader').removeClass('working');
	      	$('.output-normal').fadeOut(300);
	      	$('.output-response').fadeIn(300);
	      	window.location = resp;
	      }
	    });

	  	return false;
	  });

	  //gestion
	  $('#gestionner').click(function(){
	  	$('#loader').addClass('working');
	  	var id = $(this).data('id');
	  	var url = $(this).data('url');
	  	$.ajax({
	  		url: ajaxurl,
	  		type: 'POST',
	  		data: {
	  			'action' : 'redirect_gestion',
	  			'id' : id
	  		}
	  	}).done(function(resp){
	  		console.log(resp);
	  		if (resp = 'success'){
	  			console.log('redirect...');
	  			window.location = url + '?gest=' + id;
	  		}else{
	  			console.log(resp);
	  		}
	  		$('#loader').removeClass('working');
	  	});

	  	return false;
	  });

	  /* invite email */
	   $('#invite_email').click( function(){
		   var source = $(this).data('source');
	  	$('#loader').addClass('working');
	  	if ( $('.un-email').length ){
	  		var emails = [];
	  		$('.un-email').each(function(index){
	  			emails.push( $(this).text() );
	  		});
	  	}
	  	var idCagnotte	 = $('#idCagnotte').val();

	  	$.ajax({
	  		url: ajaxurl,
	  		type: 'POST',
	  		data: {
	  			'action': 'send_invite',
	  			'emails': emails,
	  			'idCagnotte': idCagnotte,
	  		}
	  	}).done(function(resp){
			var data= $.parseJSON(resp);
	  		if ( data.resp == "success" ){
	  			$('#open_conf').trigger('click');
	  			$('#popup_conf .conf_text').text(text.conf_invite_email);
				if(source){
					window.location = data.url;
				}
	  		}else{
	  			$('ul#response').addClass('error').html(data.erreurs);
			  		setTimeout(function() {
			  			$('ul#response').removeClass('error').html('');
			  		}, 10000 );
	  		}
	  		$('#loader').removeClass('working');
	  	});
	  	return false;
	  } );

	   /* Paramètres */
	  $('#submit-info-principale').click(function(){
	  	$('#loader').addClass('working');

	  	// info principale
	  	var nomCagnotte = $('#nom_cagnotte').val();
	  	var debut				 = $('#datepicker_debut_param').val();
	  	var fin					 = $('#datepicker_fin_param').val();
	  	var idCagnotte	 = $('#idCagnotte').val();

	  	// categorie
	  	var sousCateg = $('.lst-type .item.active input[name="sous-categ"]').val();
	  	var categ 		= $('.lst-type .item.active input[name="categ"]').val();

	  	// info beneficiaire
	  	var idBenef = $('#benef').val();
	  	var nom = $('#nom').val();
	  	var prenom = $('#prenom').val();
	  	var email = $('#email').val();
	  	var code = $('#code').val();
	  	var tel = $('#tel').val();
	  	var rib = $('#rib_value').val();

	  	$.ajax({
	  		url: ajaxurl,
	  		type: 'POST',
	  		data:{
	  			'action':'save_info_principale',
	  			'nomCagnotte': nomCagnotte,
	  			'debut': debut,
	  			'fin': fin,
	  			'idBenef': idBenef,
	  			'nom': nom,
	  			'prenom': prenom,
	  			'email': email,
	  			'code': code,
	  			'tel': tel,
	  			'rib': rib,
	  			'categ': categ,
	  			'sousCateg': sousCateg,
	  			'idCagnotte': idCagnotte
	  		}
	  	}).done(function(resp){
	  		var url = new RegExp("^http");
	  		if( url.test(resp) ){
				 	console.log('redirect..');
				 		window.location = resp + '?parametre='+idCagnotte;
				 }else{
	  			$('ul#response').addClass('error').html(resp);
			  		setTimeout(function() {
			  			$('ul#response').removeClass('error').html('');
			  		}, 10000 );
	  		}
				 $('#loader').removeClass('working');
	  	});

	  	return false;
	  });
	  	/* Paramètres rib */
	  $('.form-rib .link.submit').click(function(){
	  	$('#loader').addClass('working');
	  	var nomCagnotte = $('#nom_cagnotte').val();
	  	var idCagnotte	= $('#idCagnotte').val();
	  	var idBenef = $('#benef').val();

	  	// info beneficiaire

	  	var titulaire = $('#rib_nom').val();
	  	var banque = $('#rib_bank').val();
	  	var domicile = $('#rib_domicile').val();
	  	var codebanque = $('#rib_codebank').val();
	  	var codeguichet = $('#rib_codeguichet').val();
	  	var numcompte = $('#rib_numcompte').val();
	  	var cle = $('#rib_cle').val();
	  	var iban = $('#rib_iban').val();
	  	var bic = $('#rib_bic').val();
		var fichier = $('#rib_value').val();
		console.log(fichier);
	  	$.ajax({
	  		url: ajaxurl,
	  		type: 'POST',
	  		data:{
	  			'action':'save_info_banque',
	  			'titulaire': titulaire,
	  			'banque': banque,
	  			'domicile': domicile,
	  			'codebanque': codebanque,
	  			'codeguichet': codeguichet,
	  			'numcompte': numcompte,
	  			'cle': cle,
	  			'iban': iban,
	  			'bic': bic,
	  			'idCagnotte': idCagnotte,
	  			'idBenef': idBenef,
				'fichier' : fichier
	  		}
	  	}).done(function(resp){
			var resp_json = $.parseJSON(resp);
	  		if( resp_json.resp === "success"){
				console.log('redirect..');
				window.location = resp_json.url + '?parametre='+idCagnotte;
			}else{
				var errors = resp_json.errors;
				console.log(errors);
				$(errors).each(function(index,value){
					console.log(value);
				});
				
	  			// $('ul#responsepopup').addClass('error').html(resp);
			  	// 	setTimeout(function() {
				// 	$('ul#responsepopup').removeClass('error').html('');
				// }, 10000 );
	  		}
			$('#loader').removeClass('working');
	  	});

	  	return false;

	  });

	  /* paramtre fond */
	  $('#slide-img .item a').click(function(){
			var src = $(this).data('imgsrc');
			$('#url_img_cagnotte').val(src);

			setTimeout(function(args) {
				$('.zone-img').css('background','center / cover no-repeat url('+ $('#url_img_cagnotte').val() +')');
	    	$('.zone-img .inputfile + label').addClass('no-bg');
			}, 500);
			return false;
		});

	  $('#submit-fond').click(function(){
	  	$('#loader').addClass('working');
	  	var bg 	= $('input[name="choix-photo"]').val();
	  	var idCagnotte	 = $('#idCagnotte').val();

	  	$.ajax({
	  		url: ajaxurl,
	  		type: 'POST',
	  		data:{
	  			'action':'save_fond',
	  			'bg': bg,
	  			'idCagnotte': idCagnotte
	  		}
	  	}).done(function(resp){
	  		var url = new RegExp("^http");

	  		if( url.test(resp) ){
				 	console.log('redirect...');
				 		window.location = resp;
				 }else{
	  			$('ul#response').addClass('error').html(resp);
			  		setTimeout(function() {
			  			$('ul#response').removeClass('error').html('');
			  		}, 10000 );
	  		}
				 $('#loader').removeClass('working');
	  	});

	  	return false;
	  });

	  //Aperçu
	  $('#apercu-description').click(function(){
	  	$('#loader').addClass('working');

	  	var descr = $('.textEdit').summernote('code');

	  	$('.blc-apercu').html(descr);
		$('#loader').removeClass('working');
	  	return false;
	  });

	  /* parametre description */
	  $('#submit-descr').click(function(){
	  	$('#loader').addClass('working');

	  	var descr = $('.textEdit').summernote('code');
	  	var idCagnotte	 = $('#idCagnotte').val();

	  	$.ajax({
	  		url: ajaxurl,
	  		type: 'POST',
	  		data: {
	  			'action': 'save_descr',
	  			'descr': descr,
	  			'idCagnotte': idCagnotte
	  		}
	  	}).done(function(resp){
	  		var url = new RegExp("^http");
	  		if( url.test(resp) ){
				 	console.log('redirect...');
				 		window.location = resp;
				 }else{
	  			$('ul#response').addClass('error').html(resp);
			  		setTimeout(function() {
			  			$('ul#response').removeClass('error').html('');
			  		}, 10000 );
	  		}
				 $('#loader').removeClass('working');
	  	});
	  	return false;
	  });

	  /*Paramtre montant */
	  $('#submit-montant').click(function(){
		var url_redirect = $(this).attr('href');
		console.log(url_redirect);
	  	$('#loader').addClass('working');

	  	var ilaina = $('#ilaina').val();
	  	var suggere = $('#suggere').val();
	  	var devise = $('#devise').val();

	  	var maskIlainaAzo = $('#masque1:checked').val();
	  	if (maskIlainaAzo != "on"){
	  		maskIlainaAzo = "off";
	  	}
	  	var maskToutesContribution = $('#masque2:checked').val();
	  	if (maskToutesContribution != "on"){
	  		maskToutesContribution = "off";
	  	}
	  	var maskContribution = $('#masque3:checked').val();
	  	if (maskContribution != "on"){
	  		maskContribution = "off";
	  	}

	  	var idCagnotte	 = $('#idCagnotte').val();

	  	$.ajax({
	  		url: ajaxurl,
	  		type: 'POST',
	  		data: {
	  			'action': 'save_montant',
	  			'ilaina': ilaina,
	  			'suggere': suggere,
	  			'devise': devise,
	  			'maskIlainaAzo': maskIlainaAzo,
	  			'maskToutesContribution': maskToutesContribution,
	  			'maskContribution': maskContribution,
	  			'idCagnotte': idCagnotte
	  		}
	  	}).done(function(resp){
	  		var url = new RegExp("^http");
	  		if( url.test(resp) ){
				 	console.log('redirect...');
				 	window.location = url_redirect;//resp;
				 }else{
	  			$('ul#response').addClass('error').html(resp);
			  		setTimeout(function() {
			  			$('ul#response').removeClass('error').html('');
			  		}, 10000 );
	  		}
				 $('#loader').removeClass('working');
	  	});
	  	return false;
	  });

	  /* parametre notification */
	  $('#submit-parametre').click(function(){
	  	$('#loader').addClass('working');

	  	var recevoirNotif = $('#recevoir:checked').val();
	  	if (recevoirNotif != "on"){
	  		recevoirNotif = "off";
	  	}
	  	var notifParticip = $('#notifie:checked').val();
	  	if (notifParticip != "on"){
	  		notifParticip = "off";
	  	}
	  	var idCagnotte	 = $('#idCagnotte').val();

	  	$.ajax({
	  		url: ajaxurl,
	  		type: 'POST',
	  		data: {
	  			'action': 'save_notif',
	  			'recevoirNotif': recevoirNotif,
	  			'notifParticip': notifParticip,
	  			'idCagnotte': idCagnotte
	  		}
	  	}).done(function(resp){
	  		var url = new RegExp("^<div>");
	  		if( url.test(resp) ){
	  			$('#popup_conf .conf_titre').html(text.conf_titre_save_notif);
	  			$('#popup_conf .conf_text').html(resp);
	  			$('#open_conf').trigger('click');
				 }else{
	  			$('ul#response').addClass('error').html(resp);
			  		setTimeout(function() {
			  			$('ul#response').removeClass('error').html('');
			  		}, 10000 );
	  		}
				 $('#loader').removeClass('working');
	  	});
	  	return false;
	  });

	  /* ajout quesion */
	  if ( $('#add-question').length ){
		  $('#add-question').click(function(){
		  	var question = $('#la-question').val();
		  	var idCagnotte	 = $('#idCagnotte-question').val();

		  	if ( question == ''){
		  		alert('Question !');
		  		return false;
		  	}

		  	$('#loader').addClass('working');

		  	$.ajax({
		  		url: ajaxurl,
		  		type: 'POST',
		  		data: {
		  			'action' : 'ask_question',
		  			'question': question,
		  			'idCagnotte': idCagnotte
		  		},
		  		dataType: 'html'
		  	}).done(function(resp){
		  		//console.log(resp);
		  		// $(resp).insertBefore('#chp-comment');
		  		$('#loader').removeClass('working');

		  		window.location.href = '#question';
				window.location.reload(true);

		  	});

		  	return false;
		  });
		}



	  $('.delete a').click(function(){
	  	var id = $(this).data('delete');
	  	if ( confirm("Confirmer la suppression") ){


	  			$.ajax({
	  				url: ajaxurl,
	  				type: 'POST',
	  				data: {
	  					'action' : 'delete_pst',
	  					'id': id
	  				}
	  			}).done(function(r){
	  					if (r == "success"){
	  						location.reload();
	  					}
	  			});
	  	}
	  	return false;
	  });

	  /* edit qusint */
	  if ( $('#edit-question').length ){
			  $('#edit-question').click(function(){
			  	var question = $('#la-question').val();
			  	var id = $('.edit a').data('edit');

			  	if ( question == ''){
			  		alert('Question !');
			  		return false;
			  	}
			  	$('#loader').addClass('working');

			  	$.ajax({
			  		url: ajaxurl,
			  		type: 'POST',
			  		data: {
			  			'action' : 'ask_question',
			  			'question': question,
			  			'id_question': id
			  		},
			  		dataType: 'html'
			  	}).done(function(resp){
			  		location.reload();
			  		// $('.listComment.editing').html(resp);
			  		// $('#la-question').val('');
			  		// $('#loader').removeClass('working');
			  		// $('.listComment').removeClass('editing');
			  	});

			  	return false;
			  });
		}

		/* edit porfile */
		$('#edit-profilz').click(function(e){
	  	e.preventDefault();
	  	$('#loader').addClass('working');

	  	var form_data = new FormData( $('#form-edit-profil')[0] );

	  	form_data.append('action','edit_profile');

	  	if( $('.mobile-only:visible').length ){
	  		//form_data.delete('cin_value');
	  		//form_data.delete('choix-photo');
	  		form_data.append('device', 'mobile');

	  	}else { // if( $('.desk-only:visible').length  ){
	  		form_data.delete('cin_value_mobile');
	  		form_data.delete('choix-photo_mobile');
	  		form_data.append('device', 'desktop');

	  	}

	  	$.ajax({
			  		url: ajaxurl,
			  		type: 'POST',
			  		data: form_data,
			  		dataType: 'json',
			  		contentType: false,
        		processData: false
			  	}).done(function(resp){
			  		$('#loader').removeClass('working');
			  		$('#open_conf').trigger('click');
	  				$('#popup_conf .conf_text').text(resp);
			 });

	  	return false;
	  });

	  $('#relance_auto').click(function(){
			emails = [];

			$('[name="relance[]"]:checked').each(function(){
          emails.push($(this).val());
      });

      var idCagnotte	 = $('#idCagnotte').val();

      if ( emails.length > 0 ){
      	$('#loader').addClass('working');
      	$.ajax({
			  		url: ajaxurl,
			  		type: 'POST',
			  		data: {
			  			'action' : 'relance_auto',
			  			'emails': emails,
			  			'idCagnotte': idCagnotte
			  		}
			  	}).done(function(resp){
			  		$('#loader').removeClass('working');
			  		$('#open_conf').trigger('click');
	  				$('#popup_conf .conf_text').text(text.conf_relance_auto);
			  	});

      } else {
      	$('#open_conf').trigger('click');
	$('#popup_conf .conf_text').text('Sélectionner une ou plusieurs adresse email ci-dessus qui n\'ont pas encore répondu à votre invitation');
      }

			return false;
		});

		/* search bar autocomplete */
		var req;
		$('#ajaxsearchlite1 .orig').on('keyup', function(e){
			if ( typeof req !== 'undefined'){
				req.abort();
				$('#ajaxsearchlite1 .orig + input').val('');
			}
			$('#ajaxsearchlite1 .orig + input').val('');
			var key = e.key;
			var iz = $(this);
			var str = iz.val();
			var target = $('#ajaxsearchlite1 .orig + input');
			if ( str != '' ){
				req = $.ajax({
					url: ajaxurl,
					type: 'POST',
					data: {
						'action':'kk_search',
						'str'   : str
					}
				}).done(function(resp){
					$('#ajaxsearchlite1 .orig + input').val(resp);
					if ( key == "ArrowRight"){
						$('#ajaxsearchlite1 .orig').val(resp);
					}
				});
			}
		});

	// Page paiement Airtel Money
	if( $('#AM_page').length > 0 ){
		$('#loader').addClass('working');
		setTimeout( check_AM_Status, 40000 );
	}

	function check_AM_Status(){

		var order_id = $('#order_id').val();

  	$.ajax({
	  		url: ajaxurl,
	  		type: 'POST',
	  		data: {
	  			'action' : 'check_status_AM',
	  			'order_id': order_id
	  		},
	  		dataType: 'json'
	  	}).done(function(resp){
	  		$('#loader').removeClass('working');

	  		$('#AM_titre').text( resp.titre );
	  		$('#AM_response').text( resp.message)
	  });
	}

	// Bouton cloturer cagnotte
	$('#cloturer').click(function(){
		$.fancybox.close();
		var id_a_cloturer = jQuery('#gestionner').data('id');
		$('#loader').addClass('working');
		$.ajax({
	  		url: ajaxurl,
	  		type: 'POST',
	  		data: {
	  			'action' : 'cloturer_cagnotte',
	  			'id_a_cloturer': id_a_cloturer
	  		},
	  		dataType: 'json'
	  	}).done(function(resp){
	  		$('#loader').removeClass('working');

	  		$('#open_conf').trigger('click');
	  		$('#popup_conf .conf_text').text(text.conf_cloture);

	  		$('#cloturer-confirm').remove();
	  		$('#confirme-cloture').remove();
	  		$('#btn_participer_wrap').remove();

	  });

		return false;
	});

	$('#remove_doc_btn').click(function(e){
		e.preventDefault();
		var cagnotte_id= $(this).data('cagnotteId');
		var file_ids = [];
        $('[name=doc_files]:checked').each(function(i){
			file_ids[i] = $(this).val();
        });
		console.log(file_ids);
		$.ajax({
			url: ajaxurl,
			data: {
				'action': 'remove_doc_cagnotte',
				'file_ids' : file_ids,
				'cagnotte_id': cagnotte_id
			},
			dataType: 'html',
			type:"POST",
		}).done(function(resp){
			$('#pp-document #list-documents').html(resp);
		});
	});

	var mediaUploader;
	$('#add_doc_btn').click(function(e) {
        e.preventDefault();
        var cagnotte_id= $(this).data('cagnotteId');
        if (mediaUploader) {
            $("#menu-item-upload").html(text.conf_document_upload);
            $("#menu-item-upload").click();
            $("#menu-item-browse").css("display","none");
            $(".media-uploader-status .h2").html(text.conf_document_upload_status);
            $("h2.upload-instructions").text(text.conf_document_upload_instuction);
            $("p.max-upload-size").text(text.conf_document_upload_taille);
            mediaUploader.open();
            return;
        }
        mediaUploader = wp.media.frames.file_frame = wp.media({
            multiple: false
        });
        mediaUploader.on('select', function() {
			console.log("doc upload");
            var attachment = mediaUploader.state().get('selection').first().toJSON();
			$.ajax({
                url: ajaxurl,
                data: {
                    'action': 'insert_doc_cagnotte',
                    'doc_file' : attachment.url,
                    'cagnotte_id': cagnotte_id
                },
                dataType: 'html',
                type:"POST",
            }).done(function(resp){
                $('#pp-document #list-documents').html(resp);

            });


        });
        mediaUploader.open();
        $("#menu-item-upload").html(text.conf_document_upload);
        $("#menu-item-upload").click();
        $("#menu-item-browse").css("display","none");
        $(".media-uploader-status .h2").html(text.conf_document_upload_status);
        $("h2.upload-instructions").text(text.conf_document_upload_instuction);
        $("p.max-upload-size").text(text.conf_document_upload_taille);
    });

	var mediaUploaderImage;
	$('#add_image').click(function(e) {
        e.preventDefault();
        var cagnotte_id= $(this).data('cagnotteId');
        if (mediaUploaderImage) {
            $("#menu-item-upload").html(text.conf_document_upload);
            $("#menu-item-upload").click();
            $("#menu-item-browse").css("display","none");
            $(".media-uploader-status .h2").html(text.conf_document_upload_status);
            $("h2.upload-instructions").text(text.conf_document_upload_instuction);
            $("p.max-upload-size").text(text.conf_document_upload_taille);
            mediaUploaderImage.open();
            return;
        }
        mediaUploaderImage = wp.media.frames.file_frame = wp.media({
            multiple: false
        });
        mediaUploaderImage.on('select', function() {
			console.log("image upload");
            var attachment = mediaUploaderImage.state().get('selection').first().toJSON();
            $.ajax({
                url: ajaxurl,
                data: {
                    'action': 'insert_image_cagnotte',
                    'image_url' : attachment.url,
                    'cagnotte_id': cagnotte_id
                },
                dataType: 'html',
                type:"POST",
            }).done(function(resp){
                $('#pp-photos #list-photos .row .photo').html(resp);
                $.fancybox.close();
            });


        });
        mediaUploaderImage.open();
        $("#menu-item-upload").html(text.conf_document_upload);
        $("#menu-item-upload").click();
        $("#menu-item-browse").css("display","none");
        $(".media-uploader-status .h2").html(text.conf_document_upload_status);
        $("h2.upload-instructions").text(text.conf_document_upload_instuction);
        $("p.max-upload-size").text(text.conf_document_upload_taille);
    });

	$('#add_video').click(function(e){
		e.preventDefault();
		var cagnotte_id= $(this).data('cagnotteId');
		var patt = new RegExp("^Veuillez");
		var video_id= $("[name=video_id]").val();
		if(video_id){
			$.ajax({
				url: ajaxurl,
				data: {
					'action': 'insert_video_cagnotte',
					'video_id' : video_id,
					'cagnotte_id': cagnotte_id
				},
				dataType: 'html',
				type:"POST",
			}).done(function(resp){
				if(patt.test(resp)){
					$('.error_video').text(resp);
				}else{
					$('#pp-videos #list-videos .row .video').html(resp);
					$.fancybox.close();
				}
			});
		}else{
			$('.error_video').text("Veuillez entrer un ID");
		}
	});

	$('#remove_media_photos_btn').click(function(e){
		e.preventDefault();
		var cagnotte_id= $(this).data('cagnotteId');
		var image_ids = [];
        $('[name=ck-photo]:checked').each(function(i){
			image_ids[i] = $(this).val();
        });
		console.log(image_ids);
		$.ajax({
			url: ajaxurl,
			data: {
				'action': 'remove_photos_cagnotte',
				'image_ids' : image_ids,
				'cagnotte_id': cagnotte_id
			},
			dataType: 'html',
			type:"POST",
		}).done(function(resp){
			$('#pp-photos #list-photos .row .photo').html(resp);
		});
	});

	$('#remove_media_videos_btn').click(function(e){
		e.preventDefault();
		var cagnotte_id= $(this).data('cagnotteId');
		var video_ids = [];
        $('[name=ck-video]:checked').each(function(i){
			video_ids[i] = $(this).val();
        });
		console.log(video_ids);
		$.ajax({
			url: ajaxurl,
			data: {
				'action': 'remove_videos_cagnotte',
				'video_ids' : video_ids,
				'cagnotte_id': cagnotte_id
			},
			dataType: 'html',
			type:"POST",
		}).done(function(resp){
			$('#pp-videos #list-videos .row .video').html(resp);
		});
	});

})
