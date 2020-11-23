<?php
AddEventHandler("sale", "OnOrderNewSendEmail", "bxModifySaleMails");

function bxModifySaleMails($orderID, &$eventName, &$arFields)
{
    $additional_information = '';
    $arOrder = CSaleOrder::GetByID($orderID);
    $order_props = CSaleOrderPropsValue::GetOrderProps($orderID);
    while ($arProps = $order_props->Fetch()){
        //Имя
        if ($arProps['ORDER_PROPS_ID']==20){
            $additional_information.='Имя: '.$arProps['VALUE'].'<br/>';
            $arFields["NAME"] = $arProps["VALUE"];
        }
        //Фамилия
        if ($arProps['ORDER_PROPS_ID']==23){
            $additional_information.='Фамилия: '.$arProps['VALUE'].'<br/>';
            $arFields["FAMILIA"] = $arProps["VALUE"];
        }
        //Отчество
        if ($arProps['ORDER_PROPS_ID']==21){
            $additional_information.='Отчество: '.$arProps['VALUE'].'<br/>';
            $arFields["PATR"] = $arProps["VALUE"];
        }
        //контактный телефон
        if ($arProps['ORDER_PROPS_ID']==24){
            $additional_information.='Контактный телефон: '.$arProps['VALUE'].'<br/>';
            $arFields["PHONE"] = $arProps["VALUE"];
        }
        //E-майл
        if ($arProps['ORDER_PROPS_ID']==25){
            $additional_information.='E-майл: '.$arProps['VALUE'].'<br/>';
        }
        //Город
        if ($arProps['ORDER_PROPS_ID']==5){
            $additional_information.='Город: '.$arProps['VALUE'].'<br/>';
            $arFields["PROPERTY_CITY"] = $arProps["VALUE"];
        }
        //Адрес доставки
        if ($arProps['ORDER_PROPS_ID']==7){
            $additional_information.='Адрес доставки: '.$arProps['VALUE'].'<br/>';
            $arFields["PERSONAL_ADDRESS"] = $arProps["VALUE"];
        }
        //Индекс
        if ($arProps['ORDER_PROPS_ID']==4){
            $additional_information.='Индекс: '.$arProps['VALUE'].'<br/>';
            $arFields["ORDER_PROP_4"] = $arProps["VALUE"];
        }
    }
    $arFields["ADD_INFORMATION"] = $additional_information;
}
