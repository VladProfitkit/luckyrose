<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();

use Bitrix\Main\Loader;
use Bitrix\Main\ModuleManager;

if (!\Bitrix\Main\Loader::includeModule('redsign.devfunc'))
	return;

$this->setFrameMode(true);

$actionVariableName = 'rs_action';
$productIdVariableName = 'rs_id';
?>

<?php if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) || $_REQUEST['debug'] == 'yes'): ?>
    <?php
	$ELEMENT_ID = IntVal($_REQUEST[$productIdVariableName]);
    ?>

	<?php if ($_REQUEST['AJAX_CALL'] == 'Y' && $_REQUEST[$actionVariableName] == 'rsgppopup' && $ELEMENT_ID > 0): ?>
        <?php
		// +++++++++++++++++++++++++++++++ get element popup +++++++++++++++++++++++++++++++ //
		global $APPLICATION;
		$APPLICATION->RestartBuffer();
		if ($ELEMENT_ID < 1) {
			$arJson = array('TYPE' => 'ERROR', 'MESSAGE' => 'Element id is empty');
			echo json_encode($arJson);
			die();
		}
        ?>
		<?$ElementID = $APPLICATION->IncludeComponent(
			'bitrix:catalog.element',
			'popup',
			array(
				'IBLOCK_TYPE' => $arParams['IBLOCK_TYPE'],
				'IBLOCK_ID' => $arParams['IBLOCK_ID'],
				'PROPERTY_CODE' => $arParams['DETAIL_PROPERTY_CODE'],
				'META_KEYWORDS' => $arParams['DETAIL_META_KEYWORDS'],
				'META_DESCRIPTION' => $arParams['DETAIL_META_DESCRIPTION'],
				'BROWSER_TITLE' => $arParams['DETAIL_BROWSER_TITLE'],
				'BASKET_URL' => $arParams['BASKET_URL'],
				'SET_CANONICAL_URL' => $arParams['DETAIL_SET_CANONICAL_URL'],
				'ACTION_VARIABLE' => $arParams['ACTION_VARIABLE'],
				'PRODUCT_ID_VARIABLE' => $arParams['PRODUCT_ID_VARIABLE'],
				'SECTION_ID_VARIABLE' => $arParams['SECTION_ID_VARIABLE'],
				'PRODUCT_QUANTITY_VARIABLE' => $arParams['PRODUCT_QUANTITY_VARIABLE'],
				'PRODUCT_PROPS_VARIABLE' => $arParams['PRODUCT_PROPS_VARIABLE'],
				'CACHE_TYPE' => $arParams['CACHE_TYPE'],
				'CACHE_TIME' => $arParams['CACHE_TIME'],
				'CACHE_GROUPS' => $arParams['CACHE_GROUPS'],
				'SET_TITLE' => $arParams['SET_TITLE'],
				'SET_STATUS_404' => $arParams['SET_STATUS_404'],
				'PRICE_CODE' => $arParams['PRICE_CODE'],
				'USE_PRICE_COUNT' => $arParams['USE_PRICE_COUNT'],
				'SHOW_PRICE_COUNT' => $arParams['SHOW_PRICE_COUNT'],
				'PRICE_VAT_INCLUDE' => $arParams['PRICE_VAT_INCLUDE'],
				'PRICE_VAT_SHOW_VALUE' => $arParams['PRICE_VAT_SHOW_VALUE'],
				'USE_PRODUCT_QUANTITY' => $arParams['USE_PRODUCT_QUANTITY'],
				'PRODUCT_PROPERTIES' => $arParams['PRODUCT_PROPERTIES'],
				'ADD_PROPERTIES_TO_BASKET' => (isset($arParams['ADD_PROPERTIES_TO_BASKET']) ? $arParams['ADD_PROPERTIES_TO_BASKET'] : ''),
				'PARTIAL_PRODUCT_PROPERTIES' => (isset($arParams['PARTIAL_PRODUCT_PROPERTIES']) ? $arParams['PARTIAL_PRODUCT_PROPERTIES'] : ''),
				'LINK_IBLOCK_TYPE' => $arParams['LINK_IBLOCK_TYPE'],
				'LINK_IBLOCK_ID' => $arParams['LINK_IBLOCK_ID'],
				'LINK_PROPERTY_SID' => $arParams['LINK_PROPERTY_SID'],
				'LINK_ELEMENTS_URL' => $arParams['LINK_ELEMENTS_URL'],
				
				'OFFERS_CART_PROPERTIES' => $arParams['OFFERS_CART_PROPERTIES'],
				'OFFERS_FIELD_CODE' => $arParams['DETAIL_OFFERS_FIELD_CODE'],
				'OFFERS_PROPERTY_CODE' => $arParams['DETAIL_OFFERS_PROPERTY_CODE'],
				'OFFERS_SORT_FIELD' => $arParams['OFFERS_SORT_FIELD'],
				'OFFERS_SORT_ORDER' => $arParams['OFFERS_SORT_ORDER'],
				'OFFERS_SORT_FIELD2' => $arParams['OFFERS_SORT_FIELD2'],
				'OFFERS_SORT_ORDER2' => $arParams['OFFERS_SORT_ORDER2'],
				
				'LIST_OFFERS_FIELD_CODE' => $arParams['LIST_OFFERS_FIELD_CODE'],
				'LIST_OFFERS_PROPERTY_CODE' => $arParams['LIST_OFFERS_PROPERTY_CODE'],
				'LIST_OFFERS_LIMIT' => $arParams['LIST_OFFERS_LIMIT'],
				
				'ELEMENT_ID' => $arResult['VARIABLES']['ELEMENT_ID'],
				'ELEMENT_CODE' => $arResult['VARIABLES']['ELEMENT_CODE'],
				'SECTION_ID' => $arResult['VARIABLES']['SECTION_ID'],
				'SECTION_CODE' => $arResult['VARIABLES']['SECTION_CODE'],
				'SECTION_URL' => $arResult['FOLDER'].$arResult['URL_TEMPLATES']['section'],
				'DETAIL_URL' => $arResult['FOLDER'].$arResult['URL_TEMPLATES']['element'],
				'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
				'CURRENCY_ID' => $arParams['CURRENCY_ID'],
				'HIDE_NOT_AVAILABLE' => $arParams['HIDE_NOT_AVAILABLE'],
				'HIDE_NOT_AVAILABLE_OFFERS' => $arParams["HIDE_NOT_AVAILABLE_OFFERS"],
				'USE_ELEMENT_COUNTER' => $arParams['USE_ELEMENT_COUNTER'],
				'USE_COMPARE' => $arParams['USE_COMPARE'],
				// goPro params
				'PROP_MORE_PHOTO' => $arParams['PROP_MORE_PHOTO'],
				'HIGHLOAD' => $arParams['HIGHLOAD'],
				'PROP_ARTICLE' => $arParams['PROP_ARTICLE'],
				'USE_FAVORITE' => $arParams['USE_FAVORITE'],
				'USE_SHARE' => $arParams['USE_SHARE'],
				'SOC_SHARE_ICON' => $arParams['SOC_SHARE_ICON'],
				'OFF_MEASURE_RATION' => $arParams['OFF_MEASURE_RATION'],
				'PROP_SKU_MORE_PHOTO' => $arParams['PROP_SKU_MORE_PHOTO'],
				'PROP_SKU_ARTICLE' => $arParams['PROP_SKU_ARTICLE'],
				'PROPS_ATTRIBUTES' => $arParams['PROPS_ATTRIBUTES'],
				'PROPS_ATTRIBUTES_COLOR' => $arParams['PROPS_ATTRIBUTES_COLOR'],
				'STICKERS_PROPS' => $arParams['STICKERS_PROPS'],
				'STICKERS_DISCOUNT_VALUE' => $arParams['STICKERS_DISCOUNT_VALUE'],
				// delivery cost
				'USE_DELIVERY_COST_BLOCK' => $arParams['USE_DELIVERY_COST_BLOCK'],
				'USE_DELIVERY_COST_TAB' => $arParams['USE_DELIVERY_COST_TAB'],
				'DELIVERY_CURRENCY_ID' => ($arParams['CONVERT_CURRENCY'] == 'Y' ? $arParams['CURRENCY_ID'] : ''),
				'DELIVERY_COST_PAY_LINK' => $arParams['DELIVERY_COST_PAY_LINK'],
				'DELIVERY_COST_DELIVERY_LINK' => $arParams['DELIVERY_COST_DELIVERY_LINK'],
				// store
				'STORES_TEMPLATE' => $arParams['STORES_TEMPLATE'],
				'USE_STORE' => $arParams['USE_STORE'],
				"STORE_PATH" => $arParams['STORE_PATH'],
				'MAIN_TITLE' => $arParams['MAIN_TITLE'],
				'USE_MIN_AMOUNT' => $arParams['USE_MIN_AMOUNT'],
				'MIN_AMOUNT' => $arParams['MIN_AMOUNT'],
				"STORES" => $arParams['STORES'],
				"SHOW_EMPTY_STORE" => $arParams['SHOW_EMPTY_STORE'],
				"SHOW_GENERAL_STORE_INFORMATION" => $arParams['SHOW_GENERAL_STORE_INFORMATION'],
				"USER_FIELDS" => $arParams['USER_FIELDS'],
				"FIELDS" => $arParams['FIELDS'],
				"PROP_STORE_REPLACE_SECTION" => $arParams['PROP_STORE_REPLACE_SECTION'],
				"PROP_STORE_REPLACE_DETAIL" => $arParams['PROP_STORE_REPLACE_DETAIL'],
				// element
				'PROPS_TABS' => $arParams['PROPS_TABS'],
				'USE_CHEAPER' => $arParams['USE_CHEAPER'],
				'DETAIL_TABS_VIEW' => $arParams['DETAIL_TABS_VIEW'],
				'SHOW_PREVIEW_TEXT' => $arParams['SHOW_PREVIEW_TEXT'],
				// seo
				"ADD_SECTIONS_CHAIN" => (isset($arParams["ADD_SECTIONS_CHAIN"]) ? $arParams["ADD_SECTIONS_CHAIN"] : ''),
				"ADD_ELEMENT_CHAIN" => (isset($arParams["ADD_ELEMENT_CHAIN"]) ? $arParams["ADD_ELEMENT_CHAIN"] : ''),
			),
			$component,
			array('HIDE_ICONS' => 'Y')
		);?>
        <?php
		die();
        ?>
	<?php elseif ($arParams['USE_COMPARE'] == 'Y' && $_REQUEST['AJAX_CALL'] == 'Y' && ($_REQUEST[$actionVariableName] == 'ADD_TO_COMPARE_LIST' || $_REQUEST[$actionVariableName] == 'DELETE_FROM_COMPARE_LIST') ): ?>
        <?php
		// +++++++++++++++++++++++++++++++ add2compare +++++++++++++++++++++++++++++++ //
		global $APPLICATION,$JSON;
        ?>
		<?$APPLICATION->IncludeComponent(
			'bitrix:catalog.compare.list',
			'json',
			Array(
				'IBLOCK_TYPE' => $arParams['IBLOCK_TYPE'],
				'IBLOCK_ID' => $arParams['IBLOCK_ID'],
				'NAME' => $arParams['COMPARE_NAME'],
				'DETAIL_URL' => $arResult['FOLDER'].$arResult['URL_TEMPLATES']['element'],
				'COMPARE_URL' => $arResult['FOLDER'].$arResult['URL_TEMPLATES']['compare'],
				'IS_AJAX_REQUEST' => 'Y',
				'ACTION_VARIABLE' => $actionVariableName,
				'PRODUCT_ID_VARIABLE' => $productIdVariableName,
			),
			$component,
			array('HIDE_ICONS' => 'Y')
		);?>

		<?php
        $APPLICATION->RestartBuffer();
		if (SITE_CHARSET != 'utf-8') {
			$data = $APPLICATION->ConvertCharsetArray($JSON, SITE_CHARSET, 'utf-8');
			$json_str_utf = json_encode($data);
			$json_str = $APPLICATION->ConvertCharset($json_str_utf, 'utf-8', SITE_CHARSET);
			echo $json_str;
		} else {
			echo json_encode( $JSON );
		}

		die();
        ?>
	<?php elseif ($_REQUEST['AJAX_CALL'] == 'Y' && $_REQUEST[$actionVariableName] == 'add2favorite' && $ELEMENT_ID > 0): ?>
		<?php if (\Bitrix\Main\Loader::includeModule('redsign.favorite')): ?>
			<?php
			// +++++++++++++++++++++++++++++++ add2favorite +++++++++++++++++++++++++++++++ //
			global $APPLICATION, $JSON;
			?>
			<?$APPLICATION->IncludeComponent(
				'redsign:favorite.list',
				'json',
				array(
					'ACTION_VARIABLE' => $actionVariableName,
					'PRODUCT_ID_VARIABLE' => $productIdVariableName,
				)
			);?>
			<?php
			$APPLICATION->RestartBuffer();
			$arJson = array('TYPE' => 'OK', 'MESSAGE' => 'Element add/removed from favorite', 'HTMLBYID' => $JSON['HTMLBYID']);
			?>
		<?php else: ?>
			<?php
			$APPLICATION->RestartBuffer();
			$arJson = array('TYPE' => 'ERROR', 'MESSAGE' => 'Module favorite is not installed');
			?>
		<?php endif; ?>
		<?php
		echo json_encode($arJson);
		die();
		?>
	<?php elseif ($_REQUEST['AJAX_CALL'] == 'Y' && $_REQUEST[$actionVariableName] == 'add2basket'): ?>
        <?php
		// +++++++++++++++++++++++++++++++ add2basket +++++++++++++++++++++++++++++++ //
		global $APPLICATION, $JSON;
        
		$ProductID = IntVal($_REQUEST[$arParams["PRODUCT_ID_VARIABLE"]]);
		$QUANTITY = doubleval($_REQUEST[$arParams["PRODUCT_QUANTITY_VARIABLE"]]);

		$params = array(
			'IBLOCK_TYPE' => $arParams['IBLOCK_TYPE'],
			'IBLOCK_ID' => $arParams['IBLOCK_ID'],
			'ACTION_VARIABLE' => $arParams['ACTION_VARIABLE'],
			'PRODUCT_QUANTITY_VARIABLE' => $arParams['PRODUCT_QUANTITY_VARIABLE'],
			'PRODUCT_PROPS_VARIABLE' => $arParams['PRODUCT_PROPS_VARIABLE'],
			'USE_PRICE_COUNT' => $arParams['USE_PRICE_COUNT'],
			'USE_PRODUCT_QUANTITY' => $arParams['USE_PRODUCT_QUANTITY'],
			'PRODUCT_PROPERTIES' => $arParams['PRODUCT_PROPERTIES'],
			'ADD_PROPERTIES_TO_BASKET' => (isset($arParams['ADD_PROPERTIES_TO_BASKET']) ? $arParams['ADD_PROPERTIES_TO_BASKET'] : ''),
			'PARTIAL_PRODUCT_PROPERTIES' => (isset($arParams['PARTIAL_PRODUCT_PROPERTIES']) ? $arParams['PARTIAL_PRODUCT_PROPERTIES'] : ''),
			'OFFERS_CART_PROPERTIES' => $arParams['OFFERS_CART_PROPERTIES'],
		);
        unset($_REQUEST[$arParams["ACTION_VARIABLE"]]);
		$restat = RSDF_EasyAdd2Basket($ProductID, $QUANTITY, $params);
        ?>
		<?$APPLICATION->IncludeComponent(
            'bitrix:sale.basket.basket.line',
            'json',
            array()
        );?>
		<?php
        $APPLICATION->RestartBuffer();

		if (SITE_CHARSET != 'utf-8') {
			$data = $APPLICATION->ConvertCharsetArray($JSON, SITE_CHARSET, 'utf-8');
			$json_str_utf = json_encode($data);
			$json_str = $APPLICATION->ConvertCharset($json_str_utf, 'utf-8', SITE_CHARSET);
			echo $json_str;
		} else {
			echo json_encode( $JSON );
		}
		die();
        ?>
	<?php elseif ($_REQUEST['AJAX_CALL'] == 'Y' && $_REQUEST[$actionVariableName] == 'get_element_json'): ?>
		<?php
        global $APPLICATION, $JSON;
		$APPLICATION->RestartBuffer();
        
		if ($ELEMENT_ID < 1) {
			$arJson = array('TYPE' => 'ERROR', 'MESSAGE' => 'Element id is empty');
			echo json_encode($arJson);
			die();
		}
        ?>
		<?$ElementID=$APPLICATION->IncludeComponent(
			'bitrix:catalog.element',
			'json',
			Array(
				"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
				"IBLOCK_ID" => $arParams["IBLOCK_ID"],
				"PROPERTY_CODE" => $arParams["DETAIL_PROPERTY_CODE"],
				"META_KEYWORDS" => $arParams["DETAIL_META_KEYWORDS"],
				"META_DESCRIPTION" => $arParams["DETAIL_META_DESCRIPTION"],
				"BROWSER_TITLE" => $arParams["DETAIL_BROWSER_TITLE"],
				"BASKET_URL" => $arParams["BASKET_URL"],
				"ACTION_VARIABLE" => $arParams["ACTION_VARIABLE"],
				"PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
				"SECTION_ID_VARIABLE" => $arParams["SECTION_ID_VARIABLE"],
				"CHECK_SECTION_ID_VARIABLE" => (isset($arParams["DETAIL_CHECK_SECTION_ID_VARIABLE"]) ? $arParams["DETAIL_CHECK_SECTION_ID_VARIABLE"] : ''),
				"PRODUCT_QUANTITY_VARIABLE" => $arParams["PRODUCT_QUANTITY_VARIABLE"],
				"PRODUCT_PROPS_VARIABLE" => $arParams["PRODUCT_PROPS_VARIABLE"],
				"CACHE_TYPE" => $arParams["CACHE_TYPE"],
				"CACHE_TIME" => $arParams["CACHE_TIME"],
				"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
				"SET_TITLE" => $arParams["SET_TITLE"],
				"SET_STATUS_404" => $arParams["SET_STATUS_404"],
				"PRICE_CODE" => $arParams["PRICE_CODE"],
				"USE_PRICE_COUNT" => $arParams["USE_PRICE_COUNT"],
				"SHOW_PRICE_COUNT" => $arParams["SHOW_PRICE_COUNT"],
				"PRICE_VAT_INCLUDE" => $arParams["PRICE_VAT_INCLUDE"],
				"PRICE_VAT_SHOW_VALUE" => $arParams["PRICE_VAT_SHOW_VALUE"],
				"USE_PRODUCT_QUANTITY" => $arParams['USE_PRODUCT_QUANTITY'],
				"PRODUCT_PROPERTIES" => $arParams["PRODUCT_PROPERTIES"],
				"ADD_PROPERTIES_TO_BASKET" => (isset($arParams["ADD_PROPERTIES_TO_BASKET"]) ? $arParams["ADD_PROPERTIES_TO_BASKET"] : ''),
				"PARTIAL_PRODUCT_PROPERTIES" => (isset($arParams["PARTIAL_PRODUCT_PROPERTIES"]) ? $arParams["PARTIAL_PRODUCT_PROPERTIES"] : ''),
				"LINK_IBLOCK_TYPE" => $arParams["LINK_IBLOCK_TYPE"],
				"LINK_IBLOCK_ID" => $arParams["LINK_IBLOCK_ID"],
				"LINK_PROPERTY_SID" => $arParams["LINK_PROPERTY_SID"],
				"LINK_ELEMENTS_URL" => $arParams["LINK_ELEMENTS_URL"],
				"OFFERS_CART_PROPERTIES" => $arParams["OFFERS_CART_PROPERTIES"],
				"OFFERS_FIELD_CODE" => $arParams["DETAIL_OFFERS_FIELD_CODE"],
				"OFFERS_PROPERTY_CODE" => $arParams["DETAIL_OFFERS_PROPERTY_CODE"],
				"OFFERS_SORT_FIELD" => $arParams["OFFERS_SORT_FIELD"],
				"OFFERS_SORT_ORDER" => $arParams["OFFERS_SORT_ORDER"],
				"OFFERS_SORT_FIELD2" => $arParams["OFFERS_SORT_FIELD2"],
				"OFFERS_SORT_ORDER2" => $arParams["OFFERS_SORT_ORDER2"],
				'ELEMENT_ID' => $ELEMENT_ID, // $arResult['VARIABLES']['ELEMENT_ID'],
                'ELEMENT_CODE' => '', // $arResult['VARIABLES']['ELEMENT_CODE'],
				"SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"],
				"SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
				"SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
				"DETAIL_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["element"],
				'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
				'CURRENCY_ID' => $arParams['CURRENCY_ID'],
				'HIDE_NOT_AVAILABLE' => $arParams["HIDE_NOT_AVAILABLE"],
				'HIDE_NOT_AVAILABLE_OFFERS' => $arParams["HIDE_NOT_AVAILABLE_OFFERS"],
				'USE_ELEMENT_COUNTER' => $arParams['USE_ELEMENT_COUNTER'],
				'BRAND_PROP_CODE' => (isset($arParams['DETAIL_BRAND_PROP_CODE']) ? $arParams['DETAIL_BRAND_PROP_CODE'] : ''),
				"ADD_SECTIONS_CHAIN" => (isset($arParams["ADD_SECTIONS_CHAIN"]) ? $arParams["ADD_SECTIONS_CHAIN"] : ''),
				"ADD_ELEMENT_CHAIN" => (isset($arParams["ADD_ELEMENT_CHAIN"]) ? $arParams["ADD_ELEMENT_CHAIN"] : ''),
				'DISPLAY_COMPARE' => (isset($arParams['USE_COMPARE']) ? $arParams['USE_COMPARE'] : ''),
				'COMPARE_PATH' => $arResult['FOLDER'].$arResult['URL_TEMPLATES']['compare'],
				// goPro params
				"PROP_MORE_PHOTO" => $arParams["PROP_MORE_PHOTO"],
				"HIGHLOAD" => $arParams["HIGHLOAD"],
				"PROP_ARTICLE" => $arParams["PROP_ARTICLE"],
				"PROP_ACCESSORIES" => $arParams["PROP_ACCESSORIES"],
				"USE_FAVORITE" => $arParams["USE_FAVORITE"],
				"USE_SHARE" => $arParams["USE_SHARE"],
                'SOC_SHARE_ICON' => $arParams['SOC_SHARE_ICON'],
				"SHOW_ERROR_EMPTY_ITEMS" => $arParams["SHOW_ERROR_EMPTY_ITEMS"],
				"PROP_SKU_MORE_PHOTO" => $arParams["PROP_SKU_MORE_PHOTO"],
				"PROP_SKU_ARTICLE" => $arParams["PROP_SKU_ARTICLE"],
				"PROPS_ATTRIBUTES" => $arParams["PROPS_ATTRIBUTES"],
				// store
				"USE_STORE" => $arParams["USE_STORE"],
				"USE_MIN_AMOUNT" => $arParams["USE_MIN_AMOUNT"],
				"MIN_AMOUNT" => $arParams["MIN_AMOUNT"],
				"MAIN_TITLE" => $arParams["MAIN_TITLE"],
				"PROP_STORE_REPLACE_SECTION" => $arParams['PROP_STORE_REPLACE_SECTION'],
                "PROP_STORE_REPLACE_DETAIL" => $arParams['PROP_STORE_REPLACE_DETAIL'],
			),
			$component,
			array('HIDE_ICONS' => 'Y')
		);?>
	<?php endif; ?>
<?php endif; ?>

<?$ElementID = $APPLICATION->IncludeComponent(
	'bitrix:catalog.element',
	'gopro',
	array(
		'IBLOCK_TYPE' => $arParams['IBLOCK_TYPE'],
		'IBLOCK_ID' => $arParams['IBLOCK_ID'],
		'PROPERTY_CODE' => $arParams['DETAIL_PROPERTY_CODE'],
		'META_KEYWORDS' => $arParams['DETAIL_META_KEYWORDS'],
		'META_DESCRIPTION' => $arParams['DETAIL_META_DESCRIPTION'],
		'BROWSER_TITLE' => $arParams['DETAIL_BROWSER_TITLE'],
		'BASKET_URL' => $arParams['BASKET_URL'],
		'SET_CANONICAL_URL' => $arParams['DETAIL_SET_CANONICAL_URL'],
		'ACTION_VARIABLE' => $arParams['ACTION_VARIABLE'],
		'PRODUCT_ID_VARIABLE' => $arParams['PRODUCT_ID_VARIABLE'],
		'SECTION_ID_VARIABLE' => $arParams['SECTION_ID_VARIABLE'],
		'PRODUCT_QUANTITY_VARIABLE' => $arParams['PRODUCT_QUANTITY_VARIABLE'],
		'PRODUCT_PROPS_VARIABLE' => $arParams['PRODUCT_PROPS_VARIABLE'],
		'CACHE_TYPE' => $arParams['CACHE_TYPE'],
		'CACHE_TIME' => $arParams['CACHE_TIME'],
		'CACHE_GROUPS' => $arParams['CACHE_GROUPS'],
		'SET_TITLE' => $arParams['SET_TITLE'],
		'SET_STATUS_404' => $arParams['SET_STATUS_404'],
		'PRICE_CODE' => $arParams['PRICE_CODE'],
		'USE_PRICE_COUNT' => $arParams['USE_PRICE_COUNT'],
		'SHOW_PRICE_COUNT' => $arParams['SHOW_PRICE_COUNT'],
		'PRICE_VAT_INCLUDE' => $arParams['PRICE_VAT_INCLUDE'],
		'PRICE_VAT_SHOW_VALUE' => $arParams['PRICE_VAT_SHOW_VALUE'],
		'USE_PRODUCT_QUANTITY' => $arParams['USE_PRODUCT_QUANTITY'],
		'PRODUCT_PROPERTIES' => $arParams['PRODUCT_PROPERTIES'],
		'ADD_PROPERTIES_TO_BASKET' => (isset($arParams['ADD_PROPERTIES_TO_BASKET']) ? $arParams['ADD_PROPERTIES_TO_BASKET'] : ''),
		'PARTIAL_PRODUCT_PROPERTIES' => (isset($arParams['PARTIAL_PRODUCT_PROPERTIES']) ? $arParams['PARTIAL_PRODUCT_PROPERTIES'] : ''),
		'LINK_IBLOCK_TYPE' => $arParams['LINK_IBLOCK_TYPE'],
		'LINK_IBLOCK_ID' => $arParams['LINK_IBLOCK_ID'],
		'LINK_PROPERTY_SID' => $arParams['LINK_PROPERTY_SID'],
		'LINK_ELEMENTS_URL' => $arParams['LINK_ELEMENTS_URL'],
		
		'OFFERS_CART_PROPERTIES' => $arParams['OFFERS_CART_PROPERTIES'],
		'OFFERS_FIELD_CODE' => $arParams['DETAIL_OFFERS_FIELD_CODE'],
		'OFFERS_PROPERTY_CODE' => $arParams['DETAIL_OFFERS_PROPERTY_CODE'],
		'OFFERS_SORT_FIELD' => $arParams['OFFERS_SORT_FIELD'],
		'OFFERS_SORT_ORDER' => $arParams['OFFERS_SORT_ORDER'],
		'OFFERS_SORT_FIELD2' => $arParams['OFFERS_SORT_FIELD2'],
		'OFFERS_SORT_ORDER2' => $arParams['OFFERS_SORT_ORDER2'],
		
		'LIST_OFFERS_FIELD_CODE' => $arParams['LIST_OFFERS_FIELD_CODE'],
		'LIST_OFFERS_PROPERTY_CODE' => $arParams['LIST_OFFERS_PROPERTY_CODE'],
		'LIST_OFFERS_LIMIT' => $arParams['LIST_OFFERS_LIMIT'],
		
		'ELEMENT_ID' => $arResult['VARIABLES']['ELEMENT_ID'],
		'ELEMENT_CODE' => $arResult['VARIABLES']['ELEMENT_CODE'],
		'SECTION_ID' => $arResult['VARIABLES']['SECTION_ID'],
		'SECTION_CODE' => $arResult['VARIABLES']['SECTION_CODE'],
		'SECTION_URL' => $arResult['FOLDER'].$arResult['URL_TEMPLATES']['section'],
		'DETAIL_URL' => $arResult['FOLDER'].$arResult['URL_TEMPLATES']['element'],
		'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
		'CURRENCY_ID' => $arParams['CURRENCY_ID'],
		'HIDE_NOT_AVAILABLE' => $arParams['HIDE_NOT_AVAILABLE'],
		'HIDE_NOT_AVAILABLE_OFFERS' => $arParams["HIDE_NOT_AVAILABLE_OFFERS"],
		'USE_ELEMENT_COUNTER' => $arParams['USE_ELEMENT_COUNTER'],
		'USE_COMPARE' => $arParams['USE_COMPARE'],
		// goPro params
		'PROP_MORE_PHOTO' => $arParams['PROP_MORE_PHOTO'],
		'HIGHLOAD' => $arParams['HIGHLOAD'],
		'PROP_ARTICLE' => $arParams['PROP_ARTICLE'],
		'USE_FAVORITE' => $arParams['USE_FAVORITE'],
		'USE_SHARE' => $arParams['USE_SHARE'],
        'SOC_SHARE_ICON' => $arParams['SOC_SHARE_ICON'],
		'OFF_MEASURE_RATION' => $arParams['OFF_MEASURE_RATION'],
		'PROP_SKU_MORE_PHOTO' => $arParams['PROP_SKU_MORE_PHOTO'],
		'PROP_SKU_ARTICLE' => $arParams['PROP_SKU_ARTICLE'],
		'PROPS_ATTRIBUTES' => $arParams['PROPS_ATTRIBUTES'],
		'PROPS_ATTRIBUTES_COLOR' => $arParams['PROPS_ATTRIBUTES_COLOR'],
		'STICKERS_PROPS' => $arParams['STICKERS_PROPS'],
		'STICKERS_DISCOUNT_VALUE' => $arParams['STICKERS_DISCOUNT_VALUE'],
		// delivery cost
		'USE_DELIVERY_COST_BLOCK' => $arParams['USE_DELIVERY_COST_BLOCK'],
		'USE_DELIVERY_COST_TAB' => $arParams['USE_DELIVERY_COST_TAB'],
		'DELIVERY_CURRENCY_ID' => ($arParams['CONVERT_CURRENCY'] == 'Y' ? $arParams['CURRENCY_ID'] : ''),
		'DELIVERY_COST_PAY_LINK' => $arParams['DELIVERY_COST_PAY_LINK'],
		'DELIVERY_COST_DELIVERY_LINK' => $arParams['DELIVERY_COST_DELIVERY_LINK'],
		// store
		'STORES_TEMPLATE' => $arParams['STORES_TEMPLATE'],
		'USE_STORE' => $arParams['USE_STORE'],
		"STORE_PATH" => $arParams['STORE_PATH'],
		'MAIN_TITLE' => $arParams['MAIN_TITLE'],
		'USE_MIN_AMOUNT' => $arParams['USE_MIN_AMOUNT'],
		'MIN_AMOUNT' => $arParams['MIN_AMOUNT'],
		"STORES" => $arParams['STORES'],
		"SHOW_EMPTY_STORE" => $arParams['SHOW_EMPTY_STORE'],
		"SHOW_GENERAL_STORE_INFORMATION" => $arParams['SHOW_GENERAL_STORE_INFORMATION'],
		"USER_FIELDS" => $arParams['USER_FIELDS'],
		"FIELDS" => $arParams['FIELDS'],
		"PROP_STORE_REPLACE_SECTION" => $arParams['PROP_STORE_REPLACE_SECTION'],
		"PROP_STORE_REPLACE_DETAIL" => $arParams['PROP_STORE_REPLACE_DETAIL'],
		// element
		'PROPS_TABS' => $arParams['PROPS_TABS'],
		'USE_CHEAPER' => $arParams['USE_CHEAPER'],
		'DETAIL_TABS_VIEW' => $arParams['DETAIL_TABS_VIEW'],
		'SHOW_PREVIEW_TEXT' => $arParams['SHOW_PREVIEW_TEXT'],
		// seo
		"ADD_SECTIONS_CHAIN" => (isset($arParams["ADD_SECTIONS_CHAIN"]) ? $arParams["ADD_SECTIONS_CHAIN"] : ''),
		"ADD_ELEMENT_CHAIN" => (isset($arParams["ADD_ELEMENT_CHAIN"]) ? $arParams["ADD_ELEMENT_CHAIN"] : ''),
	),
	$component
);?>

<div class="clear"></div>

<!-- // tabs -->
<div class="detailtabs <?if($arParams['DETAIL_TABS_VIEW']=='anchor'):?>anchor<?else:?>tabs<?endif;?>">
	<div class="headers clearfix">
        <?php
		$APPLICATION->ShowViewContent('TABS_HTML_HEADERS');
		if ($arParams['USE_REVIEW'] == 'Y' && IsModuleInstalled('forum')) {
			?><a class="switcher" href="#review"><?=GetMessage('TABS_REVIEW')?><?=($arParams['DETAIL_REVIEW_SHOW_COUNT'] == 'Y' ? ' (<span class="js-detailelement-review-count">0</span>)' : '')?></a><?
		}
        ?>
	</div>
	<div class="contents">
        <?php
		$APPLICATION->ShowViewContent('TABS_HTML_CONTENTS');
        ?>
		<?php if( $arParams['USE_REVIEW']=='Y' && IsModuleInstalled('forum') ): ?>
			<div class="content selected review" id="review">
				<a class="switcher" href="#review"><?=GetMessage('TABS_REVIEW')?></a>
				<div class="contentbody clearfix">
					<a class="add2review btn3" href="#addreview"><?=GetMessage('ADD_REVIEW')?></a>
					<?$APPLICATION->IncludeComponent(
						'bitrix:forum.topic.reviews',
						'gopro',
						Array(
							"URL_TEMPLATES_DETAIL" => $arParams["REVIEWS_URL_TEMPLATES_DETAIL"],			
							"SHOW_LINK_TO_FORUM" => $arParams["SHOW_LINK_TO_FORUM"],
							"FORUM_ID" => $arParams["FORUM_ID"],
							'IBLOCK_TYPE' => $arParams['IBLOCK_TYPE'],
							'IBLOCK_ID' => $arParams['IBLOCK_ID'],
							'ELEMENT_ID' => $ElementID,
							"URL_TEMPLATES_READ" => $arParams["URL_TEMPLATES_READ"],
							"MESSAGES_PER_PAGE" => $arParams["MESSAGES_PER_PAGE"],
							"PAGE_NAVIGATION_TEMPLATE" => $arParams["PAGE_NAVIGATION_TEMPLATE"],
							"PATH_TO_SMILE" => $arParams["PATH_TO_SMILE"],
							"USE_CAPTCHA" => $arParams["USE_CAPTCHA"],
							"CACHE_TYPE" => $arParams["CACHE_TYPE"],
							"CACHE_TIME" => $arParams["CACHE_TIME"],
							'AJAX_POST' => 'N',
							'AJAX_MODE' => 'N',
						),
						$component,
						array('HIDE_ICONS' => 'Y')
					);?>
				</div>
			</div>
		<?php endif; ?>
	</div><!-- /contents -->
</div>

<!-- // modification -->
<?php if($arParams['USE_BLOCK_MODS'] == 'Y'): ?>
    <?php
	$obCache = new CPHPCache();
	if ($obCache->InitCache(36000, serialize($arFilter) ,'/iblock/catalog')) {
		$arCurIBlock = $obCache->GetVars();
	} elseif ($obCache->StartDataCache()) {
		$arCurIBlock = CIBlockPriceTools::GetOffersIBlock($arParams['IBLOCK_ID']);
		if(defined('BX_COMP_MANAGED_CACHE')) {
			global $CACHE_MANAGER;
			$CACHE_MANAGER->StartTagCache('/iblock/catalog');
			if ($arCurIBlock) {
				$CACHE_MANAGER->RegisterTag('iblock_id_'.$arParams['IBLOCK_ID']);
			}
			$CACHE_MANAGER->EndTagCache();
		} else {
			if (!$arCurIBlock) {
				$arCurIBlock = array();
			}
		}
		$obCache->EndDataCache($arCurIBlock);
	}
    ?>
    <!-- mods -->
	<div class="mods">
        <?php
        global $modFilter,$JSON;
        $modFilter = array('PROPERTY_'.$arCurIBlock['OFFERS_PROPERTY_ID'] => $ElementID);
        ?>
		<h3 class="title2"><?=$arParams['MODS_BLOCK_NAME']?></h3>
        <?php
        global $alfaCTemplate, $alfaCSortType, $alfaCSortToo, $alfaCOutput;
        ?>
<?php
$APPLICATION->IncludeFile(
    SITE_DIR."include/sorter/catalog_element_mods.php",
    array(),
    array("MODE" => "html")
);
?>
		<div class="clear"></div>
        <!-- ajaxpages_gmci -->
		<div id="ajaxpages_mods" class="ajaxpages_gmci">
<?php
global $APPLICATION,$JSON;
$isSorterChange = 'N';
if ($_REQUEST['AJAX_CALL'] == 'Y' && $_REQUEST['sorterchange'] == 'ajaxpages_mods') {
	$isSorterChange = 'Y';
	$JSON['TYPE'] = 'OK';
}
$isAjaxpages = 'N';
if ($_REQUEST['ajaxpages'] == 'Y' && $_REQUEST['ajaxpagesid'] == 'ajaxpages_mods') {
	$isAjaxpages = 'Y';
	$JSON['TYPE'] = 'OK';
}
?>
			<?$APPLICATION->IncludeComponent(
				'bitrix:catalog.section',
				'gopro',
				array(
					'IBLOCK_TYPE' => $arParams['IBLOCK_TYPE'],
					'IBLOCK_ID' => $arCurIBlock['OFFERS_IBLOCK_ID'],
					'ELEMENT_SORT_FIELD' => $arParams['OFFERS_SORT_FIELD'],
					'ELEMENT_SORT_ORDER' => $arParams['OFFERS_SORT_ORDER'],
					'ELEMENT_SORT_FIELD2' => $arParams['OFFERS_SORT_FIELD2'],
					'ELEMENT_SORT_ORDER2' => $arParams['OFFERS_SORT_ORDER2'],
					'PROPERTY_CODE' => $arParams['LIST_OFFERS_PROPERTY_CODE'],
					'META_KEYWORDS' => $arParams['LIST_META_KEYWORDS'],
					'META_DESCRIPTION' => $arParams['LIST_META_DESCRIPTION'],
					'BROWSER_TITLE' => $arParams['LIST_BROWSER_TITLE'],
					'INCLUDE_SUBSECTIONS' => 'N',
					'BASKET_URL' => $arParams['BASKET_URL'],
					'ACTION_VARIABLE' => $arParams['ACTION_VARIABLE'],
					'PRODUCT_QUANTITY_VARIABLE' => $arParams['PRODUCT_QUANTITY_VARIABLE'],
					'PRODUCT_PROPS_VARIABLE' => $arParams['PRODUCT_PROPS_VARIABLE'],
					'FILTER_NAME' => 'modFilter',
					'CACHE_TYPE' => $arParams['CACHE_TYPE'],
					'CACHE_TIME' => $arParams['CACHE_TIME'],
					'CACHE_FILTER' => $arParams['CACHE_FILTER'],
					'CACHE_GROUPS' => $arParams['CACHE_GROUPS'],
					'SET_TITLE' => 'N',
					'SET_STATUS_404' => 'N',
					'DISPLAY_COMPARE' => 'N',
					'PAGE_ELEMENT_COUNT' => '100',
					'LINE_ELEMENT_COUNT' => $arParams['LINE_ELEMENT_COUNT'],
					'PRICE_CODE' => $arParams['PRICE_CODE'],
					'USE_PRICE_COUNT' => $arParams['USE_PRICE_COUNT'],
					'SHOW_PRICE_COUNT' => $arParams['SHOW_PRICE_COUNT'],

					'PRICE_VAT_INCLUDE' => $arParams['PRICE_VAT_INCLUDE'],
					'USE_PRODUCT_QUANTITY' => $arParams['~USE_PRODUCT_QUANTITY'],
					'ADD_PROPERTIES_TO_BASKET' => (isset($arParams['OFFERS_CART_PROPERTIES']) ? $arParams['OFFERS_CART_PROPERTIES'] : ''),
					'PARTIAL_PRODUCT_PROPERTIES' => (isset($arParams['PARTIAL_PRODUCT_PROPERTIES']) ? $arParams['PARTIAL_PRODUCT_PROPERTIES'] : ''),
					'PRODUCT_PROPERTIES' => $arParams['OFFERS_CART_PROPERTIES'],

					'DISPLAY_TOP_PAGER' => 'N',
					'DISPLAY_BOTTOM_PAGER' => 'N',
					'PAGER_TITLE' => $arParams['PAGER_TITLE'],
					'PAGER_SHOW_ALWAYS' => $arParams['PAGER_SHOW_ALWAYS'],
					'PAGER_TEMPLATE' => $arParams['PAGER_TEMPLATE'],
					'PAGER_DESC_NUMBERING' => $arParams['PAGER_DESC_NUMBERING'],
					'PAGER_DESC_NUMBERING_CACHE_TIME' => $arParams['PAGER_DESC_NUMBERING_CACHE_TIME'],
					'PAGER_SHOW_ALL' => $arParams['PAGER_SHOW_ALL'],
					'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
					'CURRENCY_ID' => $arParams['CURRENCY_ID'],
					// ajaxpages
					'AJAXPAGESID' => 'ajaxpages_mods',
					'IS_AJAXPAGES' => $isAjaxpages,
					'IS_SORTERCHANGE' => $isSorterChange,
					// goPro params
					'PROP_MORE_PHOTO' => $arParams['PROP_MORE_PHOTO'],
					'HIGHLOAD' => $arParams['HIGHLOAD'],
					'PROP_ARTICLE' => $arParams['PROP_SKU_ARTICLE'],
					'PROP_ACCESSORIES' => $arParams['PROP_ACCESSORIES'],
					'USE_FAVORITE' => 'N',
					'USE_SHARE' => 'N',
                    'SOC_SHARE_ICON' => $arParams['SOC_SHARE_ICON'],
					'SHOW_ERROR_EMPTY_ITEMS' => 'N',
					'OFF_MEASURE_RATION' => $arParams['OFF_MEASURE_RATION'],
					'PROP_SKU_MORE_PHOTO' => $arParams['PROP_SKU_MORE_PHOTO'],
					'PROP_SKU_ARTICLE' => $arParams['PROP_SKU_ARTICLE'],
					'PROPS_ATTRIBUTES' => $arParams['PROPS_ATTRIBUTES'],
                    // showcase
                    'OFF_SMALLPOPUP' => $arParams['OFF_SMALLPOPUP'],
                    'USE_SHADOW_ON_HOVER' => $arParams['USE_SHADOW_ON_HOVER'],
					// store
					'USE_STORE' => $arParams['USE_STORE'],
					'USE_MIN_AMOUNT' => $arParams['USE_MIN_AMOUNT'],
					'MIN_AMOUNT' => $arParams['MIN_AMOUNT'],
					'MAIN_TITLE' => $arParams['MAIN_TITLE'],
					"PROP_STORE_REPLACE_SECTION" => $arParams['PROP_STORE_REPLACE_SECTION'],
                	"PROP_STORE_REPLACE_DETAIL" => $arParams['PROP_STORE_REPLACE_DETAIL'],
					// -----
					'BY_LINK' => 'Y',
					'DONT_SHOW_LINKS' => 'Y',
					'VIEW' => $alfaCTemplate,
					'COLUMNS5' => 'Y',
				),
				$component,
				array('HIDE_ICONS'=>'Y')
			);?>

<?php if ($isAjaxpages == 'Y' || $isSorterChange == 'Y'): ?>
    <?php
	$APPLICATION->RestartBuffer();
	if(SITE_CHARSET!='utf-8') {
		$data = $APPLICATION->ConvertCharsetArray($JSON, SITE_CHARSET, 'utf-8');
		$json_str_utf = json_encode($data);
		$json_str = $APPLICATION->ConvertCharset($json_str_utf, 'utf-8', SITE_CHARSET);
		echo $json_str;
	} else {
		echo json_encode($JSON);
	}
	die();
    ?>
<?php endif; ?>

		</div>
        <!-- /ajaxpages_gmci -->
	</div>
    <!-- /mods -->
<script>
if( $('#ajaxpages_mods').find('.js-element').length<1 ) {
	$('.mods').hide();
}
</script>
<?php endif; ?>
<!-- // /modification -->

<!-- // collection -->
<?php if (!empty($arParams['USE_CUSTOM_COLLECTION']) && $arParams['USE_CUSTOM_COLLECTION'] == 'Y'): ?>
    <?php
    global $collectionFilter;
    $collectionElementsIds = array();
    $collectionIblockId = null;
    
    $obCache = new CPHPCache();
    
    $cacheId  = array(
        'IBLOCK_ID' => $arParams['IBLOCK_ID'],
        'ELEMENT_ID' => $ElementID,
        'CODE' => $arParams['CUSTOM_COLLECTION_PROPERTY']
    );
    
    $cacheId  = serialize($cacheId);
    $cacheDir = "/iblock/catalog.element";
    
    if ($obCache->InitCache(3600, $cacheId, $cacheDir)) {
        $vars = $obCache->GetVars();
        $collectionElementsIds = $vars['COLLECTION_ELEMENTS_IDS'];
        $collectionIblockId = $vars['COLLECTION_IBLOCK_ID'];
    } else {
        $dbProperty = CIBlockElement::GetProperty($arParams['IBLOCK_ID'], $ElementID, array(), array(
            'CODE' => $arParams['CUSTOM_COLLECTION_PROPERTY']
        ));
        while ($arProperty = $dbProperty->GetNext()) {
            if($arProperty['VALUE']) {          
                $collectionElementsIds[] = $arProperty['VALUE'];
            }
            if(!$collectionIblockId && $arProperty['LINK_IBLOCK_ID']) {
                $collectionIblockId = $arProperty['LINK_IBLOCK_ID'];
            }
        }
        
        global $CACHE_MANAGER;
        $CACHE_MANAGER->StartTagCache($cacheDir);
        $CACHE_MANAGER->RegisterTag("iblock_id_" . $arParams['IBLOCK_ID']);
        $CACHE_MANAGER->EndTagCache();
        
        $obCache->EndDataCache(array(
            "COLLECTION_ELEMENTS_IDS" => $collectionElementsIds,
            "COLLECTION_IBLOCK_ID" => $collectionIblockId
        ));
    }
    ?>
    
    <?php if (count($collectionElementsIds) > 0 && $collectionIblockId): ?>
        <?php
        $collectionFilter = array(
            'ID' => $collectionElementsIds,
        );
        ?>
        <div class="detailcollection">
            <h3 class="title2"><?=GetMessage('CUSTOM_COLLECTION_BLOCK_NAME');?></h3>
            <?php
            global $alfaCTemplate, $alfaCSortType, $alfaCSortToo, $alfaCOutput;
            ?>
<?php
$APPLICATION->IncludeFile(
    SITE_DIR."include/sorter/catalog_element_collection.php",
    array(),
    array("MODE" => "html")
);
?>
            <div class="clear"></div>
            <div id="ajaxpages_collection">
                <?php
                global $APPLICATION,$JSON;
                $isSorterChange = 'N';
                if ($_REQUEST['AJAX_CALL'] == 'Y' && $_REQUEST['sorterchange'] == 'ajaxpages_collection') {
                    $isSorterChange = 'Y';
                    $JSON['TYPE'] = 'OK';
                }
                $isAjaxpages = 'N';
                if ($_REQUEST['ajaxpages'] == 'Y' && $_REQUEST['ajaxpagesid'] == 'ajaxpages_collection') {
                    $isAjaxpages = 'Y';
                    $JSON['TYPE'] = 'OK';
                }
                ?>
                <?$APPLICATION->IncludeComponent(
                    'bitrix:catalog.section',
                    'collection',
                    array(
                        'IBLOCK_TYPE' => "",
                        'IBLOCK_ID' => $collectionIblockId,
                        'ELEMENT_SORT_FIELD' => $arParams['OFFERS_SORT_FIELD'],
                        'ELEMENT_SORT_ORDER' => $arParams['OFFERS_SORT_ORDER'],
                        'ELEMENT_SORT_FIELD2' => $arParams['OFFERS_SORT_FIELD2'],
                        'ELEMENT_SORT_ORDER2' => $arParams['OFFERS_SORT_ORDER2'],
                        'PROPERTY_CODE' => $arParams['LIST_OFFERS_PROPERTY_CODE'],
                        'META_KEYWORDS' => $arParams['LIST_META_KEYWORDS'],
                        'META_DESCRIPTION' => $arParams['LIST_META_DESCRIPTION'],
                        'BROWSER_TITLE' => $arParams['LIST_BROWSER_TITLE'],
                        'INCLUDE_SUBSECTIONS' => 'N',
                        'BASKET_URL' => $arParams['BASKET_URL'],
                        'ACTION_VARIABLE' => $arParams['ACTION_VARIABLE'],
                        'PRODUCT_QUANTITY_VARIABLE' => $arParams['PRODUCT_QUANTITY_VARIABLE'],
                        'PRODUCT_PROPS_VARIABLE' => $arParams['PRODUCT_PROPS_VARIABLE'],
                        'FILTER_NAME' => 'collectionFilter',
                        'CACHE_TYPE' => $arParams['CACHE_TYPE'],
                        'CACHE_TIME' => $arParams['CACHE_TIME'],
                        'CACHE_FILTER' => $arParams['CACHE_FILTER'],
                        'CACHE_GROUPS' => $arParams['CACHE_GROUPS'],
                        'SET_TITLE' => 'N',
                        'SET_STATUS_404' => 'N',
                        'DISPLAY_COMPARE' => 'N',
                        'PAGE_ELEMENT_COUNT' => '100',
                        'LINE_ELEMENT_COUNT' => $arParams['LINE_ELEMENT_COUNT'],
                        'PRICE_CODE' => $arParams['PRICE_CODE'],
                        'USE_PRICE_COUNT' => $arParams['USE_PRICE_COUNT'],
                        'SHOW_PRICE_COUNT' => $arParams['SHOW_PRICE_COUNT'],

                        'PRICE_VAT_INCLUDE' => $arParams['PRICE_VAT_INCLUDE'],
                        'USE_PRODUCT_QUANTITY' => $arParams['~USE_PRODUCT_QUANTITY'],
                        'ADD_PROPERTIES_TO_BASKET' => (isset($arParams['OFFERS_CART_PROPERTIES']) ? $arParams['OFFERS_CART_PROPERTIES'] : ''),
                        'PARTIAL_PRODUCT_PROPERTIES' => (isset($arParams['PARTIAL_PRODUCT_PROPERTIES']) ? $arParams['PARTIAL_PRODUCT_PROPERTIES'] : ''),
                        'PRODUCT_PROPERTIES' => $arParams['OFFERS_CART_PROPERTIES'],

                        'DISPLAY_TOP_PAGER' => 'N',
                        'DISPLAY_BOTTOM_PAGER' => 'N',
                        'PAGER_TITLE' => $arParams['PAGER_TITLE'],
                        'PAGER_SHOW_ALWAYS' => $arParams['PAGER_SHOW_ALWAYS'],
                        'PAGER_TEMPLATE' => $arParams['PAGER_TEMPLATE'],
                        'PAGER_DESC_NUMBERING' => $arParams['PAGER_DESC_NUMBERING'],
                        'PAGER_DESC_NUMBERING_CACHE_TIME' => $arParams['PAGER_DESC_NUMBERING_CACHE_TIME'],
                        'PAGER_SHOW_ALL' => $arParams['PAGER_SHOW_ALL'],
                        'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
                        'CURRENCY_ID' => $arParams['CURRENCY_ID'],
                        // ajaxpages
                        'AJAXPAGESID' => 'ajaxpages_collection',
                        'IS_AJAXPAGES' => $isAjaxpages,
                        'IS_AJAXPAGES' => $isSorterChange,
                        // goPro params
                        'PROP_MORE_PHOTO' => $arParams['PROP_MORE_PHOTO'],
                        'HIGHLOAD' => $arParams['HIGHLOAD'],
                        'PROP_ARTICLE' => $arParams['PROP_SKU_ARTICLE'],
                        'PROP_ACCESSORIES' => $arParams['PROP_ACCESSORIES'],
                        'USE_FAVORITE' => 'N',
                        'USE_SHARE' => 'N',
                        'SOC_SHARE_ICON' => $arParams['SOC_SHARE_ICON'],
                        'SHOW_ERROR_EMPTY_ITEMS' => 'N',
                        'OFF_MEASURE_RATION' => $arParams['OFF_MEASURE_RATION'],
                        'PROP_SKU_MORE_PHOTO' => $arParams['PROP_SKU_MORE_PHOTO'],
                        'PROP_SKU_ARTICLE' => $arParams['PROP_SKU_ARTICLE'],
                        'PROPS_ATTRIBUTES' => $arParams['PROPS_ATTRIBUTES'],
                        // showcase
                        'OFF_SMALLPOPUP' => $arParams['OFF_SMALLPOPUP'],
                        'USE_SHADOW_ON_HOVER' => $arParams['USE_SHADOW_ON_HOVER'],
                        // store
                        'USE_STORE' => $arParams['USE_STORE'],
                        'USE_MIN_AMOUNT' => $arParams['USE_MIN_AMOUNT'],
                        'MIN_AMOUNT' => $arParams['MIN_AMOUNT'],
                        'MAIN_TITLE' => $arParams['MAIN_TITLE'],
						"PROP_STORE_REPLACE_SECTION" => $arParams['PROP_STORE_REPLACE_SECTION'],
                		"PROP_STORE_REPLACE_DETAIL" => $arParams['PROP_STORE_REPLACE_DETAIL'],
                        // -----
                        'BY_LINK' => 'Y',
                        'DONT_SHOW_LINKS' => 'N',
                        'VIEW' => $alfaCTemplate,
                        'COLUMNS5' => 'Y',
                    ),
                    $component,
                    array('HIDE_ICONS'=>'Y')
                );?>
                <?php
                if ($isAjaxpages=='Y' || $isSorterChange=='Y') {
                    $APPLICATION->RestartBuffer();
                    if(SITE_CHARSET!='utf-8') {
                        $data = $APPLICATION->ConvertCharsetArray($JSON, SITE_CHARSET, 'utf-8');
                        $json_str_utf = json_encode($data);
                        $json_str = $APPLICATION->ConvertCharset($json_str_utf, 'utf-8', SITE_CHARSET);
                        echo $json_str;
                    } else {
                        echo json_encode($JSON);
                    }
                    die();
                }
                ?>
            </div>
            
            <?php $APPLICATION->ShowViewContent('collection_sections'); ?>
            
        </div>
        
    <?php endif; ?>
<?php endif; ?>
<!-- // /collection -->

<!-- // bigdata -->
<?php if ($arParams['USE_BIG_DATA'] == 'Y'): ?>
    <?php
	$obCache = new CPHPCache();
	if ($obCache->InitCache(36000, serialize($arFilter) ,'/iblock/catalog')) {
		$arCurIBlock = $obCache->GetVars();
	} elseif ($obCache->StartDataCache()) {
		$arCurIBlock = CIBlockPriceTools::GetOffersIBlock($arParams['IBLOCK_ID']);
		if(defined('BX_COMP_MANAGED_CACHE')) {
			global $CACHE_MANAGER;
			$CACHE_MANAGER->StartTagCache('/iblock/catalog');
			if($arCurIBlock) {
				$CACHE_MANAGER->RegisterTag('iblock_id_'.$arParams['IBLOCK_ID']);
			}
			$CACHE_MANAGER->EndTagCache();
		} else {
			if(!$arCurIBlock) {
				$arCurIBlock = array();
			}
		}
		$obCache->EndDataCache($arCurIBlock);
	}
    ?>
    <!-- /bigdata -->
	<div class="bigdata js-bigdata" style="display:none;">
		<h3 class="title2"><?=$arParams['BIGDATA_BLOCK_NAME']?></h3>
        <?php
        global $alfaCTemplate, $alfaCSortType, $alfaCSortToo, $alfaCOutput;
        ?>
<?php
$APPLICATION->IncludeFile(
    SITE_DIR."include/sorter/catalog_element_bigdata.php",
    array(),
    array("MODE" => "html")
);
?>
		<div class="clear"></div>
        <!-- /ajaxpages_gmci -->
		<div id="ajaxpages_bigdata" class="ajaxpages_gmci">
        <?php
        global $APPLICATION,$JSON;
        $isSorterChange = 'N';
        if ($_REQUEST['AJAX_CALL']=='Y' && $_REQUEST['sorterchange']=='ajaxpages_bigdata') {
            $isSorterChange = 'Y';
            $JSON['TYPE'] = 'OK';
        }
        $isAjaxpages = 'N';
        if ($_REQUEST['ajaxpages']=='Y' && $_REQUEST['ajaxpagesid']=='ajaxpages_bigdata') {
            $isAjaxpages = 'Y';
            $JSON['TYPE'] = 'OK';
        }
        ?>
        <?$APPLICATION->IncludeComponent(
            "bitrix:catalog.bigdata.products",
            "gopro",
            array(
                "LINE_ELEMENT_COUNT" => 5,
                "BASKET_URL" => $arParams["BASKET_URL"],
                "ACTION_VARIABLE" => (!empty($arParams["ACTION_VARIABLE"]) ? $arParams["ACTION_VARIABLE"] : "action")."_cbdp",
                "PRODUCT_QUANTITY_VARIABLE" => $arParams["PRODUCT_QUANTITY_VARIABLE"],
                "ADD_PROPERTIES_TO_BASKET" => (isset($arParams["ADD_PROPERTIES_TO_BASKET"]) ? $arParams["ADD_PROPERTIES_TO_BASKET"] : ''),
                "PRODUCT_PROPS_VARIABLE" => $arParams["PRODUCT_PROPS_VARIABLE"],
                "PARTIAL_PRODUCT_PROPERTIES" => (isset($arParams["PARTIAL_PRODUCT_PROPERTIES"]) ? $arParams["PARTIAL_PRODUCT_PROPERTIES"] : ''),
                "SHOW_OLD_PRICE" => $arParams['SHOW_OLD_PRICE'],
                "SHOW_DISCOUNT_PERCENT" => $arParams['SHOW_DISCOUNT_PERCENT'],
                "PRICE_CODE" => $arParams["PRICE_CODE"],
                "SHOW_PRICE_COUNT" => $arParams["SHOW_PRICE_COUNT"],
                "PRODUCT_SUBSCRIPTION" => $arParams['PRODUCT_SUBSCRIPTION'],
                "PRICE_VAT_INCLUDE" => $arParams["PRICE_VAT_INCLUDE"],
                "USE_PRODUCT_QUANTITY" => $arParams['USE_PRODUCT_QUANTITY'],
                "SHOW_NAME" => "Y",
                "SHOW_IMAGE" => "Y",
                "MESS_BTN_BUY" => $arParams['MESS_BTN_BUY'],
                "MESS_BTN_DETAIL" => $arParams['MESS_BTN_DETAIL'],
                "MESS_BTN_SUBSCRIBE" => $arParams['MESS_BTN_SUBSCRIBE'],
                "MESS_NOT_AVAILABLE" => $arParams['MESS_NOT_AVAILABLE'],
                "PAGE_ELEMENT_COUNT" => 5,
                "SHOW_FROM_SECTION" => "N",
                "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
                "IBLOCK_ID" => $arParams["IBLOCK_ID"],
                "DEPTH" => "2",
                "CACHE_TYPE" => $arParams["CACHE_TYPE"],
                "CACHE_TIME" => $arParams["CACHE_TIME"],
                "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
                "SHOW_PRODUCTS_".$arParams["IBLOCK_ID"] => "Y",
                "ADDITIONAL_PICT_PROP_".$arParams["IBLOCK_ID"] => $arParams['ADD_PICT_PROP'],
                "LABEL_PROP_".$arParams["IBLOCK_ID"] => "-",
                "HIDE_NOT_AVAILABLE" => $arParams["HIDE_NOT_AVAILABLE"],
				'HIDE_NOT_AVAILABLE_OFFERS' => $arParams["HIDE_NOT_AVAILABLE_OFFERS"],
                "CONVERT_CURRENCY" => $arParams["CONVERT_CURRENCY"],
                "CURRENCY_ID" => $arParams["CURRENCY_ID"],
                "SECTION_ELEMENT_ID" => $arResult["VARIABLES"]["SECTION_ID"],
                "SECTION_ELEMENT_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
                "ID" => $ElementID,
                "PROPERTY_CODE_".$arParams["IBLOCK_ID"] => $arParams["LIST_PROPERTY_CODE"],
                "PROPERTY_CODE_".$arCurIBlock['OFFERS_IBLOCK_ID'] => $arParams['LIST_OFFERS_PROPERTY_CODE'],
                "RCM_TYPE" => (isset($arParams['BIG_DATA_RCM_TYPE']) ? $arParams['BIG_DATA_RCM_TYPE'] : ''),
                /////////////////////////////////////
                'DISPLAY_COMPARE' => $arParams['USE_COMPARE'],
                // ajaxpages
                'AJAXPAGESID' => 'ajaxpages_bigdata',
                'IS_AJAXPAGES' => $isAjaxpages,
                'IS_AJAXPAGES' => $isSorterChange,
                // goPro params
                'PROP_MORE_PHOTO' => $arParams['PROP_MORE_PHOTO'],
                'HIGHLOAD' => $arParams['HIGHLOAD'],
                'PROP_ARTICLE' => $arParams['PROP_ARTICLE'],
                'PROP_ACCESSORIES' => $arParams['PROP_ACCESSORIES'],
                'USE_FAVORITE' => $arParams['USE_FAVORITE'],
                'USE_SHARE' => $arParams['USE_SHARE'],
                'SOC_SHARE_ICON' => $arParams['SOC_SHARE_ICON'],
                'SHOW_ERROR_EMPTY_ITEMS' => $arParams['SHOW_ERROR_EMPTY_ITEMS'],
                'EMPTY_ITEMS_HIDE_FIL_SORT' => 'Y',
                'USE_AUTO_AJAXPAGES' => $arParams['USE_AUTO_AJAXPAGES'],
                'OFF_MEASURE_RATION' => $arParams['OFF_MEASURE_RATION'],
                'SOC_SHARE_ICON' => $arParams['SOC_SHARE_ICON'],
                // showcase
                'OFF_SMALLPOPUP' => $arParams['OFF_SMALLPOPUP'],
                'USE_SHADOW_ON_HOVER' => $arParams['USE_SHADOW_ON_HOVER'],
                // SKU
                'PROP_SKU_MORE_PHOTO' => $arParams['PROP_SKU_MORE_PHOTO'],
                'PROP_SKU_ARTICLE' => $arParams['PROP_SKU_ARTICLE'],
                'PROPS_ATTRIBUTES' => $arParams['PROPS_ATTRIBUTES'],
                'PROPS_ATTRIBUTES_COLOR' => $arParams['PROPS_ATTRIBUTES_COLOR'],
                // store
                'USE_STORE' => $arParams['USE_STORE'],
                'USE_MIN_AMOUNT' => $arParams['USE_MIN_AMOUNT'],
                'MIN_AMOUNT' => $arParams['MIN_AMOUNT'],
                'MAIN_TITLE' => $arParams['MAIN_TITLE'],
				"PROP_STORE_REPLACE_SECTION" => $arParams['PROP_STORE_REPLACE_SECTION'],
                "PROP_STORE_REPLACE_DETAIL" => $arParams['PROP_STORE_REPLACE_DETAIL'],
                // view
                'VIEW' => $alfaCTemplate,
                // columns
                'COLUMNS5' => 'Y',
            ),
            $component,
            array("HIDE_ICONS" => "Y")
        );?>
        <?php
        if ($isAjaxpages == 'Y' || $isSorterChange == 'Y') {
            $APPLICATION->RestartBuffer();
            if(SITE_CHARSET!='utf-8') {
                $data = $APPLICATION->ConvertCharsetArray($JSON, SITE_CHARSET, 'utf-8');
                $json_str_utf = json_encode($data);
                $json_str = $APPLICATION->ConvertCharset($json_str_utf, 'utf-8', SITE_CHARSET);
                echo $json_str;
            } else {
                echo json_encode($JSON);
            }
            die();
        }
        ?>
		</div>
        <!-- /ajaxpages_gmci -->
	</div><!-- /bigdata -->
<?php endif; ?>
<!-- // /bigdata -->
