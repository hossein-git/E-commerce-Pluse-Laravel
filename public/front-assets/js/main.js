 (function ($) {
    "use strict";

    var $document = $(document),
        $window = $(window),
        $body = $('body'),
        /* variables product*/
        same_product_height = 'false',
        /* variables menu*/
        header_menu_timeout = 500,
        header_menu_delay = 200,
        /* header*/
        $stucknav = $('.stuck-nav'),
        $menu = $('.header-menu'),
        $menuparentbox = $('.menu-parent-box'),
        $stuckmenuparentbox = $('.stuck-menu-parent-box'),
        $mobilemenuparentbox = $('.mobile-parent-menu'),
        $menumobile = $mobilemenuparentbox.children(),
        $cart = $('header .cart'),
        $stuckcartparentbox = $('.stuck-cart-parent-box'),
        $cartparentbox = $('.main-parent-cart'),
        $mobileparentcart = $('.mobile-parent-cart'),
        $currencyparentbox = $('.main-parent-currency'),
        $mobileparentcurrency = $('.mobile-parent-currency'),
        $currency = $('header .currency'),
        $languageparentbox = $('.main-parent-language'),
        $mobileparentlanguage = $('.mobile-parent-language'),
        $language = $("header .language"),
        /* content */
        addResizeCarousels_timeout,

    // Template Blocks
    blocks = {
       productItem: $('#pageContent .product'),
       priceSlider: $('#pageContent .priceSlider'),
       countdown: $('#pageContent .countdown'),
       tabsWrapper: $('#pageContent .tabs-wrapper'),
       navTabsCarusel: $('.nav-tabs--carusel'),
       airSticky: $('#pageContent .airSticky'),
       filtersRow: $('#pageContent .filters-row'),
       leftColumn: $('#pageContent .leftColumn'),
       rightColumn: $('#pageContent .rightColumn'),
       slideСolumnСlose: $('#pageContent .slide-column-close'),
       collapseBlock: $('#pageContent .collapse-block'),
       isotopShowmore: $('#pageContent .isotop_showmore_js .btn'),
       inputCounter: $('.input-counter'),
       backToTop: $('.back-to-top'),
       shoppingCartTable: $('#pageContent .shopping-cart-table'),
       headerSearch: $('header .search'),
       footerMobileCollapse: $('footer .mobile-collapse_title'),
       headerCart: $('header .cart'),
       modalCompare: $('.modal-compare'),
       modalWishlist: $('.modal-wishlist'),
       radioClickList: $('.radio-list'),
       calendarDatepicker: $('.calendarDatepicker'),
       contentParallax: $('.content-parallax'),
       videoBlock: $('#pageContent .video-block'),
       modalVideoProduct: $('#modalVideoProduct'),
       mobileMenuToggle: $('.mobile-menu-toggle'),
       mobileCategoriesToggle: $('.mobile-categories-toggle'), //index-02.html
       formGroup: $('.form-group'),
       gallery: $('#pageContent .gallery'),
       galleryMasonry: $('#pageContent .gallery-masonry'),
       headerMenuMulticolumn: $('.header-menu .multicolumn ul'),
       menuVerticalMulticolumn: $('.menu-vertical .multicolumn ul'),
       blogThumb: $('#pageContent .blog-thumb'),
       subcategoryItem: $('#pageContent .subcategory-item'),
       selectCshange: $('.select-change'),
       galleryContentFigure: $('#pageContent .gallery-content figure'),
       verticalCarousel: $(".vertical-carousel"),
       desktopHeaderBoxInfo: $(".desktop-header .box-info"),
       promoBoxBlockTableCell :$('.promo-box .block-table-cell'),
       sliderScroll: $('#pageContent .slider-scroll'),
       ttTabs: $('#pageContent .tt-tabs'),
       sliderRevolution: $('.slider-revolution'),
       carouselProductsMobile: $('.carousel-products-mobile'),
       carouselProductsMobileMd: $('.carousel-products-mobile-md'),
       ttGrid: $('.grid'),
    };

    $document.ready(function () {
       // same_product_height
      if(same_product_height === "true"){
          $body.attr('id', 'same_product_height');
      };
      // pproduct item
      if (blocks.productItem.length) {
          initProductHover();
          productSmall();
      };
      // priceSlider
      if (blocks.priceSlider.length) {
          priceSlider();
      };
      // countDown product item
      if (blocks.countdown.length) {
          countDown(true);
      };
      //sticky(product-05.html)
      if (blocks.airSticky.length) {
          airSticky();
      };
      // collapseBlock
      if (blocks.collapseBlock.length) {
          collapseBlock();
      };
      // show more item product (index-11.html)
      if (blocks.isotopShowmore.length) {
         isotopShowmoreJs();
      };
      // inputCounter
      if (blocks.inputCounter.length) {
         inputCounter();
      };
      // backToTop
      if (blocks.backToTop.length) {
         backToTop();
      };
      // header Search
      if (blocks.headerSearch.length) {
         searchDropDown();
      };
      if (blocks.footerMobileCollapse.length) {
         footerCollapse();
      };
      if (blocks.headerCart.length) {
         cartSlideIni();
      };
      if (blocks.radioClickList.length) {
         radioClickList();
      };
      //calendarDatepicker(blog)
      if (blocks.calendarDatepicker.length) {
          blocks.calendarDatepicker.datepicker();
      };
      // parallax background
      if (blocks.contentParallax.length) {
          blocks.contentParallax.each(function() {
              var attr = $(this).attr('data-image');
              $(this).css({
                'background-image': 'url(' + attr + ')'
              });
          });
      };
      // tooltip(typography.html)
      $(function() {
          $("[data-toggle=popover]").popover();
      });
      //video
      if (blocks.videoBlock.length) {
          videoPost();
      };
      //modal video on page product
      if (blocks.modalVideoProduct.length) {
          videoPopup();
      };
      // Slide Column
      if (blocks.leftColumn.length && blocks.slideСolumnСlose.length) {
        slideColumn();
      };
      // Listing view mode
      if (blocks.filtersRow.length) {
          listingModeToggle();
      };
      if (blocks.headerSearch.length) {
          headerViewSearch();
      };
      // Mobile Menu
      if (blocks.mobileMenuToggle.length || blocks.mobileCategoriesToggle.length) {
          blocks.mobileMenuToggle.initMM({
              enable_breakpoint: true,
              mobile_button: true,
              breakpoint: 1025,
              second_button: blocks.mobileCategoriesToggle
          });
      };
      if (blocks.formGroup.length) {
          initFormGroup(blocks.formGroup);
      };
      // Gallery Popup (gallery-layout.html)
      if (blocks.gallery.length) {
          blocks.gallery.find('.zomm-gallery').magnificPopup({
            type: 'image',
            gallery: {
              enabled: true
            }
          });
      };
      if (blocks.galleryMasonry.length) {
          blocks.galleryMasonry.find('.zomm-gallery').magnificPopup({
            type: 'image',
            gallery: {
              enabled: true
            }
          });
      };
      // simple menu header menu
      if (blocks.headerMenuMulticolumn.length) {
          var headerMenuObj = blocks.headerMenuMulticolumn,
              headerMenuValue = 290;

          initSimpleMenu(headerMenuObj, headerMenuValue);
      };
      // simple menu Vertical menu
      if (blocks.menuVerticalMulticolumn.length) {
          var verticalMenuObj = blocks.menuVerticalMulticolumn,
              verticalMenuValue = 207;

          initSimpleMenu(verticalMenuObj, verticalMenuValue);
      };
      if (blocks.selectCshange.length) {
          initDropdown(blocks.selectCshange);
      };
      if (blocks.collapseBlock.length) {
          if (!blocks.collapseBlock.hasClass(':not(.open)')){
              $(".collapse-block_title").click(function() {
                 $('.vertical-carousel').slick('setPosition').slick('setPosition');
              });
          };
      };
      // identify touch device
      if (is_touch_device()) {
          $body.addClass('touch-device');

          // mobile gallery functionality
          if(blocks.galleryContentFigure.length){
            initgalleryObj(blocks.galleryContentFigure);
         };
      };
      if (blocks.verticalCarousel.length) {
          blocks.verticalCarousel.slick({
              infinite: false,
              dots: false,
              vertical: true,
              slidesToShow: 2,
              slidesToScroll: 1,
            });
            $(window).on('resize', function () {
              blocks.verticalCarousel.slick('setPosition').slick('setPosition');
          });
      };
      if (blocks.sliderScroll.length) {
          blocks.sliderScroll.sliderScroll();
      };
      // tabs
      if (blocks.ttTabs.length) {
          blocks.ttTabs.ttTabs({
            singleOpen: false,
            anim_tab_duration: 270,
            anim_scroll_duration: 500,
            toggleOnDesktop: false,
            scrollToOpenMobile: true,
            effect: 'slide',
            offsetTop: '.tt-header[data-sticky="true"]',
            goToTab: [
                {
                    elem: '.tt-product-head__review-count',
                    tab: 'review',
                    scrollTo: '.tt-review__comments'
                },
                {
                    elem: '.tt-product-head__review-add, .tt-review__head > a',
                    tab: 'review',
                    scrollTo: '.tt-review__form',
                    focus: '#reviewName'
                }
            ]
        });
      };
      if (blocks.sliderRevolution.length) {
          sliderRevolution();
      };
      // determination ie
      if (getInternetExplorerVersion() !== -1) {
          $("html").addClass("ie");
      };
      //Tab with carusel
      if (blocks.navTabsCarusel.length) {
          $(document).on('click', '.tabs-wrapper .nav-tabs--carusel a', function() {
          var $this = $(this),
              $this_tab = $this.parents('.tabs-wrapper'),
              id = $this.attr('href'),
              $tab = $this_tab.find(id),
              $clone = $this_tab.find(id + '-clone');

          $clone.children().clone().appendTo($tab.empty());

          var $grid = $('.grid').isotope({
              itemSelector: '.element-item',
              layoutMode: 'masonry',
              masonry: {
                columnWidth: '.element-item'
              }
          });
          carousel($tab.find('.carousel-products'), 3, 3, 2, 2, 1);
          carousel($tab.find('.carouselTab-col-4'), 4, 4, 3, 2, 1);
        });
        $('.tabs-wrapper .nav-tabs--carusel .active a').trigger('click');
      };
      initStuck();

      setSlickGallery($('.slick-slider-content'), 1, 1, 1, 1, 1, 'slickSlider');
      setSlickGallery($('.testimonialsAsid'), 1, 1, 1, 1, 1, 'slickSlider');
      setSlickGallery($('.slider-blog-fluid'), 1, 1, 1, 1, 1, 'slickSlider');
      setSlickGallery($('.carousel-brands'), 6, 5, 4, 2, 1, 'carousel');
      setSlickGallery($('.carousel-products-1'), 3, 3, 2, 2, 1, 'carousel');
      setSlickGallery($('.carousel-menu-2'), 5, 5, 4, 3, 2, 'carousel');
      setSlickGallery($('.bigGallery'), 3, 3, 3, 2, 1, 'carousel');
      setSlickGallery($('.mobileGallery'), 1, 1, 1, 1, 1, 'carousel');
      setSlickGallery($('.carousel-products-2'), 4, 3, 3, 2, 1, 'carousel');
      setSlickGallery($('.carousel-products-3'), 2, 2, 2, 2, 1, 'carousel');
      setSlickGallery($('.mobileGallery-product'), 1, 1, 1, 1, 1, 'carousel');
      setSlickGallery($('.mobileGallery-product-big'), 2, 2, 2, 2, 1, 'carousel');
      setSlickGallery($('.slider-blog'), 1, 1, 1, 1, 1, 'carousel');
      setSlickGallery($('.carousel-look-book'), 3, 3, 2, 1, 1, 'carousel');

      $(window).trigger('resize');

    });
    $window.on('ready resize', function() {
        if (blocks.filtersRow.length && blocks.leftColumn.length) {
            listFilter();
        };
        // shopping_cart.html
        if (blocks.shoppingCartTable.length) {
            cartTableDetach();
        };
        //list Detach RightCol(listing-left-right-column.html)
        if (blocks.leftColumn.length && blocks.rightColumn.length) {
            listDetachRightCol();
        };
        if (blocks.headerCart.length) {
            mobileparentcart();
        };
        if ($currency.length) {
            mobileParentCurrency();
        };
        if ($language.length) {
            mobileParentLanguage();
        };

        //Tab aside with carusel
        var tabsObj = $('.tab-aside .nav-tabs--carusel'),
            currentW = window.innerWidth || $(window).width();

        if (tabsObj.length) {
            initTabSlider();
            tabsObj.find('.active a').trigger('click');
        };

        function initTabSlider() {
            tabsObj.each(function() {
                $(this).find('a').each(function() {
                    $(this).click(function() {
                        $(this).unbind();
                        var tab = $(this).attr("href");
                        var clone = tab + "-clone";
                        $(tab).empty();
                        $(clone).children().clone().appendTo($(tab));
                        var $obj = $(tab).find(".carouselTab1");
                        $obj.css("visibility", "hidden");
                        if ($obj.length) {
                          setTimeout(function() {
                            $obj.hide();
                            $obj.css("visibility", "visible");
                            $obj.fadeIn(0);
                            if (currentW <= 791) {
                              carousel($obj, 2, 2, 2, 2, 1);
                            }
                          }, 5);
                        }
                    })
                });
            });
        };
    });
    $window.on('load', function () {
        $body.addClass('loaded');
         // modal Compare
        if (blocks.modalCompare.length) {
            compareSlideIni();
        };
         // modal wishlist
         if (blocks.modalWishlist.length) {
            wishlistSlideIni();
        };
        if (blocks.galleryMasonry.length) {
            gridGalleryMasonr();
        };
        // page product - zoom on product
        elevateZoomWidget.init();
        //index-11.html
        if (blocks.ttGrid.length) {
            isotopeGrid.init();

            blocks.ttGrid.find('.clear-item').remove();
            blocks.ttGrid.append("<div class='clear-item element-item filter1'></div>");
        };
        if (blocks.desktopHeaderBoxInfo.length) {
            var rowObjHeight = blocks.desktopHeaderBoxInfo.closest('.container').innerHeight();
            blocks.desktopHeaderBoxInfo.innerHeight(rowObjHeight);

            if(rowObjHeight = "null"){
              var rowObjHeight = blocks.desktopHeaderBoxInfo.closest('.container-fluid').innerHeight();
              blocks.desktopHeaderBoxInfo.innerHeight(rowObjHeight);
            };
        };

    });
    $window.on('load resize', function () {
        if (blocks.productItem.length) {
            productSmall();
        };
        // change tabs title
        if (blocks.tabsWrapper.length) {
            nav_tabs_change_title(blocks.tabsWrapper);
        };
        // blog-thumb arrow carusel
        if (blocks.blogThumb.length) {
            setTimeout(function() {
                blocks.blogThumb.alignmentArrow(".blog-thumb", ".img", ".carousel-products-mobile");
            }, 225);
        };
        // blog-thumb arrow subcategory-item
        if (blocks.subcategoryItem.length) {
            setTimeout(function() {
               blocks.subcategoryItem.alignmentArrow(".subcategory-item", "img", ".carousel-products-mobile");
            }, 225);
        };
        // banner first-child
        if (blocks.promoBoxBlockTableCell.length) {
            var bannerObj = blocks.promoBoxBlockTableCell.children().removeClass('first-child');
            if(bannerObj.length){
                bannerObj.each( function () {
                  var $this = $(this);
                  if($this.is(':visible')){
                    $this.addClass('first-child');
                    return false;
                  }
                });
            };
        };
        if (blocks.carouselProductsMobileMd.length || blocks.carouselProductsMobile.length) {
            clearTimeout(addResizeCarousels_timeout);
            addResizeCarousels_timeout = setTimeout(function() {
              addResizeCarousels(
                blocks.carouselProductsMobile,
                791, {
                  slidesToShow: 2,
                  slidesToScroll: 1,
                  responsive: [{
                    breakpoint: 583,
                    settings: {
                      slidesToShow: 1,
                      slidesToScroll: 1
                    }
                  }]
                }
              );

              addResizeCarousels(
                blocks.carouselProductsMobileMd,
                1025, {
                  slidesToShow: 2,
                  slidesToScroll: 1,
                  responsive: [{
                    breakpoint: 583,
                    settings: {
                      slidesToShow: 1,
                      slidesToScroll: 1
                    }
                  }]
                }
              );
            }, 100);
        };

    });

    // Functions

    /* product hover */
    function initProductHover() {
        $(document).on('mouseenter mouseleave', '#pageContent .product', function(e) {
          var $this = $(this),
            windW = window.innerWidth,
            tabsObj = $('.tabs-wrapper');

          if ($this.parents('.product-listing').hasClass('row-view')) return;
          else if ($this.parents().hasClass('modal-quick-view')) return;

          if ($this.hasClass('no-hover')) return;

          if (e.type === 'mouseenter' && windW >= 1300) {
            $this.css({
              height: $this.innerHeight()
            }).addClass('hovered').closest(tabsObj).addClass('select-block');
            $body.addClass('hover-product');
          } else if (e.type === 'mouseleave' && e.relatedTarget) {
            $this.removeClass('hovered').removeAttr('style').closest(tabsObj).removeClass('select-block');
            $body.removeClass('hover-product');
          }
        });
    };
    // Price Slider initialize
    function priceSlider() {
        var priceSlider = document.getElementsByClassName('priceSlider')[0];

        noUiSlider.create(priceSlider, {
          start: [100, 900],
          connect: true,
          tooltips: true,
          step: 1,
          range: {
            'min': 0,
            'max': 1000
          }
        });

        var inputPriceMax = document.getElementById('priceMax');
        var inputPriceMin = document.getElementById('priceMin');

        priceSlider.noUiSlider.on('update', function(values, handle) {

          var value = values[handle];

          if (handle) {
            inputPriceMax.value = value;
          } else {
            inputPriceMin.value = value;
          }
        });

        inputPriceMax.addEventListener('change', function() {
          priceSlider.noUiSlider.set([null, this.value]);
        });
        inputPriceMin.addEventListener('change', function() {
          priceSlider.noUiSlider.set([this.value, null]);
        });
    };
    // Countdown
    function countDown(showZero) {
        var showZero = showZero || false;
        blocks.countdown.each(function() {
            var $this = $(this),
              date = $this.data('date'),
              set_year = $this.data('year') || 'Yrs',
              set_month = $this.data('month') || 'Mths',
              set_week = $this.data('week') || 'Wk',
              set_day = $this.data('day') || 'Day',
              set_hour = $this.data('hour') || 'Hrs',
              set_minute = $this.data('minute') || 'Min',
              set_second = $this.data('second') || 'Sec';

            if (date = date.split('-')) {
              date = date.join('/');
            } else return;

            $this.countdown(date , function(e) {
              var format = '<span class="countdown-row">';

              function addFormat(func, timeNum, showZero) {
                if(timeNum === 0 && !showZero) return;

                func(format);
              };

              addFormat(function() {
                format += '<span class="countdown-section">'
                        + '<span class="countdown-amount">' + e.offset.totalDays + '</span>'
                        + '<span class="countdown-period">' + set_day + '</span>'
                      + '</span>';
              }, e.offset.totalDays, showZero);

              addFormat(function() {
                format += '<span class="countdown-section">'
                        + '<span class="countdown-amount">' + e.offset.hours + '</span>'
                        + '<span class="countdown-period">' + set_hour + '</span>'
                      + '</span>';
              }, e.offset.hours, showZero);

              addFormat(function() {
                format += '<span class="countdown-section">'
                        + '<span class="countdown-amount">' + e.offset.minutes + '</span>'
                        + '<span class="countdown-period">' + set_minute + '</span>'
                      + '</span>';
              }, e.offset.minutes, showZero);

              addFormat(function() {
                format += '<span class="countdown-section">'
                        + '<span class="countdown-amount">' + e.offset.seconds + '</span>'
                        + '<span class="countdown-period">' + set_second + '</span>'
                      + '</span>';
              }, e.offset.seconds, showZero);

              format += '</span>';

                $(this).html(format);
            });
        });
    };
    // product Small
    function productSmall(){
        var currentItem = $("#pageContent  .product"),
            currentW = parseInt(currentItem.width(), 10);
        if (currentW <= 209) {
          currentItem.addClass("small");
        } else{
          currentItem.removeClass("small");
        }
        if (currentW <= 140) {
          currentItem.addClass("small-xs");
        } else {
          currentItem.removeClass("small-xs");
        }
    };
    // change tabs title
    function nav_tabs_change_title($obj) {
        $obj.each( function () {
            var $this = $(this),
                $nav_title= $this.find('.block-title'),
                $nav_tabs = $this.find('.nav-tabs.nav-tabs--carusel');

            if($nav_title.length){
                var $title_value = $nav_tabs.find('li.active a').text();
                $nav_title.text($title_value);
                $nav_tabs.on('click', 'li a', function() {
                  var $this = $(this);
                  $nav_title.text($this.text());
                });
            };
        });
    };
    // sticky(product-05.html)
    function airSticky(){
        var airStickyObj =  $('.airSticky');
        var tabObj =  $('.tt-tabs .tt-tabs__head > ul > li');
        $(window).on('resize load', function () {
            var currentW = window.innerWidth || $(window).width();
            if(currentW >= 789){
                airStickyObj.airStickyBlock({
                  debug: false,
                  stopBlock: '.airSticky_stop-block',
                  offsetTop: 10,
                });
            } else if(airStickyObj.hasClass('airSticky_absolute')) {
              airStickyObj.removeClass('airSticky_absolute');
            };
        });
        $(document).bind('resize scroll', tabObj, function() {
            airStickyObj.trigger('render.airStickyBlock');
        });
    };
    // filters-row(listing-left-column.html)
    function listFilter() {
        var currentW = window.innerWidth || $(window).width();
        var filterRow = $('.filters-row');
        var filterMobile = $('.filters-mobile');
        function insertMobileFilter() {
            var filterMobilePart01 = filterRow.find('div.pull-left .filters-row_select').detach();
            var filterMobilePart02 = filterRow.find('div.pull-right .filters-row_select').detach();
            var filterMobilePart03 = filterRow.find('.link-sort-top');
            $('.filters-mobile').append(filterMobilePart03, filterMobilePart01, filterMobilePart02).find('.filters-row_select').removeClass('hidden-sm hidden-xs');
        };
        function insertFilter() {
            var filterMobilePart01 = filterMobile.find('.filters-row_select').first().detach();
            var filterMobilePart02 = filterMobile.find('.filters-row_select').last().detach();
            var filterMobilePart03 = filterMobile.find('.link-sort-top').detach();
            filterRow.find('div.pull-left').prepend(filterMobilePart01, filterMobilePart03);
            filterRow.find('div.pull-right').prepend(filterMobilePart02);
        };
        if (currentW <= 1024) {
            insertMobileFilter();
        } else if (currentW > 1024) {
            insertFilter();
        }
        else {
            $('#pageContent .filters-row').addClass('filter-no-sidebar').find(".filters-row_select").removeClass('hidden-sm hidden-xs');
            $('#pageContent .filters-row .slide-column-open').remove();
        }
    };
    // collapseBlock
    function collapseBlock() {
        var item = blocks.collapseBlock,
            itemTitle = item.find('.collapse-block_title'),
            itemContent = item.find('.collapse-block_content');

        item.each(function() {
            if ($(this).hasClass('open')) {
              $(this).find(itemContent).slideDown();
            } else {
               $(this).find(itemContent).slideUp();
            }
        });
        itemTitle.on('click', function(e) {
            e.preventDefault;
            var speed = 300;
            var thisParent = $(this).parent(),
                nextLevel = $(this).next('.collapse-block_content');
            if (thisParent.hasClass('open')) {
                thisParent.removeClass('open');
                nextLevel.slideUp(speed);
            } else {
                thisParent.addClass('open');
                nextLevel.slideDown(speed);
            }
        })
    };
    // show more item product (index-11.html)
    function isotopShowmoreJs() {
        $body.on('click', '.isotop_showmore_js .btn', function() {
            $.ajax({
                url: 'ajax_product.php',
                success: function(data) {
                  var $item = $(data);

                  $grid.append( $item ).isotope( 'appended', $item );
                }
            });
            setTimeout(function(){
              productSmall();
            }, 150);
            return false;
        });
    };
    function inputCounter() {
        blocks.inputCounter.find('.minus-btn, .plus-btn').click(function( e ) {
            var $input = $(this).parent().find('input');
            var count = parseInt($input.val(), 10) + parseInt(e.currentTarget.className === 'plus-btn' ? 1 : -1, 10);
            $input.val(count).change();
        });
        blocks.inputCounter.find("input").change(function() {
            var _ = $(this);
            var min = 1;
            var val = parseInt(_.val(), 10);
            var max = parseInt(_.attr('size'), 10);
            val = Math.min(val, max);
            val = Math.max(val, min);
            _.val(val);
        })
        .on("keypress", function( e ) {
            if (e.keyCode === 13) {
                e.preventDefault();
            }
        });
    };
    // backToTop
    function backToTop() {
        var $obj = blocks.backToTop;
        $obj.click(function() {
            $('html, body').animate({
              scrollTop: 0
            }, 500);
            return false;
        });
        $(window).scroll(function() {
            if ($(window).scrollTop() > 500) {
              $obj.stop(true.false).fadeIn(110)
            } else {
              $obj.stop(true.false).fadeOut(110)
            }
        });
    };
    // shopping_cart.html
    function cartTableDetach() {
        var desctopQuantity = blocks.shoppingCartTable.find(".detach-quantity-desctope"),
            mobileQuantity = blocks.shoppingCartTable.find(".detach-quantity-mobile");

        if (desctopQuantity.length &&  mobileQuantity.parent().css('display') === 'block'){
            var quantityObj = desctopQuantity.find('.input').detach().get(0);
            mobileQuantity.prepend(quantityObj);
        } else if(mobileQuantity.length && mobileQuantity.parent().css('display') === 'none'){
          var quantityObj = mobileQuantity.find('.input').detach().get(0);
          desctopQuantity.prepend(quantityObj);
        };
    };
    // Search DropDown
    function searchDropDown() {
      var searchOpen = blocks.headerSearch.find('.search-open'),
          searchClose = blocks.headerSearch.find('.search-close'),
          searchBadge = blocks.headerSearch.find('.badge');

      if (searchOpen.length) {
        searchOpen.on('click', function(e) {
          e.preventDefault();
          $(this).parent('.search').addClass('open');
          $(this).next('#search-dropdown, .search-dropdown').addClass('open');
          searchBadge.addClass('badge--hidden');
        });
        searchClose.on('click', function(e) {
          e.preventDefault();
          $(this).closest('.search').removeClass('open');
          $(this).closest('#search-dropdown, .search-dropdown').removeClass('open');
          searchBadge.removeClass('badge--hidden');
        });
      };
    };
    // Mobile footer collapse
    function footerCollapse() {
        $body.on('click','footer .mobile-collapse_title', function(e) {
            e.preventDefault;
            $(this).parent('.mobile-collapse').toggleClass('open');
        });
    };
    // Cart
    function cartSlideIni() {
        var $cart = blocks.headerCart;

        $body.on('click', 'header .cart .dropdown-toggle',function(e) {
          $cart.find(".dropdown").toggleClass('open');
          headerCartSize();
          e.preventDefault();
        }).on('click', 'header .cart .cart-close', function(e) {
          $cart.find(".dropdown").toggleClass('open');
          $body.removeClass('cart-open');
          e.preventDefault();
        });

        function headerCartSize() {
            $cart.find(".dropdown-menu").scrollTop(0);
            cartHeight();
        };
        function cartHeight() {
            var $obj = $cart.find(".dropdown-menu");

            $obj.removeAttr('style');

            var w_height = window.innerHeight;
            var o_height = $obj.outerHeight();
            var delta = parseInt(w_height - o_height, 10);

            if (delta < 0) {
              $obj.css({
                  "max-height": o_height + delta,
                  "overflow": "auto",
                  "overflow-x": "hidden"
              });
              $body.addClass('cart-open');
            }
        };
    };
    //  Compare
    function compareSlideIni() {
        var $compare = blocks.modalCompare,
            $compareContainer = $compare.find('.container'),
            $compareButtonClose = $compare.find('.button-close'),
            $compareLinkObj = $(".compare-link");

        $compareLinkObj.on('click', function(e) {
          $compare.toggleClass('open');
          headercompareSize();
          e.preventDefault();
        });

        $compareButtonClose.on('click', function(e) {
          $compare.removeClass('open').removeAttr('style');
           $body.removeClass('compare-open');
          e.preventDefault();
        });

        function headercompareSize() {
            if ($compare.length) {
              $compare.scrollTop(0);
              compareHeight();
            };
        };

        function compareHeight() {
          var $obj = $compare;
          var $objContainer = $compareContainer;
          $obj.removeAttr('style');
          var w_height = window.innerHeight;
          var o_height = $objContainer.outerHeight();
          var delta = parseInt(w_height - o_height, 10);
          if (delta < 0) {
            $obj.css({
              "max-height": o_height + delta,
              "overflow": "auto",
              "overflow-x": "hidden",
              "z-index": "77777777"
            });
            $body.addClass('compare-open');
          };
        };
    };
    //  wishlist
    function wishlistSlideIni() {
        var $wishlist = blocks.modalWishlist,
            $wishlistContainer = $wishlist.find('.container'),
            $wishlistButtonClose = $wishlist.find('.button-close'),
            $wishlistLinkObj = $('.wishlist-link');

        $wishlistLinkObj.on('click', function(e) {
            $wishlist.toggleClass('open');
            headerwishlistSize();
            e.preventDefault();
        });
        $wishlistButtonClose.on('click', function(e) {
            $wishlist.removeClass('open').removeAttr('style');
            $body.removeClass('wishlist-open');
            e.preventDefault();
        });
        function headerwishlistSize() {
          if ($wishlist.length) {
            $wishlist.scrollTop(0);
            wishlistHeight();
          }
        };
        function wishlistHeight() {
            var $obj = $wishlist;
            var $objContainer = $wishlistContainer;
            $obj.removeAttr('style');
            var w_height = window.innerHeight;
            var o_height = $objContainer.outerHeight();
            var delta = parseInt(w_height - o_height, 10);
            if (delta < 0) {
              $obj.css({
                "max-height": o_height + delta,
                "overflow": "auto",
                "overflow-x": "hidden",
                "z-index": "77777777"
              });
              $body.addClass('wishlist-open');
            }
        };
    };
    //form radio Click
    function radioClickList() {
        var radiolistItem = blocks.radioClickList.find('li');

        radiolistItem.on('click', function() {
            radiolistItem.removeClass("active");
            $(this).addClass("active");
        });
    };
    //list Detach RightCol(listing-left-right-column.html)
    function listDetachRightCol() {
        var leftColContent = blocks.leftColumn.find(".detach-rightCol"),
            rightColContent = blocks.rightColumn.find(".detach-rightCol"),
            rightCol = blocks.rightColumn,
            lefttCol = blocks.leftColumn;
        if (leftColContent.length &&  rightCol.css('display') === 'block'){
            var rightColumnContent = leftColContent.detach();
            rightCol.prepend(rightColumnContent);
        } else if (rightColContent.length &&  rightCol.css('display') === 'none'){
          var leftColumnContent = rightColContent.detach();
          lefttCol.append(leftColumnContent);
        }
    };
    //video
    function videoPost() {
        blocks.videoBlock.find('.link-video').click(function(e) {
            e.preventDefault();
            var myVideo = $(this).parent().find('.movie')[0];
            if (myVideo.paused) {
              myVideo.play();
              $(this).addClass('play');
            } else {
              myVideo.pause();
              $(this).removeClass('play');
            }
        });
    };
    //modal video on page product
    function videoPopup() {
        blocks.modalVideoProduct.on('show.bs.modal', function(e) {
            var relatedTarget = $(e.relatedTarget),
                attr = relatedTarget.attr('data-value'),
                attrType = relatedTarget.attr('data-type');

            if(attrType === "youtube" || attrType === "vimeo" || attrType === undefined){
              $('<iframe src="'+attr+'" allowfullscreen></iframe>').appendTo($(this).find('.modal-video-content'));
            };

            if(attrType === "video"){
              $('<div class="video-block"><a href="#" class="link-video"></a><video class="movie"  src="'+attr+'" allowfullscreen></video></div>').appendTo($(this).find('.modal-video-content'));
              videoPost();
            };

        }).on('hidden.bs.modal', function () {
            $(this).find('.modal-video-content').empty();
        });
    };
    function slideColumn() {
        blocks.slideСolumnСlose.addClass('position-fix');
        $('.slide-column-open').on('click', function(e) {
          e.preventDefault();
          $('.leftColumn, .slide-column-close').addClass('column-open');
          $body.css("top", -$body.scrollTop()).addClass("no-scroll").append('<div class="modal-filter"></div>');
          if ($(".modal-filter").length > 0) {
            $(".modal-filter").click(function() {
              $('.slide-column-close').trigger('click');
            })
          }
        });
        blocks.slideСolumnСlose.on('click', function(e) {
          e.preventDefault();
          $(".leftColumn, .slide-column-close").removeClass('column-open');
          var top = parseInt($body.css("top").replace("px", ""), 10) * -1;
          $body.removeAttr("style").removeClass("no-scroll").scrollTop(top);
          $(".modal-filter").unbind().remove();
        });
    };
    // Listing view mode
    function rowViewProductSmall() {
        var currentW = $(".product-listing.row-view .product").width();
        if (currentW < 591) {
            blocks.productItem.addClass("short");
        }
    };
    function listingModeToggle() {
        var filtersRow = blocks.filtersRow;
        if(filtersRow.length){
          var linkRowView = filtersRow.find('a.link-row-view'),
              linkGridView = filtersRow.find('a.link-grid-view'),
              linkViewMobile = filtersRow.find('.link-view-mobile'),
              productListing = $('.product-listing');

          linkRowView.on('click', function(e) {
              e.preventDefault();
              $(this).addClass('active');
              linkGridView.removeClass('active');
              linkViewMobile.removeClass('active');
              productListing.addClass('row-view').removeClass('row-view-one').find('.product').removeClass('small small-xs');
              rowViewProductSmall();
          });
          linkGridView.on('click', function(e) {
              e.preventDefault();
              $(this).addClass('active');
              linkRowView.removeClass('active');
              linkViewMobile.removeClass('active');
              productListing.removeClass('row-view').removeClass('row-view-one');
              $(window).trigger('resize');
          });
          linkViewMobile.on('click', function(e) {
              e.preventDefault();
              $(this).toggleClass('active');
              linkGridView.removeClass('active');
              linkRowView.removeClass('active');
              productListing.removeClass('row-view').toggleClass('row-view-one');
          });
        };
    };
    // header view search
    function headerViewSearch() {
      $body.on('click', 'header .search-open', function(e) {
          e.preventDefault();
          $(this).parent('.search').addClass('open');
          $(this).next('#search-dropdown, .search-dropdown').addClass('open');
          $('header .badge').addClass('badge--hidden');

          $('.header-01, .header-02, .header-03, .header-06').length > 0 && $('.header-menu').addClass('opacity');
          ($('.header-04').length > 0 || $('.header-08').length > 0) && $('.logo, .toggle-menu, .language, .currency, .account, .cart').addClass('opacity');
          $('.header-05').length > 0 && $('.logo, .account, .cart, .header-menu').addClass('opacity');
          $('.header-07').length > 0 && $('.cart').addClass('opacity');
      })
      .on('click', 'header .search-close', function(e) {
          e.preventDefault();
          $(this).closest('.search').removeClass('open');
          $(this).closest('#search-dropdown, .search-dropdown').removeClass('open');
          $('header .badge').removeClass('badge--hidden');

          $('.header-01, .header-02, .header-03, .header-06').length > 0 && $('.header-menu').removeClass('opacity');
          ($('.header-04').length > 0 || $('.header-08').length > 0) && $('.logo, .toggle-menu, .language, .currency, .account, .cart').removeClass('opacity');
          $('.header-05').length > 0 && $('.logo, .account, .cart, .header-menu').removeClass('opacity');
          $('.header-07').length > 0 && $('.cart').removeClass('opacity');
      });
    };
    function initFormGroup($obj) {
        $obj.each( function () {
            var $this = $(this);
            var iconObj = $this.find('.input-group-addon');
            if(iconObj.length){
                $this.click(function() {
                   blocks.formGroup.removeClass('active');
                   $this.addClass('active');
                })
            };
        });
    };
    // logo for retina
    if ('devicePixelRatio' in window && window.devicePixelRatio === 2) {
        $body.addClass('mac');
        var img_to_replace = jQuery('.footer-logo img, .logo img').get();
        for (var i = 0, l = img_to_replace.length; i < l; i++) {
          var src = img_to_replace[i].src;
          src = src.replace(/\.(png|jpg|gif)+$/i, '@2x.$1');
          img_to_replace[i].src = src;
        };
    };
    // simple menu
    function initSimpleMenu(obj, objValue) {
        obj.each( function () {
            var $this = $(this);
            var objWidt = $this.width();
            if(objWidt > objValue){
              $this.closest('ul').addClass('large-width');
            }
        });
    };
    // blog-thumb arrow carusel
    // blog-thumb arrow subcategory-item
    $.fn.findHeight = function (){
        var $blocks = $(this),
            maxH    = $blocks.eq(0).height();

        $blocks.each(function(){
            maxH = ( $(this).height() > maxH ) ? $(this).height() : maxH;
        });

        return maxH/2;
    };
    $.fn.alignmentArrow = function(objParent, obj, objParentArrow){
        return this.each(function(){
            var $objParent = $(objParent),
            $obj = $objParent.find(obj),
            $objParentArrow = $objParent.closest(objParentArrow).find('.slick-arrow');
            if (!$objParentArrow.length){
               $objParentArrow = $objParent.closest(".carousel-products-mobile-md").find('.slick-arrow');
            }

            if($obj.length && $objParentArrow.length){

              var $objHeight =  $obj.findHeight(),
                  $objParentError = parseInt($objParent.css('marginTop'), 10),
                  $objParentError1 = parseInt($obj.css('paddingTop'), 10);

              $objParentArrow.css({
                'top' : $objHeight + $objParentError + $objParentError1 + 'px'
              });

            }
        });
    };
    function initDropdown($dropdown) {
        $dropdown.each( function () {
            var $this = $(this);
            var $title = $this.find('.title-value');
            var $activeElement = $this.find('.dropdown-menu li.active');
            if ($activeElement.length) {
              $title.text($activeElement.data('top-value'));
            } else {
              var $firstElement = $this.find('.dropdown-menu li').first();
              $title.text($firstElement.data('top-value'));
            }
        });
        blocks.selectCshange.on('click', 'li', function() {
            var $this = $(this);

            $this.siblings().removeClass('active');
            $this.addClass('active');
            $this.closest('.select-change').find('.title-value').text($this.data('top-value'));
        });
    };
    // identify touch device
    function is_touch_device() {
        return !!('ontouchstart' in window) || !!('onmsgesturechange' in window);
    };
    // mobile gallery functionality
    function initgalleryObj($obj) {
        $obj.on('touchend', function(){
             var $this = $(this);
             if(!$this.hasClass('gallery-click')){
                $obj.removeClass('gallery-click finish-animation');
                $this.addClass('gallery-click');
                setTimeout(function() {
                    $this.addClass('finish-animation');
                }, 300);
             }
        });
    };
    // Gallery Masonr
    function gridGalleryMasonr() {
        // init Isotope
        var $grid = $('.grid-gallery-masonry').isotope({
            itemSelector: '.element-item',
            layoutMode: 'masonry',
            masonry: {
              gutter: 0
            }
        });
        // filter functions
        var filterFns = {
            ium: function() {
              var name = $(this).find('.name').text();
              return name.match(/ium$/);
            }
        };
        // bind filter button click
        blocks.galleryMasonry.find('.filter-nav').on('click', '.button', function() {
            var filterValue = $(this).attr('data-filter');
            // use filterFn if matches value
            filterValue = filterFns[filterValue] || filterValue;
            $grid.isotope({
              filter: filterValue
            });
        });
        // change is-checked class on buttons
        blocks.galleryMasonry.find('.filter-nav .button').each(function(i, buttonGroup) {
            var $buttonGroup = $(buttonGroup);
            $buttonGroup.on('click', '.button', function() {
              $buttonGroup.find('.is-checked').removeClass('is-checked');
              $(this).addClass('is-checked');
            });
        });
    };
    var newSelection = "";
    $(".filter-nav div").click(function() {
        $("#all-filter-content").hide(0);
        $("#all-filter-content").fadeIn(500);

        $(".filter-nav div").removeClass("current");
        $(this).addClass("current");

        newSelection = $(this).attr("rel");

        $(".item").not("." + newSelection).fadeOut();
        $("." + newSelection).fadeIn();

        $("#all-filter-content").fadeIn(0);
    });
    // page product - zoom on product
    var elevateZoomWidget = {
      scroll_zoom: true,
      class_name: '.zoom-product',
      thumb_parent: $('#smallGallery'),
      scrollslider_parent: $('.slider-scroll-product'),
      checkNoZoom: function(){
        return $(this.class_name).parent().parent().hasClass('no-zoom');
      },
      init: function(type){
        var _ = this;
        var currentW = window.innerWidth || $(window).width();
        var zoom_image = $(_.class_name);
        var _thumbs = _.thumb_parent;
        _.initBigGalleryButtons();
        _.scrollSlider();

        if(zoom_image.length === 0) return false;
        if(!_.checkNoZoom()){
          var attr_scroll = zoom_image.parent().parent().attr('data-scrollzoom');
          attr_scroll = attr_scroll ? attr_scroll : _.scroll_zoom;
          _.scroll_zoom = attr_scroll === 'false' ? false : true;
          currentW > 767 && _.configureZoomImage();
          _.resize();
        }

        if(_thumbs.length === 0) return false;
        var thumb_type = _thumbs.parent().attr('class').indexOf('-vertical') > -1 ? 'vertical' : 'horizontal';
        _[thumb_type](_thumbs);
        _.setBigImage(_thumbs);
      },
      configureZoomImage: function(){
        var _ = this;
        $('.zoomContainer').remove();
        var zoom_image = $(this.class_name);
        zoom_image.each(function(){
          var _this = $(this);
          var clone = _this.removeData('elevateZoom').clone();
          _this.after(clone).remove();
        });
        setTimeout(function(){
          $(_.class_name).elevateZoom({
            gallery: _.thumb_parent.attr('id'),
            zoomType: "inner",
            scrollZoom: Boolean(_.scroll_zoom),
            cursor: "crosshair",
            zoomWindowFadeIn: 300,
            zoomWindowFadeOut: 300
          });
        }, 100);
      },
      resize: function(){
        var _ = this;
        $(window).resize(function(){
          var currentW = window.innerWidth || $(window).width();
          if(currentW <= 767) return false;
          _.configureZoomImage();
        });
      },
      horizontal: function(_parent){
        _parent.slick({
          infinite: true,
          dots: false,
          slidesToShow: 4,
          slidesToScroll: 1,
          responsive: [{
            breakpoint: 1200,
            settings: {
              slidesToShow: 3,
              slidesToScroll: 1
            }
          },
          {
            breakpoint: 992,
            settings: {
              slidesToShow: 4,
              slidesToScroll: 1
            }
          }]
        });
      },
      vertical: function(_parent){
        _parent.slick({
          vertical: true,
          infinite: true,
          slidesToShow: 5,
          slidesToScroll: 1,
          verticalSwiping: true,
          arrows: true,
          dots: false,
          centerPadding: "6px",
          responsive: [{
            breakpoint: 1200,
            settings: {
              slidesToShow: 5,
              slidesToScroll: 1
            }
          },
          {
            breakpoint: 992,
            settings: {
              slidesToShow: 5,
              slidesToScroll: 1
            }
          },
          {
            breakpoint: 768,
            settings: {
              slidesToShow: 5,
              slidesToScroll: 1
            }
          }]
        });
      },
       initBigGalleryButtons: function(){
              var bigGallery = $('.bigGallery');
              if(bigGallery.length === 0) return false;
              $( 'body' ).on( 'mouseenter', '.zoomContainer',
                      function(){        bigGallery.find('button').addClass('show');        }
              ).on( 'mouseleave', '.zoomContainer',
                      function(){ bigGallery.find('button').removeClass('show'); }
              );
      },
      scrollSlider: function(){
        var _scrollslider_parent = this.scrollslider_parent;
        if(_scrollslider_parent.length === 0) return false;
        _scrollslider_parent.on('init', function(event, slick) {
          _scrollslider_parent.css({ 'opacity': 1 });
        });
        _scrollslider_parent.css({ 'opacity': 0 }).slick({
          infinite: false,
          vertical: true,
          verticalScrolling: true,
          dots: true,
          arrows: false,
          slidesToShow: 1,
          slidesToScroll: 1,
          responsive: [{
            breakpoint: 1200,
            settings: {
              slidesToShow: 1,
              slidesToScroll: 1
            }
          },
          {
            breakpoint: 992,
            settings: {
              slidesToShow: 1,
              slidesToScroll: 1
            }
          },
          {
            breakpoint: 768,
            settings: {
              slidesToShow: 1,
              slidesToScroll: 1
            }
          }]
        }).mousewheel(function(e) {
          e.preventDefault();
          e.deltaY < 0 ? $(this).slick('slickNext') : $(this).slick('slickPrev');
        });
      },
      setBigImage: function(_parent){
        var _ = this;
        _parent.find('a').click(function(e){
          _.checkNoZoom() && e.preventDefault();
          var zoom_image = $(_.class_name);
          var getParam = _.checkNoZoom() ? 'data-image' : 'data-zoom-image';
          var setParam = _.checkNoZoom() ? 'src' : 'data-zoom-image';
          var big_image = $(this).attr(getParam);
          zoom_image.attr(setParam, big_image);

          if(!_.checkNoZoom()) return false;
          _parent.find('.zoomGalleryActive').removeClass('zoomGalleryActive');
          $(this).addClass('zoomGalleryActive');
        });
      }
    };
    // header menu(hover)
    (function toggle_header_menu() {
      var delay = header_menu_timeout,
          hoverTimer = header_menu_delay,
          timeout1 = false;

      var set_dropdown_maxH = function() {
        var wind_H = window.innerHeight,
            $menu = $(this).find('.dropdown-menu'),
            menu_top = $menu.get(0).getBoundingClientRect().top,
            menu_max_H = wind_H - menu_top,
            $menu_H = $menu.innerHeight(),
            $btn_top = $('.back-to-top');

        if ($menu_H > menu_max_H) {
          var $body = $('body'),
              $stuck = $('.stuck-nav');
          $menu.css({
            maxHeight: menu_max_H - 20,
            overflow: 'auto'
          });

          var scrollWidth = function() {
            var $div = $('<div>').css({
              overflowY: 'scroll',
              width: '50px',
              height: '50px',
              visibility: 'hidden'
            });

            $body.append($div);
            var scrollWidth = $div.get(0).offsetWidth - $div.get(0).clientWidth;
            $div.remove();

            return scrollWidth;
          };

          $body.css({
            overflowY: 'hidden',
            paddingRight: scrollWidth()
          });

          $stuck.css({
            paddingRight: scrollWidth()
          });

          $btn_top.css({
            right: scrollWidth()
          });
        }
      };

      if ($('.header-menu, .menu-vertical nav').length > 0) {
        $(document).on({
          mouseenter: function() {
            var $this = $(this),
              that = this,
              windowW = window.innerWidth || $(window).width();

            if (windowW > 1025 && $body.hasClass('touch-device')) {
              $(".header-menu .dropdown > a, .menu-vertical .dropdown > a").one("click", false);
            };

              timeout1 = setTimeout(function () {

                var $carousel = $this.find('.carousel-menu-1.header-menu-product'),
                  $menu = $this.find('.dropdown-menu');


                $this.addClass('active')
                   .find(".dropdown-menu")
                   .stop()
                   .addClass('hover')
                   .fadeIn(hoverTimer);

                if($menu.length & !$menu.hasClass('one-col')) {
                    set_dropdown_maxH.call(that);
                }

            if($carousel.length) {
              if(!$carousel.hasClass('slick-initialized')) {
                    setSlickGallery($carousel, 2, 2, 2, 2, 2, 'carousel');
                  } else {
                    $carousel.slick('setPosition');
                  }
                  var obgCarusel = $('.header-menu .header-menu-product');
                  if(obgCarusel.length){
                      var widthCarusel = obgCarusel.parent().width();
                      var widthCarusel = widthCarusel - 8;
                      obgCarusel.css({
                            width: widthCarusel
                      });
                  }
            }

              }, delay);
          },
          mouseleave: function(e) {
            var $this = $(this),
              $dropdown = $this.find(".dropdown-menu");

            if($(e.target).parents('.dropdown-menu').length && !$(e.target).parents('.megamenu-submenu').length && !$(e.target).parents('.one-col').length) return;

            if(timeout1 !== false) {
              clearTimeout(timeout1);
              timeout1 = false;
            }

              if($dropdown.length) {
                $dropdown.stop().fadeOut({duration: 0, complete: function() {
                  $this.removeClass('active')
                       .find(".dropdown-menu")
                       .removeClass('hover');
                }});
            } else {
              $this.removeClass('active')
                     .find(".dropdown-menu")
                     .removeClass('hover');
            }

            $dropdown.removeAttr('style');

                $body.removeAttr('style');

                $('.stuck-nav').css({
                  paddingRight: 'inherit'
                });

                $('.back-to-top').css({
                  right: 0
                });
          }
        }, '.header-menu li, .menu-vertical nav li');

        $('.multicolumn ul li').hover(function() {
          var $ul = $(this).find('ul:first');

          if ($ul.length) {
            var windW = window.innerWidth,
                windH = window.innerHeight,
                ulW = parseInt($ul.css('width'), 10),
                thisR = this.getBoundingClientRect().right,
                thisL = this.getBoundingClientRect().left;

            if (windW - thisR < ulW) {
              $ul.removeClass('left').addClass('right');
            } else if (thisL < ulW) {
              $ul.removeClass('right').addClass('left');
            } else {
              $ul.removeClass('left right');
            }
            $ul.stop(true, true).fadeIn(300);
          }
        }, function() {
          $(this).find('ul:first').stop(true, true).fadeOut(300).removeAttr('style');
        });

        $('.megamenu-submenu li').hover(function() {
          var $ul = $(this).find('ul:first');

          if ($ul.length) {
            var $dropdownMenu = $(this).parents('.dropdown').find('.dropdown-menu'),
                dropdown_left = $dropdownMenu.get(0).getBoundingClientRect().left,
                dropdown_Right = $dropdownMenu.get(0).getBoundingClientRect().right,
                dropdown_Bottom = $dropdownMenu.get(0).getBoundingClientRect().bottom,
                ulW = parseInt($ul.css('width'), 10),
                thisR = this.getBoundingClientRect().right,
                thisL = this.getBoundingClientRect().left;

            if (dropdown_Right - 20 - thisR < ulW) {
              $ul.removeClass('left').addClass('right');
            } else if (thisL - ulW - 20 < dropdown_left) {
              $ul.removeClass('right').addClass('left');
            } else {
              $ul.removeClass('left right');
            }

            $ul.stop(true, true).fadeIn(300);

            var ul_bottom = $ul.get(0).getBoundingClientRect().bottom;

            if (dropdown_Bottom < ul_bottom) {
              var move_top = dropdown_Bottom - ul_bottom;
              $ul.css({
                top: move_top
              });
            }
          }
        }, function() {
          $(this).find('ul:first').stop(true, true).fadeOut(300).removeAttr('style');
        });

        $('.megamenu div').hover(function() {
          $(this).children('.title-underline').addClass('active');
        }, function() {
          $(this).children('.title-underline').removeClass('active');
        });

      }
      if ($('.menu-vertical nav').length > 0) {
          $('.menu-vertical nav li:not(.multicolumn)').hover(function() {
              var $this = $(this);
              var menuVerticalHeight = $('.menu-vertical').innerHeight();
              var menuVerticalPopupHeight = $(this).find('.dropdown-menu').innerHeight();
              if( menuVerticalHeight >= menuVerticalPopupHeight ){
                $(this).find('.dropdown-menu').css({
                  'minHeight' : menuVerticalHeight
                });
              };
          }, function() {
             $(this).find('.dropdown-menu').removeAttr('style');
          });
      }

      function onscroll_dropdown_hover() {
        var $dropdown_active = $('.dropdown.hover');

        if (!$dropdown_active.find('.dropdown-menu').not('.one-col').length) return;

        if ($dropdown_active.length)
          set_dropdown_maxH.call($dropdown_active);
      };
      $(window).on('scroll', function() {
        onscroll_dropdown_hover();
      });
    })();
    // slider-scroll (index-05.html)
    $.fn.sliderScroll = function() {
      var $slider = this;

      if (!$slider.length) return false;

      var $nav = $slider.find('.nav-slider-scroll');

      $nav.on('click', 'li', function(e) {
        var wind_H = window.innerHeight,
          wind_W = window.innerWidth,
          $li = $nav.children(),
          $item,
          item_top,
          item_H,
          scroll_to,
          responsive = (wind_W < 768 && wind_H > 562) ? (wind_H - 562) / 2 : 0,
          eq = 0,
          i = 0;

        for (; i < $li.length; i++) {
          if ($li.get(i) === this)
            eq = i;
        }

        $item = $slider.find('.item').eq(eq),
          item_top = $item.offset().top,
          item_H = $item.outerHeight(),
          scroll_to = item_top - wind_H / 2 + item_H / 2;

        $('html, body').animate({
          scrollTop: scroll_to + responsive
        }, 500);

        e.preventDefault();
        e.stopPropagation();
        return false;
      });

      $(window).on('resize scroll load', function() {
        var wind_H = window.innerHeight,
          wind_W = window.innerWidth,
          $items = $slider.find('.item'),
          nav_marg_bottom = parseInt($nav.find('li:last-child a', 10).css('margin-bottom')),
          nav_H = $nav.innerHeight() - nav_marg_bottom - 14,
          nav_top = $nav.offset().top,
          $last_item = $slider.find('.item:last-child'),
          last_item_top = $last_item.offset().top,
          last_item_H = $last_item.outerHeight(),
          last_item_max = last_item_top + last_item_H / 2,
          $first_item = $slider.find('.item').eq(0),
          first_item_top = $first_item.offset().top,
          first_item_H = $first_item.outerHeight(),
          first_item_max = first_item_top + first_item_H / 2,
          pos_top = 0,
          responsive = (wind_W < 768 && wind_H > 562) ? (wind_H - 562) / 2 : 0,
          i = 0;

        if (last_item_max < pageYOffset + wind_H / 2 - responsive)
          pos_top = last_item_max - nav_H / 2 - pageYOffset;
        else if (first_item_max > pageYOffset + wind_H / 2 - responsive)
          pos_top = first_item_max - nav_H / 2 - pageYOffset;
        else
          pos_top = wind_H / 2 - nav_H / 2 - responsive;

        $nav.css({
          'top': pos_top
        });

        for (; i < $items.length; i++) {
          var $item = $items.eq(i),
            this_bottom = $item.offset().top + $item.outerHeight(),
            eq;

          if (this_bottom > nav_top + nav_H / 2) {
            $nav.find('li').removeClass('active').eq(i).addClass('active');
            break;
          }
        }
      });
    };
    //tabs
    $.fn.ttTabs = function (options) {
        function ttTabs(tabs) {
            var $tabs = $(tabs),
                $head = $tabs.find('.tt-tabs__head'),
                $head_ul = $head.find('> ul'),
                $head_li = $head_ul.find('> li'),
                $head_span = $head_li.find('> span'),
                $border = $head.find('.tt-tabs__border'),
                $body = $tabs.find('.tt-tabs__body'),
                $body_li = $body.find('> div'),
                anim_tab_duration = options.anim_tab_duration || 500,
                anim_scroll_duration = options.anim_scroll_duration || 500,
                breakpoint = 1025,
                scrollToOpenMobile = (options.scrollToOpenMobile !== undefined) ? options.scrollToOpenMobile : true,
                singleOpen = (options.singleOpen !== undefined) ? options.singleOpen : true,
                toggleOnDesktop = (options.toggleOnDesktop !== undefined) ? options.toggleOnDesktop : true,
                effect = (options.effect !== undefined) ? options.effect : 'slide',
                offsetTop = (options.offsetTop !== undefined) ? options.offsetTop : '',
                goToTab = options.goToTab,
                $btn_prev = $('<div>').addClass('tt-tabs__btn-prev disabled'),
                $btn_next = $('<div>').addClass('tt-tabs__btn-next'),
                btn_act = false;

            function _closeTab($li, desktop) {
                var anim_obj = {
                    duration: anim_tab_duration,
                    complete: function () {
                        $(this).removeAttr('style');
                    }
                };

                function _anim_func($animElem) {
                    if(effect === 'toggle') {
                        $animElem.hide().removeAttr('style');
                    } else if(effect === 'slide') {
                        $animElem.slideUp(anim_obj);
                    } else {
                        $animElem.slideUp(anim_obj);
                    }
                };

                var $animElem;

                if(desktop || singleOpen) {
                    $head_li.removeClass('active');
                    $animElem = $body_li.filter('.active').removeClass('active').find('> div').stop();

                    _anim_func($animElem);
                } else {
                    var index = $head_li.index($li);

                    $li.removeClass('active');
                    $animElem = $body_li.eq(index).removeClass('active').find('> div').stop();

                    _anim_func($animElem);
                }
            };

            function _openTab($li, desktop, beforeOpen, afterOpen, trigger) {
                var index = $head_li.index($li),
                    $body_li_act = $body_li.eq(index),
                    $animElem,
                    anim_obj = {
                        duration: anim_tab_duration,
                        complete: function () {
                            if(afterOpen) afterOpen($body_li_act);
                        }
                    };

                function _anim_func($animElem) {
                    if(beforeOpen) beforeOpen($li.find('> span'));

                    if(effect === 'toggle') {
                        $animElem.show();
                        if(afterOpen) afterOpen($body_li_act);
                    } else if(effect === 'slide') {
                        $animElem.slideDown(anim_obj);
                    } else {
                        $animElem.slideDown(anim_obj);
                    }
                };

                $li.addClass('active');
                $animElem = $body_li_act.addClass('active').find('> div').stop();

                _anim_func($animElem);
            };

            function _replaceBorder($this, animate) {
                if($this.length) {
                    var span_l = $this.get(0).getBoundingClientRect().left,
                        head_l = $head.get(0).getBoundingClientRect().left,
                        position = {
                            left: span_l - head_l,
                            width: $this.width()
                        };
                } else {
                    var position = {
                        left: 0,
                        width: 0
                    };
                }

                if(animate) $border.stop().animate(position, anim_tab_duration);
                else $border.stop().css(position);
            };

            function _correctBtns($li, func) {
                var span_act_l = $li.find('> span').get(0).getBoundingClientRect().left,
                    span_act_r = $li.find('> span').get(0).getBoundingClientRect().right,
                    head_pos = {
                        l: $head.get(0).getBoundingClientRect().left,
                        r: $head.get(0).getBoundingClientRect().right
                    };

                if(span_act_l < head_pos.l) {
                    _replace_slider(Math.ceil(head_pos.l - span_act_l), head_pos, false, function () {
                        func();
                    });
                } else if(span_act_r > head_pos.r) {
                    _replace_slider(Math.ceil(span_act_r - head_pos.r) * -1, head_pos, false, function () {
                        func();
                    });
                } else {
                    func();
                }
            };

            $head.on('click', '> ul > li > span', function (e, trigger) {
                var $this = $(this),
                    $li = $this.parent(),
                    wind_w = window.innerWidth,
                    desktop = wind_w > breakpoint,
                    trigger = (trigger === 'trigger') ? true : false;

                if($li.hasClass('active')) {
                    if(desktop && !toggleOnDesktop) return;

                    _closeTab($li, desktop);

                    _replaceBorder('', true);
                } else {
                    _correctBtns($li, function () {
                        _closeTab($li, desktop);

                        _openTab($li, desktop,
                            function($li_act) {
                                if(desktop) {
                                    var animate = !trigger;

                                    _replaceBorder($li_act, animate);
                                }
                            },
                            function ($body_li_act) {
                                if(!desktop && !trigger && scrollToOpenMobile) {
                                    var tob_t = $body_li_act.offset().top;
                                    $('html, body').stop().animate({ scrollTop: tob_t }, {
                                        duration: anim_scroll_duration
                                    });
                                }
                            }
                        );
                    });
                }
            });

            $body.on('click', '> div > span', function (e) {
                var $this = $(this),
                    $li = $this.parent(),
                    index = $body_li.index($li);

                $head_li.eq(index).find('> span').trigger('click');
            });

            function _toTab(tab, scrollTo, focus) {
                var wind_w = window.innerWidth,
                    desktop = wind_w > breakpoint,
                    header_h = 0,
                    $sticky = $(offsetTop),
                    $openTab = $head_li.filter('[data-tab="' + tab + '"]'),
                    $scrollTo = $(scrollTo),
                    toTab = {};

                if(desktop && $sticky.length) {
                    header_h = $sticky.height();
                }

                if(!$openTab.hasClass('active')) {
                    toTab = { scrollTop: $tabs.offset().top - header_h };
                }

                $('html, body').stop().animate(toTab, {
                    duration: anim_scroll_duration,
                    complete: function () {
                        _correctBtns($openTab, function () {
                            _closeTab($openTab, desktop);

                            _openTab($openTab, desktop,
                                function($li_act) {
                                    _replaceBorder($li_act, true);
                                },
                                function () {
                                    if ($scrollTo.length) {
                                        $('html, body').animate({ scrollTop: $scrollTo.offset().top - header_h }, {
                                            duration: anim_scroll_duration,
                                            complete: function () {
                                                var $focus = $(focus);

                                                if ($focus.length) $focus.focus();
                                            }
                                        });
                                    }
                                }
                            );
                        })
                    }
                });
            };

            if($.isArray(goToTab) && goToTab.length) {
                $(goToTab).each(function () {
                    var elem = this.elem,
                        tab = this.tab,
                        scrollTo = this.scrollTo,
                        focus = this.focus;

                    $(elem).on('click', function (e) {
                        _toTab(tab, scrollTo, focus);

                        e.preventDefault();
                        return false;
                    });
                });
            }

            function _btn_disabled(head_pos) {
                var span_pos = {
                    l: $head_li.first().find('> span').get(0).getBoundingClientRect().left,
                    r: $head_li.last().find('> span').get(0).getBoundingClientRect().right
                };

                if(span_pos.l < head_pos.l) $btn_prev.removeClass('disabled');
                else $btn_prev.addClass('disabled');

                if(span_pos.r > head_pos.r) $btn_next.removeClass('disabled');
                else $btn_next.addClass('disabled');
            };

            function _replace_slider(difference, head_pos, resize, afterReplace) {
                var ul_pos = parseInt($head_ul.css('left'), 10),
                    border_pos = parseInt($border.css('left'), 10),
                    duration = (!resize) ? anim_tab_duration : 0,
                    anim_pos = {
                        'left': ul_pos + difference
                    };

                if(resize) {
                    $head_ul.css(anim_pos);
                    _btn_disabled(head_pos);
                } else {
                    $border.animate({ 'left': border_pos + difference }, anim_tab_duration);

                    $head_ul.animate(anim_pos, {
                        duration: duration,
                        complete: function () {
                            _btn_disabled(head_pos);
                            if(afterReplace) afterReplace();
                            btn_act = false;
                        }
                    });
                }
            };

            $tabs.on('click', '.tt-tabs__btn-prev, .tt-tabs__btn-next', function () {
                var $btn = $(this);

                if($btn.hasClass('disabled') || btn_act) return;

                btn_act = true;

                var head_pos = {
                        l: $head.get(0).getBoundingClientRect().left,
                        r: $head.get(0).getBoundingClientRect().right
                    };

                if($btn.hasClass('tt-tabs__btn-next')) {
                    $head_span.each(function (i) {
                        var $this = $(this),
                            this_r = $this.get(0).getBoundingClientRect().right;

                        if(this_r > head_pos.r) {
                            _replace_slider(Math.ceil(this_r - head_pos.r) * -1, head_pos);
                            return false;
                        }
                    });
                } else if($btn.hasClass('tt-tabs__btn-prev')) {
                    $($head_span.get().reverse()).each(function (i) {
                        var $this = $(this),
                            this_l = $this.get(0).getBoundingClientRect().left;

                        if(this_l < head_pos.l) {
                            _replace_slider(Math.ceil(head_pos.l - this_l), head_pos);
                            return false;
                        }
                    });
                }
            });

            $(window).on('resize load', function () {
                var wind_w = window.innerWidth,
                    desktop = wind_w > breakpoint,
                    head_w = $head.innerWidth(),
                    li_w = 0;

                $head_li.each(function () {
                    li_w += $(this).innerWidth();
                });

                if(desktop) {
                    var $li_act = $head_li.filter('.active'),
                        $span_act = $li_act.find('> span');

                    if(!singleOpen && $span_act.length > 1) {
                        var $save_active = $li_act.first();

                        _closeTab('', desktop);
                        _openTab($save_active, desktop);
                    }

                    if(li_w > head_w) {
                        $head.addClass('slider').append($btn_prev).append($btn_next);

                        $head_ul.css({ 'margin-right' : (li_w - $head.innerWidth()) * -1 });

                        if($span_act.length) {

                            var span_act_r = $span_act.get(0).getBoundingClientRect().right,
                                span_last_r = $head_span.last().get(0).getBoundingClientRect().right,
                                head_pos = {
                                    l: $head.get(0).getBoundingClientRect().left,
                                    r: $head.get(0).getBoundingClientRect().right
                                };

                            if(span_act_r > head_pos.r) {
                                _replace_slider(Math.ceil(span_act_r - head_pos.r) * -1, head_pos, true);
                            } else if(span_last_r < head_pos.r) {
                                _replace_slider(head_pos.r - span_last_r, head_pos, true);
                            }

                            _replaceBorder($span_act, false);
                        }

                    } else {
                        $head_ul.removeAttr('style');
                        $btn_prev.remove();
                        $btn_next.remove();
                        $head.removeClass('slider');
                        _replaceBorder($span_act, false);
                    }

                    $head.css({ 'visibility': 'visible' });
                } else {
                    $border.removeAttr('style');
                }
            });

            $head_li.filter('[data-active="true"]').find('> span').trigger('click', ['trigger']);

            return $tabs;
        };

        var tabs = new ttTabs($(this).eq(0));

        return tabs;
    };
    //REVOLUTION SLIDER (function to reset the plug on the breakpoints)
    function sliderRevolution(){
        function click_to_play_video() {
          var $this = $(this),
            $video = $this.find('li video');

          if (!$video.length) return;

          $video.on('play', function() {
            var $btn = $(this).parents('li').find('.video-play');

            $btn.addClass('pause');
            $(this).parents('.tp-caption.fullscreenvideo').addClass('click-video');
          });

          $video.on('pause ended', function() {
            var $btn = $(this).parents('li').find('.video-play');

            $btn.removeClass('pause');
          });

          $this.find('.video-play').on('click', function(e) {
            var $video = $(this).parents('li').find('video');

            $video.trigger('click');
            e.preventDefault();
            e.stopPropagation();
            return false;
          });

          $this.on('revolution.slide.onbeforeswap', function(event, data) {
            $(this).find('.tp-caption.fullscreenvideo').removeClass('click-video');
          });
        };

        function autoplay_video(elem) {
          var $get_sliders = $(this);

          $get_sliders.each(function() {
            var $slider = $(this);

            var set_event = function() {
              $slider.on('revolution.slide.onchange', function(event, data) {
                var $this = $(this),
                  $active_slide = $this.find('li').eq(data.slideIndex - 1),
                  $video = $active_slide.find('video'),
                  autoplay = $active_slide.find('.tp-caption').attr('data-autoplay');

                if ($video.length && autoplay === 'true') {
                  var video = $video.get(0);

                  video.currentTime = 0;

                  $slider.one('revolution.slide.onafterswap', function(event, data) {
                    if (video.paused) {
                      video.play();
                    }
                  });
                }
              });
            };

            if ($slider.hasClass('revslider-initialised')) {
              set_event();
            } else {
              $slider.one('revolution.slide.onloaded', function() {
                set_event();
              });
            }
          });
        };

        $.fn.resizeRevolution = function(options, new_rev_obj, bp_arr) {
          if (!$(this).length || !$(options.slider).length || !options.breakpoints) return false;

          var wrapper = this,
            slider = options.slider,
            breakpoints = options.breakpoints,
            fullscreen_BP = options.fullscreen_BP || false,
            new_rev_obj = new_rev_obj || {},
            bp_arr = bp_arr || [],
            rev_obj = {
              dottedOverlay: "none",
              delay: 4600,
              startwidth: 1920,
              hideThumbs: 200,
              hideTimerBar: "on",

              thumbWidth: 100,
              thumbHeight: 50,
              thumbAmount: 5,

              navigationArrows: "none",

              touchenabled: "on",
              onHoverStop: "on",

              swipe_velocity: 0.7,
              swipe_min_touches: 1,
              swipe_max_touches: 1,
              drag_block_vertical: false,

              parallax: "mouse",
              parallaxBgFreeze: "on",
              parallaxLevels: [7, 4, 3, 2, 5, 4, 3, 2, 1, 0],

              keyboardNavigation: "off",

              navigationHAlign: "center",
              navigationVAlign: "bottom",
              navigationHOffset: 0,
              navigationVOffset: 20,

              soloArrowLeftHalign: "left",
              soloArrowLeftValign: "center",
              soloArrowLeftHOffset: 20,
              soloArrowLeftVOffset: 0,

              soloArrowRightHalign: "right",
              soloArrowRightValign: "center",
              soloArrowRightHOffset: 20,
              soloArrowRightVOffset: 0,

              shadow: 0,

              spinner: "",
              h_align: "left",

              stopLoop: "off",
              stopAfterLoops: -1,
              stopAtSlide: -1,

              shuffle: "off",

              autoHeight: "off",
              forceFullWidth: "off",

              hideThumbsOnMobile: "off",
              hideNavDelayOnMobile: 1500,
              hideBulletsOnMobile: "off",
              hideArrowsOnMobile: "off",
              hideThumbsUnderResolution: 0,

              hideSliderAtLimit: 0,
              hideCaptionAtLimit: 0,
              hideAllCaptionAtLilmit: 0,
              startWithSlide: 0,
              fullScreenOffsetContainer: false
            };

          $.extend(rev_obj, new_rev_obj);

          var get_Slider = function($sliderWrapp) {
            return $sliderWrapp.find(slider);
          };

          var get_current_bp = function() {
            var wind_W = window.innerWidth;

            for (var i = 0; i < breakpoints.length; i++) {
              var bp = breakpoints[i];

              if (!breakpoints.length) return false;

              if (wind_W <= bp) {
                if (i === 0) {
                  return bp;
                } else {
                  if (bp > breakpoints[i - 1])
                    return bp;
                }
              } else if (wind_W > bp && i === breakpoints.length - 1)
                return Infinity;
            }
            return false;
          };

          var $sliderWrappers = $(wrapper);

          $sliderWrappers.each(function() {
            var $sliderWrapp = $(this),
              $sliderInit = get_Slider($sliderWrapp),
                $sliderCopy = $sliderWrapp.clone(),
                bp = get_current_bp();

            if (!$sliderInit.length) return false;

            var start_Rev = function($sliderInit, bp) {
              var wind_W = window.innerWidth,
                rev_settings_obj = {},
                rev_screen_obj = {},
                set_rev_obj = {};

              if (fullscreen_BP) {
                var full_width = (wind_W >= fullscreen_BP) ? 'off' : 'on',
                  full_screen = (wind_W >= fullscreen_BP) ? 'on' : 'off';

                rev_screen_obj = {
                  fullWidth: full_width,
                  fullScreen: full_screen
                };
              }

              if (bp_arr.length) {
                for (var i = 0; i < bp_arr.length; i++) {
                  var this_obj = bp_arr[i];

                  if (this_obj.bp && this_obj.bp.length === 2 && this_obj.bp[0] < this_obj.bp[1]) {
                    var from = this_obj.bp[0],
                      to = this_obj.bp[1];

                    if (from <= bp && to >= bp) {
                      for (var key in this_obj) {
                        if (key !== 'bp')
                          rev_settings_obj[key] = this_obj[key];
                      }
                    }
                  }
                }
              }

              $.extend(set_rev_obj, rev_obj, rev_settings_obj, rev_screen_obj);

              $($sliderInit).show().revolution(set_rev_obj);

              $(options.functions).each(function() {
                this.call($sliderInit);
              });
            };

            start_Rev($sliderInit, bp);

            var restart_Rev = function(current_bp) {
              if (!$($sliderInit).hasClass('revslider-initialised')) return;
              bp = current_bp || 0;
              $sliderInit.revkill();
              $sliderWrapp.replaceWith($sliderCopy);
              $sliderWrapp = $sliderCopy;
              $sliderCopy = $sliderWrapp.clone();
              $sliderInit = get_Slider($sliderWrapp);
              start_Rev($sliderInit, bp);
            };

            function endResize(func) {
              var windWidth = window.innerWidth,
                interval;

              interval = setInterval(function() {
                var windWidthInterval = window.innerWidth;
                if (windWidth === windWidthInterval) {
                  setTimeout(function() {
                    func();
                  }, 200);
                }
                clearInterval(interval);
              }, 100);
            };

            $(window).on('resize', function() {
              endResize(function() {
                var current_bp = get_current_bp();
                if (current_bp !== bp)
                  restart_Rev(current_bp);
              })
            });
          });
        };

        $('.slider-revolution.revolution-default').resizeRevolution({
          slider: '.tp-banner',
          breakpoints: [414, 767, 1025],
          fullscreen_BP: 768,
          functions: [
            click_to_play_video,
            autoplay_video
          ]
        }, {
          fullScreenOffsetContainer: "header"
        }, [{
          bp: [0, 768],
          startheight: 1100
        }]);

        $('.slider-revolution.revolution-static').resizeRevolution({
          slider: '.tp-banner',
          breakpoints: [414, 767, 1025],
          fullscreen_BP: 768,
          functions: [
            click_to_play_video,
            autoplay_video
          ]
        }, {
          fullScreenOffsetContainer: "header-static"
        }, [{
            bp: [0, 768],
            startheight: 1300
          },
          {
            bp: [0, 1025],
            fullScreenOffsetContainer: "header"
          }
        ]);
    };
    var cssFix = function() {
        var u = navigator.userAgent.toLowerCase(),
          is = function(t) {
            return (u.indexOf(t) != -1)
          };
        $("html").addClass([
          (!(/opera|webtv/i.test(u)) && /msie (\d)/.test(u)) ? ('ie ie' + RegExp.$1) :
          is('firefox/2') ? 'gecko ff2' :
          is('firefox/3') ? 'gecko ff3' :
          is('gecko/') ? 'gecko' :
          is('opera/9') ? 'opera opera9' : /opera (\d)/.test(u) ? 'opera opera' + RegExp.$1 :
          is('konqueror') ? 'konqueror' :
          is('applewebkit/') ? 'webkit safari' :
          is('mozilla/') ? 'gecko' : '',
          (is('x11') || is('linux')) ? ' linux' :
          is('mac') ? ' mac' :
          is('win') ? ' win' : ''
        ].join(''));
    }();
    function getInternetExplorerVersion() {
        var rv = -1;
        if (navigator.appName === 'Microsoft Internet Explorer') {
          var ua = navigator.userAgent;
          var re = new RegExp("MSIE ([0-9]{1,}[\.0-9]{0,})");
          if (re.exec(ua) != null)
            rv = parseFloat(RegExp.$1);
        } else if (navigator.appName === 'Netscape') {
          var ua = navigator.userAgent;
          var re = new RegExp("Trident/.*rv:([0-9]{1,}[\.0-9]{0,})");
          if (re.exec(ua) != null)
            rv = parseFloat(RegExp.$1);
        }
        return rv;
    };
    /**
     * Stuck init. Properties: on/off
     * @value = 'off', default empty
     */
    function initStuck(value) {
      if($stucknav.hasClass('disabled')) return;

      var value = value || false,
        ie = (getInternetExplorerVersion() !== -1) ? true : false;

      if (value === 'off') return false;
      var n = 0;
      $(window).scroll(function() {
        var HeaderTop = $('header').innerHeight() - 20;
        if ($(window).scrollTop() > HeaderTop) {
          if ($stucknav.hasClass('stuck')) return false;
          $stucknav.hide();
          $stucknav.addClass('stuck');
          window.innerWidth < 1025 ? $stuckmenuparentbox.append($menumobile.detach()) : $stuckmenuparentbox.append($menu.detach());
          $stuckcartparentbox.append($cart.detach());


          if ($stucknav.find('.stuck-cart-parent-box > .cart > .dropdown').hasClass('open') || ie)
            $stucknav.stop().show();
          else
            $stucknav.stop().fadeIn(300);

        } else {
          if (!$stucknav.hasClass('stuck')) return false;
          $stucknav.hide();
          $stucknav.removeClass('stuck');
          if (window.innerWidth < 1025) {
            $mobilemenuparentbox.append($menumobile.detach());
            $mobileparentcart.append($cart.detach());
            return false;
          }
          $menuparentbox.append($menu.detach());
          $cartparentbox.append($cart.detach());
        }
      });
      $(window).resize(function() {
        if (!$stucknav.hasClass('stuck')) return false;
        if (window.innerWidth < 1025) {
          $menuparentbox.append($menu.detach());
          $stuckmenuparentbox.append($menumobile.detach());
        } else {
          $mobilemenuparentbox.append($menumobile.detach());
          $stuckmenuparentbox.append($menu.detach());
        }
      });
    };
    //cart
    function mobileparentcart() {
        if (window.innerWidth < 1025) {
            if ($mobileparentcart.children().lenght) return false;
            if ($('.stuck').length) return false;
            $mobileparentcart.append($cart.detach());
        } else {
            if ($cartparentbox.children().lenght) return false;
            if ($('.stuck').length) return false;
            $cartparentbox.append($cart.detach());
        };
    };
    //currency
    function mobileParentCurrency() {
        if (window.innerWidth < 1025) {
            if ($mobileparentcurrency.children().lenght) return false;
            $mobileparentcurrency.append($currency.detach());
        } else {
            if ($currencyparentbox.children().lenght) return false;
            $currencyparentbox.append($currency.detach());
        };
    };
    //language
    function mobileParentLanguage() {
        if (window.innerWidth < 1025) {
            if ($mobileparentlanguage.children().lenght) return false;
            $mobileparentlanguage.append($language.detach());
        } else {
            if ($languageparentbox.children().lenght) return false;
            $languageparentbox.append($language.detach());
        }
    };
    function addResizeCarousels(selector, breakpoint, options) {
        if (!selector) return false;

        var $carousels = $(selector),
            breakpoint = breakpoint || 768,
            options = options || null,
            windW = window.innerWidth || $(window).width();

        if (windW < breakpoint) {
            $carousels.each(function() {
                $(this).not('.slick-initialized').slick(options);
            });
        } else {
            $carousels.each(function() {
              if ($(this).hasClass('slick-initialized'))
                $(this).slick('unslick');
            });
        };
    };
    var $grid = blocks.ttGrid,
        isotopeGrid = {
        grid: $grid,
        init: function(){
            var _ = this;
            if(_.grid.length === 0) return false;
            this.grid.isotope({
                itemSelector: '.element-item',
                layoutMode: 'masonry',
                masonry: {
                  columnWidth: '.element-item'
                }
            });
            var filterFns = {
                numberGreaterThan50: function () {
                  var number = $(this).find('.number').text();
                  return parseInt(number, 10) > 50;
                },
                ium: function () {
                  var name = $(this).find('.name').text();
                  return name.match(/ium$/);
                }
            };
            $('.nav-tab-filter').on('click', 'button', function () {
                var filterValue = $(this).attr('data-filter');
                // use filterFn if matches value
                filterValue = filterFns[filterValue] || filterValue;
                _.grid.isotope({
                  filter: filterValue
                });
            });
            $('.button-group').each(function (i, buttonGroup) {
                var $buttonGroup = $(buttonGroup);
                $buttonGroup.on('click', 'button', function () {
                  $buttonGroup.find('.is-checked').removeClass('is-checked');
                  $(this).addClass('is-checked');
                });
            });
            $(".filter-isotop").length && $(".filter-isotop").find(".is-checked").trigger("click");
        }
    };
    function setSlickGallery(value) {
        if (value.length === 0) return false;
        var arr = $.makeArray(arguments);
        var fn = window[arr[arr.length - 1]];
        if (typeof fn === "function") fn(arr[0], arr[1], arr[2], arr[3], arr[4], arr[5]);
    };
 })(jQuery);
function carousel(value) {

    var windowW = window.innerWidth || $(window).width();
    var arr = $.makeArray(arguments);

    var slidesToShowXl = (arr[1] > 0) ? arr[1] : 6; //numberXl
    var slidesToShowLg = (arr[2] > 0) ? arr[2] : 4; //numberLg
    var slidesToShowMd = (arr[3] > 0) ? arr[3] : arr[2]; //numberMd
    var slidesToShowSm = (arr[4] > 0) ? arr[4] : arr[3]; //numberSm
    var slidesToShowXs = (arr[5] > 0) ? arr[5] : 1; //numberXs

    var speed = 500;

    value.slick({
        slidesToShow: slidesToShowXl,
        slidesToScroll: 1,
        speed: speed,

        responsive: [{
          breakpoint: 1770,
          settings: {
            slidesToShow: slidesToShowLg,
            slidesToScroll: slidesToShowLg
          }
        }, {
          breakpoint: 1199,
          settings: {
            slidesToShow: slidesToShowMd,
            slidesToScroll: slidesToShowMd
          }
        }, {
          breakpoint: 798,
          settings: {
            slidesToShow: slidesToShowSm,
            slidesToScroll: slidesToShowSm
          }
        }, {
          breakpoint: 480,
          settings: {
            slidesToShow: slidesToShowXs,
            slidesToScroll: slidesToShowXs
          }
        }]
    });
};
function slickSlider(value) {
    value.not('.slick-initialized').slick({
        infinite: true,
        dots: true,
        arrows: false,
        slidesToShow: 1,
        slidesToScroll: 1,
    });
};