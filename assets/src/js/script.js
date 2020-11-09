$( ".header-menu ul li a" ).hover(
    function() {
        $( this ).addClass( "hover" );
        $( '.header-menu' ).addClass( "hover" );
    }, function() {
        $( this ).removeClass( "hover" );
        $( '.header-menu' ).removeClass( "hover" );
    }
);