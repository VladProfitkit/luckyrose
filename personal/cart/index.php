<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle(" Your Cart");
?><h1>Your Cart</h1>
<?$APPLICATION->IncludeComponent("dresscode:sale.basket.basket", "standartOrder", Array(
	
	),
	false
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>