<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
	die();

use \Bitrix\Main\Loader;
use \Bitrix\Main\Page\Asset;
use \Bitrix\Main\Application;
use \Bitrix\Main\Config\Option;
use \Bitrix\Main\Localization\Loc;
use \Redsign\Tuning;

Loc::loadMessages(__FILE__);

global $moduleId;
include(Application::getDocumentRoot().SITE_TEMPLATE_PATH.'/template_ext/module_id.php');

// check module include
if (!Loader::includeModule($moduleId)) {
	ShowError(Loc::getMessage('RSGOPRO.ERROR_NOT_INSTALLED_MODULE'));
	die();
}

if (!Loader::includeModule('redsign.devfunc')) {
    ShowError(Loc::getMessage('RSGOPRO.ERROR_NOT_INSTALLED_MODULE'), array('#MODULE#' => 'redsign.devfunc'));
    die();
} else {
    RSDevFunc::Init(array('jsfunc'));
}

if (!Loader::includeModule('redsign.tuning')) {
    ShowError(Loc::getMessage('RSGOPRO.ERROR_NOT_INSTALLED_MODULE'), array('#MODULE#' => 'redsign.tuning'));
    die();
}

$request = Application::getInstance()->getContext()->getRequest();

// is main page
$isMain = ($APPLICATION->GetCurPage(true) == SITE_DIR.'index.php') ? 'Y' : 'N';

// is catalog page
$isCatalog = (strpos($APPLICATION->GetCurPage(true), SITE_DIR.'catalog/') === false) ? 'N' : 'Y';

// is personal page
$isPersonal = (strpos($APPLICATION->GetCurPage(true), SITE_DIR.'personal/') === false) ? 'N' : 'Y';

// is auth page
$isAuth = (strpos($APPLICATION->GetCurPage(true), SITE_DIR.'auth/') === false) ? 'N' : 'Y';

// is ajax hit
global $isAjax;
$xFancybox = $request->getQuery('x-fancybox');
$isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && isset($xFancybox) || (isset($_REQUEST['AJAX_CALL']) && 'Y' == $_REQUEST['AJAX_CALL']);

\CJSCore::Init(array('ajax'));

global $licenseWorkLinkFull;
$circular = Option::get($moduleId, 'circular', 'Y');
$skuView = Option::get($moduleId, 'skuView', 'line_through');
$phoneMask = Option::get($moduleId, 'phone_mask', '+7 (999) 999-9999');
$licenseWorkLink = Option::get($moduleId, 'license_work_link', '');
$offYandex = Option::get($moduleId, 'off_yandex', 'N');
$licenseWorkLinkFull = '<div class="line clearfix license-link-work">';
if (!empty($licenseWorkLink)) {
	$licenseWorkLinkFull.= Loc::getMessage('RSGOPRO.LICENSE_WORK_LINK_PART1').'<br><a href="'.$licenseWorkLink.'" target="_blank">'.Loc::getMessage('RSGOPRO.LICENSE_WORK_LINK_PART2').'</a>';
} else {
	$licenseWorkLinkFull.= Loc::getMessage('RSGOPRO.LICENSE_WORK_LINK_EMPTY');
}
$licenseWorkLinkFull.= '</div>';

$asset = Asset::getInstance();

// add strings
$asset->addString('<link href="'.SITE_DIR.'favicon.ico" rel="shortcut icon"  type="image/x-icon">');
$asset->addString('<meta http-equiv="X-UA-Compatible" content="IE=edge" />');
$asset->addString('<meta name="viewport" content="width=device-width, initial-scale=1.0">');
if ($offYandex != 'Y') {
	$asset->addString('<script type="text/javascript" src="//yandex.st/share/share.js" charset="utf-8"></script>');
	$asset->addString('<script src="//yastatic.net/share2/share.js" async="async" charset="utf-8"></script>');
}



// add styles
$asset->addCss(SITE_TEMPLATE_PATH.'/assets/css/style.css');
// $asset->addCss(SITE_TEMPLATE_PATH.'/assets/lib/fancybox/jquery.fancybox.css');
$asset->addCss(SITE_TEMPLATE_PATH.'/assets/lib/fancybox3/jquery.fancybox.min.css');
// $asset->addCss(SITE_TEMPLATE_PATH.'/assets/lib/owl/owl.carousel.css');
$asset->addCss(SITE_TEMPLATE_PATH.'/assets/lib/owl2-2.2.1/owl.carousel.min.css');
$asset->addCss(SITE_TEMPLATE_PATH.'/assets/lib/jscrollpane/jquery.jscrollpane.css');
$asset->addCss(SITE_TEMPLATE_PATH.'/assets/js/glass/style.css');

// add scripts (lib)
// $asset->addJs(SITE_TEMPLATE_PATH.'/assets/lib/jquery/jquery-1.11.2.min.js');
// $asset->addJs(SITE_TEMPLATE_PATH.'/assets/lib/jquery/jquery-3.2.1.js');
$asset->addJs(SITE_TEMPLATE_PATH.'/assets/lib/jquery/jquery-3.2.1.min.js');
$asset->addJs(SITE_TEMPLATE_PATH.'/assets/lib/jquery.mousewheel.min.js');
$asset->addJs(SITE_TEMPLATE_PATH.'/assets/lib/jquery.cookie.js');
$asset->addJs(SITE_TEMPLATE_PATH.'/assets/lib/jquery.maskedinput.min.js');
// $asset->addJs(SITE_TEMPLATE_PATH.'/assets/lib/owl/owl.carousel.min.js');
// $asset->addJs(SITE_TEMPLATE_PATH.'/assets/lib/owl2-2.2.1/owl.carousel.js');
$asset->addJs(SITE_TEMPLATE_PATH.'/assets/lib/owl2-2.2.1/owl.carousel.min.js');
$asset->addJs(SITE_TEMPLATE_PATH.'/assets/lib/jscrollpane/jquery.jscrollpane.min.js');
$asset->addJs(SITE_TEMPLATE_PATH.'/assets/lib/jssor/jssor.core.js');
$asset->addJs(SITE_TEMPLATE_PATH.'/assets/lib/jssor/jssor.utils.js');
$asset->addJs(SITE_TEMPLATE_PATH.'/assets/lib/jssor/jssor.slider.min.js');
// $asset->addJs(SITE_TEMPLATE_PATH.'/assets/lib/fancybox/jquery.fancybox.pack.js');
$asset->addJs(SITE_TEMPLATE_PATH.'/assets/lib/fancybox3/jquery.fancybox.min.js');
$asset->addJs(SITE_TEMPLATE_PATH.'/assets/lib/scrollto/jquery.scrollTo.min.js');
$asset->addJs(SITE_TEMPLATE_PATH.'/assets/lib/smoothscroll/SmoothScroll.js');
$asset->addJs(SITE_TEMPLATE_PATH.'/assets/lib/bootstrap/bootstrap.js');
// $asset->addJs(SITE_TEMPLATE_PATH.'/assets/lib/bootstrap/bootstrap.min.js');

// add scripts (our)
$asset->addJs(SITE_TEMPLATE_PATH.'/assets/js/popup/script.js');
$asset->addJs(SITE_TEMPLATE_PATH.'/assets/js/jscrollpane.js');
$asset->addJs(SITE_TEMPLATE_PATH.'/assets/js/glass/script.js');
$asset->addJs(SITE_TEMPLATE_PATH.'/assets/js/script.js');
$asset->addJs(SITE_TEMPLATE_PATH.'/assets/js/offers.js');
$asset->addJs(SITE_TEMPLATE_PATH.'/assets/js/timer.js');

// add custom
$asset->addCss(SITE_TEMPLATE_PATH.'/assets/js/popup/style.css');
$asset->addCss(SITE_TEMPLATE_PATH.'/custom/style.css');
$asset->addJs(SITE_TEMPLATE_PATH.'/custom/script.js');
$asset->addCss(SITE_DIR.'include/style.css');
$asset->addJs(SITE_DIR.'include/script.js');

// redsign.tuning
$tuning = Tuning\TuningCore::getInstance();
$instanceOptionManager = $tuning->getInstanceOptionMananger();

global $mainMenuType, $headerType;
$mainMenuType = $instanceOptionManager->get('MAIN_MENU_TYPE');
$headerType = ($mainMenuType == 'horizontal1') ? 'type2' : 'type1';
$showblockNewsNadSection = $instanceOptionManager->get('SWITCH_NEWS_AND_SECTIONS');
$showblockBestProducts = $instanceOptionManager->get('SWITCH_BEST_PRODUCTS');
$showblockBrands = $instanceOptionManager->get('SWITCH_BRANDS');

?><!DOCTYPE html>
<html xml:lang="<?=LANGUAGE_ID?>" lang="<?=LANGUAGE_ID?>" itemscope itemtype="http://schema.org/WebSite">
<head>
	<title itemprop="name"><?php $APPLICATION->ShowTitle(); ?></title>
	<script type="text/javascript">
	// some JS params
	var rsGoPro = rsGoPro || {};
		rsGoPro.options = {},
		rsGoPro.options.fancybox = {},
		BX_COOKIE_PREFIX = 'BITRIX_SM_',
		SITE_ID = '<?=SITE_ID?>',
		SITE_DIR = '<?=str_replace('//', '/', SITE_DIR);?>',
		SITE_TEMPLATE_PATH = '<?=str_replace('//', '/', SITE_TEMPLATE_PATH);?>',
		SITE_CATALOG_PATH = 'catalog',
		RSGoPro_Adaptive = 'true',
		RSGoPro_FancyCloseDelay = 1000,
		RSGoPro_FancyReloadPageAfterClose = false,
		RSGoPro_FancyOptionsBase = {},
		RSGoPro_OFFERS = {},
		RSGoPro_VIEWED = {},
		RSGoPro_FAVORITE = {},
		RSGoPro_COMPARE = {},
		RSGoPro_INBASKET = {},
		RSGoPro_BASKET = {},
		RSGoPro_STOCK = {},
		RSGoPro_PHONETABLET = "N",
        RSGoPro_PhoneMask = '<?=$phoneMask?>',
		rsGoProActionVariableName = 'rs_action',
		rsGoProProductIdVariableName = 'rs_id',
		rsGoProLicenseWorkLink = '<?=($licenseWorkLink)?>';
	</script>
    <?php $APPLICATION->ShowHead(); ?>
    <script type="text/javascript">
    BX.message({
		"RSGOPRO_JS_TO_MACH_CLICK_LIKES": '<?=CUtil::JSEscape(GetMessage('RSGOPRO.JS_TO_MACH_CLICK_LIKES'))?>',
		"RSGOPRO_IN_STOCK_ISSET": '<?=CUtil::JSEscape(GetMessage('RSGOPRO.IN_STOCK_ISSET'))?>',
		"LICENSE_WORK_LINK": '<?=($licenseWorkLink)?>',
		"LICENSE_WORK_LINK_PART1": '<?=CUtil::JSEscape(GetMessage('RSGOPRO.LICENSE_WORK_LINK_PART1'))?>',
		"LICENSE_WORK_LINK_PART2": '<?=CUtil::JSEscape(GetMessage('RSGOPRO.LICENSE_WORK_LINK_PART2'))?>',
	});
    </script>
    <?$APPLICATION->IncludeFile(
        SITE_DIR."include/header/head_end.php",
        Array(),
        Array("MODE"=>"html")
    );?>

    <meta name="yandex-verification" content="5f1e2381c69a00ee" />
    <meta name="google-site-verification" content="9YSgtwR9MT6XGhmZ058djZgzckVLSszksc1lgRo3HbQ" />
</head>
<body class="aa rsgopro adaptive prop_option_<?=$skuView?><?=($circular == 'Y' ? ' circular' : '')?> header_<?=$headerType?><?=($offYandex == 'Y' ? ' js-off-yandex' : '')?>">
    <?/*
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-H7WL0D2DG2"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'G-H7WL0D2DG2');
    </script>
    */?>

    <!-- Yandex.Metrika counter -->
    <script type="text/javascript" >
        (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
            m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
        (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

        ym(69673336, "init", {
            clickmap:true,
            trackLinks:true,
            accurateTrackBounce:true,
            webvisor:true
        });
    </script>
    <noscript><div><img src="https://mc.yandex.ru/watch/69673336" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
    <!-- /Yandex.Metrika counter -->

    <?$APPLICATION->IncludeFile(
        SITE_DIR."include/header/body_start.php",
        Array(),
        Array("MODE"=>"html")
    );?>
    
	<div id="panel"><?=$APPLICATION->ShowPanel()?></div>
    
    <div id="svg-icons" style="display: none;"></div>
    
	<div class="body" itemscope itemtype="http://schema.org/WebPage"><!-- body -->

		<!-- header type -->
		<?php
		require_once (Application::getDocumentRoot().SITE_DIR.'include/header/header_'.$headerType.'.php');
		?>
		<!-- /header type -->

		<?php if ($isMain != 'Y'): ?>
			<div id="title" class="title">
				<div class="centering">
					<div class="centeringin clearfix">
						<?$APPLICATION->IncludeFile(
							SITE_DIR."include/header/breadcrumb.php",
							Array(),
							Array("MODE"=>"html")
						);?>
						<h1 class="pagetitle"><?php $APPLICATION->ShowTitle(false); ?></h1>
					</div>
				</div>
			</div><!-- /title -->
		<?php endif; ?>

		<div id="content" class="content">
			<div class="centering">
				<div class="centeringin clearfix">

<?php
if ($isAjax) {
	$APPLICATION->RestartBuffer();
	?><div class="restart-buffer"><div class="restart-buffer__content"><?
}
