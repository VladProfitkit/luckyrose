<?define("INDEX_PAGE", "Y");?>
<?define("MAIN_PAGE", true);?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Lucky Rose Club");?>
	<div id="promoBlock">
	<?$APPLICATION->IncludeComponent("dresscode:slider", "promoSlider", array(
		"IBLOCK_TYPE" => "slider",
			"IBLOCK_ID" => "2",
			"CACHE_TYPE" => "Y",
			"CACHE_TIME" => "3600000",
			"PICTURE_WIDTH" => "1181",
			"PICTURE_HEIGHT" => "555",
			"COMPONENT_TEMPLATE" => "promoSlider",
			"COMPOSITE_FRAME_MODE" => "A",
			"COMPOSITE_FRAME_TYPE" => "AUTO"
		),
		false,
		array(
		"ACTIVE_COMPONENT" => "Y"
		)
	);?>

	<?$APPLICATION->IncludeComponent(
		"dresscode:special.product", 
		".default", 
		array(
			"CACHE_TYPE" => "Y",
			"CACHE_TIME" => "3600000",
			"PROP_NAME" => "PRODUCT_DAY",
			"IBLOCK_TYPE" => "catalog",
			"IBLOCK_ID" => "10",
			"PICTURE_WIDTH" => "200",
			"PICTURE_HEIGHT" => "180",
			"ELEMENTS_COUNT" => "10",
			"SORT_PROPERTY_NAME" => "SORT",
			"SORT_VALUE" => "ASC",
			"COMPONENT_TEMPLATE" => ".default",
			"HIDE_NOT_AVAILABLE" => "N",
			"HIDE_MEASURES" => "N"
		),
		false,
		array(
			"ACTIVE_COMPONENT" => "Y"
		)
	);?>
	</div>

	<?$APPLICATION->IncludeComponent(
		"dresscode:offers.product", 
		".default", 
		array(
			"CACHE_TYPE" => "Y",
			"CACHE_TIME" => "3600000",
			"PROP_NAME" => "OFFERS",
			"IBLOCK_TYPE" => "catalog",
			"IBLOCK_ID" => "10",
			"PICTURE_WIDTH" => "770",
			"PICTURE_HEIGHT" => "425",
			"PROP_VALUE" => array(
				0 => "_9",
				1 => "_10",
				2 => "_11",
				3 => "_12",
				4 => "_50",
			),
			"ELEMENTS_COUNT" => "10",
			"SORT_PROPERTY_NAME" => "SORT",
			"SORT_VALUE" => "ASC",
			"COMPONENT_TEMPLATE" => ".default",
			"PRODUCT_PRICE_CODE" => array(
				0 => "BASE",
			),
			"HIDE_NOT_AVAILABLE" => "N",
			"HIDE_MEASURES" => "N",
			"COMPOSITE_FRAME_MODE" => "A",
			"COMPOSITE_FRAME_TYPE" => "AUTO"
		),
		false,
		array(
			"ACTIVE_COMPONENT" => "Y"
		)
	);?>


	<?$APPLICATION->IncludeComponent(
		"dresscode:pop.section", 
		".default", 
		array(
			"CACHE_TYPE" => "Y",
			"CACHE_TIME" => "3600000",
			"PROP_NAME" => "UF_POPULAR",
			"IBLOCK_TYPE" => "catalog",
			"IBLOCK_ID" => "10",
			"PICTURE_WIDTH" => "120",
			"PICTURE_HEIGHT" => "100",
			"PROP_VALUE" => "Y",
			"ELEMENTS_COUNT" => "10",
			"SORT_PROPERTY_NAME" => "7",
			"SORT_VALUE" => "DESC",
			"SELECT_FIELDS" => array(
				0 => "NAME",
				1 => "SECTION_PAGE_URL",
				2 => "DETAIL_PICTURE",
				3 => "UF_IMAGES",
				4 => "UF_MARKER",
				5 => "",
			),
			"POP_LAST_ELEMENT" => "Y",
			"COMPONENT_TEMPLATE" => ".default"
		),
		false,
		array(
			"ACTIVE_COMPONENT" => "Y"
		)
	);?>
	
	<?$APPLICATION->IncludeComponent(
		"dresscode:slider", 
		"middle", 
		array(
			"IBLOCK_TYPE" => "slider",
			"IBLOCK_ID" => "3",
			"CACHE_TYPE" => "Y",
			"CACHE_TIME" => "3600000",
			"PICTURE_WIDTH" => "1476",
			"PICTURE_HEIGHT" => "202"
		),
		false
	);?> 	
	
	<?$APPLICATION->IncludeComponent(
		"bitrix:main.include", 
		".default", 
		array(
			"COMPONENT_TEMPLATE" => ".default",
			"AREA_FILE_SHOW" => "sect",
			"AREA_FILE_SUFFIX" => "simplyText",
			"AREA_FILE_RECURSIVE" => "Y",
			"EDIT_TEMPLATE" => ""
		),
		false
	);?>

<!-- дизайн создание seo: TOP-iNFO d.o.o. +7 931 273 63 31 http://top-info.biz top.info.croatia@gmail.com -->
<!-- не удалять эту строчку - та, что вверху :) -->
<!-- когда сломается - чинить не будем -->
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>