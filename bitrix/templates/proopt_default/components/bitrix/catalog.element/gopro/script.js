var RSGoPro_DetailBuy1Click = false,
	RSGoPro_DetailCheaper = false,
	RSGoPro_AfterLoading = false;

function RSGoPro_str_replace(search, replace, subject) {
	return subject.split(search).join(replace);
}

function RSGoPro_OnOfferChangeDetail($elementObj) {
	var finedOfferID = $elementObj.find('.js-add2basketpid').val(),
		element_id = $elementObj.data('elementid');
	
	if (finedOfferID > 0) {
		// images
		$elementObj.find('.changeimage.imgoffer').hide().removeClass('scrollitem');
		$elementObj.find('.changeimage.imgofferid'+finedOfferID).show().addClass('scrollitem');
		$elementObj.find('.changeimage.imgofferid'+finedOfferID).filter(':first').trigger('click');
		RSGoPro_DetailJScrollPaneReinitialize();
		setTimeout(function(){
			$elementObj.find('.changeimage:visible:first').trigger('click');
		}, 50);
	}

	clearTimeout(RSGoPro_ajaxTimeout);
	RSGoPro_ajaxTimeout = setTimeout(function(){
		console.log('detail - updateDelivery');
		updateDelivery($elementObj);
	}, RSGoPro_ajaxTimeoutTime);
}

function RSGoPro_OnChangeQuantity($elementObj) {
	clearTimeout(RSGoPro_ajaxTimeout);
	RSGoPro_ajaxTimeout = setTimeout(function(){
		updateDelivery($elementObj);
	}, RSGoPro_ajaxTimeoutTime);
}

function RSGoPro_DetailJScrollPaneReinitialize() {
	setTimeout(function(){ // fix for slow shit
		// images
		var pane2api,
			$scroll;
		$('.d_jscrollpane').parents('.picslider').removeClass('jspHasScroll');
		$('.d_jscrollpane').each(function(i){
			$scroll = $(this);
			RSGoPro_JSPReinitByObj($scroll);
		});
		// images in fancy
		$('.popd_jscrollpane').parents('.picslider').removeClass('jspHasScroll');
		$('.popd_jscrollpane').each(function(i){
			$scroll = $(this);
			RSGoPro_JSPReinitByObj($scroll);
		});
		// prices
		$('.prs_jscrollpane').parents('.prices').removeClass('jspHasScroll');
		$('.prs_jscrollpane').each(function(i){
			$scroll = $(this);
			RSGoPro_JSPReinitByObj($scroll);
		});
	}, 150);
}

function RSGoPro_FancyImagesOnUpdate() {
	setTimeout(function(){ // fix for slow shit
		$('.fancygallery').find('.image .max').css('maxHeight', parseInt($('.fancygallery').height())-5);
		$('.fancygallery').find('.slider .max').css('height', parseInt($('.fancygallery').height())-5-60);
	}, 50);
}
function RSGoPro_FancyChangeImageFix() {
	var genImageUrl = $('.fancybox-container').find('.genimage').attr('src');
	$('.fancybox-container').find('.changeimage').removeClass('selected');
	$('.fancybox-container').find('.changeimage').each(function(i) {
		if (genImageUrl == $(this).find('img').data('bigimage')) {
			$(this).addClass('selected');
			RSGoPro_ScrollGoToElement($(this));
			return false;
		}
	});
}

function RSGoPro_ScrollToSelector(selector) {
	var scrollTopPos = $( selector ).offset().top + 'px';
	if (!RSDevFunc_PHONETABLET) {
		$('html, body').animate({
			scrollTop: scrollTopPos
		}, 500);
	} else {
		$('html, body').scrollTop( scrollTopPos )
	}
}

function updateDelivery($element) {
	var $quantityInput = $element.find(".js-quantity"),
		productId = $quantityInput.closest(".add2basketform").find(".js-add2basketpid").val(),
		quantity = $quantityInput.val(),
		$deliveryBlock = $element.find(".product-delivery");

	var beforeAfterFn = function() {
		RSGoPro_Area2Darken($deliveryBlock, 'animashka');
		RSGoPro_Area2Darken($('#delivery-tab'), 'animashka');
	}

	BX.onCustomEvent('rs_delivery_update', [productId, quantity, beforeAfterFn, beforeAfterFn]);
}

$(document).ready(function() {

	$(window).resize(BX.debounce(function() {
		RSGoPro_FancyImagesOnUpdate();
		RSGoPro_DetailJScrollPaneReinitialize();
	}, 100));
	
	// zoom
	if(RSDevFunc_PHONETABLET) {
		$('.elementdetail').find('.zoom').hide();
	}

	// change general image
	$(document).on('click','a.changeimage', function(){
		var $curLink = $(this);
		if( $curLink.parents('.d_jscrollpane').length>0 ) {
			var $jscrollpane = $curLink.parents('.d_jscrollpane');
		} else {
			var $jscrollpane = $curLink.parents('.popd_jscrollpane');
		}
		$jscrollpane.find('a.changeimage').removeClass('selected');
		var bigimage = $curLink.addClass('selected').find('img').data('bigimage');
		if (bigimage != 'undefined' && bigimage != '') {
			$curLink.parents('.changegenimage').find('.genimage').attr('src', bigimage );
			RSGoPro_ScrollGoToElement($curLink);
		}
		return false;
	});
	// set selected on general image
	var genImageUrl = $('.elementdetail').find('.genimage').attr('src');
	$('.elementdetail').find('.sliderin').find('.changeimage').removeClass('selected');
	$('.elementdetail').find('.sliderin').find('.changeimage').each(function(i){
		if( genImageUrl==$(this).find('img').data('bigimage') ) {
			$(this).addClass('selected');
			return false;
		}
	});
	
	// jScrollPane -> images and prices
	RSGoPro_ScrollInit('.d_jscrollpane');
	RSGoPro_ScrollInit('.popd_jscrollpane');
	RSGoPro_ScrollInit('.prs_jscrollpane');
	$(window).resize(function(){
		RSGoPro_ScrollReinit('.d_jscrollpane');
		RSGoPro_ScrollReinit('.popd_jscrollpane');
		RSGoPro_ScrollReinit('.prs_jscrollpane');
	});
	
	// Fancybox -> gallery
	if (!RSDevFunc_PHONETABLET) {
		rsGoPro.options.fancybox.productGallery = $.extend({}, rsGoPro.options.fancybox.base);
		rsGoPro.options.fancybox.productGallery.baseClass = 'rs-gopro-popup rs-gopro-product-gallery',
		rsGoPro.options.fancybox.productGallery.caption = $('.elementdetail').data('elementname'),
		rsGoPro.options.fancybox.productGallery.onComplete = function() {
			setTimeout(function() {
				RSGoPro_FancyImagesOnUpdate();
				$.when( RSGoPro_DetailJScrollPaneReinitialize() ).done(function(x) {
					RSGoPro_FancyChangeImageFix();
				});
			}, 150);
		},

		$('.glass_lupa')
			.on('click touchstart', function(event) {})
			.data({
				type: 'inline'
			})
			.fancybox(rsGoPro.options.fancybox.productGallery);
		
		// stores
		rsGoPro.options.fancybox.productStores = $.extend({}, rsGoPro.options.fancybox.base);
		rsGoPro.options.fancybox.productStores.baseClass = 'rs-gopro-popup rs-gopro-product-stores',
		$('.genamount:not(.cantopen)')
		.on('click touchstart', function(event) {})
		.data({
			type: 'inline'
		})
		.fancybox(rsGoPro.options.fancybox.productStores);
	} else {
		$(document).on('click','.genamount:not(.cantopen)',function(){
			var id = $(this).attr('href');
			$(id).toggleClass('noned').removeAttr('style');
			return false;
		});
	}
	
	// tabs
	$(document).on('click','.tabs .switcher',function(){
		var $switcher = $(this);
		var $tabs = $switcher.parents('.tabs');
		var id = $switcher.attr('href');
		$tabs.find('.switcher').removeClass('selected');
		$tabs.find('.content').removeClass('selected');
		$tabs.find('.switcher[href="'+id+'"]').addClass('selected');
		$tabs.find(id).addClass('selected');
		if(RSGoPro_AfterLoading) {
			if(RSDevFunc_PHONETABLET && $switcher.parent().hasClass('headers')==false) {
				setTimeout(function(){ // fix for slow shit
					var scrollTop = $switcher.offset().top - 8;
					$('html,body').scrollTop(scrollTop);
				},50);
			}
			$(document).trigger('detaltabchange');
			var scrollV = document.body.scrollTop;
	        var scrollH = document.body.scrollLeft;
			document.location.hash = RSGoPro_str_replace('#','',id);
			document.body.scrollTop = scrollV;
	        document.body.scrollLeft = scrollH;
	    }
		return false;
	});
	$(document).on('click','.anchor .switcher',function(){
		RSGoPro_ScrollToSelector( '.contents .switcher[href="'+$(this).attr('href')+'"]' );
		$(document).trigger('detaltabchange');
		return false;
	});
	
	$(window).on('hashchange', function(){
		if(RSGoPro_AfterLoading) {
			$('.detailtabs.tabs').find('.switcher[href="'+window.location.hash+'"]').trigger('click');
		}
	});
	// tabs -> add review
	$(document).on('click','.add2review',function(e){
		e.stopPropagation();
		$('#detailreviews').find('.reviewform').toggleClass('noned');
		return false;
	});
	
	// change offer
	$(document).on('RSGoProOnOfferChange',function(e,elementObj){
		RSGoPro_OnOfferChangeDetail(elementObj);
		if( $('.elementdetail').find('.soloprice').length>0 ) {
			if( $('.elementdetail').find('.soloprice').find('.discount').html()=='' ) {
				$('.elementdetail').find('.soloprice').find('.hideifzero').hide();
			} else {
				$('.elementdetail').find('.soloprice').find('.hideifzero').show();
			}
		}
	});

	// change quantity
	$(document).on('RSGoProOnChangeQuantity',function(e,elementObj){
		RSGoPro_OnChangeQuantity(elementObj);
	});
	
	// buy1click
	$(document).on('click','.buy1click.detail',function(e){
		RSGoPro_DetailBuy1Click = true;
	});
	// buy1click - put data to form
	$(document).on('RSGoProOnFancyBeforeShow',function(){
		if(RSGoPro_DetailBuy1Click) {
			var value = '';
			value = BX.message("RSGoPro_DETAIL_PROD_ID") + ': ' + $('.elementdetail').find('.js-add2basketpid').val() + '\n' +
				BX.message("RSGoPro_DETAIL_PROD_NAME") + ': ' + $('.elementdetail').data('elementname') + '\n' +
				BX.message("RSGoPro_DETAIL_PROD_LINK") + ': ' + window.location.href + '\n' +
				'-----------------------------------------------------';
			$('.fancybox-inner').find('textarea[name="RS_AUTHOR_ORDER_LIST"]').text( value );
		}
		RSGoPro_DetailBuy1Click = false;
	});
	
	// cheaper
	$(document).on('click','.cheaper.detail',function(e){
		RSGoPro_DetailCheaper = true;
	});
	// cheaper - put data to form
	$(document).on('RSGoProOnFancyBeforeShow',function(){
		if(RSGoPro_DetailCheaper) {
			var value = '';
			value = BX.message("RSGoPro_DETAIL_CHEAPER_TITLE") + '\n' +
				+ '\n' +
				BX.message("RSGoPro_DETAIL_PROD_ID") + ': ' + $('.elementdetail').find('.js-add2basketpid').val() + '\n' +
				BX.message("RSGoPro_DETAIL_PROD_NAME") + ': ' + $('.elementdetail').data('elementname') + '\n' +
				BX.message("RSGoPro_DETAIL_PROD_LINK") + ': ' + window.location.href + '\n' +
				'-----------------------------------------------------';
			$('.fancybox-inner').find('textarea[name="RS_AUTHOR_COMMENT"]').text( value );
		}
		RSGoPro_DetailCheaper = false;
	});
	
	$(document).on('click','.go2detailfrompreview',function(){
		$('.detailtabs.tabs').find('.switcher[href="#detailtext"]').trigger('click');
		RSGoPro_ScrollToSelector( '.switcher[href="#detailtext"]' );
		return false;
	});
	
});

// click on first tab
$(document).ready(function(){
	var r = RSDevFunc_GetUrlVars()['result'];
	if (r) {
		r = r.substr(0, r.indexOf('#'));
	}
	
	var $tabs = $('.detailtabs.tabs');
	if (window.location.hash == '#postform' || (r && r == 'reply')	) {
		$tabs.find('.switcher[href="#review"]').trigger('click');
	} else if($tabs.find('.switcher[href="' + window.location.hash + '"]').length > 0) {
		$tabs.find('.switcher[href="' + window.location.hash + '"]').trigger('click');
	} else {
		$tabs.find('.switcher:first').trigger('click');
	}
	
	$('.detailtabs.anchor').find('.switcher:first').addClass('selected');
	RSGoPro_AfterLoading = true;
});

// add this element to viewed list
$(window).on('load', function(){
	setTimeout(function(){
		var viewedUrl = '/bitrix/components/bitrix/catalog.element/ajax.php';
		var viewedData = {
			AJAX		: 'Y',
			SITE_ID		: SITE_ID,
			PARENT_ID	: $('.elementdetail').data('elementid'),
			PRODUCT_ID	: $('.elementdetail').find('.js-add2basketpid').val()
		};
		$.ajax({
			type: 'POST',
			url: viewedUrl,
			data: viewedData
		}).done(function(response){
			// console.warn( 'Element add to viewed' );
		}).fail(function(){
			console.warn( 'Element can\'t add to viewed' );
		});
	},500);
});
