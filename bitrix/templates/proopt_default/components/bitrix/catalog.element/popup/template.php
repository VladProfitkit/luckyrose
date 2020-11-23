<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();

// $this->setFrameMode(true);

$strMainID = $this->GetEditAreaId($arResult['ID']);

$iPriceCount = 0;
if (is_array($arResult['CAT_PRICES']) && count($arResult['CAT_PRICES']) > 0) {
    foreach ($arResult['CAT_PRICES'] as $sPriceCode => $arPrice) {
        if (!$arPrice['CAN_VIEW']) {
            continue;
        }
        $iPriceCount++;
    }
}
$bMultyPrice = ($iPriceCount > 1 ? true : false);

$haveOffers = (is_array($arResult['OFFERS']) && count($arResult['OFFERS'])>0) ? true : false;
if ($haveOffers)
    $product = &$arResult['OFFERS'][0];
else
    $product = &$arResult;

if($arResult['CATALOG_SUBSCRIBE'] == 'Y')
	$showSubscribeBtn = true;
else
	$showSubscribeBtn = false;

$canBuy = $product['CAN_BUY'];

?><div class="js-element js-elementid<?=$arResult['ID']?> <?if($haveOffers):?>offers<?else:?>simple<?endif;?> elementpopup<?
	if( isset($arResult['DAYSARTICLE2']) || isset($product['DAYSARTICLE2']) ) { echo ' da2'; }
	if( isset($arResult['QUICKBUY']) || isset($product['QUICKBUY']) ) { echo ' qb'; }
	?> propvision1" data-elementid="<?=$arResult['ID']?>"<?
	?> data-elementname="<?=CUtil::JSEscape($arResult['NAME'])?>" data-detail="<?=$arResult['DETAIL_PAGE_URL']?>"><?
	?><i class="icon da2qb"></i><?
	?><div class="elementpopupinner clearfix"><?
		?><a href="<?=$arResult['DETAIL_PAGE_URL']?>"><i class="icon da2qb"></i></a><?
		// -- LEFT BLOCK
		?><div class="block left"><?
			?><div class="ppadding"><?
				?><div class="name"><a href="<?=$arResult['DETAIL_PAGE_URL']?>"><?=$arResult['NAME']?></a></div><?
				?><div class="pictures changegenimage"><?
        ?><div class="pic"><?

            $arItem = &$arResult;
            // stickers
            include($_SERVER['DOCUMENT_ROOT'].SITE_TEMPLATE_PATH.'/template_ext/stickers.php');

            // get _$strAlt_ and _$strTitle_
            include($_SERVER['DOCUMENT_ROOT'].SITE_TEMPLATE_PATH.'/template_ext/img_alt_title.php');
            if (isset($arResult['FIRST_PIC_DETAIL']['SRC'])) {
                ?><div class="glass"><?
                    ?><img class="js_picture_glass genimage" src="<?=$arResult['FIRST_PIC_DETAIL']['SRC']?>" alt="<?=$strAlt?>" title="<?=$strTitle?>" /><?
                    ?><div class="glass_lupa" data-src=".fancyimages"></div><?
                ?></div><?
            } else {
                ?><img src="<?=$arResult['NO_PHOTO']['src']?>" alt="<?=$strAlt?>" title="<?=$strTitle?>" /><?
            }

            // TIMERS
            $arTimers = array();
            if ($arResult['HAVE_DA2'] == 'Y') {
                if( isset($arResult['DAYSARTICLE2']) ) {
                    $arTimers[] = $arResult['DAYSARTICLE2'];
                } elseif ($haveOffers) {
                    foreach ($arResult['OFFERS'] as $arOffer) {
                        if (isset($arOffer['DAYSARTICLE2'])) {
                            $arTimers[] = $arOffer['DAYSARTICLE2'];
                        }
                    }
                }
            } elseif ($arResult['HAVE_QB'] == 'Y') {
                if (isset($arResult['QUICKBUY'])) {
                    $arTimers[] = $arResult['QUICKBUY'];
                } elseif ($haveOffers) {
                    foreach ($arResult['OFFERS'] as $arOffer) {
                        if (isset($arOffer['QUICKBUY'])) {
                            $arTimers[] = $arOffer['QUICKBUY'];
                        }
                    }
                }
            }

            if (is_array($arTimers) && count($arTimers) > 0) {
                ?><div class="timers"><?
                    $haveVision = false;
                    foreach ($arTimers as $arTimer) {
                        $KY = 'TIMER';
                        if (isset($arTimer['DINAMICA_EX'])) {
                            $KY = 'DINAMICA_EX';
                        }
            $jsTimer = array(
              'DATE_FROM' => $arTimer[$KY]['DATE_FROM'],
              'DATE_TO' => $arTimer[$KY]['DATE_TO'],
              'AUTO_RENEWAL' => $arTimer['AUTO_RENEWAL'],
            );
            if (isset($arTimer['DINAMICA'])) {
              $jsTimer['DINAMICA_DATA'] = $arTimer['DINAMICA'] == 'custom' ? array_flip(unserialize($arTimer['DINAMICA_DATA'])) : $arTimer['DINAMICA'];
            }
                        ?><div class="timer <?if(isset($arTimer['DINAMICA_EX'])):?>da2<?else:?>qb<?endif;?> js-timer_id<?=$arTimer['ELEMENT_ID']?> clearfix" style="display:<?
                            if (($arResult['ID'] == $arTimer['ELEMENT_ID'] || $product['ID'] == $arTimer['ELEMENT_ID']) && !$haveVision) {
                                ?>inline-block<?
                                $haveVision = true;
                            } else {
                                ?>none<?
                            }
                            ?>;" data-timer='<?=json_encode($jsTimer)?>'><?
                            ?><div class="clock"><i class="icon"></i></div><?
                            ?><div class="intimer clearfix" data-dateto="<?=$arTimer[$KY]['DATE_TO']?>"><?
                                ?><div class="val"<?=($arTimer[$KY]['DAYS'] < 1 ? ' style="display: none;"' : '');?>><?
                                    ?><div class="value result-day"><?
                                    echo($arTimer[$KY]['DAYS']>9?$arTimer[$KY]['DAYS']:'0'.$arTimer[$KY]['DAYS'] )
                                    ?></div><div class="podpis"><?=GetMessage('QB_AND_DA2_DAY')?></div></div><?
                                ?><div class="val"><div class="value result-hour"><?
                                    echo($arTimer[$KY]['HOUR']>9?$arTimer[$KY]['HOUR']:'0'.$arTimer[$KY]['HOUR'] )
                                    ?></div><div class="podpis"><?=GetMessage('QB_AND_DA2_HOUR')?></div></div><?
                                ?><div class="val"><div class="value result-minute"><?
                                    echo($arTimer[$KY]['MINUTE']>9?$arTimer[$KY]['MINUTE']:'0'.$arTimer[$KY]['MINUTE'] )
                                    ?></div><div class="podpis "><?=GetMessage('QB_AND_DA2_MIN')?></div></div><?
                                    ?><div class="val"<?=($arTimer[$KY]['DAYS'] > 0 ? ' style="display: none;"' : '');?>><div class="value result-second"><?
                                        echo($arTimer[$KY]['SECOND']>9?$arTimer[$KY]['SECOND']:'0'.$arTimer[$KY]['SECOND'] )
                                        ?></div><div class="podpis "><?=GetMessage('QB_AND_DA2_SEC')?></div></div><?
                                if (isset($arTimer['DINAMICA_EX']) || isset($arTimer['TIMER'])) {
                                    ?><div class="val ml"><div class="value"><span class="num_percent">0</span>%</div><div class="podpis"><?=GetMessage('QB_AND_DA2_PRODANO')?></div></div><?
                                }
                            ?></div><?
                            if (isset($arTimer['DINAMICA_EX']) || isset($arTimer['TIMER'])) {
                                ?><div class="clear"></div><div class="progressbar"><div class="progress" style="width:0%;"></div></div><?
                            }
                        ?></div><?
                    }
                ?></div><?
            }
            // /TIMERS
        ?></div><?
        if (isset($arResult['FIRST_PIC_DETAIL']['SRC'])) {
            ?>
            <?
            ?><div class="picslider horizontal scrollp"><?
                ?><a rel="nofollow" class="scrollbtn prev page" href="#"><svg class="svg-icon"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-arrow-linear-left"></use></svg></a><?
                ?><a rel="nofollow" class="scrollbtn next page" href="#"><svg class="svg-icon"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-arrow-linear-right"></use></svg></a><?
                ?><div class="d_jscrollpane scroll horizontal-only" id="d_scroll_<?=$arResult['ID']?>"><?
                    $imagesCnt = 0;
                    $imagesHTML = '';
                    $first = false;
                    if ($haveOffers) {
                        foreach ($arResult['OFFERS'] as $arOffer) {
                            if (is_array($arOffer['DETAIL_PICTURE']['RESIZE'])) {
                                $imagesHTML.= '<a rel="nofollow" class="changeimage';
                                if ($arOffer['ID'] == $product['ID']) {
                                    $imagesHTML.= ' scrollitem';
                                }
                                $imagesHTML.= ' imgoffer imgofferid'.$arOffer['ID'].'"';
                                if ($arOffer['ID'] == $product['ID']) {
                                    $imagesCnt++;
                                } else {
                                    $imagesHTML.= ' style="display:none;"';
                                }
                                $imagesHTML.= ' href="#">';
                                    $imagesHTML.= '<img src="'.$arOffer['DETAIL_PICTURE']['RESIZE']['src'].'" ';
                                        $imagesHTML.= 'alt="'.$arOffer['DETAIL_PICTURE']['ALT'].'" ';
                                        $imagesHTML.= 'title="'.$arOffer['DETAIL_PICTURE']['TITLE'].'" ';
                                        $imagesHTML.= 'data-bigimage="'.$arOffer['DETAIL_PICTURE']['SRC'].'" ';
                                    $imagesHTML.= '/>';
                                $imagesHTML.= '</a>';
                            }
                            if (is_array($arOffer['PROPERTIES'][$arParams['PROP_SKU_MORE_PHOTO']]['VALUE'][0]['RESIZE']))
                            {
                                foreach($arOffer['PROPERTIES'][$arParams['PROP_SKU_MORE_PHOTO']]['VALUE'] as $arImage)
                                {
                                    $imagesHTML.= '<a rel="nofollow" class="changeimage ';
                                    if($arOffer['ID']==$product['ID'])
                                    {
                                        $imagesHTML.= ' scrollitem';
                                    }
                                    $imagesHTML.= ' imgoffer imgofferid'.$arOffer['ID'].'"';
                                    if($arOffer['ID']==$product['ID'])
                                    {
                                        $imagesCnt++;
                                    } else {
                                        $imagesHTML.= ' style="display:none;"';
                                    }
                                    $imagesHTML.= ' href="#">';
                                        $imagesHTML.= '<img src="'.$arImage['RESIZE']['src'].'" ';
                                            $imagesHTML.= 'alt="'.$arOffer['NAME'].'" ';
                                            $imagesHTML.= 'title="'.$arOffer['NAME'].'" ';
                                            $imagesHTML.= 'data-bigimage="'.$arImage['SRC'].'" ';
                                        $imagesHTML.= '/>';
                                    $imagesHTML.= '</a>';
                                }
                            }
                        }
                    }
                    if (is_array($arResult['DETAIL_PICTURE']['RESIZE'])) {
                        $imagesHTML.= '<a rel="nofollow" class="changeimage scrollitem" href="#">';
                            $imagesHTML.= '<img src="'.$arResult['DETAIL_PICTURE']['RESIZE']['src'].'" ';
                                $imagesHTML.= 'alt="'.$strAlt.'" ';
                                $imagesHTML.= 'title="'.$strTitle.'" ';
                                $imagesHTML.= 'data-bigimage="'.$arResult['DETAIL_PICTURE']['SRC'].'" ';
                            $imagesHTML.= '/>';
                        $imagesHTML.= '</a>';
                        $imagesCnt++;
                    }
                    if (is_array($arResult['PROPERTIES'][$arParams['PROP_MORE_PHOTO']]['VALUE'][0]['RESIZE'])) {
                        foreach ($arResult['PROPERTIES'][$arParams['PROP_MORE_PHOTO']]['VALUE'] as $arImage) {
                            $imagesHTML.= '<a rel="nofollow" class="changeimage scrollitem" href="#">';
                                $imagesHTML.= '<img src="'.$arImage['RESIZE']['src'].'" ';
                                    $imagesHTML.= 'alt="'.$strAlt.'" ';
                                    $imagesHTML.= 'title="'.$strTitle.'" ';
                                    $imagesHTML.= 'data-bigimage="'.$arImage['SRC'].'" ';
                                $imagesHTML.= '/>';
                            $imagesHTML.= '</a>';
                            $imagesCnt++;
                        }
                    }
                    ?><div class="sliderin scrollinner" style="width:<?=($imagesCnt*112)?>px;"><?=$imagesHTML?></div><?
                ?></div><?
            ?></div><?
            ?><div class="fancyimages noned" title="<?=$arResult['NAME']?>"><?
                ?><div class="fancygallery"><?
                    ?><table class="changegenimage"><?
                        ?><tbody><?
                            ?><tr><?
                                ?><td class="image"><img class="max genimage" src="<?=$arResult['FIRST_PIC']['SRC']?>" alt="" title="" /></td><?
                                ?><td class="slider"><?
                                    ?><div class="picslider scrollp vertical"><?
                                        ?><a rel="nofollow" class="scrollbtn prev pop" href="#"><?
                                            ?><svg class="svg-icon"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-arrow-linear-up"></use></svg><?
                                        ?></a><?
                                        ?><div class="popd_jscrollpane scroll vertical-only max" id="d_scroll_popup_<?=$arResult['ID']?>"><?
                                            ?><div class="scrollinner"><?
                                                ?><?=$imagesHTML?><?
                                            ?></div><?
                                        ?></div><?
                                        ?><a rel="nofollow" class="scrollbtn next pop" href="#"><?
                                            ?><svg class="svg-icon"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-arrow-linear-down"></use></svg><?
                                        ?></a><?
                                    ?></div><?
                                ?></td><?
                            ?></tr><?
                        ?></tbody><?
                    ?></table><?
                ?></div><?
            ?></div><?
        }
    ?></div><?
			?></div>
			
			<?php // PRICES ?>
			<?php if ($bMultyPrice): ?>
				<div class="prices scrollp vertical">
					<a rel="nofollow" class="scrollbtn prev" href="#"><svg class="svg-icon"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-arrow-linear-up"></use></svg></a>
					<?php if ($arParams['USE_PRICE_COUNT']):?>
						<div class="prices_jscrollpane scroll vertical vertical-only" id="prs_scroll_<?=$arItem['ID']?>" style="height:<?if(count($product['PRICE_MATRIX']['COLS']) > 2):?>102<?else:?>68<?endif;?>px;">
							<table class="pricestable scrollinner">
								<tbody>
								<?
								$iPriceCnt = 0;
								foreach ($product['PRICE_MATRIX']['COLS'] as $typeID => $arType):
									$arPrice = array_shift($product['PRICE_MATRIX']['MATRIX'][$typeID]);
									?>
									<tr class="scrollitem <?if (++$cnt % 2 == 0): ?>even<? else: ?>odd<? endif; ?>">
										<td class="nowrap"><?=$arType['NAME_LANG']?></td>

										<td class="nowrap">
											<span class="price price_pdv_<?=$arType['NAME'];?><? if($arPrice['DISCOUNT_DIFF'] > 0):?> new<?endif;?>">
												<?= isset($arPrice["PRINT_DISCOUNT_VALUE"]) ? $arPrice["PRINT_DISCOUNT_VALUE"] : '&mdash;';?>
											</span>
										</td>
									</tr>
								<?php endforeach; ?>
								</tbody>
							</table>
						</div>
					<?php else: ?>
						<div class="prices_jscrollpane scroll vertical vertical-only" id="prs_scroll_<?=$arItem['ID']?>" style="height:<?if(count($product['PRICES']) > 2):?>102<?else:?>68<?endif;?>px;">
							<table class="pricestable scrollinner">
								<tbody>
								<?
								$iPriceCnt = 0;
								foreach ($product['PRICES'] as $sPriceCode => $arPrice):
									?>
									<tr class="scrollitem <?if (++$cnt % 2 == 0): ?>even<? else: ?>odd<? endif; ?>">
										<td class="nowrap"><?=$arResult['CAT_PRICES'][$sPriceCode]['TITLE']?></td>

										<td class="nowrap">
											<span class="price price_pdv_<?=$sPriceCode;?><? if($arPrice['DISCOUNT_DIFF'] > 0):?> new<?endif;?>">
												<?=isset($arPrice["PRINT_DISCOUNT_VALUE"]) ? $arPrice["PRINT_DISCOUNT_VALUE"] : '&mdash;';?>
											</span>
										</td>
									</tr>
								<?php endforeach; ?>
								</tbody>
							</table>
						</div>
					<?php endif; ?>
					<a rel="nofollow" class="scrollbtn next" href="#"><svg class="svg-icon"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-arrow-linear-down"></use></svg></a>
				</div>
			<?php else: ?>
				<div class="soloprice">
				<?php if ($arParams['USE_PRICE_COUNT']):?>
					<?php foreach ($product['PRICE_MATRIX']['COLS'] as $typeID => $arType): ?>
						<?php $arPrice = array_shift($product['PRICE_MATRIX']['MATRIX'][$typeID]); ?>
						<span class="price gen price_pdv_<?=$arType['NAME'];?>"><?=$arPrice['PRINT_DISCOUNT_VALUE']?></span>
						<?php if ($arPrice['DISCOUNT_DIFF'] > 0): ?>
							<span class="price old price_pv_<?=$arType['NAME'];?>"><?=$arPrice['PRINT_VALUE']?></span>
							<span class="discount price_pd_<?=$arType['NAME'];?>"><?=$arPrice['PRINT_DISCOUNT_DIFF']?></span>
					<?php endif; ?>
					<?php
						break;
					endforeach;
					?>
				<?php else: ?>
					<?php if (!empty($product['MIN_PRICE'])): ?>
						<?php
						$arPrice = $product['MIN_PRICE'];
						?>
						<span class="price gen price_pdv_<?=$sPriceCode?>"><?=$arPrice['PRINT_DISCOUNT_VALUE']?></span>
						<?php if ($arPrice['DISCOUNT_DIFF'] > 0): ?>
							<span class="price old price_pv_<?=$sPriceCode?>"><?=$arPrice['PRINT_VALUE']?></span>
							<span class="discount price_pd_<?=$sPriceCode?>"><?=$arPrice['PRINT_DISCOUNT_DIFF']?></span>
						<?php endif; ?>
					<?php else: ?>
						<?php foreach ($arResult['PRICES'] as $sPriceCode => $arResPrice):
							if (!$arResult['PRICES'][$sPriceCode]['CAN_VIEW']) {
								continue;
							}
							$arPrice = $product['PRICES'][$sPriceCode];
							?>
							<span class="price gen price_pdv_<?=$sPriceCode?>"><?=$arPrice['PRINT_DISCOUNT_VALUE']?></span>
							<?php if ($arPrice['DISCOUNT_DIFF'] > 0): ?>
								<span class="price old price_pv_<?=$sPriceCode?>"><?=$arPrice['PRINT_VALUE']?></span>
								<span class="discount price_pd_<?=$sPriceCode?>"><?=$arPrice['PRINT_DISCOUNT_DIFF']?></span>
							<?php endif; ?>
						<?php endforeach; ?>
					<?php endif; ?>
				<?php endif; ?>
				</div>
			<?php endif; ?>
		</div>
		
		<?php // -- RIGHT BLOCK ?>
		<div class="block right"><?
			?><div class="ppadding right-block"><?
				?><div class="propanddesc"><?
					// ARTICLE
					if( isset($product['PROPERTIES'][$arParams['PROP_SKU_ARTICLE']]['VALUE']) || isset($arResult['PROPERTIES'][$arParams['PROP_ARTICLE']]['VALUE']) )
					{
						?><div class="article"><?=GetMessage('ARTICLE')?>: <span class="offer_article" <?
							?>data-prodarticle="<?=( isset($arResult['PROPERTIES'][$arParams['PROP_ARTICLE']]['VALUE']) ? $arResult['PROPERTIES'][$arParams['PROP_ARTICLE']]['VALUE'] : '' )?>"><?
							?><?=( isset($product['PROPERTIES'][$arParams['PROP_SKU_ARTICLE']]['VALUE']) ? $product['PROPERTIES'][$arParams['PROP_SKU_ARTICLE']]['VALUE'] : $arResult['PROPERTIES'][$arParams['PROP_ARTICLE']]['VALUE'] )?><?
						?></span></div><?
					} else {
						?><div class="article" style="display:none;"><?=GetMessage('ARTICLE')?>: <span class="offer_article"></span></div><?
					}
					?>

					<?// PROPERTIES
					if ($arParams['HIGHLOAD'] == 'HIGHLOAD_TYPE_LIST') {
						if (is_array($arResult['OFFERS_EXT']['PROPERTIES']) && count($arResult['OFFERS_EXT']['PROPERTIES']) > 0) {
							?><div class="properties properties_list clearfix"><?
							foreach ($arResult['OFFERS_EXT']['PROPERTIES'] as $propCode => $arProperty) {
								$isColor = false;
								?><div class="offer_prop offer_prop_list prop_<?=$propCode?> closed<?
								if (is_array($arParams['PROPS_ATTRIBUTES_COLOR']) && in_array($propCode,$arParams['PROPS_ATTRIBUTES_COLOR'])) {
									$isColor = true;
									?> color<?
								}
								?>" data-code="<?=$propCode?>">
								<div class="offer_prop-name"><?=$arResult['OFFERS_EXT']['PROPS'][$propCode]['NAME']?>: </div><?
								?><div class="div_select"><?
									?><div class="div_options div_options_list"><?
									$firstVal = false;
									foreach ($arProperty as $value => $arValue) {
									?><span class="div_option<?
										if($arValue['FIRST_OFFER'] == 'Y'):?> selected<?
										elseif($arValue['DISABLED_FOR_FIRST'] == 'Y'):?> disabled<?
										endif;?>" data-value="<?=htmlspecialcharsbx($arValue['VALUE'])?>"><?
										if ($isColor) {
										?><span style="background-image:url('<?=$arValue['PICT']['SRC']?>');" title="<?=$arValue['VALUE']?>"></span><?
										} else {
										?><span class="list-item"><?=$arValue['VALUE']?></span><?
										}
									?></span><?
									if ($arValue['FIRST_OFFER'] == 'Y') {
										$firstVal = $arValue;
									}
									}
									?></div><?
									if (is_array($firstVal)) {
									?><div class="div_selected div_selected_list"><?
										if ($isColor) {
										?><span style="background-image:url('<?=$firstVal['PICT']['SRC']?>');" title="<?=$firstVal['VALUE']?>"></span><?
										} else {
										?><span><?=$firstVal['VALUE']?></span><?
										}
										?><svg class="svg-icon"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-arrow-filled-down"></use></svg><?
									?></div><?
									}
								?></div><?
								?></div><?
							}
							?></div><?
						}
					} else {
						if (is_array($arResult['OFFERS_EXT']['PROPERTIES']) && count($arResult['OFFERS_EXT']['PROPERTIES'])>0) {
							?><div class="properties clearfix"><?

							foreach ($arResult['OFFERS_EXT']['PROPERTIES'] as $propCode => $arProperty) {
								$isColor = false;
								?><div class="offer_prop prop_<?=$propCode?> closed<?
								if (is_array($arParams['PROPS_ATTRIBUTES_COLOR']) && in_array($propCode,$arParams['PROPS_ATTRIBUTES_COLOR'])) {
									$isColor = true;
									?> color<?
								}
								?>" data-code="<?=$propCode?>">
								<span class="offer_prop-name"><?=$arResult['OFFERS_EXT']['PROPS'][$propCode]['NAME']?>: </span><?
								?><div class="div_select"><?
									?><div class="div_options"><?
									$firstVal = false;
									foreach ($arProperty as $value => $arValue) {
									?><div class="div_option<?
										if($arValue['FIRST_OFFER'] == 'Y'):?> selected<?
										elseif($arValue['DISABLED_FOR_FIRST'] == 'Y'):?> disabled<?
										endif;?>" data-value="<?=htmlspecialcharsbx($arValue['VALUE'])?>"><?
										if ($isColor) {
										?><span style="background-image:url('<?=$arValue['PICT']['SRC']?>');" title="<?=$arValue['VALUE']?>"></span> &nbsp; <?=$arValue['VALUE']?><?
										} else {
										?><span><?=$arValue['VALUE']?></span><?
										}
									?></div><?
									if ($arValue['FIRST_OFFER'] == 'Y') {
										$firstVal = $arValue;
									}
									}
									?></div><?
									if (is_array($firstVal)) {
									?><div class="div_selected"><?
										if ($isColor) {
										?><span style="background-image:url('<?=$firstVal['PICT']['SRC']?>');" title="<?=$firstVal['VALUE']?>"></span><?
										} else {
										?><span><?=$firstVal['VALUE']?></span><?
										}
										?><svg class="svg-icon"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-arrow-filled-down"></use></svg><?
									?></div><?
									}
								?></div><?
								?></div><?
							}
							?></div><?
						}
					}
					?>
		
					<?php // DESCRIPTION
					if(isset($arResult['PREVIEW_TEXT']) && $arResult['PREVIEW_TEXT']!='')
					{
						?><div class="description"><div class="text"><?=$arResult['PREVIEW_TEXT']?></div><a class="more" href="<?=$arResult['DETAIL_PAGE_URL']?>" title="<?=$arResult['NAME']?>"><?=GetMessage('GOPRO.MORE')?></a></div><?
					}
				?></div><?
				// ADD2BASKET
				?><noindex><div class="buy"><?
					?><form class="add2basketform js-buyform<?=$arResult['ID']?> js-synchro<?if(!$product['CAN_BUY']):?> cantbuy<?endif;?> clearfix" name="add2basketform"><?
						?><input type="hidden" name="<?=$arParams['ACTION_VARIABLE']?>" value="ADD2BASKET"><?
						?><input type="hidden" name="<?=$arParams['PRODUCT_ID_VARIABLE']?>" class="js-add2basketpid" value="<?=$product['ID']?>"><?
						if ($arParams['USE_PRODUCT_QUANTITY']) {
							?><span class="quantity"><?
								?><span class="quantity_inner"><?
									?><a class="minus js-minus">-</a><?
									?><input type="text" class="js-quantity<?php if ($arParams['USE_PRICE_COUNT']):?> js-use_count<?endif;?>" name="<?=$arParams['PRODUCT_QUANTITY_VARIABLE']?>" value="<?=$product['CATALOG_MEASURE_RATIO']?>" data-ratio="<?=$product['CATALOG_MEASURE_RATIO']?>"><?
									if ($arParams['OFF_MEASURE_RATION'] != 'Y') {
										?><span class="js-measurename"><?=$product['CATALOG_MEASURE_NAME']?></span><?
									}
									?><a class="plus js-plus">+</a><?
								?></span><?
							?></span><?
						}
						?><a rel="nofollow" class="submit add2basket btn1" href="#" title="<?=GetMessage('ADD2BASKET')?>"><?=GetMessage('CT_BCE_CATALOG_ADD')?></a><?
                        // SUBSCRIBE
                        if ($showSubscribeBtn):
                            $APPLICATION->includeComponent('bitrix:catalog.product.subscribe', 'gopro',
                                array(
                                    'PRODUCT_ID' => $arResult['ID'],
                                    'BUTTON_ID' => $strMainID.'_subscribe_link',
                                    'BUTTON_CLASS' => 'btn3',
                                    'DEFAULT_DISPLAY' => true,
                                ),
                                $component,
                                array('HIDE_ICONS' => 'Y')
                            );
                        endif;
						?><a rel="nofollow" class="inbasket btn2" href="<?=$arParams['BASKET_URL']?>" title="<?=GetMessage('INBASKET_TITLE')?>"><?=GetMessage('INBASKET')?></a><?
						?><input type="submit" name="submit" class="noned" value="" /><?
					?></form><?
				?></div></noindex><?
				// COMPARE
				if ($arParams['USE_COMPARE'] == 'Y') {
					?><div class="compare"><?
						?><a rel="nofollow" class="checkbox add2compare" href="<?=$arResult['COMPARE_URL']?>"><label><?=GetMessage('ADD2COMPARE')?></label></a><?
					?></div><?
				}
				// FAVORITE & SHARE
				?><div class="favorishare clearfix"><?
					if ($arParams['USE_FAVORITE'] == 'Y' || $arParams['USE_SHARE'] == 'Y') {
						// FAVORITE
						if ($arParams['USE_FAVORITE'] == 'Y') {
							?><div class="favorite"><?
								?><a rel="nofollow" class="add2favorite" href="#favorite"><svg class="svg-icon"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-heart"></use></svg><?=GetMessage('FAVORITE')?></a><?
							?></div><?
						}
						// SHARE
						if ($arParams['USE_SHARE'] == 'Y') {
							?><div class="share"><?
								?><span class="b-share"><a class="fancyajax fancybox.ajax email2friend b-share__handle b-share__link b-share-btn__vkontakte" href="<?=SITE_DIR?>include/popup/email2friend/?link=<?=CUtil::JSUrlEscape('http://'.$_SERVER['HTTP_HOST'].$arResult['DETAIL_PAGE_URL'])?>" title="<?=GetMessage('EMAIL2FRIEND')?>"><svg class="svg-icon"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-email"></use></svg></a></span><?
								?><span class="js-yasha2" id="detailYaShare_<?=$arResult['ID']?>"></span><?
								?><script type="text/javascript">
								new Ya.share2('detailYaShare_<?=$arResult['ID']?>', {
									content: {
										<?if(isset($arResult['PREVIEW_TEXT']) && $arResult['PREVIEW_TEXT']!=''):?>description: '<?=CUtil::JSEscape($arItem['PREVIEW_TEXT'])?>',<?endif;?>
										<?if(isset($arResult['FIRST_PIC'])):?>image: '//<?=$_SERVER['HTTP_HOST']?><?=$arResult['FIRST_PIC']['RESIZE']['src']?>',<?endif;?>
										url: '//<?=$_SERVER['HTTP_HOST']?><?=$arResult['DETAIL_PAGE_URL']?>',
										title: '<?=CUtil::JSEscape($arResult['NAME'])?>'
									},
									theme: {
										services: 'vkontakte,facebook,twitter',
										size: 's',
										bare: false
									}
								});
								</script><?
							?></div><?
						}
					}
				?></div><?
			?></div><?
		?></div><?
	?></div><?
?></div>
