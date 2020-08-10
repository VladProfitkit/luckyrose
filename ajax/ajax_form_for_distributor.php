<?php
if($_POST['IS_AJAX'] == 'N'){
    require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
}
else{
    require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
}


$data = array_map('trim', $_POST);
CModule::IncludeModule("iblock");
$el = new CIBlockElement;

$arFileds = Array(
    "IBLOCK_ID"       => 12,
    "PROPERTY_VALUES" => array(
        'COUNTRY' => $_POST['country'],
        'CITY' => $_POST['city'],
        'NAME' => $_POST['user_name'],
        'SURNAME' => $_POST['user_surname'],
        'PHONE' => $_POST['user_number'],
        'EMAIL' => $_POST['user_email'],
        'SHOP' => $_POST['user_shop'],
        'LINKS' => $_POST['user_links'],
    ),
    "NAME"            => $_POST['user_surname'].' '.$_POST['user_name'].' - '.$_POST['user_shop'],
    "ACTIVE"          => "Y"
);

if ($PRODUCT_ID = $el->Add($arFileds)) {
    echo 'Отправлено';
}else{
    echo strip_tags($el->LAST_ERROR);
}


$USER_COUNTRY = htmlspecialchars($_POST["country"]);
$USER_CITY = htmlspecialchars($_POST["city"]);
$USER_NAME = htmlspecialchars($_POST["user_name"]);
$USER_SURNAME = htmlspecialchars($_POST["user_surname"]);
$USER_NUMBER = htmlspecialchars($_POST["user_number"]);
$USER_EMAIL = htmlspecialchars($_POST["user_email"]);
$USER_SHOP = htmlspecialchars($_POST["user_shop"]);
$USER_LINKS = htmlspecialchars($_POST["user_links"]);

$arEventFields = array(
    "USER_COUNTRY" => $USER_COUNTRY,
    "USER_CITY" => $USER_CITY,
    "USER_NAME" => $USER_NAME,
    "USER_SURNAME" => $USER_SURNAME,
    "USER_NUMBER" => $USER_NUMBER,
    "USER_EMAIL" => $USER_EMAIL,
    "USER_SHOP" => $USER_SHOP,
    "USER_LINKS" => $USER_LINKS
);

CEvent::send("REQUEST_DISTRIBUTOR", "s1", $arEventFields, "N", "", "");

if($_POST['IS_AJAX'] == 'N'){
    require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
}