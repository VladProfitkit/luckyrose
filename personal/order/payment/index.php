<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
$APPLICATION->SetTitle("Оплата заказа");
ob_start();
?>
<?$APPLICATION->IncludeComponent(
	"bitrix:sale.order.payment",
	"",
	Array(
	)
);?>
<?
$formPay = ob_get_contents();
ob_end_clean();
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_after.php");
$APPLICATION->SetTitle("Оплата заказа");
?>
	<div class="formPayment">
		<?
		echo $formPay;
		?>
	</div>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>