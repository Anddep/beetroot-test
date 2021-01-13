/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ 187:
/***/ (() => {



jQuery(document).ready(function ($) {
  //global var
  var getUrl = getSearchformParametr(); //hover menu

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
  }); //search

  $("#search-btn").click(function (e) {
    e.preventDefault();
    getUrl = getSearchformParametr();
    sendRequest(getUrl, true);
  }); //change  filter

  var filterParametrAmenities = [];
  var filterParametrExtras = [];
  var filterParametrAccessibility = [];
  var filterParametrBedroom = [];
  var filterParametrType = [];
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

    getUrl = getSearchformParametr() + '&amenities=' + filterParametrAmenities.join(",") + '&extras=' + filterParametrExtras.join(",") + '&accessibility=' + filterParametrAccessibility.join(",") + '&bedroom=' + filterParametrBedroom.join(",") + '&type=' + filterParametrType.join(",");
    sendRequest(getUrl, true);
  }); //pagination click

  $(document).on('click', '.pagination li a', function (e) {
    e.preventDefault();
    $('.pagination li').removeClass('active');
    $(e.target).parent().addClass('active');
    var pageNo = $(e.target).text();
    getUrl += '&page=' + pageNo;
    console.log(getUrl);
    sendRequest(getUrl, false);
  });

  function getSearchformParametr() {
    var where = $('#where-field').val();
    var checkIn = $('#check-in-field').val();
    var checkOut = $('#check-out-field').val();
    var guest = $('#guests-field').val() === null ? '' : $('#guests-field').val();
    return siteUrl + '/wp-json/api/v1/property?where=' + where + '&in=' + checkIn + '&out=' + checkOut + '&guest=' + guest;
  }

  function sendRequest(url, isPaginationGenerated) {
    console.log(url);
    $.ajax({
      url: url,
      type: 'GET',
      success: function success(data) {
        if (data) {
          console.log(data);
          generateItems(data);

          if (isPaginationGenerated) {
            generatePagination(data.total);
          }
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

  function generatePagination(totalItems) {
    var numberOfPage = Math.ceil(totalItems / 2);
    $(".pagination").html('');

    if (numberOfPage > 1) {
      for (var i = 1; i <= numberOfPage; i++) {
        $(".pagination").append("<li><a  href=\"\" data-page=\"" + i + "\">" + i + "</a></li>");
      }

      $(".pagination li:first-child").addClass('active');
    }
  }
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