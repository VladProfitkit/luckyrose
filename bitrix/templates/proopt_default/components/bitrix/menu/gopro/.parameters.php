<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
	die();

use \Bitrix\Main\Loader;
use \Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

if (!Loader::includeModule('iblock'))
	return;

if (!Loader::includeModule('catalog'))
	return;

if (!Loader::includeModule('redsign.devfunc'))
	return;


$arTemplateList = array(
	'horizontal1' => Loc::getMessage('RSGOPRO.SUB_TEMPLATE.horizontal1'),
	'vertical1' => Loc::getMessage('RSGOPRO.SUB_TEMPLATE.vertical1'),
	'vertical2' => Loc::getMessage('RSGOPRO.SUB_TEMPLATE.vertical2'),
);

$arTemplateParameters['RSGOPRO_SUB_TEMPLATE'] = array(
	'NAME' => Loc::getMessage('RSGOPRO.SUB_TEMPLATE'),
	'TYPE' => "LIST",
	'VALUES' => $arTemplateList,
	'DEFAULT' => 'vertical1',
);

switch ($arCurrentValues['RSGOPRO_SUB_TEMPLATE']) {
	case 'horizontal1':
		$subTemplateFolder = 'horizontal1';
		break;
	case 'vertical2':
		$subTemplateFolder = 'vertical2';
		break;
	default: // vertical1
		$subTemplateFolder = 'vertical1';
}

$arDFParamsCatalog = RSDevFuncParameters::GetTemplateParamsCatalog($arCurrentValues);
foreach ($arDFParamsCatalog as $PNAME => $arParam) {
	$arTemplateParameters[$PNAME] = $arParam;
}
