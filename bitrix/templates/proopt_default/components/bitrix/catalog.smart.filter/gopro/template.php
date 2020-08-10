<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true)die();

$this->setFrameMode(true);
?><form name="<?=$arResult['FILTER_NAME'].'_form'?>" action="<?=$arResult['FORM_ACTION']?>" method="get" class="smartfilter" onsubmit="return RSGoPro_FilterOnSubmitForm();"><?
	foreach($arResult['HIDDEN'] as $arItem) {
		?><input <?
			?>type="hidden" <?
			?>name="<?=$arItem['CONTROL_NAME']?>" <?
			?>id="<?=$arItem['CONTROL_ID']?>" <?
			?>value="<?=$arItem['HTML_VALUE']?>" <?
		?>/> <?
	}
	?><div class="around_filtren"><?
		?><div class="filtren clearfix<?
			if($arParams['FILTER_FIXED']=='Y'):?> filterfixed<?endif;?><?
			if($arParams['FILTER_USE_AJAX']=='Y'):?> ajaxfilter<?endif;?><?
			echo ' '.$arParams['FILTER_DISABLED_PIC_EFFECT'];
			?>"><?
			?><div class="title"><?
				?><a class="shhi" href="#"><span class="show"><?=GetMessage('CT_BCSF_FILTER_TITLE_SHOW')?></span><span class="hide"><?=GetMessage('CT_BCSF_FILTER_TITLE_HIDE')?></span></a><?
				if($arParams['USE_COMPARE']=='Y') {
					?><span class="filtercompare"><?=GetMessage('FILTER_COMPARE')?>: <a href="#"></a></span><?
				}
			?></div><?
			?><div class="body"><?
				?><div class="clearfix"><?

				// prices
				foreach($arResult['ITEMS'] as $key=>$arItem) {
					$key = $arItem["ENCODED_ID"];
					if(isset($arItem["PRICE"])) {
						/*if (!$arItem["VALUES"]["MIN"]["VALUE"] || !$arItem["VALUES"]["MAX"]["VALUE"] || $arItem["VALUES"]["MIN"]["VALUE"] == $arItem["VALUES"]["MAX"]["VALUE"]) {
							continue;
						}*/
						$precision = 2;
						if (Bitrix\Main\Loader::includeModule("currency"))
						{
							$res = CCurrencyLang::GetFormatDescription($arItem["VALUES"]["MIN"]["CURRENCY"]);
							$precision = $res['DECIMALS'];
						}
						?><div class="lvl1<?if($isScrolable):?> scrolable<?endif;?><?if($isSearchable):?> searcheble<?endif;?>" data-propid="<?=$arItem['ID']?>" data-propcode="<?=$arItem['CODE']?>"><?
							?><a href="#" class="showchild"><?
							?><svg class="svg-icon"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-arrow-filled-down"></use></svg><?
							?><?=$arItem['NAME']?></a><?
							?><div class="property number"><?
								?><span class="smartf-div inputs"><?
									?><span class="from"><?=GetMessage('CT_BCSF_FILTER_FROM')?></span><?
									?><input
										class="min-price min"
										type="text"
										name="<?=$arItem["VALUES"]["MIN"]["CONTROL_NAME"]?>"
										id="<?=$arItem["VALUES"]["MIN"]["CONTROL_ID"]?>"
										value="<?=$arItem["VALUES"]["MIN"]["HTML_VALUE"]?>"
										size="9"
										onkeyup="smartFilter.keyup(this)"
									/><?
									?><span class="separator"></span><?
									?><span class="to"><?=GetMessage("CT_BCSF_FILTER_TO")?></span><?
									?><input
										class="max-price max"
										type="text"
										name="<?=$arItem["VALUES"]["MAX"]["CONTROL_NAME"]?>"
										id="<?=$arItem["VALUES"]["MAX"]["CONTROL_ID"]?>"
										value="<?=$arItem["VALUES"]["MAX"]["HTML_VALUE"]?>"
										size="9"
										onkeyup="smartFilter.keyup(this)"
									/><?
								?></span><?
								?><span class="smartf-div aroundslider"><?
									?><span class="smartf-div" style="clear: both;"></span><?
									?><span class="smartf-div bx_ui_slider_track" id="drag_track_<?=$key?>"><?
										$precision = $arItem["DECIMALS"]? $arItem["DECIMALS"]: 0;
										$step = ($arItem["VALUES"]["MAX"]["VALUE"] - $arItem["VALUES"]["MIN"]["VALUE"]) / 4;
										$price1 = number_format($arItem["VALUES"]["MIN"]["VALUE"], $precision, ".", "");
										$price2 = number_format($arItem["VALUES"]["MIN"]["VALUE"] + $step, $precision, ".", "");
										$price3 = number_format($arItem["VALUES"]["MIN"]["VALUE"] + $step * 2, $precision, ".", "");
										$price4 = number_format($arItem["VALUES"]["MIN"]["VALUE"] + $step * 3, $precision, ".", "");
										$price5 = number_format($arItem["VALUES"]["MAX"]["VALUE"], $precision, ".", "");
										?><span class="smartf-div bx_ui_slider_part p1"><span><?=$price1?></span></span><?
										?><span class="smartf-div bx_ui_slider_part p2"><span><?=$price2?></span></span><?
										?><span class="smartf-div bx_ui_slider_part p3"><span><?=$price3?></span></span><?
										?><span class="smartf-div bx_ui_slider_part p4"><span><?=$price4?></span></span><?
										?><span class="smartf-div bx_ui_slider_part p5"><span><?=$price5?></span></span><?
										?><span class="smartf-div bx_ui_slider_pricebar_VD" style="left: 0; right: 0;" id="colorUnavailableActive_<?=$key?>"></span><?
										?><span class="smartf-div bx_ui_slider_pricebar_VN" style="left: 0; right: 0;" id="colorAvailableInactive_<?=$key?>"></span><?
										?><span class="smartf-div bx_ui_slider_pricebar_V"  style="left: 0; right: 0;" id="colorAvailableActive_<?=$key?>"></span><?
										?><span class="smartf-div bx_ui_slider_range" 	id="drag_tracker_<?=$key?>"  style="left: 0;right: 0;"><?
											?><a class="bx_ui_slider_handle left pngicons"  style="left:0;" href="javascript:void(0)" id="left_slider_<?=$key?>"></a><?
											?><a class="bx_ui_slider_handle right pngicons" style="right:0;" href="javascript:void(0)" id="right_slider_<?=$key?>"></a><?
										?></span><?
									?></span><?
								?></span><?
								if (Bitrix\Main\Loader::includeModule('currency')) {
									$res = CCurrencyLang::GetFormatDescription($arItem["VALUES"]["MIN"]["CURRENCY"]);
									$precision = $res['DECIMALS'];
								}
								$arJsParams = array(
									"leftSlider" => 'left_slider_'.$key,
									"rightSlider" => 'right_slider_'.$key,
									"tracker" => "drag_tracker_".$key,
									"trackerWrap" => "drag_track_".$key,
									"minInputId" => $arItem["VALUES"]["MIN"]["CONTROL_ID"],
									"maxInputId" => $arItem["VALUES"]["MAX"]["CONTROL_ID"],
									"minPrice" => $arItem["VALUES"]["MIN"]["VALUE"],
									"maxPrice" => $arItem["VALUES"]["MAX"]["VALUE"],
									"curMinPrice" => $arItem["VALUES"]["MIN"]["HTML_VALUE"],
									"curMaxPrice" => $arItem["VALUES"]["MAX"]["HTML_VALUE"],
									"fltMinPrice" => intval($arItem["VALUES"]["MIN"]["FILTERED_VALUE"]) ? $arItem["VALUES"]["MIN"]["FILTERED_VALUE"] : $arItem["VALUES"]["MIN"]["VALUE"] ,
									"fltMaxPrice" => intval($arItem["VALUES"]["MAX"]["FILTERED_VALUE"]) ? $arItem["VALUES"]["MAX"]["FILTERED_VALUE"] : $arItem["VALUES"]["MAX"]["VALUE"],
									"precision" => $precision,
									"colorUnavailableActive" => 'colorUnavailableActive_'.$key,
									"colorAvailableActive" => 'colorAvailableActive_'.$key,
									"colorAvailableInactive" => 'colorAvailableInactive_'.$key,
								);
							?></div><?
							?><script type="text/javascript">
								BX.ready(function(){
									window['trackBar<?=$key?>'] = new BX.Iblock.SmartFilter(<?=CUtil::PhpToJSObject($arJsParams)?>);
								});
							</script><?
						?></div><?
					}
				}

				// simple
				foreach($arResult['ITEMS'] as $key=>$arItem) {
					if( empty($arItem['VALUES']) || isset($arItem['PRICE']) ) {
						continue;
					}

					if(
						$arItem["DISPLAY_TYPE"] == "A"
						&& (
							!$arItem["VALUES"]["MIN"]["VALUE"]
							|| !$arItem["VALUES"]["MAX"]["VALUE"]
							|| $arItem["VALUES"]["MIN"]["VALUE"] == $arItem["VALUES"]["MAX"]["VALUE"]
						)
					) {
						continue;
					}
					// scroll
					if(in_array($arItem['CODE'], $arParams['FILTER_PROP_SCROLL']) || in_array($arItem['CODE'], $arParams['FILTER_SKU_PROP_SCROLL'])) {
						$isScrolable = true;
					} else {
						$isScrolable = false;
					}
					// search
					if(in_array($arItem['CODE'], $arParams['FILTER_PROP_SEARCH']) || in_array($arItem['CODE'], $arParams['FILTER_SKU_PROP_SEARCH'])) {
						$isSearchable = true;
					} else {
						$isSearchable = false;
					}
					?><div class="lvl1<?if($isScrolable):?> scrolable<?endif;?><?if($isSearchable):?> searcheble<?endif;?><?if($arItem["DISPLAY_EXPANDED"]!="Y"):?> closed<?endif?>" data-propid="<?=$arItem['ID']?>" data-propcode="<?=$arItem['CODE']?>"><?
						?><a href="#" class="showchild"><?
						?><svg class="svg-icon"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-arrow-filled-down"></use></svg><?
						?><?=$arItem['NAME']?><?if($arItem['FILTER_HINT']<>''):?><span class="hint">?<span class="smartf-div"><?=$arItem['FILTER_HINT']?></span></span><?endif;?></a><?
						$arCur = current($arItem["VALUES"]);
						switch ($arItem["DISPLAY_TYPE"]) {
							case "A"://NUMBERS_WITH_SLIDER
								if (1==1) {} // fix VSCode syntaxis
								?><div class="property number"><?
									?><span class="smartf-div inputs"><?
										?><span class="from"><?=GetMessage('CT_BCSF_FILTER_FROM')?></span><?
										?><input
											class="min-price min"
											type="text"
											name="<?=$arItem["VALUES"]["MIN"]["CONTROL_NAME"]?>"
											id="<?=$arItem["VALUES"]["MIN"]["CONTROL_ID"]?>"
											value="<?=$arItem["VALUES"]["MIN"]["HTML_VALUE"]?>"
											size="9"
											onkeyup="smartFilter.keyup(this)"
										/><?
										?><span class="separator"></span><?
										?><span class="to"><?=GetMessage("CT_BCSF_FILTER_TO")?></span><?
										?><input
											class="max-price max"
											type="text"
											name="<?=$arItem["VALUES"]["MAX"]["CONTROL_NAME"]?>"
											id="<?=$arItem["VALUES"]["MAX"]["CONTROL_ID"]?>"
											value="<?=$arItem["VALUES"]["MAX"]["HTML_VALUE"]?>"
											size="9"
											onkeyup="smartFilter.keyup(this)"
										/><?
									?></span><?
									?><span class="smartf-div aroundslider"><?
										?><span class="smartf-div" style="clear: both;"></span><?
										?><span class="smartf-div bx_ui_slider_track" id="drag_track_<?=$key?>"><?
											$precision = $arItem["DECIMALS"]? $arItem["DECIMALS"]: 0;
											$step = ($arItem["VALUES"]["MAX"]["VALUE"] - $arItem["VALUES"]["MIN"]["VALUE"]) / 4;
											$value1 = number_format($arItem["VALUES"]["MIN"]["VALUE"], $precision, ".", "");
											$value2 = number_format($arItem["VALUES"]["MIN"]["VALUE"] + $step, $precision, ".", "");
											$value3 = number_format($arItem["VALUES"]["MIN"]["VALUE"] + $step * 2, $precision, ".", "");
											$value4 = number_format($arItem["VALUES"]["MIN"]["VALUE"] + $step * 3, $precision, ".", "");
											$value5 = number_format($arItem["VALUES"]["MAX"]["VALUE"], $precision, ".", "");
											?><span class="smartf-div bx_ui_slider_part p1"><span><?=$value1?></span></span><?
											?><span class="smartf-div bx_ui_slider_part p2"><span><?=$value2?></span></span><?
											?><span class="smartf-div bx_ui_slider_part p3"><span><?=$value3?></span></span><?
											?><span class="smartf-div bx_ui_slider_part p4"><span><?=$value4?></span></span><?
											?><span class="smartf-div bx_ui_slider_part p5"><span><?=$value5?></span></span><?
											?><span class="smartf-div bx_ui_slider_pricebar_VD" style="left: 0;right: 0;" id="colorUnavailableActive_<?=$key?>"></span><?
											?><span class="smartf-div bx_ui_slider_pricebar_VN" style="left: 0;right: 0;" id="colorAvailableInactive_<?=$key?>"></span><?
											?><span class="smartf-div bx_ui_slider_pricebar_V"  style="left: 0;right: 0;" id="colorAvailableActive_<?=$key?>"></span><?
											?><span class="smartf-div bx_ui_slider_range" 	id="drag_tracker_<?=$key?>"  style="left: 0;right: 0;"><?
												?><a class="bx_ui_slider_handle left pngicons"  style="left:0;" href="javascript:void(0)" id="left_slider_<?=$key?>"></a><?
												?><a class="bx_ui_slider_handle right pngicons" style="right:0;" href="javascript:void(0)" id="right_slider_<?=$key?>"></a><?
											?></span><?
										?></span><?
									?></span><?
									$arJsParams = array(
										"leftSlider" => 'left_slider_'.$key,
										"rightSlider" => 'right_slider_'.$key,
										"tracker" => "drag_tracker_".$key,
										"trackerWrap" => "drag_track_".$key,
										"minInputId" => $arItem["VALUES"]["MIN"]["CONTROL_ID"],
										"maxInputId" => $arItem["VALUES"]["MAX"]["CONTROL_ID"],
										"minPrice" => $arItem["VALUES"]["MIN"]["VALUE"],
										"maxPrice" => $arItem["VALUES"]["MAX"]["VALUE"],
										"curMinPrice" => $arItem["VALUES"]["MIN"]["HTML_VALUE"],
										"curMaxPrice" => $arItem["VALUES"]["MAX"]["HTML_VALUE"],
										"fltMinPrice" => intval($arItem["VALUES"]["MIN"]["FILTERED_VALUE"]) ? $arItem["VALUES"]["MIN"]["FILTERED_VALUE"] : $arItem["VALUES"]["MIN"]["VALUE"] ,
										"fltMaxPrice" => intval($arItem["VALUES"]["MAX"]["FILTERED_VALUE"]) ? $arItem["VALUES"]["MAX"]["FILTERED_VALUE"] : $arItem["VALUES"]["MAX"]["VALUE"],
										"precision" => $arItem["DECIMALS"]? $arItem["DECIMALS"]: 0,
										"colorUnavailableActive" => 'colorUnavailableActive_'.$key,
										"colorAvailableActive" => 'colorAvailableActive_'.$key,
										"colorAvailableInactive" => 'colorAvailableInactive_'.$key,
									);
								?></div><?
								?><script type="text/javascript">
									BX.ready(function(){
										window['trackBar<?=$key?>'] = new BX.Iblock.SmartFilter(<?=CUtil::PhpToJSObject($arJsParams)?>);
									});
								</script><?
								break;
							case "B"://NUMBERS
								?><div class="property number"><?
									?><span class="smartf-div inputs"><?
										?><span class="from"><?=GetMessage('CT_BCSF_FILTER_FROM')?></span><?
										?><input <?
											?>class="min-price min" <?
											?>type="text" <?
											?>name="<?=$arItem["VALUES"]["MIN"]["CONTROL_NAME"]?>" <?
											?>id="<?=$arItem["VALUES"]["MIN"]["CONTROL_ID"]?>" <?
											?>value="<?=$arItem["VALUES"]["MIN"]["HTML_VALUE"]?>" <?
											?>size="9" <?
											?>onkeyup="smartFilter.keyup(this)" <?
										?>/><?
										?><span class="separator"></span><?
										?><span class="to"><?=GetMessage("CT_BCSF_FILTER_TO")?></span><?
										?><input <?
											?>class="max-price max" <?
											?>type="text" <?
											?>name="<?=$arItem["VALUES"]["MAX"]["CONTROL_NAME"]?>" <?
											?>id="<?=$arItem["VALUES"]["MAX"]["CONTROL_ID"]?>" <?
											?>value="<?=$arItem["VALUES"]["MAX"]["HTML_VALUE"]?>" <?
											?>size="9" <?
											?>onkeyup="smartFilter.keyup(this)" <?
										?>/><?
									?></span><?
								?></div><?
								break;
							case "G"://CHECKBOXES_WITH_PICTURES
								?><div class="property cwp"><?
									foreach ($arItem["VALUES"] as $val => $ar) {
										$class = "";
										if ($ar["CHECKED"]) {
											$class.= " active";
										}
										if ($ar["DISABLED"]) {
											$class.= " disabled";
										}
										$onclick = "smartFilter.keyup(BX('".CUtil::JSEscape($ar["CONTROL_ID"])."'));";
										?><div class="lvl2"><?
											?><span class="smartf-div <?=$class?>"><?
												?><span><input <?
													?>type="checkbox" <?
													?>name="<?=$ar["CONTROL_NAME"]?>" <?
													?>id="<?=$ar["CONTROL_ID"]?>" <?
													?>value="<?=$ar["HTML_VALUE"]?>" <?
													?><? echo $ar["CHECKED"]? 'checked="checked"': '' ?> <?
													?>onclick="<?=$onclick?>" <?
												?>/></span><?
												?><label for="<?=$ar["CONTROL_ID"]?>" data-role="label_<?=$ar["CONTROL_ID"]?>" class="pic <?=$class?>"><?
													if (isset($ar["FILE"]) && !empty($ar["FILE"]["SRC"])) {
														?><span style="background-image:url('<?=$ar["FILE"]["SRC"]?>');"></span><?
													}
												?></label><?
											?></span><?
										?></div><?
									}
								?></div><?
								break;
							case "H"://CHECKBOXES_WITH_PICTURES_AND_LABELS
								?><div class="property cwpal"><?
									// search
									if ($isSearchable && !$isColor) {
										?><input type="text" class="f_search" name="f_search" id="f_search" value="" placeholder="<?=GetMessage('FILTR_SEARHC')?>"><?
									}
									// scroll
									if ($isScrolable && count($arItem['VALUES'])>$arParams['FILTER_PROP_SCROLL_CNT']) {
										$isScrolable = true;
									} else {
										$isScrolable = false;
									}
									if ($isScrolable) {
										?><div class="smartf-div f_jscrollpane" id="f_scroll_<?=$arItem['ID']?>"><?
									}
									foreach ($arItem["VALUES"] as $val => $ar) {
										$class = "";
										if ($ar["CHECKED"]) {
											$class.= " active";
										}
										if ($ar["DISABLED"]) {
											$class.= " disabled";
										}
										$onclick = "smartFilter.keyup(BX('".CUtil::JSEscape($ar["CONTROL_ID"])."'));";
										?><div class="lvl2"><?
											?><span class="smartf-div clearfix <?=$class?>"><?
												?><span><input <?
													?>type="checkbox" <?
													?>name="<?=$ar["CONTROL_NAME"]?>" <?
													?>id="<?=$ar["CONTROL_ID"]?>" <?
													?>value="<?=$ar["HTML_VALUE"]?>" <?
													?><? echo $ar["CHECKED"]? 'checked="checked"': '' ?> <?
													?>onclick="<?=$onclick?>" <?
												?>/></span><?
												?><label for="<?=$ar["CONTROL_ID"]?>" data-role="label_<?=$ar["CONTROL_ID"]?>" class="pic <?=$class?>"><?
													if (isset($ar["FILE"]) && !empty($ar["FILE"]["SRC"])) {
														?><span style="background-image:url('<?=$ar["FILE"]["SRC"]?>');"></span><?
													}
												?></label><?
												?><label for="<?=$ar["CONTROL_ID"]?>" data-role="label_<?=$ar["CONTROL_ID"]?>" class="name <?=$class?>"><?
													?><span class="val"><?=$ar["VALUE"]?></span><?
													if ($arParams["FILTER_HIDE_PROP_COUNT"] != "Y" && isset($ar["ELEMENT_COUNT"])):
														?><span class="role_count">&nbsp;(<span data-role="count_<?=$ar["CONTROL_ID"]?>"><?=$ar["ELEMENT_COUNT"]?></span>)</span><?
													endif;
													/*?><textarea><?print_r($ar)?></textarea><?*/
												?></label><?
											?></span><?
										?></div><?
									}
									// scroll
									if($isScrolable) {
										?></div><?
									}
								?></div><?
								break;
							case "P"://DROPDOWN
								?><div class="property dd"><?
									?><div class="dropdown" id="fltr_<?=$arItem['CODE']?>"><div class="dropdown"><?
										$arChecked = array();
										$ar = current($arItem["VALUES"]);
										?><div class="lvl2"><?
											?><span class="smartf-div"><?
												?><span><input <?
													?>type="radio" <?
													?>value="" <?
													?>name="<?=$ar["CONTROL_NAME_ALT"]?>" <?
													?>id="all_<?=$ar["CONTROL_NAME_ALT"]?>" <?
													?><? echo $ar["CHECKED"]? 'checked="checked"': '' ?><?
													?>onclick="smartFilter.click(this)" <?
												?>/></span><?
												?><label for="all_<?=$ar["CONTROL_NAME_ALT"]?>" data-role="label_<?=$arCur["CONTROL_ID"]?>" class="name"><?
													?><span class="val"><?=GetMessage("CT_BCSF_FILTER_ALL")?></span><?
												?></label><?
											?></span><?
										?></div><?
										foreach ($arItem["VALUES"] as $val => $ar) {
											$class = "";
											if ($ar["CHECKED"]) {
												$class.= " active";
											}
											if ($ar["DISABLED"]) {
												$class.= " disabled";
											}
											?><div class="lvl2"><?
												?><span class="smartf-div <?=$class?>"><?
													?><span><input <?
														?>type="radio" <?
														?>value="<?=$ar["HTML_VALUE_ALT"]?>" <?
														?>name="<?=$ar["CONTROL_NAME_ALT"]?>" <?
														?>id="<?=$ar["CONTROL_ID"]?>" <?
														?><? echo $ar["CHECKED"]? 'checked="checked"': '' ?><?
														?>onclick="smartFilter.click(this)" <?
													?>/></span><?
													?><label for="<?=$ar["CONTROL_ID"]?>" data-role="label_<?=$ar["CONTROL_ID"]?>" class="name <?=$class?>"><?
														?><span class="val"><?=$ar["VALUE"]?></span><?
													?></label><?
												?></span><?
											?></div><?
											if ($ar["CHECKED"]) {
												$arChecked = $ar;
											}
										}
									?></div></div><?
									?><div class="lvl2 selected"><?
										?><span class="smartf-div"><?
											?><label data-role="label_<?=$arCur["CONTROL_ID"]?>" class="name select"><?
												?><span><?=( isset($arChecked['VALUE']) ? $arChecked['VALUE'] : GetMessage("CT_BCSF_FILTER_ALL") )?></span><?
												?><svg class="svg-icon"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-arrow-filled-down"></use></svg><?
											?></label><?
										?></span><?
									?></div><?
								?></div><?
								break;
							case "R"://DROPDOWN_WITH_PICTURES_AND_LABELS
								?><div class="property dd wpal"><?
									?><div class="dropdown" id="fltr_<?=$arItem['CODE']?>"><div class="dropdown"><?
										$arChecked = array();
										$ar = current($arItem["VALUES"]);
										?><div class="lvl2 clearfix"><?
											?><span class="smartf-div"><?
												?><span><input <?
													?>type="radio" <?
													?>value="" <?
													?>name="<?=$ar["CONTROL_NAME_ALT"]?>" <?
													?>id="all_<?=$ar["CONTROL_NAME_ALT"]?>" <?
													?><? echo $ar["CHECKED"]? 'checked="checked"': '' ?><?
													?>onclick="smartFilter.click(this)" <?
												?>/></span><?
												?><label for="all_<?=$ar["CONTROL_NAME_ALT"]?>" data-role="label_<?=$ar["CONTROL_ID"]?>" class="pic <?=$class?>"><?
													if (isset($ar["FILE"]) && !empty($ar["FILE"]["SRC"])) {
														?><span class="nopic"></span><?
													}
												?></label><?
												?><label for="all_<?=$ar["CONTROL_NAME_ALT"]?>" data-role="label_<?=$ar["CONTROL_ID"]?>" class="name <?=$class?>"><?
													?><span class="val"><?=GetMessage("CT_BCSF_FILTER_ALL")?></span><?
												?></label><?
											?></span><?
										?></div><?
										foreach ($arItem["VALUES"] as $val => $ar) {
											$class = "";
											if ($ar["CHECKED"]) {
												$class.= " active";
											}
											if ($ar["DISABLED"]) {
												$class.= " disabled";
											}
											?><div class="lvl2 clearfix"><?
												?><span class="smartf-div <?=$class?>"><?
													?><span><input <?
														?>type="radio" <?
														?>value="<?=$ar["HTML_VALUE_ALT"]?>" <?
														?>name="<?=$ar["CONTROL_NAME_ALT"]?>" <?
														?>id="<?=$ar["CONTROL_ID"]?>" <?
														?><? echo $ar["CHECKED"]? 'checked="checked"': '' ?><?
														?>onclick="smartFilter.click(this)" <?
													?>/></span><?
													?><label for="<?=$ar["CONTROL_ID"]?>" data-role="label_<?=$ar["CONTROL_ID"]?>" class="pic <?=$class?>"><?
														if (isset($ar["FILE"]) && !empty($ar["FILE"]["SRC"])) {
															?><span style="background-image:url('<?=$ar["FILE"]["SRC"]?>');"></span><?
														}
													?></label><?
													?><label for="<?=$ar["CONTROL_ID"]?>" data-role="label_<?=$ar["CONTROL_ID"]?>" class="name <?=$class?>"><?
														?><span class="val"><?=$ar["VALUE"]?></span><?
														if ($arParams["FILTER_HIDE_PROP_COUNT"] != "Y" && isset($ar["ELEMENT_COUNT"])):
															?><span class="role_count">&nbsp;(<span data-role="count_<?=$ar["CONTROL_ID"]?>"><? echo $ar["ELEMENT_COUNT"]; ?></span>)</span><?
														endif;
													?></label><?
												?></span><?
											?></div><?
											if($ar["CHECKED"]) {
												$arChecked = $ar;
											}
										}
									?></div></div><?
									?><div class="lvl2 selected"><?
										?><span class="smartf-div"><?
											?><label data-role="label_<?=$arChecked["CONTROL_ID"]?>" class="pic select"><?
												if (isset($arChecked["FILE"]) && !empty($arChecked["FILE"]["SRC"])) {
													?><span style="background-image:url('<?=$arChecked["FILE"]["SRC"]?>');"></span><?
												} else {
													?><span class="nopic"></span><?
												}
											?></label><?
											?><label data-role="label_<?=$arChecked["CONTROL_ID"]?>" class="name select"><?
												?><span><?
													?><?=( isset($arChecked['VALUE']) ? $arChecked['VALUE'] : GetMessage("CT_BCSF_FILTER_ALL") )?><?
												?></span><?
												?><i class="icon pngicons"></i><?
											?></label><?
										?></span><?
									?></div><?
								?></div><?
								break;
							case "K"://RADIO_BUTTONS
								?><div class="property rb"><?
									// search
									if ($isSearchable && !$isColor) {
										?><input type="text" class="f_search" name="f_search" id="f_search" value="" placeholder="<?=GetMessage('FILTR_SEARHC')?>"><?
									}
									// scroll
									if ($isScrolable && count($arItem['VALUES'])>$arParams['FILTER_PROP_SCROLL_CNT']) {
										$isScrolable = true;
									} else {
										$isScrolable = false;
									}
									if ($isScrolable) {
										?><div class="smartf-div f_jscrollpane" id="f_scroll_<?=$arItem['ID']?>"><?
									}
									?><div class="lvl2"><?
										?><span class="smartf-div"><?
											?><input <?
												?>type="radio" <?
												?>value="" <?
												?>name="<?=$arCur["CONTROL_NAME_ALT"]?>" <?
												?>id="<?="all_".$arCur["CONTROL_ID"]?>" <?
												?>onclick="smartFilter.click(this)" <?
											?>/><?
											?><label for="all_<?=$arCur["CONTROL_ID"]?>" data-role="label_<?=$arCur["CONTROL_ID"]?>" class="name <?=$class?>" onclick="smartFilter.keyup(BX('<?=CUtil::JSEscape($ar["CONTROL_ID"])?>')); BX.toggleClass(this, 'active');"><?
												?><span><?=GetMessage("CT_BCSF_FILTER_ALL")?></span><?
											?></label><?
										?></span><?
									?></div><?
									foreach ($arItem["VALUES"] as $val => $ar) {
										$class = "";
										if ($ar["CHECKED"]) {
											$class.= " active";
										}
										if ($ar["DISABLED"]) {
											$class.= " disabled";
										}
										?><div class="lvl2"><?
											?><span class="smartf-div <?=$class?>"><?
												?><input <?
													?>type="radio" <?
													?>value="<?=$ar["HTML_VALUE_ALT"]?>" <?
													?>name="<?=$ar["CONTROL_NAME_ALT"]?>" <?
													?>id="<?=$ar["CONTROL_ID"]?>" <?
													?><? echo $ar["CHECKED"]? 'checked="checked"': '' ?><?
													?>onclick="smartFilter.click(this)" <?
												?>/><?
												?><label for="<?=$ar["CONTROL_ID"]?>" data-role="label_<?=$ar["CONTROL_ID"]?>" class="name <?=$class?>"><?
													?><span class="val"><?=$ar["VALUE"]?></span><?
													if ($arParams["FILTER_HIDE_PROP_COUNT"] != "Y" && isset($ar["ELEMENT_COUNT"])):
														?><span class="role_count">&nbsp;(<span data-role="count_<?=$ar["CONTROL_ID"]?>"><? echo $ar["ELEMENT_COUNT"]; ?></span>)</span><?
													endif;
												?></label><?
											?></span><?
										?></div><?
									}
									// scroll
									if($isScrolable) {
										?></div><?
									}
								?></div><?
								break;
							case "U"://CALENDAR
								?><div class="property c"><?
									?><div class="inputs"><?
										$APPLICATION->IncludeComponent(
											'bitrix:main.calendar',
											'',
											array(
												'FORM_NAME' => $arResult["FILTER_NAME"]."_form",
												'SHOW_INPUT' => 'Y',
												'INPUT_ADDITIONAL_ATTR' => 'class="calendar" placeholder="'.FormatDate("SHORT", $arItem["VALUES"]["MIN"]["VALUE"]).'" onkeyup="smartFilter.keyup(this)" onchange="smartFilter.keyup(this)"',
												'INPUT_NAME' => $arItem["VALUES"]["MIN"]["CONTROL_NAME"],
												'INPUT_VALUE' => $arItem["VALUES"]["MIN"]["HTML_VALUE"],
												'SHOW_TIME' => 'N',
												'HIDE_TIMEBAR' => 'Y',
											),
											null,
											array('HIDE_ICONS' => 'Y')
										);
										$APPLICATION->IncludeComponent(
											'bitrix:main.calendar',
											'',
											array(
												'FORM_NAME' => $arResult["FILTER_NAME"]."_form",
												'SHOW_INPUT' => 'Y',
												'INPUT_ADDITIONAL_ATTR' => 'class="calendar" placeholder="'.FormatDate("SHORT", $arItem["VALUES"]["MAX"]["VALUE"]).'" onkeyup="smartFilter.keyup(this)" onchange="smartFilter.keyup(this)"',
												'INPUT_NAME' => $arItem["VALUES"]["MAX"]["CONTROL_NAME"],
												'INPUT_VALUE' => $arItem["VALUES"]["MAX"]["HTML_VALUE"],
												'SHOW_TIME' => 'N',
												'HIDE_TIMEBAR' => 'Y',
											),
											null,
											array('HIDE_ICONS' => 'Y')
										);
									?></div><?
								?></div><?
								break;
							default://CHECKBOXES
								?><div class="property"><?
									// search
									if ($isSearchable && !$isColor) {
										?><input type="text" class="f_search" name="f_search" id="f_search" value="" placeholder="<?=GetMessage('FILTR_SEARHC')?>"><?
									}
									// scroll
									if ($isScrolable && count($arItem['VALUES'])>$arParams['FILTER_PROP_SCROLL_CNT']) {
										$isScrolable = true;
									} else {
										$isScrolable = false;
									}
									if ($isScrolable) {
										?><div class="smartf-div f_jscrollpane" id="f_scroll_<?=$arItem['ID']?>"><?
									}
									foreach ($arItem["VALUES"] as $val => $ar) {
										$class = '';
										if ($ar["CHECKED"]) {
											$class.= " active";
										}
										if ($ar["DISABLED"]) {
											if($class != ' active') {
												$class.= " disabled";
											}
										}
										?><div class="lvl2"><?
											?><span class="smartf-div <?=$class?>"><?
												?><input <?
													?>type="checkbox" <?
													?>name="<?=$ar["CONTROL_NAME"]?>" <?
													?>id="<?=$ar["CONTROL_ID"]?>" <?
													?>value="<?=$ar["HTML_VALUE"]?>" <?
													?><? echo $ar["CHECKED"]? 'checked="checked"': '' ?> <?
												?>/><?
												?><label for="<?=$ar["CONTROL_ID"]?>" data-role="label_<?=$ar["CONTROL_ID"]?>" class="name <?=$class?>" onclick="smartFilter.keyup(BX('<?=CUtil::JSEscape($ar["CONTROL_ID"])?>')); BX.toggleClass(this, 'active');"><?
													?><span class="val"><?=$ar["VALUE"]?></span><?
													if ($arParams["FILTER_HIDE_PROP_COUNT"] != "Y" && isset($ar["ELEMENT_COUNT"])):
														?><span class="role_count">&nbsp;(<span data-role="count_<?=$ar["CONTROL_ID"]?>"><? echo $ar["ELEMENT_COUNT"]; ?></span>)</span><?
													endif;
												?></label><?
											?></span><?
										?></div><?
									}
									// scroll
									if ($isScrolable) {
										?></div><?
									}
								?></div><?
						}
					?></div><?
				}
				?></div>
                
                <div class="buttons">
                    <input
                        class="btn1"
                        type="submit"
                        id="set_filter"
                        name="set_filter"
                        value="<?=GetMessage("CT_BCSF_SET_FILTER")?>"
                    />
                    <span class="separator"></span>
                    <input
                        class="btn3"
                        type="submit"
                        id="del_filter"
                        name="del_filter"
                        value="<?=GetMessage("CT_BCSF_DEL_FILTER")?>"
                    />
				</div>
			</div>
			<div class="modef" id="modef" <?if(!isset($arResult['ELEMENT_COUNT'])) echo 'style="display:none"';?>>
				<span class="arrow">&nbsp;</span>
				<span class="data">
					<?=GetMessage('CT_BCSF_FILTER_COUNT', array('#ELEMENT_COUNT#' => ' <span id="modef_num">'.intval($arResult['ELEMENT_COUNT']).'</span>'));?>
					<a href="<?echo $arResult['FILTER_URL']?>"><?=GetMessage('CT_BCSF_FILTER_SHOW')?></a>
				</span>
			</div>
		</div>
	</div>
</form>
<script>
	var smartFilter = new JCSmartFilter('<?=CUtil::JSEscape($arResult['FORM_ACTION'])?>', <?=CUtil::PhpToJSObject($arResult["JS_FILTER_PARAMS"])?>);
</script>
