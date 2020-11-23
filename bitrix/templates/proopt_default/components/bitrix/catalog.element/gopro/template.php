<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();

$this->setFrameMode(true);

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

?><div class="elementdetail js-element js-elementid<?=$arResult['ID']?> <?if($haveOffers):?>offers<?else:?>simple<?endif;?><?
    if( isset($arResult['DAYSARTICLE2']) || isset($product['DAYSARTICLE2']) ) { echo ' da2'; }
    if( isset($arResult['QUICKBUY']) || isset($product['QUICKBUY']) ) { echo ' qb'; }
    ?> propvision1 clearfix" data-elementid="<?=$arResult['ID']?>" <?
    ?>data-elementname="<?=CUtil::JSEscape($arResult['NAME'])?>" <?
    ?>data-detail="<?=$arResult['DETAIL_PAGE_URL']?>" <?
    ?>data-productid="<?=$product['ID']?>" <?
    ?>><i class="icon da2qb"></i><?

    // PICTURES
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
            ?><div class="zoom"><?
                ?><svg class="svg-icon"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-search"></use></svg><?=GetMessage('ZOOM')?><?
            ?></div><?
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
    // INFO
    ?><div class="detail-product__info"><?
        // ARTICLE && STORES
        ?><div class="articleandstores clearfix"><?
            // ARTICLE
            if (isset($product['PROPERTIES'][$arParams['PROP_SKU_ARTICLE']]['VALUE']) || isset($arResult['PROPERTIES'][$arParams['PROP_ARTICLE']]['VALUE'])) {
                ?><div class="article"><?
                    if ($product['PROPERTIES'][$arParams['PROP_SKU_ARTICLE']]['VALUE']!='' || $arResult['PROPERTIES'][$arParams['PROP_ARTICLE']]['VALUE'] != '') {
                        ?><?=GetMessage('ARTICLE')?>: <span class="offer_article" <?
                            ?>data-prodarticle="<?=( $arResult['PROPERTIES'][$arParams['PROP_ARTICLE']]['VALUE']!='' ? $arResult['PROPERTIES'][$arParams['PROP_ARTICLE']]['VALUE'] : '' )?>"><?
                            ?><?=( $product['PROPERTIES'][$arParams['PROP_SKU_ARTICLE']]['VALUE']!='' ? $product['PROPERTIES'][$arParams['PROP_SKU_ARTICLE']]['VALUE'] : $arResult['PROPERTIES'][$arParams['PROP_ARTICLE']]['VALUE'] )?><?
                        ?></span><?
                    }
                ?></div><?
            } else {
                ?><div class="article" style="visibility: hidden;"><?=GetMessage('ARTICLE')?>: <span class="offer_article"></span></div><?
            }
            // STORES
            if($arParams['USE_STORE']=='Y') {
                if (!empty($arParams['PROP_STORE_REPLACE_SECTION']) && $arResult['DISPLAY_PROPERTIES'][$arParams['PROP_STORE_REPLACE_DETAIL']]['DISPLAY_VALUE'] != '') {
                    ?><div class="stores"><?
                        ?><span><?=$arResult['DISPLAY_PROPERTIES'][$arParams['PROP_STORE_REPLACE_DETAIL']]['DISPLAY_VALUE']?></span><?
                    ?></div><?
                } else {
                    ?><?$APPLICATION->IncludeComponent(
                        'bitrix:catalog.store.amount',
                        'gopro',
                        array(
                            "ELEMENT_ID" => $arResult['ID'],
                            "STORE_PATH" => $arParams['STORE_PATH'],
                            "CACHE_TYPE" => "A",
                            "CACHE_TIME" => "36000",
                            "MAIN_TITLE" => $arParams['MAIN_TITLE'],
                            "USE_STORE_PHONE" => $arParams['USE_STORE_PHONE'],
                            "SCHEDULE" => $arParams['USE_STORE_SCHEDULE'],
                            "USE_MIN_AMOUNT" => "N",
                            "GOPRO_USE_MIN_AMOUNT" => $arParams['USE_MIN_AMOUNT'],
                            "MIN_AMOUNT" => $arParams['MIN_AMOUNT'],
                            "SHOW_EMPTY_STORE" => $arParams['SHOW_EMPTY_STORE'],
                            "SHOW_GENERAL_STORE_INFORMATION" => $arParams['SHOW_GENERAL_STORE_INFORMATION'],
                            "USER_FIELDS" => $arParams['USER_FIELDS'],
                            "FIELDS" => $arParams['FIELDS'],
                            // gopro
                            'DATA_QUANTITY' => $arResult['DATA_QUANTITY'],
                            'FIRST_ELEMENT_ID' => $product['ID'],
                        ),
                        $component,
                        array('HIDE_ICONS'=>'Y')
                    );?><?
                }
            }
        ?></div>
        
        <?php // prices ?>
        <?php if ($bMultyPrice): ?>
            <div class="prices horizontal scrollp">
                <a rel="nofollow" class="scrollbtn prev" href="#"><span></span><svg class="svg-icon"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-arrow-linear-left"></use></svg></a>
                <a rel="nofollow" class="scrollbtn next" href="#"><span></span><svg class="svg-icon"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-arrow-linear-right"></use></svg></a>
                <div class="prs_jscrollpane scroll horizontal-only" id="prs_scroll_<?=$arResult['ID']?>">
                <?php if ($arParams['USE_PRICE_COUNT'] && !empty($product['PRICE_MATRIX']['COLS'])):?>
                    <div class="scrollinner" style="width:<?=(count($product['PRICE_MATRIX']['COLS']) * 160)?>px;">
                        <table class="pricestable scrollitem">
                            <thead>
                                <tr>
                                    <?php foreach ($product['PRICE_MATRIX']['COLS'] as $typeID => $arType): ?>
                                        <?php $arPrice = reset($product['PRICE_MATRIX']['MATRIX'][$typeID]); ?>
                                        <th class="nowrap"><?=$arType['NAME_LANG'];?></th>
                                        <?php ob_start(); ?>
                                        <td class="nowrap">
                                            <span class="price old price_pv_<?=$arType['NAME'];?>">
                                                <?=($arPrice['DISCOUNT_DIFF'] ? $arPrice['PRINT_VALUE'] : '')?>
                                            </span>
                                        </td>
                                        <?php
                                        $sPriceHTML .= ob_get_clean();
                                        ob_start();
                                        ?>
                                        <td class="nowrap">
                                            <span class="price<?php
                                            if ($arPrice['DISCOUNT_DIFF']) { echo ' new'; }
                                            ?> price_pdv_<?=$arType['NAME'];?>">
                                                <?=$arPrice['PRINT_DISCOUNT_VALUE'];?>
                                            </span>
                                        </td>
                                        <?php $sDiscountHTML .= ob_get_clean(); ?>
                                    <?php endforeach; ?>
                                </tr>
                            </thead>
                            <tbody>
                                <tr><?=$sPriceHTML;?></tr>
                                <tr><?=$sDiscountHTML;?></tr>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="scrollinner" style="width:<?=(count($product['PRICES']) * 160);?>px;">
                        <table class="pricestable scrollitem">
                            <thead>
                            <tr>
                                <?php foreach($product['PRICES'] as $sPriceCode => $arPrice): ?>
                                    <th class="nowrap"><?=$arResult['CAT_PRICES'][$sPriceCode]['TITLE']?></th>
                                    <?php ob_start(); ?>
                                    <td class="nowrap">
                                        <span class="price old price_pv_<?=$sPriceCode;?>">
                                            <?=($arPrice['DISCOUNT_DIFF'] ? $arPrice['PRINT_VALUE'] : '')?>
                                        </span>
                                    </td>
                                    <?php $sPriceHTML .= ob_get_clean(); ?>
                                    <?php ob_start(); ?>
                                    <td class="nowrap">
                                        <span class="price<?php
                                        if ($arPrice['DISCOUNT_DIFF'] > 0):
                                            echo ' new';
                                        endif;
                                        ?> price_pdv_<?=$sPriceCode;?>">
                                            <?=$arPrice['PRINT_DISCOUNT_VALUE'];?>
                                        </span>
                                    </td>
                                    <?php $sDiscountHTML .= ob_get_clean(); ?>
                                <?php endforeach; ?>
                            </tr>
                            </thead>
                            <tbody>
                                <tr><?=$sPriceHTML;?></tr>
                                <tr><?=$sDiscountHTML;?></tr>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
                </div>
            </div>
        <?php else: ?>
            <div class="soloprice">
                <table>
                <?php if ($arParams['USE_PRICE_COUNT'] && !empty($product['PRICE_MATRIX']['COLS'])):?>
                    <?php foreach ($product['PRICE_MATRIX']['COLS'] as $typeID => $arType): ?>
                        <?php $arPrice = reset($product['PRICE_MATRIX']['MATRIX'][$typeID]); ?>
                        <tr>
                            <td>
                                <div class="line"><span class="name"><?=GetMessage('SOLOPRICE_PRICE')?><span></div>
                            </td>
                            <td class="nowrap">
                                <span class="price<?php if ($arPrice['DISCOUNT_DIFF']): ?> new<?php endif; ?> gen price_pdv_<?=$arType['NAME'];?>">
                                    <?=$arPrice['PRINT_DISCOUNT_VALUE'];?>
                                </span>
                            </td>
                        </tr>
                        <tr class="hideifzero js-discount-hideifzero" <?php if ($arPrice['DISCOUNT_DIFF'] < 1): ?>style="display: none;"<?php endif; ?>>
                            <td>
                                <div class="line">
                                    <span class="name"><?=GetMessage('SOLOPRICE_PRICE_OLD')?><span>
                                </div>
                            </td>
                            <td class="nowrap">
                                <span class="price old price_pv_<?=$arType['NAME'];?>">
                                    <?=$arPrice['PRINT_VALUE'];?>
                                </span>
                            </td>
                        </tr>
                        <tr class="hideifzero js-discount-hideifzero" <?php if ($arPrice['DISCOUNT_DIFF'] < 1): ?>style="display: none;"<?php endif; ?>>
                            <td>
                                <div class="line"><span class="name"><?=GetMessage('SOLOPRICE_DISCOUNT')?><span></div>
                            </td>
                            <td class="nowrap">
                                <span class="discount price_pd_<?=$arType['NAME'];?>">
                                    <?=$arPrice['PRINT_DISCOUNT_DIFF'];?>
                                </span>
                            </td>
                        </tr>
                        <?
                        break;
                    endforeach;
                    ?>
                <?php else: ?>
                    <?php
                    foreach($product['PRICES'] as $sPriceCode => $arPrice):
                        if ($arPrice['MIN_PRICE'] != 'Y') {
                            continue;
                        }
                        ?>
                        <tr>
                            <td>
                                <div class="line"><span class="name"><?=GetMessage('SOLOPRICE_PRICE')?></span></div>
                            </td>
                            <td class="nowrap">
                                <span class="price<?php
                                if ($product['MIN_PRICE']['DISCOUNT_DIFF'] > 0) {
                                    echo ' new';
                                }
                                ?> gen price_pdv_<?=$sPriceCode?>">
                                    <?=$arPrice['PRINT_DISCOUNT_VALUE'];?>
                                </span>
                            </td>
                        </tr>
                        <tr class="hideifzero js-discount-hideifzero" <?php if ($arPrice['DISCOUNT_DIFF'] < 1): ?>style="display: none;"<?php endif; ?>>
                            <td>
                                <div class="line">
                                    <span class="name"><?=GetMessage('SOLOPRICE_PRICE_OLD')?></span>
                                </div>
                            </td>
                            <td class="nowrap">
                                <span class="price old price_pv_<?=$sPriceCode?>"><?=$arPrice['PRINT_VALUE']?></span>
                            </td>
                        </tr>
                        <tr class="hideifzero js-discount-hideifzero" <?php if ($arPrice['DISCOUNT_DIFF'] < 1): ?>style="display: none;"<?php endif; ?>>
                            <td>
                                <div class="line"><span class="name"><?=GetMessage('SOLOPRICE_DISCOUNT')?></span></div>
                            </td>
                            <td class="nowrap">
                                <span class="discount price_pd_<?=$sPriceCode?>"><?=$arPrice['PRINT_DISCOUNT_DIFF']?></span>
                            </td>
                        </tr>
                    <?php
                        break;
                    endforeach;
                    ?>
                <?php endif; ?>
                </table>
            </div>
        <?php endif; ?>

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
    
        if ($haveOffers) {
            ?><div class="charactersiticSKU"><?
                foreach ($product['DISPLAY_PROPERTIES'] as $arProp) {
                    if (!in_array($arProp['CODE'], $arParams['PROPS_ATTRIBUTES'])) {
                        ?><div class="SKU_prop prop_num<?=$arProp['CODE']?>">
                            <span class="name_prop_sku"><?=$arProp['NAME']?>: </span>
                            <span class="val_prop_sku"><?
                            echo(is_array($arProp['DISPLAY_VALUE']) ? implode(' / ', $arProp['DISPLAY_VALUE']) : $arProp['DISPLAY_VALUE']);
                            ?></span>
                        </div><?
                    }
                }
            ?></div><?
        }
    
        // ADD2BASKET
        ?><!--noindex--><div class="buy clearfix"><?
            ?><form class="add2basketform js-buyform<?=$arResult['ID']?> js-synchro<?if(!$product['CAN_BUY']):?> cantbuy<?endif;?> clearfix" name="add2basketform"><?
                ?><input type="hidden" name="<?=$arParams['ACTION_VARIABLE']?>" value="ADD2BASKET"><?
                ?><input type="hidden" name="<?=$arParams['PRODUCT_ID_VARIABLE']?>" class="js-add2basketpid" value="<?=$product['ID']?>"><?
                if ($arParams['USE_PRODUCT_QUANTITY']) {
                    ?><span class="quantity"><?
                        ?><span class="quantitytitle"><?=GetMessage('CT_BCE_QUANTITY')?>&nbsp; &nbsp;</span><?
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
                ?><a rel="nofollow" class="submit add2basket btn1" href="#" title="<?=GetMessage('ADD2BASKET')?>"><?
                    ?><svg class="svg-icon"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-cart-2"></use></svg><?
                    ?><?=GetMessage('CT_BCE_CATALOG_ADD')?><?
                ?></a><?
                ?><a rel="nofollow" class="inbasket btn2" href="<?=$arParams['BASKET_URL']?>" title="<?=GetMessage('INBASKET_TITLE')?>"><?
                    ?><svg class="svg-icon"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-check2"></use></svg><?
                    ?><?=GetMessage('INBASKET')?><?
                ?></a><?
                ?><a rel="nofollow" class="go2basket" href="<?=$arParams['BASKET_URL']?>"><?=GetMessage('INBASKET_TITLE')?></a>
                <?if(false):?>
                <a rel="nofollow" class="buy1click js-buy1click detail fancyajax fancybox.ajax btn3" href="<?=SITE_DIR?>include/popup/buy1click/" title="<?=GetMessage('BUY1CLICK')?>" data-insertdata='{"RS_ORDER_IDS":<?=$product['ID']?>}'><?=GetMessage('BUY1CLICK')?></a>
                <?endif;

                // SUBSCRIBE
                if ($showSubscribeBtn):
                    $APPLICATION->includeComponent('bitrix:catalog.product.subscribe', 'gopro',
                        array(
                            'PRODUCT_ID' => $product['ID'],
                            'BUTTON_ID' => $strMainID.'_subscribe_link',
                            'BUTTON_CLASS' => 'btn3 js-product-subscribe',
                            'DEFAULT_DISPLAY' => true,
                        ),
                        $component,
                        array('HIDE_ICONS' => 'Y')
                    );
                endif;

                ?><input type="submit" name="submit" class="noned" value="" /><?
            ?></form><?
        ?></div><!--/noindex--><?
        
        // COMPARE & FAVORITE & CHEAPER
        ?><div class="threeblock clearfix"><?
            // COMPARE
            if ($arParams['USE_COMPARE'] == 'Y') {
                ?><div class="compare"><?
                    ?><a rel="nofollow" class="checkbox add2compare" href="<?=$arResult['COMPARE_URL']?>"><span class="label js-label"><?=GetMessage('ADD2COMPARE')?></span></a><?
                ?></div><?
            }
            
            // FAVORITE & CHEAPER
            if ($arParams['USE_FAVORITE']=='Y' || $arParams['USE_CHEAPER']=='Y') {
                ?><div class="favoriteandcheaper"><?
                    // FAVORITE
                    if ($arParams['USE_FAVORITE'] == 'Y') {
                        ?><div class="favorite"><?
                            ?><a rel="nofollow" class="checkbox add2favorite" href="#favorite"><span class="label js-label"><?=GetMessage('FAVORITE')?></span></a><?
                        ?></div><?
                    }
                ?></div><?
            }
        ?></div>

        <?php if ($arParams['USE_DELIVERY_COST_BLOCK'] == 'Y' || $arParams['USE_DELIVERY_COST_TAB'] == 'Y'): ?>
            <?$APPLICATION->IncludeComponent(
                "redsign:delivery.calculator",
                "block",
                array(
                    "CURRENCY" => $arParams['DELIVERY_CURRENCY_ID'],
                    "ELEMENT_ID" => $product['ID'],
                    "QUANTITY" => isset($arResult['QUANTITY']) ? $arResult['QUANTITY'] : 1,
                    "DELIVERY" => array(),
                    "BLOCK_DELIVERY" => $arParams['USE_DELIVERY_COST_BLOCK'],
                    "TAB_DELIVERY" => $arParams['USE_DELIVERY_COST_TAB'],
                    "DELIVERY_COST_PAY_LINK" => $arParams['DELIVERY_COST_PAY_LINK'],
                    "DELIVERY_COST_DELIVERY_LINK" => $arParams['DELIVERY_COST_DELIVERY_LINK'],
                ),
                false
            );?>
        <?php endif; ?>
        
        <?
        // SHARE
        if ($arParams['USE_SHARE'] == 'Y' && !empty($arParams["SOC_SHARE_ICON"]) && $arParams['GOPRO']['OFF_YANDEX'] != 'Y') {
            ?><div class="share">
                <div class="ya-share2"
                    data-services="<?=implode(',', $arParams["SOC_SHARE_ICON"])?>"
                    data-lang="<?=LANGUAGE_ID?>"
                    data-size="s"
                    data-copy="first"
                ></div>
            </div><?
        }
        
        // PREVIEW TEXT
        if ($arParams['SHOW_PREVIEW_TEXT']=='Y' && $arResult['PREVIEW_TEXT'] != '') {
            ?><div class="previewtext"><?
                ?><?=$arResult['PREVIEW_TEXT']?><?
                if ($arResult['TABS']['DETAIL_TEXT']) {
                    ?>&nbsp;<a class="go2detailfrompreview" href="#detailtext"><?=GetMessage('GO2DETAILFROMPREVIEW')?></a><?
                }
            ?></div><?
        }
    ?></div><?
?></div><?
?><script>
    BX.message({
        RSGoPro_DETAIL_PROD_ID: '<?=GetMessageJS('RSGOPRO.DETAIL_PROD_ID')?>',
        RSGoPro_DETAIL_PROD_NAME: '<?=GetMessageJS('RSGOPRO.DETAIL_PROD_NAME')?>',
        RSGoPro_DETAIL_PROD_LINK: '<?=GetMessageJS('RSGOPRO.DETAIL_PROD_LINK')?>',
        RSGoPro_DETAIL_CHEAPER_TITLE: '<?=GetMessageJS('RSGOPRO.DETAIL_CHEAPER_TITLE')?>',
    });
    $(document).ready(function() {
        if ($(document).width()<670) {
            $(".add2review").css("margin-top", "10px");
            $(".add2review").css("margin-left", "0px");
        }
    });
</script><?
// tabs
// tabs -> HEADERS
$this->SetViewTarget('TABS_HTML_HEADERS');
if ($arResult['TABS']['DETAIL_TEXT']) {
    ?><a class="switcher" href="#detailtext"><?=GetMessage('TABS_DETAIL_TEXT')?></a><?
}
if ($arResult['TABS']['DISPLAY_PROPERTIES']) {
    ?><a class="switcher" href="#properties"><?=GetMessage('TABS_PROPERTIES')?></a><?
}
if ($arResult['TABS']['DELIVERY_COST']) {
    ?><a class="switcher" href="#deliverycost"><?=GetMessage('TABS_DELIVERY_COST')?></a><?
}
if ($arResult['TABS']['SET']) {
    ?><a class="switcher" href="#set"><?=GetMessage('TABS_SET')?></a><?
}
if ($arResult['TABS']['PROPS_TABS']) {
    foreach ($arParams['PROPS_TABS'] as $sPropCode) {
        if (
            $sPropCode != '' &&
            $arResult['PROPERTIES'][$sPropCode]['PROPERTY_TYPE']=='E' &&
            isset($arResult['PROPERTIES'][$sPropCode]['VALUE']) &&
            is_array($arResult['PROPERTIES'][$sPropCode]['VALUE']) &&
            count($arResult['PROPERTIES'][$sPropCode]['VALUE'])>0
        ) {
            ?><a class="switcher" href="#prop<?=$sPropCode?>"><?=$arResult['PROPERTIES'][$sPropCode]['NAME']?></a><?
        } elseif(
            $sPropCode!='' &&
            $arResult['PROPERTIES'][$sPropCode]['PROPERTY_TYPE']=='F' &&
            isset($arResult['PROPERTIES'][$sPropCode]['VALUE']) &&
            is_array($arResult['PROPERTIES'][$sPropCode]['VALUE']) &&
            count($arResult['PROPERTIES'][$sPropCode]['VALUE'])>0
        ) { // files
            ?><a class="switcher" href="#prop<?=$sPropCode?>"><?=$arResult['PROPERTIES'][$sPropCode]['NAME']?></a><?
        } elseif( $sPropCode!='' && isset($arResult['DISPLAY_PROPERTIES'][$sPropCode]['DISPLAY_VALUE']) ) { // else
            ?><a class="switcher" href="#prop<?=$sPropCode?>"><?=$arResult['DISPLAY_PROPERTIES'][$sPropCode]['NAME']?></a><?
        }
    }
}
$this->EndViewTarget();
// tabs -> CONTENTS
$this->SetViewTarget('TABS_HTML_CONTENTS');
if ($arResult['TABS']['DETAIL_TEXT']) {
    ?><div class="content selected" id="detailtext"><?
        ?><a class="switcher" href="#detailtext"><?=GetMessage('TABS_DETAIL_TEXT')?></a><?
        ?><div class="contentbody clearfix"><?
            ?><div class="contentinner"><?
                ?><?=$arResult['DETAIL_TEXT']?><?
            ?></div><?
        ?></div><?
    ?></div><?
}
if ($arResult['TABS']['DISPLAY_PROPERTIES']) {
    ?><div class="content properties selected" id="properties"><?
        ?><a class="switcher" href="#properties"><?=GetMessage('TABS_PROPERTIES')?></a><?
        ?><div class="contentbody clearfix"><?
            ?><div class="contentinner"><?
                $arTemp = array();
                if (is_array($arParams['PROPS_TABS']) && count($arParams['PROPS_TABS']) > 0) {
                    foreach ($arParams['PROPS_TABS'] as $sPropCode) {
                        $arTemp[$sPropCode] = $sPropCode;
                    }
                }
                if (is_array($arParams['STICKERS_PROPS']) && count($arParams['STICKERS_PROPS']) > 0) {
                    foreach ($arParams['STICKERS_PROPS'] as $sPropCode) {
                        $arTemp[$sPropCode] = $sPropCode;
                    }
                }
                if ($arParams['PROP_STORE_REPLACE_SECTION'] != '') {
                    $arTemp[$arParams['PROP_STORE_REPLACE_SECTION']] = $arParams['PROP_STORE_REPLACE_SECTION'];
                }
                if ($arParams['PROP_STORE_REPLACE_DETAIL'] != '') {
                    $arTemp[$arParams['PROP_STORE_REPLACE_DETAIL']] = $arParams['PROP_STORE_REPLACE_DETAIL'];
                }
                $APPLICATION->IncludeComponent('redsign:grupper.list',
                    'gopro',
                    array(
                        'DISPLAY_PROPERTIES' => array_diff_key($arResult['DISPLAY_PROPERTIES'], $arTemp),
                        'CACHE_TIME' => 36000,
                    ),
                    $component,
                    array('HIDE_ICONS' => 'Y')
                );
            ?></div><?
        ?></div><?
    ?></div><?
}
if ($arResult['TABS']['DELIVERY_COST']) {
    ?><div class="content selected" id="deliverycost"><?
        ?><a class="switcher" href="#deliverycost"><?=GetMessage('TABS_DELIVERY_COST')?></a><?
        ?><div class="contentbody clearfix"><?
            ?><div class="contentinner"><?
                ?><div id="delivery-tab"><?=GetMessage('TABS_DELIVERY_COST_LOADING')?></div><?
            ?></div><?
        ?></div><?
    ?></div><?
}
if ($arResult['TABS']['SET']) {
    ?><div class="content set selected" id="set"><?
        ?><a class="switcher" href="#set"><?=GetMessage('TABS_SET')?></a><?
        ?><div class="contentbody clearfix"><?
            //if($haveOffers && $arResult['OFFERS_IBLOCK']>0)
             if (isset($arResult['OFFERS']) && !empty($arResult['OFFERS']))
            {
                foreach($arResult['OFFERS'] as $arOffer)
                {
                    if(!$arOffer['HAVE_SET'])
                        continue;
                    ?><div class="aroundset offer offerid<?=$arOffer['ID']?><?if($product['ID']!=$arOffer['ID']):?> noned<?endif;?>"><?
                        ?><?$APPLICATION->IncludeComponent('bitrix:catalog.set.constructor',
                            'gopro',
                            array(
                                'IBLOCK_ID' => $arResult['OFFERS_IBLOCK'],
                                'ELEMENT_ID' => $arOffer['ID'],
                                'PRICE_CODE' => $arParams['PRICE_CODE'],
                                'BASKET_URL' => $arParams['BASKET_URL'],
                                'OFFERS_CART_PROPERTIES' => $arParams['OFFERS_CART_PROPERTIES'],
                                'CACHE_TYPE' => $arParams['CACHE_TYPE'],
                                'CACHE_TIME' => $arParams['CACHE_TIME'],
                                'CACHE_GROUPS' => $arParams['CACHE_GROUPS'],
                            ),
                            $component,
                            array('HIDE_ICONS' => 'Y')
                        );?><?
                    ?></div><?
                }
            }
            else {
                //if($arResult['HAVE_SET'])
                //{
                    ?><div class="aroundset simple"><?
                        ?><?$APPLICATION->IncludeComponent('bitrix:catalog.set.constructor',
                            'gopro',
                            array(
                                'IBLOCK_ID' => $arParams['IBLOCK_ID'],
                                'ELEMENT_ID' => $arResult['ID'],
                                'PRICE_CODE' => $arParams['PRICE_CODE'],
                                'BASKET_URL' => $arParams['BASKET_URL'],
                                'CACHE_TYPE' => $arParams['CACHE_TYPE'],
                                'CACHE_TIME' => $arParams['CACHE_TIME'],
                                'CACHE_GROUPS' => $arParams['CACHE_GROUPS'],
                                "CONVERT_CURRENCY" => $arParams['CONVERT_CURRENCY'],
                                "CURRENCY_ID" => $arParams['CURRENCY_ID'],
                            ),
                            $component,
                            array('HIDE_ICONS' => 'Y')
                        );?><?
                    ?></div><?
                //}
            }
        ?></div><?
    ?></div><?
}
if( $arResult['TABS']['PROPS_TABS'] )
{
    global $lightFilter;
    foreach($arParams['PROPS_TABS'] as $sPropCode)
    {
        if(
            $sPropCode!='' &&
            $arResult['PROPERTIES'][$sPropCode]['PROPERTY_TYPE']=='E' &&
            isset($arResult['PROPERTIES'][$sPropCode]['VALUE']) &&
            is_array($arResult['PROPERTIES'][$sPropCode]['VALUE']) &&
            count($arResult['PROPERTIES'][$sPropCode]['VALUE'])>0
        )
        { // binds to elements
            ?><div class="content selected" id="prop<?=$sPropCode?>"><?
                ?><a class="switcher" href="#prop<?=$sPropCode?>"><?=$arResult['PROPERTIES'][$sPropCode]['NAME']?></a><?
                ?><div class="contentbody clearfix"><?
                    ?><div class="contentinner"><?
                        $lightFilter = array(
                            'ID' => $arResult['PROPERTIES'][$sPropCode]['VALUE'],
                        );
                        ?><?$intSectionID = $APPLICATION->IncludeComponent(
                            'bitrix:catalog.section',
                            'light',
                            array(
                                'IBLOCK_TYPE' => $arParams['IBLOCK_TYPE'],
                                'IBLOCK_ID' => $arParams['IBLOCK_ID'],
                                'ELEMENT_SORT_FIELD' => $arParams['ELEMENT_SORT_FIELD'],
                                'ELEMENT_SORT_ORDER' => $arParams['ELEMENT_SORT_ORDER'],
                                'ELEMENT_SORT_FIELD2' => $arParams['ELEMENT_SORT_FIELD2'],
                                'ELEMENT_SORT_ORDER2' => $arParams['ELEMENT_SORT_ORDER2'],
                                'PROPERTY_CODE' => $arParams['LIST_PROPERTY_CODE'],
                                'META_KEYWORDS' => $arParams['LIST_META_KEYWORDS'],
                                'META_DESCRIPTION' => $arParams['LIST_META_DESCRIPTION'],
                                'BROWSER_TITLE' => $arParams['LIST_BROWSER_TITLE'],
                                'INCLUDE_SUBSECTIONS' => $arParams['INCLUDE_SUBSECTIONS'],
                                'BASKET_URL' => $arParams['BASKET_URL'],
                                'ACTION_VARIABLE' => $arParams['ACTION_VARIABLE'],
                                'PRODUCT_ID_VARIABLE' => $arParams['PRODUCT_ID_VARIABLE'],
                                'SECTION_ID_VARIABLE' => $arParams['SECTION_ID_VARIABLE'],
                                'PRODUCT_QUANTITY_VARIABLE' => $arParams['PRODUCT_QUANTITY_VARIABLE'],
                                'PRODUCT_PROPS_VARIABLE' => $arParams['PRODUCT_PROPS_VARIABLE'],
                                'FILTER_NAME' => 'lightFilter',
                                'CACHE_TYPE' => $arParams['CACHE_TYPE'],
                                'CACHE_TIME' => $arParams['CACHE_TIME'],
                                'CACHE_FILTER' => $arParams['CACHE_FILTER'],
                                'CACHE_GROUPS' => $arParams['CACHE_GROUPS'],
                                'SET_TITLE' => $arParams['SET_TITLE'],
                                'SET_STATUS_404' => $arParams['SET_STATUS_404'],
                                'DISPLAY_COMPARE' => $arParams['USE_COMPARE'],
                                'PAGE_ELEMENT_COUNT' => $alfaCOutput,//$arParams['PAGE_ELEMENT_COUNT'],
                                'LINE_ELEMENT_COUNT' => $arParams['LINE_ELEMENT_COUNT'],
                                'PRICE_CODE' => $arParams['PRICE_CODE'],
                                'USE_PRICE_COUNT' => $arParams['USE_PRICE_COUNT'],
                                'SHOW_PRICE_COUNT' => $arParams['SHOW_PRICE_COUNT'],

                                'PRICE_VAT_INCLUDE' => $arParams['PRICE_VAT_INCLUDE'],
                                'USE_PRODUCT_QUANTITY' => $arParams['USE_PRODUCT_QUANTITY'],
                                'ADD_PROPERTIES_TO_BASKET' => (isset($arParams['ADD_PROPERTIES_TO_BASKET']) ? $arParams['ADD_PROPERTIES_TO_BASKET'] : ''),
                                'PARTIAL_PRODUCT_PROPERTIES' => (isset($arParams['PARTIAL_PRODUCT_PROPERTIES']) ? $arParams['PARTIAL_PRODUCT_PROPERTIES'] : ''),
                                'PRODUCT_PROPERTIES' => $arParams['PRODUCT_PROPERTIES'],
                                "USE_MAIN_ELEMENT_SECTION" => $arParams["USE_MAIN_ELEMENT_SECTION"],
                                'DISPLAY_TOP_PAGER' => $arParams['DISPLAY_TOP_PAGER'],
                                'DISPLAY_BOTTOM_PAGER' => $arParams['DISPLAY_BOTTOM_PAGER'],
                                'PAGER_TITLE' => $arParams['PAGER_TITLE'],
                                'PAGER_SHOW_ALWAYS' => $arParams['PAGER_SHOW_ALWAYS'],
                                'PAGER_TEMPLATE' => $arParams['PAGER_TEMPLATE'],
                                'PAGER_DESC_NUMBERING' => $arParams['PAGER_DESC_NUMBERING'],
                                'PAGER_DESC_NUMBERING_CACHE_TIME' => $arParams['PAGER_DESC_NUMBERING_CACHE_TIME'],
                                'PAGER_SHOW_ALL' => $arParams['PAGER_SHOW_ALL'],

                                'OFFERS_CART_PROPERTIES' => $arParams['OFFERS_CART_PROPERTIES'],
                                'OFFERS_FIELD_CODE' => $arParams['LIST_OFFERS_FIELD_CODE'],
                                'OFFERS_PROPERTY_CODE' => $arParams['LIST_OFFERS_PROPERTY_CODE'],
                                'OFFERS_SORT_FIELD' => $arParams['OFFERS_SORT_FIELD'],
                                'OFFERS_SORT_ORDER' => $arParams['OFFERS_SORT_ORDER'],
                                'OFFERS_SORT_FIELD2' => $arParams['OFFERS_SORT_FIELD2'],
                                'OFFERS_SORT_ORDER2' => $arParams['OFFERS_SORT_ORDER2'],
                                'OFFERS_LIMIT' => $arParams['LIST_OFFERS_LIMIT'],

                                'SECTION_ID' => $arResult['VARIABLES']['SECTION_ID'],
                                'SECTION_CODE' => $arResult['VARIABLES']['SECTION_CODE'],
                                'SECTION_URL' => $arResult['FOLDER'].$arResult['URL_TEMPLATES']['section'],
                                'DETAIL_URL' => $arResult['FOLDER'].$arResult['URL_TEMPLATES']['element'],
                                'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
                                'CURRENCY_ID' => $arParams['CURRENCY_ID'],
                                'HIDE_NOT_AVAILABLE' => $arParams['HIDE_NOT_AVAILABLE'],
                                // goPro params
                                'PROP_MORE_PHOTO' => $arParams['PROP_MORE_PHOTO'],
                                'PROP_ARTICLE' => $arParams['PROP_ARTICLE'],
                                'PROP_ACCESSORIES' => $arParams['PROP_ACCESSORIES'],
                                'USE_FAVORITE' => $arParams['USE_FAVORITE'],
                                'USE_SHARE' => $arParams['USE_SHARE'],
                                'SHOW_ERROR_EMPTY_ITEMS' => $arParams['SHOW_ERROR_EMPTY_ITEMS'],
                                'PROP_SKU_MORE_PHOTO' => $arParams['PROP_SKU_MORE_PHOTO'],
                                'PROP_SKU_ARTICLE' => $arParams['PROP_SKU_ARTICLE'],
                                'PROPS_ATTRIBUTES' => $arParams['PROPS_ATTRIBUTES'],
                                // store
                                'USE_STORE' => $arParams['USE_STORE'],
                                'USE_MIN_AMOUNT' => $arParams['USE_MIN_AMOUNT'],
                                'MIN_AMOUNT' => $arParams['MIN_AMOUNT'],
                                'MAIN_TITLE' => $arParams['MAIN_TITLE'],
                                // some...
                                'BY_LINK' => 'Y',
                                // seo
                                "ADD_SECTIONS_CHAIN" => "N",
                                "SET_BROWSER_TITLE" => "N",
                                "SET_META_KEYWORDS" => "N",
                                "SET_META_DESCRIPTION" => "N",
                                "ADD_ELEMENT_CHAIN" => "N",
                            ),
                            $component,
                            array('HIDE_ICONS'=>'Y')
                        );?><?
                    ?></div><?
                ?></div><?
            ?></div><?
        } elseif(
            $sPropCode!='' &&
            $arResult['PROPERTIES'][$sPropCode]['PROPERTY_TYPE']=='F' &&
            isset($arResult['PROPERTIES'][$sPropCode]['VALUE']) &&
            is_array($arResult['PROPERTIES'][$sPropCode]['VALUE']) &&
            count($arResult['PROPERTIES'][$sPropCode]['VALUE'])>0
        ) { // files
            ?><div class="content files selected" id="prop<?=$sPropCode?>"><?
                ?><a class="switcher" href="#prop<?=$sPropCode?>"><?=$arResult['PROPERTIES'][$sPropCode]['NAME']?></a><?
                ?><div class="contentbody clearfix"><?
                    ?><div class="contentinner"><?
                        $index = 1;
                        foreach ($arResult['PROPERTIES'][$sPropCode]['VALUE'] as $arFile) {
                            ?><a class="docs" href="<?=$arFile['FULL_PATH']?>"><?
                                ?><i class="icon pngicons <?=$arFile['TYPE']?>"></i><?
                                ?><span class="name"><?=$arFile['ORIGINAL_NAME']?></span><?
                                if( isset($arFile['DESCRIPTION']) ) { ?><span class="description"><?=$arFile['DESCRIPTION']?></span><? }
                                ?><span class="size">(<?=$arFile['TYPE']?>, <?=$arFile['SIZE']?>)</span><?
                            ?></a><?
                            if ($index > 3) { $index==0; }
                            ?><span class="separator x<?=$index?>"></span><?
                            $index++;
                        }
                    ?></div><?
                ?></div><?
            ?></div><?
        } elseif( $sPropCode!='' && isset($arResult['DISPLAY_PROPERTIES'][$sPropCode]['DISPLAY_VALUE']) ) { // else
            ?><div class="content selected" id="prop<?=$sPropCode?>"><?
                ?><a class="switcher" href="#prop<?=$sPropCode?>"><?=$arResult['DISPLAY_PROPERTIES'][$sPropCode]['NAME']?></a><?
                ?><div class="contentbody clearfix"><?
                    ?><div class="contentinner prop-tabs"><?
                        ?><?
                        if(is_array($arResult['DISPLAY_PROPERTIES'][$sPropCode]['DISPLAY_VALUE'])){
                            echo implode(' / ', $arResult['DISPLAY_PROPERTIES'][$sPropCode]['DISPLAY_VALUE']);
                        } else {
                            echo $arResult['DISPLAY_PROPERTIES'][$sPropCode]['DISPLAY_VALUE'];
                        }
                        ?><?
                    ?></div><?
                ?></div><?
            ?></div><?
        }
    }
}
$this->EndViewTarget();
