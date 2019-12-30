<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Wholesale");
?>If you would like to become a member of the Lucky Rose Club team or obtain more discounts, fill out the feedback form presented below and our manager will be in touch with you soon. We would love to see you join our team!
<?$APPLICATION->IncludeComponent("bitrix:form", "template1", Array(
	"AJAX_MODE" => "Y",	// Enable AJAX mode
		"AJAX_OPTION_ADDITIONAL" => "",	// Additional ID
		"AJAX_OPTION_HISTORY" => "N",	// Emulate browser navigation
		"AJAX_OPTION_JUMP" => "N",	// Enable scrolling to component's top
		"AJAX_OPTION_STYLE" => "Y",	// Enable styles loading
		"CACHE_TIME" => "3600",	// Cache time (sec.)
		"CACHE_TYPE" => "A",	// Cache type
		"CHAIN_ITEM_LINK" => "",	// Link for additional navigation chain item
		"CHAIN_ITEM_TEXT" => "",	// Name of additional navigation chain item
		"COMPOSITE_FRAME_MODE" => "A",	// Default component template vote
		"COMPOSITE_FRAME_TYPE" => "AUTO",	// Component content
		"EDIT_ADDITIONAL" => "N",	// Allow editing the auxiliary fields
		"EDIT_STATUS" => "Y",	// Show status change form
		"IGNORE_CUSTOM_TEMPLATE" => "N",	// Ignore custom template
		"NOT_SHOW_FILTER" => array(	// Codes of fields that are not allowed to show in the filter
			0 => "",
			1 => "",
		),
		"NOT_SHOW_TABLE" => array(	// Codes of fields that are not allowed to show in the table
			0 => "",
			1 => "",
		),
		"RESULT_ID" => $_REQUEST[RESULT_ID],	// Result ID
		"SEF_MODE" => "N",	// Enable SEF (Search Engine Friendly Urls) support
		"SHOW_ADDITIONAL" => "N",	// Show auxiliary web form fields in a table of results
		"SHOW_ANSWER_VALUE" => "N",	// Show value ANSWER_VALUE in a table of results
		"SHOW_EDIT_PAGE" => "N",	// Show Result Edit page
		"SHOW_LIST_PAGE" => "N",	// Show Results List page
		"SHOW_STATUS" => "Y",	// Show status for each result in a table of results
		"SHOW_VIEW_PAGE" => "N",	// Show Result View page
		"START_PAGE" => "new",	// Start page
		"SUCCESS_URL" => "",	// Success page URL
		"USE_EXTENDED_ERRORS" => "N",	// Use extended error messages output
		"VARIABLE_ALIASES" => array(
			"action" => "action",
		),
		"WEB_FORM_ID" => "3",	// Web form ID
	),
	false
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>