jQuery(document).ready(function($) {

    if( $('body').hasClass('tour-page') ){
        if( window.error_str && window.status_str ) {

            $('#gratitude-popup h5').text( '' );
            //$('#gratitude-popup p').html( window.error_str + '<br>' + window.status_str);
            $('#gratitude-popup p').text( window.status_str);
            $.fancybox.open('#gratitude-popup', {
                padding:0
            });
        }
    }

    if( $('body').hasClass('transfer-page') ) {
        $('input[name*=time]').inputmask("h:s",{ autoUnmask:true });
    }

    $(".buy-now").on('click', function(){
        var popup = $(this).attr('href'),
            id = $(this).data('id');

        $(popup).find('input[name=postid]').val(id);

    });

    $('.buy-click_pro').click(function(e) {
        e.preventDefault();
        $.fancybox.open({
            padding:0,
            wrapCSS:"buy-popup-wrapper",
            scrolling:"no",
            href: myAjax.ajaxurl,
            type: "ajax",
            ajax: {
                type: "POST",
                data: {
                    'action' : 'tour_popup',
                    'id' : $(this).data('id'),
                }
            },
            beforeShow: function() {
                $('.fancybox-type-ajax .buy-form-popup .buy-form-dates').selectmenu({
                    classes:{
                        "ui-selectmenu-button":"buy-date-button",
                        "ui-selectmenu-menu":"buy-date-selector"
                    }
                })
            }
        });
    });

    $('.buy-now_pro').click(function(e) {
        e.preventDefault();
        $.fancybox.open({
            padding:0,
            wrapCSS:"buy-popup-wrapper",
            scrolling:"no",
            href: myAjax.ajaxurl,
            type: "ajax",
            ajax: {
                type: "POST",
                data: {
                    'action' : 'tour_now_popup',
                    'id' : $(this).data('id'),
                }
            },
            beforeShow: function() {
                $('.fancybox-type-ajax .buy-form-popup .buy-form-dates').selectmenu({
                    classes:{
                        "ui-selectmenu-button":"buy-date-button",
                        "ui-selectmenu-menu":"buy-date-selector"
                    }
                })
            }
        });
    });

    if( $('#more_post').length > 0 ) {

        $('body').on('click', '#more_post', function(e){
            e.preventDefault();

            var btn = $(this);

            btn.parent().find('.loader-container').css({ 'display' : 'block' });

            $.ajax({
                url: btn.attr('href'),
                type: 'POST',
                success: function( str ){
                    var tempDom = $('<output>').append($.parseHTML(str)),
                        appContainer = $('.products-list > div', tempDom),
                        appPagination = $('#pagination', tempDom);

                    $('.products-list').append(appContainer);
                    $(".products-list").html($(".products-list").html());
                    
                    $('#pagination').replaceWith(appPagination);
                    $("#pagination").html($("#pagination").html());

                    btn.parent().find('.loader-container').css({ 'display' : 'none' });
                },
                error: function(response) {
                    alert('shit happens');
                }
            });
        });

    }


    function formSuccess( data ) {
        $('.loading').removeClass('loading');
        $('form').find('input:not([type="submit"], [type="hidden"]), input[type="file"], textarea').val('');

        $('form .delete-wrap').css({'display': 'none'});
        $('form .file-upload').css({'display': 'block'});

        $('#gratitude-popup h5').text( data.title );
        $('#gratitude-popup p').text( data.text );
        $.fancybox.open('#gratitude-popup', {
            padding:0
        });

    }
    function formError( data, form ) {
        $('.loading').removeClass('loading');


        for( var field in data.errors ){
            if(data.errors.hasOwnProperty(field)){
                form.find('[name="'+ field +'"]').addClass('-error');//.append('<em>'+ data.errors[field] +'</em>');
                if( field == 'file' ){
                    form.find('[name="'+ field +'"]').closest('.file-upload').after('<div class="clearfix"></div><em>'+ data.errors[field] +'</em>');
                }
            }
        }
    }
    function formSubmit( form, wp_action ) {
        var $form = form,
            $btn = $form.find('*[type=submit]');

        $('form em').remove();
        $('.-error').removeClass('-error');

        var formData = new FormData($form[0]);

        formData.append('action', wp_action);

        $btn.addClass('loading');

        $.ajax({
            url: myAjax.ajaxurl,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response){
                $btn.removeClass('loading');

                //console.log(response);

                if(response.success) {
                    if( response.data.formUrl ) {
                        window.location.href = response.data.formUrl;
                    } else {
                        formSuccess( response.data );
                        $btn.removeClass('loading');
                    }

                } else {
                    formError( response.data, $form );
                    $btn.removeClass('loading');
                }


            },
            error: function(response) {
                alert('shit happens');
            }
        });
    }


    $('#transfer-form').submit(function(e){
        e.preventDefault();
        formSubmit( $(this), 'transfer_mail' );
    });

    $('#buy-ticket-form').submit(function(e){
        e.preventDefault();

        formSubmit( $(this), 'ticket_mail' );

    });

    $('body').on("submit", '.by_tour_one_click', function(e) {
        e.preventDefault();
        formSubmit( $(this), 'tour_mail' );

    });
    
    $('.tour-price-go-to').on('click', function(e){
        e.preventDefault();
        var href = this.hash;
      
      $('html, body').animate({
        scrollTop: $(href).offset().top - 100
      }, 1000);
    });

    $('.buy-ticket.buy-click_pro').off('click').on('click', function(e) {
        e.preventDefault();
        var $btn = $(this);
        $.fancybox.open('#buy-ticket-popup', {
            padding: 0,
            wrapCSS: 'buy-popup-wrapper',
            scrolling: 'no',
            beforeShow: function(){
                var $popup =  $(this.content[0]);
                $popup.find('input[name=postid]').val($btn.data('id'));
            }
        });
    });
    
    $('#buy-ticket-popup form').on('submit', function(event){
        event.preventDefault();
        var $this = $(this);
        var data = $this.serializeArray();
        data.push({name: 'action', value: 'ticket_mail'});
        $.ajax(myAjax.ajaxurl, {
            type: 'post',
            data: data,
            success: function(response){
                if(response.success) {
                    if( response.data.formUrl ) {
                        window.location.href = response.data.formUrl;
                        // formSuccess( response.data );
                    }
                } else {
                    formError( response.data, $this );
                }
                
            },
            error: function(error){ console.error(error); }
        })
    });

    $('.buy-tour.buy-click_pro').off('click').on('click', function(e) {
        e.preventDefault();
        var $btn = $(this);
        $.fancybox.open('#buy-1-click-form-popup', {
            padding:0,
            wrapCSS:"buy-popup-wrapper",
            scrolling:"no",
            beforeShow: function() {
                var $popup =  $(this.content[0]);
                $popup.find('input[name=postid]').val($btn.data('id'));
            }
        });
    });

    $('#buy-1-click-form-popup form').on('submit', function(event){
        event.preventDefault();
        var $this = $(this);
        var data = $this.serializeArray();
        data.push({name: 'action', value: 'tour_mail'});
        $.ajax(myAjax.ajaxurl, {
            type: 'post',
            data: data,
            success: function(response){
                if(response.success) {
                    if( response.data.formUrl ) {
                        window.location.href = response.data.formUrl;
                        // formSuccess( response.data );
                    }
                } else {
                    formError( response.data, $this );
                }

            },
            error: function(error){ console.error(error); }
        })
    });
});
