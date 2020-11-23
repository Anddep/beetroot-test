
$( document ).ready(function() {

    //hover menu
    $( ".header-menu ul li a" ).hover(
        function() {
            $( this ).addClass( "hover" );
            $( '.header-menu' ).addClass( "hover" );
        }, function() {
            $( this ).removeClass( "hover" );
            $( '.header-menu' ).removeClass( "hover" );
        }
    );
    //mobile menu
    $( ".open-menu" ).click(function() {
        $('.header-menu').addClass('show');
        $('body').addClass('no-scroll');
    });
    $( ".close-menu" ).click(function() {
        $('.header-menu').removeClass('show');
        $('body').removeClass('no-scroll');
    });

    //change view list
    $( ".sort-view-btn" ).click(function() {
        let typeVIew = $( this ).attr('id');
        $('.hotel-list').removeClass().addClass('hotel-list ' + typeVIew);
        $( ".sort-view-btn" ).removeClass('active');
        $(this).addClass('active');
    });

    //open filter on mobile
    $(".open-filter").click(function(){
        $(this).toggleClass('open');
        $(".hotel-filter").slideToggle({
            duration: 'fast',
            step: function() {
                if ($(".hotel-filter").css('display') == 'block') {
                    $(".hotel-filter").css('display', 'flex');
                }
            },
            complete: function() {
                if ($(".hotel-filter").css('display') == 'block') {
                    $(".hotel-filter").css('display', 'flex');
                }
            }
        });
    });

});