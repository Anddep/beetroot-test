/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ 187:
/***/ (() => {



jQuery(document).ready(function ($) {
  //global var
  var API_PATH = siteUrl + '/wp-json/api/v1/property?';
  var getUrl;
  var objParameterUrl = {
    page: null,
    posts_per_page: null,
    order: 'date',
    where: '',
    "in": '',
    out: '',
    guest: '',
    amenities: '',
    extras: '',
    accessibility: '',
    bedroom: '',
    type: ''
  };
  getSearchFormParametr(); //hover menu

  $(".header-menu ul li a").hover(function () {
    $(this).addClass("hover");
    $('.header-menu').addClass("hover");
  }, function () {
    $(this).removeClass("hover");
    $('.header-menu').removeClass("hover");
  }); //mobile menu

  $(".open-menu").click(function () {
    $('.header-menu').addClass('show');
    $('body').addClass('no-scroll');
  });
  $(".close-menu").click(function () {
    $('.header-menu').removeClass('show');
    $('body').removeClass('no-scroll');
  }); //change view list

  $(".sort-view-btn").click(function () {
    var typeVIew = $(this).attr('id');
    $('.hotel-list').removeClass().addClass('hotel-list ' + typeVIew);
    $(".sort-view-btn").removeClass('active');
    $(this).addClass('active');
  }); //open filter on mobile

  $(".open-filter").click(function () {
    $(this).toggleClass('open');
    $(".hotel-filter").slideToggle({
      duration: 'fast',
      step: function step() {
        if ($(".hotel-filter").css('display') == 'block') {
          $(".hotel-filter").css('display', 'flex');
        }
      },
      complete: function complete() {
        if ($(".hotel-filter").css('display') == 'block') {
          $(".hotel-filter").css('display', 'flex');
        }
      }
    });
  }); //search form

  $("#search-btn").click(function (e) {
    e.preventDefault();
    objParameterUrl.page = '';
    getSearchFormParametr();
    sendRequest(objParameterUrl, true);
  }); //show count

  $('#sort-count-select').on('change', function () {
    objParameterUrl.posts_per_page = parseInt(this.value);
    objParameterUrl.page = '';
    sendRequest(objParameterUrl, true);
  }); //change ordering

  $('#sort-filter-select').on('change', function () {
    objParameterUrl.order = this.value;
    objParameterUrl.page = '';
    sendRequest(objParameterUrl, true);
  }); //change  filter

  $('input:checkbox').removeAttr('checked');
  var filterParametrAmenities = [],
      filterParametrExtras = [],
      filterParametrAccessibility = [],
      filterParametrBedroom = [],
      filterParametrType = [];
  $(".filter-checkbox").change(function (e) {
    var _this = this;

    e.preventDefault();

    if ($(this).attr("data-tax") === 'amenities') {
      if (filterParametrAmenities.includes($(this).attr("data-tax-slug"))) {
        filterParametrAmenities = filterParametrAmenities.filter(function (e) {
          return e !== $(_this).attr("data-tax-slug");
        });
      } else {
        filterParametrAmenities.push($(this).attr("data-tax-slug"));
      }
    } else if ($(this).attr("data-tax") === 'extras') {
      if (filterParametrExtras.includes($(this).attr("data-tax-slug"))) {
        filterParametrExtras = filterParametrExtras.filter(function (e) {
          return e !== $(_this).attr("data-tax-slug");
        });
      } else {
        filterParametrExtras.push($(this).attr("data-tax-slug"));
      }
    } else if ($(this).attr("data-tax") === 'accessibility') {
      if (filterParametrAccessibility.includes($(this).attr("data-tax-slug"))) {
        filterParametrAccessibility = filterParametrAccessibility.filter(function (e) {
          return e !== $(_this).attr("data-tax-slug");
        });
      } else {
        filterParametrAccessibility.push($(this).attr("data-tax-slug"));
      }
    } else if ($(this).attr("data-tax") === 'bedroom-features') {
      if (filterParametrBedroom.includes($(this).attr("data-tax-slug"))) {
        filterParametrBedroom = filterParametrBedroom.filter(function (e) {
          return e !== $(_this).attr("data-tax-slug");
        });
      } else {
        filterParametrBedroom.push($(this).attr("data-tax-slug"));
      }
    } else if ($(this).attr("data-tax") === 'property-type') {
      if (filterParametrType.includes($(this).attr("data-tax-slug"))) {
        filterParametrType = filterParametrType.filter(function (e) {
          return e !== $(_this).attr("data-tax-slug");
        });
      } else {
        filterParametrType.push($(this).attr("data-tax-slug"));
      }
    }

    objParameterUrl.amenities = filterParametrAmenities.join(",");
    objParameterUrl.extras = filterParametrExtras.join(",");
    objParameterUrl.accessibility = filterParametrAccessibility.join(",");
    objParameterUrl.bedroom = filterParametrBedroom.join(",");
    objParameterUrl.type = filterParametrType.join(",");
    sendRequest(objParameterUrl, true);
  }); //pagination click

  $(document).on('click', '.pagination li a', function (e) {
    e.preventDefault();
    $('.pagination li').removeClass('active');
    $(e.target).parent().addClass('active');
    objParameterUrl.page = $(e.target).text();
    sendRequest(objParameterUrl, false);
  });

  function deleteEmptyKey(obj) {
    for (var propName in obj) {
      if (obj[propName] === null || obj[propName] === undefined || obj[propName] === '') {
        delete obj[propName];
      }
    }
  }

  function getSearchFormParametr() {
    $('input:checkbox').removeAttr('checked');
    ['amenities', 'extras', 'accessibility', 'bedroom', 'type'].forEach(function (e) {
      return objParameterUrl[e] = '';
    });
    console.log(objParameterUrl);
    objParameterUrl.where = $('#where-field').val();
    objParameterUrl["in"] = $('#check-in-field').val();
    objParameterUrl.out = $('#check-out-field').val();
    objParameterUrl.guest = $('#guests-field').val() === null ? '' : $('#guests-field').val();
  }

  function sendRequest(obj, isPaginationGenerated) {
    deleteEmptyKey(obj);
    var url = jQuery.param(obj);
    url = API_PATH + url;
    console.log(url);
    $.ajax({
      url: url,
      type: 'GET',
      success: function success(data) {
        if (data) {
          console.log(data);
          generateItems(data);

          if (isPaginationGenerated) {
            generatePagination(data.total, data.postOnPage);
          }

          generateCount(data.total, data.postOnPage);
        } else {
          $('.hotel-list').empty();
          $('.pagination-wrap').empty();
          $('.hotel-list').append("<div class=\"search-error\">Narrow your search</div>");
        }
      }
    });
  }

  function generateItems(data) {
    $('.hotel-list').empty();
    data.items.forEach(function (item) {
      item.thumbnail = item.thumbnail ? item.thumbnail : '';
      item.author.image = item.author.image ? item.author.image : '';
      $('.hotel-list').append("\n            <div class=\"hotel-item\">\n                <a href=\"" + item.link + "\" class=\"img-wrap\">\n                    <img src=\"" + item.thumbnail + "\">\n                    <div class=\"price\">$" + item.price + " / Night</div>\n                </a>\n                <div class=\"info-wrap\">\n                    <a href=\"" + item.location.link + "\" class=\"location\"><i class=\"fa fa-map-marker\" aria-hidden=\"true\"></i> " + item.location.name + " </a>\n                    <div class=\"hotel-attributes\">\n                        <div class=\"attribute\"><i class=\"fa fa-bed\" aria-hidden=\"true\"></i><span>" + item.rooms.all + "</span></div>\n                        <div class=\"attribute\"><i class=\"fa fa-bath\" aria-hidden=\"true\"></i><span>" + item.rooms.bedrooms + "</span></div>\n                        <div class=\"attribute\"><i class=\"fa fa-television\" aria-hidden=\"true\"></i><span>" + item.rooms.bathrooms + "</span></div>\n                        <div class=\"attribute\"><i class=\"fa fa-square-o\" aria-hidden=\"true\"></i><span>" + item.rooms.square + "</span></div>\n                    </div>\n                    <div class=\"author-wrap\">\n                        <img class=\"author-img\" src=\"" + item.author.image + "\">\n                        <div class=\"author-info-wrap\">\n                            <div class=\"name\">" + item.author.name + "</div>\n                            <div class=\"date\">" + item.date + "</div>\n                        </div>\n                    </div>\n                    <div class=\"action\">\n                        <a href=\"\" class=\"save-btn\"><i class=\"fa fa-star\" aria-hidden=\"true\"></i> Save</a>\n                        <a href=\"" + item.link + "\" class=\"details-btn\">Details</a>\n                    </div>\n                    <div class=\"description\">" + item.description + "</div>\n                </div>\n            </div>\n        ");
    });
  }

  function generatePagination(totalItems, countOfPage) {
    var numberOfPage = Math.ceil(totalItems / countOfPage);
    $(".pagination").html('');

    if (numberOfPage > 1) {
      for (var i = 1; i <= numberOfPage; i++) {
        $(".pagination").append("<li><a  href=\"\" data-page=\"" + i + "\">" + i + "</a></li>");
      }

      $(".pagination li:first-child").addClass('active');
    }
  }

  function generateCount(totalItems, countOfPage) {
    var startCount = 0,
        endCount = 0;
    $('#all-count').html(totalItems);

    if (objParameterUrl.page == 1 || objParameterUrl.page == null) {
      startCount = 1;
    } else {
      startCount = countOfPage * (objParameterUrl.page - 1) + 1;
    }

    endCount = startCount + countOfPage - 1;

    if (endCount > totalItems) {
      endCount = totalItems;
    }

    $('#current-count').html(startCount + '-' + endCount);
  } //single page
  // $("#book-form-submit").click(function(e){


  $(".book-form").on('submit', function (e) {
    e.preventDefault();
    var data = {
      'action': 'send_form',
      'check-in': '111'
    };
    console.log(data);
    $.ajax({
      url: ajax_url,
      data: data,
      type: 'POST',
      success: function success(data) {
        if (data) {} else {}
      }
    });
  });
});

/***/ }),

/***/ 546:
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ 16:
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ 838:
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ 100:
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ 639:
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		if(__webpack_module_cache__[moduleId]) {
/******/ 			return __webpack_module_cache__[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/************************************************************************/
(() => {


__webpack_require__(546);

__webpack_require__(838);

__webpack_require__(100);

__webpack_require__(16);

__webpack_require__(639);

__webpack_require__(187);
})();

/******/ })()
;