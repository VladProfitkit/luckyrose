<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Sales");?><h1>Sales</h1><?$APPLICATION->IncludeComponent(
	"bitrix:menu", 
	"personal", 
	array(
		"COMPONENT_TEMPLATE" => "personal",
		"ROOT_MENU_TYPE" => "left2",
		"MENU_CACHE_TYPE" => "A",
		"MENU_CACHE_TIME" => "3600000",
		"MENU_CACHE_USE_GROUPS" => "Y",
		"MENU_CACHE_GET_VARS" => array(
		),
		"MAX_LEVEL" => "1",
		"CHILD_MENU_TYPE" => "",
		"USE_EXT" => "N",
		"DELAY" => "N",
		"ALLOW_MULTI_SELECT" => "N"
	),
	false
);?><?$APPLICATION->IncludeComponent(
	"dresscode:simple.offers", 
	".default", 
	array(
		"COMPONENT_TEMPLATE" => ".default",
		"IBLOCK_TYPE" => "catalog",
		"IBLOCK_ID" => "10",
		"PRICE_CODE" => array(
			0 => "BASE",
		),
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "3600000",
		"PROP_NAME" => "OFFERS",
		"PROP_VALUE" => "11",
		"CONVERT_CURRENCY" => "Y",
		"PROPERTY_CODE" => array(
			0 => "OFFERS",
			1 => "SKU_COLOR",
			2 => "VIDEO",
			3 => "WARRANTY",
			4 => "REF",
			5 => "CML2_ARTICLE",
			6 => "DELIVERY",
			7 => "PICKUP",
			8 => "USER_ID",
			9 => "BLOG_POST_ID",
			10 => "BLOG_COMMENTS_CNT",
			11 => "VOTE_COUNT",
			12 => "SHOW_MENU",
			13 => "SIMILAR_PRODUCT",
			14 => "RATING",
			15 => "RELATED_PRODUCT",
			16 => "VOTE_SUM",
			17 => "ATT_BRAND",
			18 => "COLOR",
			19 => "ZOOM2",
			20 => "BATTERY_LIFE",
			21 => "SWITCH",
			22 => "GRAF_PROC",
			23 => "LENGTH_OF_CORD",
			24 => "DISPLAY",
			25 => "LOADING_LAUNDRY",
			26 => "FULL_HD_VIDEO_RECORD",
			27 => "INTERFACE",
			28 => "COMPRESSORS",
			29 => "Number_of_Outlets",
			30 => "MAX_RESOLUTION_VIDEO",
			31 => "MAX_BUS_FREQUENCY",
			32 => "MAX_RESOLUTION",
			33 => "FREEZER",
			34 => "POWER_SUB",
			35 => "POWER",
			36 => "HARD_DRIVE_SPACE",
			37 => "MEMORY",
			38 => "OS",
			39 => "ZOOM",
			40 => "PAPER_FEED",
			41 => "SUPPORTED_STANDARTS",
			42 => "VIDEO_FORMAT",
			43 => "SUPPORT_2SIM",
			44 => "MP3",
			45 => "ETHERNET_PORTS",
			46 => "MATRIX",
			47 => "CAMERA",
			48 => "PHOTOSENSITIVITY",
			49 => "DEFROST",
			50 => "SPEED_WIFI",
			51 => "SPIN_SPEED",
			52 => "PRINT_SPEED",
			53 => "SOCKET",
			54 => "IMAGE_STABILIZER",
			55 => "GSM",
			56 => "SIM",
			57 => "TYPE",
			58 => "MEMORY_CARD",
			59 => "TYPE_BODY",
			60 => "TYPE_MOUSE",
			61 => "TYPE_PRINT",
			62 => "CONNECTION",
			63 => "TYPE_OF_CONTROL",
			64 => "TYPE_DISPLAY",
			65 => "TYPE2",
			66 => "REFRESH_RATE",
			67 => "RANGE",
			68 => "AMOUNT_MEMORY",
			69 => "MEMORY_CAPACITY",
			70 => "VIDEO_BRAND",
			71 => "DIAGONAL",
			72 => "RESOLUTION",
			73 => "TOUCH",
			74 => "CORES",
			75 => "LINE_PROC",
			76 => "PROCESSOR",
			77 => "CLOCK_SPEED",
			78 => "TYPE_PROCESSOR",
			79 => "PROCESSOR_SPEED",
			80 => "HARD_DRIVE",
			81 => "HARD_DRIVE_TYPE",
			82 => "Number_of_memory_slots",
			83 => "MAXIMUM_MEMORY_FREQUENCY",
			84 => "TYPE_MEMORY",
			85 => "BLUETOOTH",
			86 => "FM",
			87 => "GPS",
			88 => "HDMI",
			89 => "SMART_TV",
			90 => "USB",
			91 => "WIFI",
			92 => "FLASH",
			93 => "ROTARY_DISPLAY",
			94 => "SUPPORT_3D",
			95 => "SUPPORT_3G",
			96 => "WITH_COOLER",
			97 => "FINGERPRINT",
			98 => "COLLECTION",
			99 => "TOTAL_OUTPUT_POWER",
			100 => "HTML",
			101 => "VID_ZASTECHKI",
			102 => "VID_SUMKI",
			103 => "PROFILE",
			104 => "VYSOTA_RUCHEK",
			105 => "GAS_CONTROL",
			106 => "GRILL",
			107 => "MORE_PROPERTIES",
			108 => "GENRE",
			109 => "OTSEKOV",
			110 => "CONVECTION",
			111 => "INTAKE_POWER",
			112 => "NAZNAZHENIE",
			113 => "BULK",
			114 => "PODKLADKA",
			115 => "SURFACE_COATING",
			116 => "brand_tyres",
			117 => "SEASON",
			118 => "SEASONOST",
			119 => "DUST_COLLECTION",
			120 => "COUNTRY_BRAND",
			121 => "DRYING",
			122 => "REMOVABLE_TOP_COVER",
			123 => "CONTROL",
			124 => "FINE_FILTER",
			125 => "FORM_FAKTOR",
			126 => "MARKER_PHOTO",
			127 => "NEW",
			128 => "DELIVERY_DESC",
			129 => "SALE",
			130 => "MARKER",
			131 => "POPULAR",
			132 => "WEIGHT",
			133 => "HEIGHT",
			134 => "DEPTH",
			135 => "WIDTH",
			136 => "",
		),
		"CURRENCY_ID" => "USD",
		"HIDE_NOT_AVAILABLE" => "N",
		"HIDE_MEASURES" => "N",
		"COMPOSITE_FRAME_MODE" => "A",
		"COMPOSITE_FRAME_TYPE" => "AUTO"
	),
	false,
	array(
		"ACTIVE_COMPONENT" => "Y"
	)
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>