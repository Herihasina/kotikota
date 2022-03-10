$(document).ready(function() {
    // $(".media-sidebar").initialize( function(){
    //    alert("bka")
    // });
    var change_mga_eu = $('#change-mga-eu').val();
    var change_mga_usd = $('#change-mga-usd').val();
    var change_us_liv = $('#change-mga-liv').val();
    var change_us_cad = $('#change-mga-cad').val();

    $('#go-connected').click(function() {
        $('#popup-apropos .fancybox-close-small').trigger('click');
        setTimeout(function() {
            $('.btn-head a.link').trigger('click');
        }, 300);
    });

    $('.open-forgot').on('click', function() {
        $('.lrm-signin-section').removeClass('is-selected');
        $('.lrm-signup-section').removeClass('is-selected');
        $('.lrm-reset-password-section').addClass('is-selected');
        return false;
    });
    $('.open-login').on('click', function() {
        $('.lrm-signin-section').addClass('is-selected');
        $('.lrm-signup-section').removeClass('is-selected');
        $('.lrm-reset-password-section').removeClass('is-selected');
        return false;
    });
    $('.close-register-popup').on('click', function() {
        $('.lrm-signin-section').addClass('is-selected');
        $('.lrm-signup-section').removeClass('is-selected');
        $('.lrm-reset-password-section').removeClass('is-selected');
        $.fancybox.close();
        return false;
    });


    if( $('#new_btn:visible').length ){
        $('#new_btn').trigger('click');
        setTimeout(function() {
            $.fancybox.close();
        }, 8000);
    }

    $('#ml').click(function() {
        $('#gtranslate_selector')
            .val('fr|mg')
            .trigger('change');
        return false;
    });
    $('#fr').click(function() {
        $('#gtranslate_selector')
            .val('fr|fr')
            .trigger('change');
        return false;
    });
    $('#en').click(function() {
        $('#gtranslate_selector')
            .val('fr|en')
            .trigger('change');
        return false;
    })

    $('.lrm-accept-terms-checkbox').trigger('click');

    // Simulation Popup
    $('#input-attendue').keypress(function() {
        setTimeout(function(args) {
            var attendue = parseInt($('#input-attendue').val());
            var devise_attendue = $('#choix-devise-attendue').val();
            var devise_percue = $('#choix-devise-percue').val();

            if (devise_attendue == devise_percue) {
                $('#input-percue').val(attendue - (attendue * 6 / 100));
            }
            if (devise_attendue == 'mga' && devise_percue == 'eu') {
                $('#input-percue').val(((attendue - (attendue * 6 / 100)) / change_mga_eu).toFixed(2));
            }
            if (devise_attendue == 'mga' && devise_percue == 'us') {
                $('#input-percue').val(((attendue - (attendue * 6 / 100)) / change_mga_us).toFixed(2));
            }
            if (devise_attendue == 'eu' && devise_percue == 'mga') {
                $('#input-percue').val(((attendue - (attendue * 6 / 100)) * change_mga_eu).toFixed(2));
            }
            if (devise_attendue == 'eu' && devise_percue == 'us') {
                $('#input-percue').val(((attendue - (attendue * 6 / 100)) / change_us_eu).toFixed(2));
            }
            if (devise_attendue == 'us' && devise_percue == 'mga') {
                $('#input-percue').val(((attendue - (attendue * 6 / 100)) * change_mga_us).toFixed(2));
            }
            if (devise_attendue == 'us' && devise_percue == 'eu') {
                $('#input-percue').val(((attendue - (attendue * 6 / 100)) * change_us_eu).toFixed(2));
            }

        }, 1000);
    });

    $('#choix-devise-percue,#choix-devise-attendue').change(function() {
        var attendue = parseInt($('#input-attendue').val());
        var devise_attendue = $('#choix-devise-attendue').val();
        var devise_percue = $('#choix-devise-percue').val();

        if (devise_attendue == devise_percue) {
            $('#input-percue').val(attendue - (attendue * 6 / 100));
        }
        if (devise_attendue == 'mga' && devise_percue == 'eu') {
            $('#input-percue').val(((attendue - (attendue * 6 / 100)) / change_mga_eu).toFixed(2));
        }
        if (devise_attendue == 'mga' && devise_percue == 'us') {
            $('#input-percue').val(((attendue - (attendue * 6 / 100)) / change_mga_us).toFixed(2));
        }
        if (devise_attendue == 'eu' && devise_percue == 'mga') {
            $('#input-percue').val(((attendue - (attendue * 6 / 100)) * change_mga_eu).toFixed(2));
        }
        if (devise_attendue == 'eu' && devise_percue == 'us') {
            $('#input-percue').val(((attendue - (attendue * 6 / 100)) / change_us_eu).toFixed(2));
        }
        if (devise_attendue == 'us' && devise_percue == 'mga') {
            $('#input-percue').val(((attendue - (attendue * 6 / 100)) * change_mga_us).toFixed(2));
        }
        if (devise_attendue == 'us' && devise_percue == 'eu') {
            $('#input-percue').val(((attendue - (attendue * 6 / 100)) * change_us_eu).toFixed(2));
        }
    });

    $('#input-attendue').on('focus', function() {
        $('#input-percue').val('');
    });

    function setInputFilter(textbox, inputFilter) {
        ["input", "keydown", "keyup", "mousedown", "mouseup", "select", "contextmenu", "drop"].forEach(function(event) {
            textbox.addEventListener(event, function() {
                if (inputFilter(this.value)) {
                    this.oldValue = this.value;
                    this.oldSelectionStart = this.selectionStart;
                    this.oldSelectionEnd = this.selectionEnd;
                } else if (this.hasOwnProperty("oldValue")) {
                    this.value = this.oldValue;
                    this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
                } else {
                    this.value = "";
                }
            });
        });
    }

    // if ( $("#input-attendue").length){
    // 	setInputFilter($("#input-attendue"), function(value) {
    // 	  return /^\d*\.?\,?\d*$/.test(value);
    // 	});
    // }

    //FAQ
    var all_faqs = $('.foire-question').data('all_faqs');
    if (all_faqs != 0) {
        for (var i = 0; i < all_faqs; i++) {
            fix_faq(i);
        }
    }

    function fix_faq(i) {
        $('#qst' + i).click(function() {
            $('#faq' + i).prependTo('.lst-faq .inner');
            setTimeout(function(args) {
                $('#faq' + i + ' .s-titre').trigger('click');

            }, 500);
        });
    };

    $(".lst-faq .s-titre").click(function() {
        $(this).toggleClass('active');
        $(".lst-faq").find('.txt').slideUp();
        if ($(this).hasClass("active")) {
            $(".lst-faq .s-titre").removeClass('active');
            $(this).next().slideToggle();
            $(this).toggleClass('active');
        }
    });

    $(".lst-type .item .content").click(function() {
        var vis = $(this);
        if (vis.parent().hasClass("active")) {
            vis.parent().removeClass("active");
            vis.find('.span-normal').show();
            vis.find('.span-hover').hide();
        } else {
            $(".lst-type .item .content").parent().removeClass('active');
            vis.parent().addClass('active');
            vis.find('.span-normal').hide();
            vis.find('.span-hover').show();
        }
        vis.parents().find(".menu-liste-cagnotte").first().removeClass("active");

    });

    $(".fancybox-faq").fancybox({
        fitToView: false,
        autoSize: false,
        closeClick: false,
        openEffect: 'none',
        closeEffect: 'none'
    });
    /*
    	$('.lrm-signin-section').removeClass('is-selected');
    	$('.lrm-signup-section').removeClass('is-selected');
    	$('.lrm-reset-password-section').addClass('is-selected');
    */
    $('.fancybox-home').fancybox({
        fitToView: false,
        autoSize: false,
        closeClick: false,
        openEffect: 'none',
        closeEffect: 'none',
        beforeShow: function() {
            console.log('click');
            $('.lrm-signin-section').addClass('is-selected');
            $('.lrm-signup-section').removeClass('is-selected');
            $('.lrm-reset-password-section').removeClass('is-selected');
        }
    });

    $('.fancybox-register').fancybox({
        fitToView: false,
        autoSize: false,
        closeClick: false,
        openEffect: 'none',
        closeEffect: 'none',
        afterClose: function(inst, cur) {
            console.log('click');
            $('.lrm-signin-section').addClass('is-selected');
            $('.lrm-signup-section').removeClass('is-selected');
            $('.lrm-reset-password-section').removeClass('is-selected');
        },
        beforeShow: function() {
            console.log('click');
            $('.lrm-signin-section').removeClass('is-selected');
            $('.lrm-signup-section').addClass('is-selected');
            $('.lrm-reset-password-section').removeClass('is-selected');

            $('.signup-date-birth').datepicker({
                dateFormat: 'dd-mm-yy',
                changeMonth: true,
                changeYear: true,
                maxDate: '-18y',
                yearRange: '1940:2002',
                firstDay: 1,
                closeText: 'Fermer',
                prevText: 'Précédent',
                nextText: 'Suivant',
                currentText: 'Aujourd\'hui',
                monthNames: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'],
                monthNamesShort: ['Janv.', 'Févr.', 'Mars', 'Avril', 'Mai', 'Juin', 'Juil.', 'Août', 'Sept.', 'Oct.', 'Nov.', 'Déc.'],
                dayNames: ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'],
                dayNamesShort: ['Dim.', 'Lun.', 'Mar.', 'Mer.', 'Jeu.', 'Ven.', 'Sam.'],
                dayNamesMin: ['D', 'L', 'M', 'M', 'J', 'V', 'S'],
                weekHeader: 'Sem.',
            });
        }
    });

    //upload image cagnotte
    var mediaUploader;
    $('#fileImg').click(function(e) {

        $('button[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            // var target = $(e.target).attr("href") // activated tab
            alert("target");
        }); 
        e.preventDefault();
        if (mediaUploader) {
            $("#menu-item-upload").html("Télécharger des fichiers");
            $("#menu-item-browse").html("Galerie de photos");
            $("#menu-item-upload").insertAfter('#menu-item-browse')
            
            $("#menu-item-browse").click();
            $("#menu-item-browse").css("display","block");
            $(".media-uploader-status .h2").html("Téléchargement");

            
            $("#menu-item-upload").click(function(e) {
                $("h2.upload-instructions").text("Déposez vos fichiers pour les télécharger");
                $("p.max-upload-size").text("Taille de fichier maximale pour le téléchargement : 8 Mo.");
                $(".media-uploader-status .h2").html("Téléchargement");
            });
            mediaUploader.open();
            return;
        }

        mediaUploader = wp.media.frames.file_frame = wp.media({
            multiple: false
        });
        mediaUploader.on('select', function() {

            var attachment = mediaUploader.state().get('selection').first().toJSON();
            
            if ($('.blc-cagnotte').length) {
                $('#url_img_cagnotte').val(attachment.url).addClass('filled');
            }
            if ($('.parametreCagnotte').length) {
                $('#url_img_cagnotte').val(attachment.url);
            }

            $('.zone-img .inputfile + label').addClass('no-bg');

            getMeta(
                $('#url_img_cagnotte').val(),
                function(width, height) {
                    if (width > 200 && height > 190) {
                        if (width >= height) {
                            $('.zone-img').css('background', 'center / auto no-repeat #875296 url(' + $('#url_img_cagnotte').val() + ')');
                        } else {
                            $('.zone-img').css('background', 'center / auto no-repeat #875296 url(' + $('#url_img_cagnotte').val() + ')');
                        }
                    }
                }
            );

        });
        mediaUploader.open();

        $("#menu-item-upload").html("Télécharger des fichiers");
        $("#menu-item-browse").html("Galerie de photos");
        $("#menu-item-upload").insertAfter('#menu-item-browse')
        $(".media-uploader-status .h2").html("Téléchargement");
         
        $("#menu-item-browse").click();

        $("#menu-item-upload").click(function(e) {
            $("h2.upload-instructions").text("Déposez vos fichiers pour les télécharger");
            $("p.max-upload-size").text("Taille de fichier maximale pour le téléchargement : 8 Mo.");
            $(".media-uploader-status .h2").html("Téléchargement");
        });
    });
    function getMeta(url, callback) {
        var img = new Image();
        img.src = url;
        img.onload = function() {
            callback(this.width, this.height);
        }
    }


    var exist = $('#slider-range-min').length
    if (exist) {
        $("#slider-range-min").slider({
            value: 20,
            orientation: "horizontal",
            range: "min",
            animate: true,
            step: 20,
            disabled: true,
            change: function(ev, ui) {
                var newVal = $("#slider-range-min").slider('value');
                $('#pourcentage')
                    .text(newVal + '%')
                    .css({
                        'width': newVal + '%'
                    });
            }
        });
    }

    // auto remplissage jauge cagnotte
    $('#nom_cagnotte').change(function() {
        if ($(this).val()) {
            $('#nom_cagnotte').addClass('filled');
        } else {
            $('#nom_cagnotte').removeClass('filled');
        }
    });
    $('#nom_benef').change(function() {
        if ($(this).val()) {
            $('#nom_benef').addClass('filled');
        } else {
            $('#nom_benef').removeClass('filled');
        }
    });
    $('#description_cagnotte').change(function() {
        if ($(this).val()) {
            $('#description_cagnotte').addClass('filled');
        } else {
            $('#description_cagnotte').removeClass('filled');
        }
    });

    /* date picker creer cagnotte*/
    $("#datepicker_debut").datepicker({
        minDate: 0,
        dateFormat: 'dd-mm-yy',
        firstDay: 1,
        closeText: 'Fermer',
        prevText: 'Précédent',
        nextText: 'Suivant',
        currentText: 'Aujourd\'hui',
        monthNames: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'],
        monthNamesShort: ['Janv.', 'Févr.', 'Mars', 'Avril', 'Mai', 'Juin', 'Juil.', 'Août', 'Sept.', 'Oct.', 'Nov.', 'Déc.'],
        dayNames: ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'],
        dayNamesShort: ['Dim.', 'Lun.', 'Mar.', 'Mer.', 'Jeu.', 'Ven.', 'Sam.'],
        dayNamesMin: ['D', 'L', 'M', 'M', 'J', 'V', 'S'],
        weekHeader: 'Sem.',
        onClose: function(selectedDate) {
            if ($(this).val()) {
                $('.debut_cagnotte').addClass('filled');
            } else {
                $('.debut_cagnotte').removeClass('filled');
            }
            $('#datepicker').datepicker("option", "minDate", selectedDate);

        }

    }).datepicker("setDate", new Date());

    $('#datepicker').datepicker({
        dateFormat: 'dd-mm-yy',
        firstDay: 1,
        closeText: 'Fermer',
        prevText: 'Précédent',
        nextText: 'Suivant',
        currentText: 'Aujourd\'hui',
        monthNames: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'],
        monthNamesShort: ['Janv.', 'Févr.', 'Mars', 'Avril', 'Mai', 'Juin', 'Juil.', 'Août', 'Sept.', 'Oct.', 'Nov.', 'Déc.'],
        dayNames: ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'],
        dayNamesShort: ['Dim.', 'Lun.', 'Mar.', 'Mer.', 'Jeu.', 'Ven.', 'Sam.'],
        dayNamesMin: ['D', 'L', 'M', 'M', 'J', 'V', 'S'],
        weekHeader: 'Sem.',
    });

    /* datepicker parametre cagnotte */
    $("#datepicker_debut_param").datepicker({
        minDate: 0,
        dateFormat: 'dd-mm-yy',
        firstDay: 1,
        closeText: 'Fermer',
        prevText: 'Précédent',
        nextText: 'Suivant',
        currentText: 'Aujourd\'hui',
        monthNames: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'],
        monthNamesShort: ['Janv.', 'Févr.', 'Mars', 'Avril', 'Mai', 'Juin', 'Juil.', 'Août', 'Sept.', 'Oct.', 'Nov.', 'Déc.'],
        dayNames: ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'],
        dayNamesShort: ['Dim.', 'Lun.', 'Mar.', 'Mer.', 'Jeu.', 'Ven.', 'Sam.'],
        dayNamesMin: ['D', 'L', 'M', 'M', 'J', 'V', 'S'],
        weekHeader: 'Sem.',
        onClose: function(selectedDate) {
            $('#datepicker_fin_param').datepicker("option", "minDate", selectedDate);
        }
    });

    $('#datepicker_fin_param').datepicker({
        dateFormat: 'dd-mm-yy',
        firstDay: 1,
        closeText: 'Fermer',
        prevText: 'Précédent',
        nextText: 'Suivant',
        currentText: 'Aujourd\'hui',
        monthNames: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'],
        monthNamesShort: ['Janv.', 'Févr.', 'Mars', 'Avril', 'Mai', 'Juin', 'Juil.', 'Août', 'Sept.', 'Oct.', 'Nov.', 'Déc.'],
        dayNames: ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'],
        dayNamesShort: ['Dim.', 'Lun.', 'Mar.', 'Mer.', 'Jeu.', 'Ven.', 'Sam.'],
        dayNamesMin: ['D', 'L', 'M', 'M', 'J', 'V', 'S'],
        weekHeader: 'Sem.',
    });

    $(".lst-choix-cond-part .item .content").click(function() {

        $(this).find('input[type=text]').focus();
    });

    // focus montants -- créer cagnote
    /*
    $('#montant_conseille').focusout(function() {
        $(this).removeClass('has-focus');
    });
    */
    $('#montant_conseille').focus(function() {
        $(this).addClass('has-focus');
    });
    /*
    $('#montant_fixe').focusout(function() {
        $(this).removeClass('has-focus');
    });
    */
    $('#montant_fixe').focus(function() {
        $(this).addClass('has-focus');
    });

    $('#estLimite').on('change', function() {
        $('#limite_cagnotte').toggleClass('disabled');
        $('#choix-devise').toggleClass('disabled');
    })

    /* menu connecté */
    $('.btn-head.logged-in').mouseenter(function() {
        $('#sous-menu-connecte').slideDown();
        return false;
    });

    $('.btn-head.logged-in').mouseleave(function() {
        $('#sous-menu-connecte').slideUp();
        return false;
    });

    /* end menu connecté */
    
    setInterval(function() {
        var cat = $('.lst-form-type.jauge').find('.active').length;
        if (cat) {
            $('.lst-form-type.jauge').addClass('filled');
        } else {
            $('.lst-form-type.jauge').removeClass('filled');
        }

        if ($('#estLimite').val() == "true") {
            $('#estLimite').removeClass('filled');
            $('#limite_cagnotte').change(function() {
                if ($(this).val()) {
                    $('#limite_cagnotte').addClass('filled');
                } else {
                    $('#limite_cagnotte').removeClass('filled');
                }
            });
        } else {
            $('#estLimite').addClass('filled');
        }

        var done = $('.filled').length;
        switch (done) {

            case 3:
                $("#slider-range-min").slider({
                    value: 40
                });
                break;
            case 4:
            case 5:
                $("#slider-range-min").slider({
                    value: 60
                });
                break;
            case 6:
                $("#slider-range-min").slider({
                    value: 80
                });
                break;

            case 7:
                $("#slider-range-min").slider({
                    value: 100
                });
                break;
            default:
                $("#slider-range-min").slider({
                    value: 20
                });
                break;

        }

    }, 800);

    $('.lst-img .img a').click(function() {
        $(this).parent().siblings().removeClass('selected-img');
        $(this).parent().toggleClass('selected-img');
        // $('#fileImg').trigger('click');
        var src = $(this).data('imgsrc');
        $('#url_img_cagnotte').val(src);

        setTimeout(function(args) {
            $('.zone-img').css('background', 'center / cover no-repeat url(' + $('#url_img_cagnotte').val() + ')');
            $('.zone-img .inputfile + label').addClass('no-bg');
            $("label.no-bg").html("Changer<br>votre photo");
        }, 500);
        return false;
    });

    $('#estLimite').on('change', function() {
        var enableInput = $(this).val();
        if (enableInput == 'false') {
            $('#limite_cagnotte').attr('disabled', true);
        } else {
            $('#limite_cagnotte').attr('disabled', false);
        }
    });

    //gestion cagnotte
    $('#relative.content-comment').hover(function() {
        $(this).find('.delete').toggleClass('show');
    });
    $('#relative.liste-message .item').hover(function() {
        $(this).find('.delete').toggleClass('show');
    });

    // edit question pour les tompomny
    $('.edit a').click(function() {
        var id = $(this).data('edit');

        var ancienne_question = $(this).parent().siblings('.txt').text();

        $(this).parents('.listComment').addClass('editing');

        $('#la-question').val($.trim(ancienne_question)).focus();
        $('#add-question').hide();
        $('#edit-question').show();
        return false;
    });

    if ($('#emails_list').length) {
        $('#emails_list').email_multiple({
            data: ''
        })
    }

    //upload image cagnotte
    var mediaUploader;
    $('#pdp-btn').click(function(e) {
        e.preventDefault();
        if (mediaUploader) {
            $("#menu-item-upload").html("Télécharger des fichiers");
            $("#menu-item-browse").html("Galerie de photos");
            $("#menu-item-upload").insertAfter('#menu-item-browse')
            
            $("#menu-item-browse").click();
            $("#menu-item-browse").css("display","block");
            $(".media-uploader-status .h2").html("Téléchargement");

            $("#menu-item-upload").click(function(e) {
                $("h2.upload-instructions").text("Déposez vos fichiers pour les télécharger");
                $("p.max-upload-size").text("Taille de fichier maximale pour le téléchargement : 8 Mo.");
                $(".media-uploader-status .h2").html("Téléchargement");
            });
            mediaUploader.open();
            return;
        }
        mediaUploader = wp.media.frames.file_frame = wp.media({
            multiple: false
        });
        mediaUploader.on('select', function() {
            var attachment = mediaUploader.state().get('selection').first().toJSON();

            $('#pdp').val(attachment.url);
            $('.zone-img').css('background', 'center / cover no-repeat url(' + $('#pdp').val() + ')');
            $('.zone-img .inputfile + label').addClass('no-bg');
        });
        mediaUploader.open();
        $("#menu-item-upload").html("Télécharger des fichiers");
        $("#menu-item-browse").html("Galerie de photos");
        $("#menu-item-upload").insertAfter('#menu-item-browse')
        $(".media-uploader-status .h2").html("Téléchargement");
         
        $("#menu-item-browse").click();

        $("#menu-item-upload").click(function(e) {
            $("h2.upload-instructions").text("Déposez vos fichiers pour les télécharger");
            $("p.max-upload-size").text("Taille de fichier maximale pour le téléchargement : 8 Mo.");
            $(".media-uploader-status .h2").html("Téléchargement");
        });
    });
    $('#cin_btn').click(function(e) {
        e.preventDefault();
        if (mediaUploader) {
            $("#menu-item-upload").html("Télécharger");
            $("#menu-item-upload").click();
            $("#menu-item-browse").css("display","none");
            $(".media-uploader-status .h2").html("Téléchargement");
            $("h2.upload-instructions").text("Déposez vos fichiers pour les télécharger");
            $("p.max-upload-size").text("Taille de fichier maximale pour le téléchargement : 8 Mo.");
            mediaUploader.open();
            return;
        }
        mediaUploader = wp.media.frames.file_frame = wp.media({
            multiple: false
        });
        mediaUploader.on('select', function() {
            var attachment = mediaUploader.state().get('selection').first().toJSON();
            $('#cin_value').val(attachment.url);
            $('.zone-img-cin').css('background', 'center / cover no-repeat url(' + $('#cin_value').val() + ')');
            $('#cin_value').siblings('span').text(attachment.filename);
        });
        mediaUploader.open();
        $("#menu-item-upload").html("Télécharger");
        $("#menu-item-upload").click();
        $("#menu-item-browse").css("display","none");
        $(".media-uploader-status .h2").html("Téléchargement");
        $("h2.upload-instructions").text("Déposez vos fichiers pour les télécharger");
        $("p.max-upload-size").text("Taille de fichier maximale pour le téléchargement : 8 Mo.");
    });
    $('#rib_btn').click(function(e) {
        e.preventDefault();
        if (mediaUploader) {
            $("#menu-item-upload").html("Télécharger");
            $("#menu-item-upload").click();
            $("#menu-item-browse").css("display","none");
            $(".media-uploader-status .h2").html("Téléchargement");
            $("h2.upload-instructions").text("Déposez vos fichiers pour les télécharger");
            $("p.max-upload-size").text("Taille de fichier maximale pour le téléchargement : 8 Mo.");
            mediaUploader.open();
            return;
        }
        mediaUploader = wp.media.frames.file_frame = wp.media({
            multiple: false
        });
        mediaUploader.on('select', function() {
            var attachment = mediaUploader.state().get('selection').first().toJSON();
            $('#rib_value').val(attachment.id);
            $('#rib_value').siblings('span').text(attachment.filename);
        });
        mediaUploader.open();
        $("#menu-item-upload").html("Télécharger");
        $("#menu-item-upload").click();
        $("#menu-item-browse").css("display","none");
        $(".media-uploader-status .h2").html("Téléchargement");
        $("h2.upload-instructions").text("Déposez vos fichiers pour les télécharger");
        $("p.max-upload-size").text("Taille de fichier maximale pour le téléchargement : 8 Mo.");
    });

    $('#add_doc_btn').click(function(e) {
        e.preventDefault();
        if (mediaUploader) {
            $("#menu-item-upload").html("Télécharger");
            $("#menu-item-upload").click();
            $("#menu-item-browse").css("display","none");
            $(".media-uploader-status .h2").html("Téléchargement");
            $("h2.upload-instructions").text("Déposez vos fichiers pour les télécharger");
            $("p.max-upload-size").text("Taille de fichier maximale pour le téléchargement : 8 Mo.");
            mediaUploader.open();
            return;
        }
        mediaUploader = wp.media.frames.file_frame = wp.media({
            multiple: false
        });
        mediaUploader.on('select', function() {
            var attachment = mediaUploader.state().get('selection').first().toJSON();
            $('#cin_value').val(attachment.url);
            $('.zone-img-cin').css('background', 'center / cover no-repeat url(' + $('#cin_value').val() + ')');
            $('#cin_value').siblings('span').text(attachment.filename);
        });
        mediaUploader.open();
        $("#menu-item-upload").html("Télécharger");
        $("#menu-item-upload").click();
        $("#menu-item-browse").css("display","none");
        $(".media-uploader-status .h2").html("Téléchargement");
        $("h2.upload-instructions").text("Déposez vos fichiers pour les télécharger");
        $("p.max-upload-size").text("Taille de fichier maximale pour le téléchargement : 8 Mo.");
    });

    $('.signup-date-birth').datepicker({
        dateFormat: 'dd-mm-yy',
        changeMonth: true,
        changeYear: true,
        maxDate: '-18y',
        yearRange: '1940:2002',
        firstDay: 1,
        firstDay: 1,
        closeText: 'Fermer',
        prevText: 'Précédent',
        nextText: 'Suivant',
        currentText: 'Aujourd\'hui',
        monthNames: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'],
        monthNamesShort: ['Janv.', 'Févr.', 'Mars', 'Avril', 'Mai', 'Juin', 'Juil.', 'Août', 'Sept.', 'Oct.', 'Nov.', 'Déc.'],
        dayNames: ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'],
        dayNamesShort: ['Dim.', 'Lun.', 'Mar.', 'Mer.', 'Jeu.', 'Ven.', 'Sam.'],
        dayNamesMin: ['D', 'L', 'M', 'M', 'J', 'V', 'S'],
        weekHeader: 'Sem.',
    });

    // change_placeholder($('#montant_fixe'), 'chacun donne… ce que tu veux');
    // change_placeholder($('#montant_conseille'), 'chacun donne ce qu’il veut…mais tu conseilles un montant');
    /*
    function change_placeholder(id, original_ph) {
        id.focusin(function() {
            $(this).attr('placeholder', 'saisir un montant');
        });
        id.focusout(function() {
            $(this).attr('placeholder', original_ph);
        });
    }
    */

    function numStr(a, b) {
        a = '' + a;
        b = b || ' ';
        var c = '',
            d = 0;
        while (a.match(/^0[0-9]/)) {
            a = a.substr(1);
        }
        for (var i = a.length - 1; i >= 0; i--) {
            c = (d != 0 && d % 3 == 0) ? a[i] + b + c : a[i] + c;
            d++;
        }
        return c;
    }

    $('.format_chiffre').each(function() {
        var $this = $(this);
        var montant_brut = $this.text();
        $this.text(numStr(montant_brut, ' '));
    });

    // tonga d trigger click fa tsy mila mijer anlé page intermédiaire io
    if ($('#payment-page:visible').length) {
        $('#go-paypal').trigger('click');
    }

    if ($('#payment-om:visible').length) {
        $('#go-om').trigger('click');
    }

    $('.close-fancy').on('click', function() {
        $.fancybox.close();
        return false;
    })

    if( $('.participation #phone:visible').length > 0 ){
        var input = document.querySelector("#phone"),
        errorMsg = document.querySelector("#error-msg"),
        validMsg = document.querySelector("#valid-msg");

        // var errorMap = ["Invalid number", "Invalid country code", "Too short", "Too long", "Invalid number"];

        var iti = window.intlTelInput(input, {
            initialCountry: $("#code").val(),
            customPlaceholder: function(selectedCountryPlaceholder, selectedCountryData) {
                return "";
            },
            separateDialCode: true,
            geoIpLookup: function(callback) {
                $.get('https://ipinfo.io', function() {}, "jsonp").always(function(resp) {
                  var countryCode = (resp && resp.country) ? resp.country : "mg";
                  callback(countryCode);
            });
            },
            preferredCountries: ["mg","fr"],
            utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js"
        });


        var reset = function() {
          input.classList.remove("error");
          errorMsg.innerHTML = "";
          errorMsg.classList.add("hide");
          validMsg.classList.add("hide");

        };

        // on blur: validate
        input.addEventListener('blur', function() {
          reset();
          if (input.value.trim()) {
            if (iti.isValidNumber()) {
              validMsg.classList.remove("hide");
            } else {
              input.classList.add("error");
              var errorCode = iti.getValidationError();
              errorMsg.innerHTML = "✗";
              errorMsg.classList.remove("hide");
            }
          }
        });

        // on keyup / change flag: reset
        input.addEventListener('change', reset);
        input.addEventListener('keyup', reset);
    }


    if( $('#tel:visible').length > 0 ){
        var input = document.querySelector("#tel"),
        errorMsg = document.querySelector("#error-msg"),
        validMsg = document.querySelector("#valid-msg");

        var iti = window.intlTelInput(input, {
            initialCountry: $("#code").val(),
            separateDialCode: true,
            geoIpLookup: function(callback) {
                $.get('https://ipinfo.io', function() {}, "jsonp").always(function(resp) {
                  var countryCode = (resp && resp.country) ? resp.country : "mg";
                  callback(countryCode);
            });
            },
            preferredCountries: ["mg","fr"],
            utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js"
        });

        var reset = function() {
          input.classList.remove("error");
          errorMsg.innerHTML = "";
          errorMsg.classList.add("hide");
          validMsg.classList.add("hide");
        };

        // on blur: validate
        input.addEventListener('blur', function() {
          reset();
          if (input.value.trim()) {
            if (iti.isValidNumber()) {
              validMsg.classList.remove("hide");
            } else {
              input.classList.add("error");
              var errorCode = iti.getValidationError();
              errorMsg.innerHTML = "✗";
              errorMsg.classList.remove("hide");
            }
          }
        });

        // on keyup / change flag: reset
        input.addEventListener('change', reset);
        input.addEventListener('keyup', reset);
    }
    $(".iti__country").click(function(e) {
        $("#code").val($(this).attr("data-country-code"));
    });
    
    $(".onoff").on('change', function() {
        //togBtn= $(this);
        //togBtn.val(togBtn.prop('checked'));
        if ($(this).is(':checked')) {
            $(this).attr('checked','checked');
            $(this).val('on');
        }
        else {
           $(this).removeAttr('checked');
            $(this).val('off');
        }
    });
});


// $( window ).load(function() {
//     /* menu connecté */
//     $('.btn-head.logged-in').hover(function() {
//         $('#sous-menu-connecte').slideToggle();
//         return false;
//     });

    
// });
