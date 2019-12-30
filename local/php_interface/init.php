<?php
include_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/wsrubi.smtp/classes/general/wsrubismtp.php");
define("LOG_FILENAME", $_SERVER["DOCUMENT_ROOT"] . "/log/log_" . date("d_m_y") . ".txt");

use Bitrix\Main\Mail\Event;

/**
 * Created by PhpStorm.
 * User: alexe
 * Date: 25.07.2019
 * Time: 19:05
 */
AddEventHandler("sale", "OnOrderNewSendEmail", "modifySendingSaleData");

function modifySendingSaleData($orderID, &$eventName, &$arFields)
{
    // инициализируем переменные
    $name = '';
    $lastName = '';
    $fullName = '';
    $phone = '';
    $zip = '';
    $countryName = '';
    $obl = '';
    $cityName = '';
    $address = '';
    $address2 = '';
    $deliveryName = '';
    $paySystemName = '';

    // получаем параметры заказа по ID
    $arOrder = CSaleOrder::GetByID($orderID);

    // получаем свойства заказа
    $orderProps = CSaleOrderPropsValue::GetOrderProps($orderID);

    // проходим циклом по всем свойствам и вытаскиваем нужные нам
    while ($arProps = $orderProps->Fetch()) {
        // телефон
        if ($arProps['CODE'] == 'PHONE') {
            $phone = htmlspecialchars($arProps['VALUE']);
        }
        // индекс
        if ($arProps['CODE'] == 'PCZ') {
            $zip = $arProps['VALUE'];
        }
        // индекс
        if ($arProps['CODE'] == 'CITY') {
            $city = $arProps['VALUE'];
        }
        // адрес
        if ($arProps['CODE'] == 'ADDRESS') {
            $address = $arProps['VALUE'];
        }
        // адрес
        if ($arProps['CODE'] == 'ADDRESS2') {
            $address2 = $arProps['VALUE'];
        }
        // имя
        if ($arProps['CODE'] == 'FN') {
            $name = $arProps['VALUE'];
        }
        // фамилия
        if ($arProps['CODE'] == 'LN') {
            $lastName = $arProps['VALUE'];
        }
    }

    if ($name or $lastName)
        $fullName = $name . ' ' . $lastName;
    if ($zip)
        $fullAddress = $zip . ', ';

    if ($cityName)
        $fullAddress .= $cityName . ', ';
    if ($address)
        $fullAddress .= $address . ', ';
    $fullAddress .= $address2;

    // получаем название службы доставки
    $arDeliv = CSaleDelivery::GetByID($arOrder['DELIVERY_ID']);
    if ($arDeliv) {
        $deliveryName = $arDeliv['NAME'];
    }

    // получаем название платежной системы
    $arPaySystem = CSalePaySystem::GetByID($arOrder['PAY_SYSTEM_ID']);
    if ($arPaySystem) {
        $paySystemName = $arPaySystem['NAME'];
    }


    if ($arOrder['USER_DESCRIPTION'])
        $arFields['ORDER_DESCRIPTION'] = $arOrder['USER_DESCRIPTION'];
    $arFields['PRICE_DELIVERY'] = $arOrder['PRICE_DELIVERY'];
    $arFields['USER_FULL_NAME'] = $fullName;
    $arFields['PHONE'] = $phone;
    $arFields['CITY'] = $city;
    $arFields['DELIVERY_NAME'] = $deliveryName;
    $arFields['PAY_SYSTEM_NAME'] = $paySystemName;
    $arFields['FULL_ADDRESS'] = $fullAddress;

}

AddEventHandler("sale", "OnSaleComponentOrderResultPrepared", ['\SaleEvents', "OnSaleComponentOrderResultPrepared"]);

class SaleEvents {

    public static function OnSaleComponentOrderResultPrepared($order, &$user_result, $request, &$params, &$result) {
        /**@global \CUser $USER */
        global $USER;
        if ($USER->IsAuthorized()
            && ($user_info = \Bitrix\Main\UserTable::getList([
                'filter' => [
                    '=ID' => $USER->GetID(),
                ],
                'select' => [
                    'EMAIL',
                    'NAME',
                    'LAST_NAME',
                    'SECOND_NAME',
                    'PERSONAL_PHONE',
                ],
            ])->fetch())
        ) {
            foreach ($result['JS_DATA']['ORDER_PROP']['properties'] as &$prop) {
                if (!empty(reset($prop['VALUE']))) {
                    continue;
                }

                if ($prop['CODE'] == 'LN') {
                    $prop['VALUE'] = $user_info['LAST_NAME'];
                }
                if ($prop['CODE'] == 'FN') {
                    $prop['VALUE'] = $user_info['NAME'];
                }

            }
            unset($prop);
        }
    }
}

AddEventHandler("main", "OnBeforeUserRegister", Array("UserEvent", "OnBeforeUserRegisterHandler"));
AddEventHandler("main", "OnAfterUserAdd", Array("UserEvent", "OnAfterUserAddHandler"));
AddEventHandler("main", "OnBeforeUserAdd", Array("UserEvent", "OnBeforeUserAddHandler"));

class UserEvent {

    function OnBeforeUserRegisterHandler(&$arFields) {
        //AddMessage2Log($arFields, 'UserRegistration');
    }

    function OnAfterUserAddHandler(&$arFields) {
        AddMessage2Log($arFields,'UserAdd');

        $res2 = Event::send(
            array(
                "EVENT_NAME" => "AUTO_REGISTRATION_USER",
                "LID" => "s1",
                "C_FIELDS" => array(
                    "USER_MAIL" => $arFields['EMAIL'],
                    "USER_LOGIN" => $arFields['LOGIN'],
                    "USER_PASWORD" => $arFields['CONFIRM_PASSWORD'],
                ),
            )
        );
        if ($res2->getId()) {
//            AddMessage2Log("Отправка сообщения на почту ". $res2->getId(), "sendMail");
        } else {
//            AddMessage2Log("Отправка сообщения на почту неудалась", "sendMail");
        }

        $arFilter = Array(
            "USER_LOGIN" => $arFields['LOGIN'],
        );

        CModule::IncludeModule("sale");
        $db_sales = CSaleOrder::GetList(array("ID" => "DESC"), $arFilter);
        if ($ar_sales = $db_sales->Fetch()) {
            AddMessage2Log($ar_sales,'OrderInfo');
        }

    }

    function OnBeforeUserAddHandler(&$arFields)
    {
        //AddMessage2Log($arFields,'BeforeUserAdd');
    }
}

AddEventHandler("sale", "OnSaleComponentOrderShowAjaxAnswer", Array("UserAjaxOrder", "OnSaleComponentOrderShowAjaxAnswerHandler"));

class UserAjaxOrder {
    function OnSaleComponentOrderShowAjaxAnswerHandler(&$result) {
//        AddMessage2Log($result,'ajaxMethod');

        $arOrder = CSaleOrderPropsValue::GetOrderProps($result['order']['ID']);
        $arPropList = array();
        while ($arProps = $arOrder->Fetch()){
            $arPropList[$arProps['CODE']] = $arProps;
        }
//            AddMessage2Log($arPropList,'ajaxMethodOrderInfo');

        $rsUser = CUser::GetByID($_SESSION['SESS_AUTH']['USER_ID']);
        $arUser = $rsUser->Fetch();
//        AddMessage2Log($arUser,'ajaxMethodUserInfo');

        $user = new CUser;

        $fields = array();

        if(empty($arUser['NAME']))
            $fields['NAME'] = $arPropList['FN']['VALUE'];
        if(empty($arUser['LAST_NAME']))
            $fields['LAST_NAME'] = $arPropList['LN']['VALUE'];
        if(empty($arUser['PERSONAL_MOBILE']))
            $fields['PERSONAL_MOBILE'] = $arPropList['PHONE']['VALUE'];
        if(empty($arUser['PERSONAL_CITY']))
            $fields['PERSONAL_CITY'] = $arPropList['CITY']['VALUE'];
        if(empty($arUser['PERSONAL_ZIP']))
            $fields['PERSONAL_ZIP'] = $arPropList['PCZ']['VALUE'];
        if(empty($arUser['PERSONAL_STREET']))
            $fields['PERSONAL_STREET'] = $arPropList['ADDRESS']['VALUE'];
        if(empty($arUser['PERSONAL_MAILBOX']))
            $fields['PERSONAL_MAILBOX'] = $arPropList['ADDRESS2']['VALUE'];

        if(!empty($fields))
            $user->Update($arUser['ID'], $fields);



    }
}