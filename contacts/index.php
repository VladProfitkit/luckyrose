<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Contacts: E-mail, phone: Viber, WhatsApp");
?><h1>Contacts</h1>
<p>E-Mail: sales@luckyroseclub.com
<div style="width:600px;margin:0 autho;text-align:center;">
    <ul class="sn">
        <a href="https://vk.com/luckyroseclub" class="vk" rel="nofollow"></a>
        <a href="http://www.facebook.com/luckyroseclub" class="fb" rel="nofollow"></a>
        <a href="https://twitter.com/luckyroseclub" class="tw" rel="nofollow"></a>
        <a href="https://instagram.com/luckyroseclub_official" class="go" rel="nofollow"></a>

    </ul>
</div>

<html>
 <head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>Подчеркивание у ссылок</title>
  <style type="text/css">
   A {
    text-decoration: none; /* Убирает подчеркивание для ссылок */
   } 
   A:hover { 
    text-decoration: underline; /* Добавляем подчеркивание при наведении курсора на ссылку */
    color: orange; /* Ссылка красного цвета */
   } 
  </style>
 </head>
 <body> 
   <p><a href="https://www.facebook.com/luckyroseclub">Facebook</a></p>
<p><a href="https://www.instagram.com/luckyroseclub_official/">Instagram</a></p>
<p><a href="https://twitter.com/luckyroseclub">Twitter</a></p>
<p><a href="https://vk.com/luckyroseclub">VKontakte</a></p>
 </body>
</html>


<p><p> If you have any questions, you can text us via phone number <p>Whatsapp/Viber/Telegram<strong> +7-964-612-08-92.</strong> <p> Text in English only please.

 <?$APPLICATION->IncludeComponent(
	"bitrix:menu",
	"personal",
	Array(
		"ALLOW_MULTI_SELECT" => "N",
		"CHILD_MENU_TYPE" => "",
		"COMPONENT_TEMPLATE" => "personal",
		"DELAY" => "N",
		"MAX_LEVEL" => "1",
		"MENU_CACHE_GET_VARS" => array(),
		"MENU_CACHE_TIME" => "3600000",
		"MENU_CACHE_TYPE" => "A",
		"MENU_CACHE_USE_GROUPS" => "Y",
		"ROOT_MENU_TYPE" => "about",
		"USE_EXT" => "N"
	)
);?>

	
		<?$APPLICATION->IncludeComponent(
			"bitrix:form.result.new", 
			".default", 
			array(
				"CACHE_TIME" => "360000",
				"CACHE_TYPE" => "Y",
				"CHAIN_ITEM_LINK" => "",
				"CHAIN_ITEM_TEXT" => "",
				"EDIT_URL" => "",
				"IGNORE_CUSTOM_TEMPLATE" => "N",
				"LIST_URL" => "",
				"SEF_MODE" => "N",
				"SUCCESS_URL" => "",
				"USE_EXTENDED_ERRORS" => "Y",
				"WEB_FORM_ID" => "2",
				"COMPONENT_TEMPLATE" => ".default",
				"VARIABLE_ALIASES" => array(
					"WEB_FORM_ID" => "WEB_FORM_ID",
					"RESULT_ID" => "RESULT_ID",
				)
			),
			false
		);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php")?>