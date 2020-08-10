<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
	die();

$this->setFrameMode(true);

$first = false;
?>

<table class="groupedprops">
	<?php foreach ($arResult['GROUPED_ITEMS'] as $arrValue): ?>
		<?php if (is_array($arrValue['PROPERTIES']) && count($arrValue['PROPERTIES']) > 0): ?>
			<tr>
				<th colspan="2"<?if(!$first):?> class="first"<?endif;?>><?=$arrValue["GROUP"]["NAME"]?></th>
			</tr>
			<?php
			$first = true;
			foreach ($arrValue['PROPERTIES'] as $property): ?>
				<tr>
					<td class="valign-bottom"><span class="name"><?=$property["NAME"]?></span><div class="line"></div></td>
					<td class="valign-bottom">
						<?php if (is_array($property['DISPLAY_VALUE'])): ?>
							<div class="val"><?=implode('&nbsp;/&nbsp;', $property["DISPLAY_VALUE"] )?></div>
						<?php else: ?>
							<div class="val"><?=$property["DISPLAY_VALUE"]?></div>
						<?php endif; ?>
					</td>
				</tr>
			<?php endforeach; ?>
		<?php endif; ?>
	<?php endforeach; ?>
	
	<?php if (is_array($arResult['NOT_GROUPED_ITEMS']) && count($arResult['NOT_GROUPED_ITEMS']) > 0): ?>
		<?php foreach ($arResult['NOT_GROUPED_ITEMS'] as $property): ?>
			<tr>
				<td class="valign-bottom"><span class="name"><?=$property["NAME"]?></span><div class="line"></div></td>
				<td class="valign-bottom">
					<?php if (is_array($property['DISPLAY_VALUE'])): ?>
						<div class="val"><?=implode('&nbsp;/&nbsp;', $property["DISPLAY_VALUE"] )?></div>
					<?php else: ?>
						<div class="val"><?=$property["DISPLAY_VALUE"]?></div>
					<?php endif; ?>
				</td>
			</tr>
		<?php endforeach; ?>
	<?php endif; ?>
</table>
