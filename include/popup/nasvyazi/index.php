<?require($_SERVER['DOCUMENT_ROOT'].'/bitrix/header.php');
$APPLICATION->SetTitle("Мы всегда на связи");
?><?php
echo '<link href="'.SITE_DIR.'include/popup/nasvyazi/style.css?'.randString(10, array('1234567890')).'" type="text/css" rel="stylesheet" />';
?>
<div class="nasvyazi">
	<div class="block left">
		<span style="color:#666666;"></span><br />
		<span style="font-weight:bold;font-family:Opensanslight,Arial,Helvetica,sans-serif;">What's App/Viber</span><br />
		<a href="tel:89646120892">+7-964-612-08-92</a><br />
		<br />
		<span style="font-weight:bold;font-family:Opensanslight,Arial,Helvetica,sans-serif;">ВЫ МОЖЕТЕ НАПИСАТЬ НАМ ПИСЬМО</span><br />
		<a href="mailto:luckyrose@list.ru">luckyrose@list.ru</a><br />
		или воспользоваться формой для оптовиков <a href="http://www.luckyroseclub.ru//wholesale-buyers">обратной связи</a><br />
		<br />
		<span style="line-height:25px;font-weight:bold;font-family:Opensanslight,Arial,Helvetica,sans-serif;">ПРИСОЕДИНЯЙСЯ</span><br />
		<a href="https://www.facebook.com/luckyroseclub"><img src="/include/icon_fb.png" alt=""></a>&nbsp; 
		<a href="https://vk.com/luckyroseclub"><img src="/include/icon_vk.png" alt=""></a>&nbsp; 
		<a href="https://twitter.com/luckyroseclub"><img src="/include/icon_tw.png" alt=""></a>&nbsp; 
		<a href="https://www.instagram.com/luckyroseclub_official/"><img src="/include/icon_inst.png" alt=""></a>&nbsp; 
		<a href="https://www.youtube.com/channel/UCIFZtwOZ-lfKt2mBG-DvkQQ"><img src="/include/youtube.png" alt=""></a>&nbsp; 
	</div>
	<div class="block center"><?
		$APPLICATION->IncludeComponent(
			"bitrix:catalog.store.list",
			"nasvyazi",
			Array(
				"CACHE_TIME" => $arParams["CACHE_TIME"],
				"PHONE" => $arParams["PHONE"],
				"SCHEDULE" => $arParams["SCHEDULE"],
				"MIN_AMOUNT" => $arParams["MIN_AMOUNT"],
				"TITLE" => $arParams["TITLE"],
				"SET_TITLE" => $arParams["SET_TITLE"],
				"PATH_TO_ELEMENT" => $arResult["PATH_TO_ELEMENT"],
				"PATH_TO_LISTSTORES" => $arResult["PATH_TO_LISTSTORES"],
				"MAP_TYPE" => $arParams["MAP_TYPE"],
			)
		);
	?></div>
	<div class="block right">
		<span style="font-weight:bold;font-family:Opensanslight,Arial,Helvetica,sans-serif;"></span><br />
		<a href="#"></a><br />
		<a href="#"></a><br />
		<a href="#"></a><br />
		<br />
		<span style="font-weight:bold;font-family:Opensanslight,Arial,Helvetica,sans-serif;"></span><br />
		<a href="#"></a><br />
		<a href="#"></a><br />
		<a href="#"></a><br />
	</div>
</div>

<?require($_SERVER['DOCUMENT_ROOT'].'/bitrix/footer.php');?>