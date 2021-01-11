<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
	die();

use \Bitrix\Main\Application;
use \Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

global $isAjax;

if ($isAjax) {
	?></div></div><?
	die();
}

?>

				</div>
			</div>
		</div><!-- /content -->
	</div><!-- /body -->
	
	<div id="footer" class="footer"><!-- footer -->
		<div class="centering">
			<div class="centeringin line1 clearfix">
				<div class="block one">
					<div class="logo">
						<a href="<?=SITE_DIR?>">
							<?$APPLICATION->IncludeFile(
								SITE_DIR."include/company_logo.php",
								Array(),
								Array("MODE"=>"html")
							);?>
						</a>
					</div>
					<div class="contacts clearfix">
						<div class="phone2">
							<a class="fancyajax fancybox.ajax feedback" href="<?=SITE_DIR?>include/popup/feedback/?AJAX_CALL=Y" title="<?=Loc::getMessage('RSGOPRO.FEEDBACK')?>"><svg class="svg-icon"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-dialog"></use></svg><?=Loc::getMessage('RSGOPRO.FEEDBACK')?></a>
							<div class="phone">
								<?$APPLICATION->IncludeFile(
									SITE_DIR."include/footer/phone2.php",
									Array(),
									Array("MODE"=>"html")
								);?>
							</div>
						</div>
					</div>
				</div>
				<div class="block two">
					<?$APPLICATION->IncludeFile(
						SITE_DIR."include/footer/catalog_menu.php",
						Array(),
						Array("MODE"=>"html")
					);?>
				</div>
				<div class="block three">
					<?$APPLICATION->IncludeFile(
						SITE_DIR."include/footer/menu.php",
						Array(),
						Array("MODE"=>"html")
					);?>
				</div>
				<div class="block four">
					<div class="sovservice">
						<?$APPLICATION->IncludeFile(
							SITE_DIR."include/footer/socservice.php",
							Array(),
							Array("MODE"=>"html")
						);?>
					</div>
					<div class="subscribe">
						<?$APPLICATION->IncludeFile(
							SITE_DIR."include/footer/subscribe.php",
							Array(),
							Array("MODE"=>"html")
						);?>
					</div>
				</div>
			</div>
		</div>

		<div class="line2">
			<div class="centering">
				<div class="centeringin clearfix">
					<div class="sitecopy">
						<?$APPLICATION->IncludeFile(
							SITE_DIR."include/footer/law.php",
							Array(),
							Array("MODE"=>"html")
						);?>
					</div>
					<div class="developercopy hidden-xs"></div>
				</div>
			</div>
		</div>
	</div><!-- /footer -->

	<?$APPLICATION->IncludeFile(
		SITE_DIR."include/footer/easycart.php",
		Array(),
		Array("MODE"=>"html")
	);?>

	<?php include(Application::getDocumentRoot().SITE_TEMPLATE_PATH.'/template_ext/footer_inc.php'); ?>

	<script type="text/javascript">RSGoPro_SetSet();</script>

	<div style="display:none;">AlfaSystems GoPro GP261D21</div>

    <script>$('#svg-icons').setHtmlByUrl({url:SITE_TEMPLATE_PATH + '/assets/img/icons.svg?v333'});</script>

	<?$APPLICATION->IncludeFile(
		SITE_DIR."include/tuning/component.php",
		Array(),
		Array("MODE"=>"html")
	);?>

    <?$APPLICATION->IncludeFile(
        SITE_DIR."include/footer/body_end.php",
        Array(),
        Array("MODE"=>"html")
    );?>



<!-- дизайн создание seo: TOP-iNFO d.o.o. +7 931 273 63 31 http://top-info.biz top.info.croatia@gmail.com -->
<!-- не удалять эту строчку - та, что вверху :) -->
<!-- когда сломается - чинить не будем -->


</body>
</html>
