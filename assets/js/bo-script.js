jQuery(function($){
	/**
	 * Fonctionnement du filtre
	 * onChange eo @ilay select => on récupère la value sélectionnée : id_cagnotte|mode paiement|date
	 * envoi requete AJAX selon cette value pour récupérer les value existantes en BDD
	 * affichage de ces values dans le formulaires #form_interne
	 * 
	*/
	$('#filtre_tri').on('change',function(){
		var optionSelected = $("option:selected", this);
		var filtre = this.value;
		$('#loader-bo').fadeIn();
		if( filtre == 'cagnotte'){
			$.ajax({
				url: ajaxurl,
				type: "POST",
				data: {
					'action': 'update_cagnotte',
					'filtre': filtre
				}
			}).done(function(reponse){
				$('#loader-bo').fadeOut();
				var resp = JSON.parse(reponse);
				if( resp.msg == 'OK' ){
					$('#form_interne').fadeIn();
					$('#le_filtre').text('');
					$('#le_filtre').text( filtre );
					$('#tri').html('');
					$.each( resp.nom_cagnottes, function( index, value ) {
					  $('#tri').append('<option value="'+ value+'">'+ value +'</option>');
					});
					$('#hidden_filtre').val( 'id_cagnotte' );
				}
			});
		}else if( filtre == 'paiement' ){
			
			$.ajax({
				url: ajaxurl,
				type: "POST",
				data: {
					'action': 'update_paiement',
					'filtre': filtre
				}
			}).done(function(reponse){
				$('#loader-bo').fadeOut();
				var resp = JSON.parse(reponse);
				if( resp.msg == 'OK' ){
					$('#form_interne').fadeIn();
					$('#le_filtre').text('');
					$('#le_filtre').text( filtre );
					$('#tri').html('');
					$('#tri').append(
						'<option value="paypal">paypal</option>' +
						'<option value="telma">MVola</option>' +
						'<option value="orange">Orange Money</option>' +
						'<option value="airtel">Airtel Money</option>'
					);
					$('#hidden_filtre').val( 'paiement' );
				}
			});
		}else if( filtre == 'date' ){
			$.ajax({
				url: ajaxurl,
				type: "POST",
				data: {
					'action': 'update_date',
					'filtre': filtre
				}
			}).done(function(reponse){
				$('#loader-bo').fadeOut();
				var resp = JSON.parse(reponse);
				if( resp.msg == 'OK' ){
					$('#form_interne').fadeIn();
					$('#le_filtre').text('');
					$('#le_filtre').text( filtre );
					$('#tri').html('');
					$.each( resp.date, function( index, value ) {
					  $('#tri').append('<option value="'+ value+'">'+ value +'</option>');
					});
					$('#hidden_filtre').val( 'date' );
				}
			});
		}else if( filtre == 'all' ){
			$.ajax({
				url: ajaxurl,
				type: "POST",
				data: {
					'action': 'update_reset',
					'filtre': filtre
				}
			}).done(function(reponse){
				$('#loader-bo').fadeOut();
				var resp = JSON.parse(reponse);
				if( resp.msg == 'reload' ){
					window.location.reload();
				}
			});
		}
	});
});