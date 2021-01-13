
jQuery( document ).ready(function($) {

    //global var
    let getUrl = getSearchformParametr();

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



    //search
    $("#search-btn").click(function(e){
        e.preventDefault();
        getUrl = getSearchformParametr();
        sendRequest(getUrl, true);
    });
    //change  filter
    let filterParametrAmenities = [];
    let filterParametrExtras = [];
    let filterParametrAccessibility = [];
    let filterParametrBedroom = [];
    let filterParametrType  = [];
    $(".filter-checkbox").change(function(e){
        e.preventDefault();
        if ($(this).attr("data-tax") === 'amenities'){
            if (filterParametrAmenities.includes($(this).attr("data-tax-slug")) ) {
                filterParametrAmenities = filterParametrAmenities.filter(e => e !== $(this).attr("data-tax-slug"));
            } else {
                filterParametrAmenities.push($(this).attr("data-tax-slug"));
            }
        } else if ($(this).attr("data-tax") === 'extras'){
            if (filterParametrExtras.includes($(this).attr("data-tax-slug")) ) {
                filterParametrExtras = filterParametrExtras.filter(e => e !== $(this).attr("data-tax-slug"));
            } else {
                filterParametrExtras.push($(this).attr("data-tax-slug"));
            }
        } else if ($(this).attr("data-tax") === 'accessibility'){
            if (filterParametrAccessibility.includes($(this).attr("data-tax-slug")) ) {
                filterParametrAccessibility = filterParametrAccessibility.filter(e => e !== $(this).attr("data-tax-slug"));
            } else {
                filterParametrAccessibility.push($(this).attr("data-tax-slug"));
            }
        } else if ($(this).attr("data-tax") === 'bedroom-features'){
            if (filterParametrBedroom.includes($(this).attr("data-tax-slug")) ) {
                filterParametrBedroom = filterParametrBedroom.filter(e => e !== $(this).attr("data-tax-slug"));
            } else {
                filterParametrBedroom.push($(this).attr("data-tax-slug"));
            }
        } else if ($(this).attr("data-tax") === 'property-type'){
            if (filterParametrType.includes($(this).attr("data-tax-slug")) ) {
                filterParametrType = filterParametrType.filter(e => e !== $(this).attr("data-tax-slug"));
            } else {
                filterParametrType.push($(this).attr("data-tax-slug"));
            }
        }


        getUrl = getSearchformParametr() + '&amenities=' + filterParametrAmenities.join(",") + '&extras=' + filterParametrExtras.join(",") + '&accessibility=' + filterParametrAccessibility.join(",") + '&bedroom=' + filterParametrBedroom.join(",") + '&type=' + filterParametrType.join(",");
        sendRequest(getUrl, true);


    });

    //pagination click
    $(document).on('click', '.pagination li a', function (e) {
        e.preventDefault();
        $('.pagination li').removeClass('active');
        $(e.target).parent().addClass('active');
        let pageNo = $(e.target).text();
        getUrl += '&page='+pageNo;
        console.log(getUrl);
        sendRequest(getUrl, false);


    });




    function getSearchformParametr() {
        let where = $('#where-field').val();
        let checkIn = $('#check-in-field').val();
        let checkOut = $('#check-out-field').val();
        let guest = $('#guests-field').val() === null ? '' : $('#guests-field').val();

        return siteUrl + '/wp-json/api/v1/property?where=' + where + '&in=' + checkIn + '&out=' + checkOut + '&guest=' + guest;

    }

    function sendRequest(url, isPaginationGenerated) {
        console.log(url);

        $.ajax({
            url: url,
            type: 'GET',
            success: function (data) {
                if (data) {
                    console.log(data);
                    generateItems(data);
                    if (isPaginationGenerated){
                        generatePagination(data.total)
                    }
                } else {
                    $('.hotel-list').empty();
                    $('.pagination-wrap').empty();
                    $('.hotel-list').append(`<div class="search-error">Narrow your search</div>`);
                }
            }
        });
    }

    function generateItems(data){
        $('.hotel-list').empty();
        data.items.forEach((item) => {
            item.thumbnail = item.thumbnail ? item.thumbnail : '';
            item.author.image = item.author.image ? item.author.image : '';
            $('.hotel-list').append(`
            <div class="hotel-item">
                <a href="`+item.link+`" class="img-wrap">
                    <img src="`+item.thumbnail+`">
                    <div class="price">$`+item.price+` / Night</div>
                </a>
                <div class="info-wrap">
                    <a href="`+item.location.link+`" class="location"><i class="fa fa-map-marker" aria-hidden="true"></i> `+item.location.name+` </a>
                    <div class="hotel-attributes">
                        <div class="attribute"><i class="fa fa-bed" aria-hidden="true"></i><span>`+item.rooms.all+`</span></div>
                        <div class="attribute"><i class="fa fa-bath" aria-hidden="true"></i><span>`+item.rooms.bedrooms+`</span></div>
                        <div class="attribute"><i class="fa fa-television" aria-hidden="true"></i><span>`+item.rooms.bathrooms+`</span></div>
                        <div class="attribute"><i class="fa fa-square-o" aria-hidden="true"></i><span>`+item.rooms.square+`</span></div>
                    </div>
                    <div class="author-wrap">
                        <img class="author-img" src="`+item.author.image+`">
                        <div class="author-info-wrap">
                            <div class="name">`+item.author.name+`</div>
                            <div class="date">`+item.date+`</div>
                        </div>
                    </div>
                    <div class="action">
                        <a href="" class="save-btn"><i class="fa fa-star" aria-hidden="true"></i> Save</a>
                        <a href="`+item.link+`" class="details-btn">Details</a>
                    </div>
                    <div class="description">`+item.description+`</div>
                </div>
            </div>
        `);
        });


    }

    function generatePagination(totalItems) {
        let numberOfPage = Math.ceil(totalItems / 2);
        $(".pagination").html('');
        if (numberOfPage > 1) {
            for (let i = 1; i <= numberOfPage; i++) {
                $(".pagination").append(`<li><a  href="" data-page="` + i + `">` + i + `</a></li>`);
            }
            $(".pagination li:first-child").addClass('active');
        }
    }




});