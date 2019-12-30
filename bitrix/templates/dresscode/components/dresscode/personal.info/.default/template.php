<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<script>
    var ajaxDir = "<?=$this->GetFolder();?>";
</script>
<div id="mainProfile">
	<form action="" method="GET" id="personalForm">
		<ul class="profileSettings">
            <li> 
                <label><?=GetMessage('PROFILE_NAME')?></label>
                <input type="text" name="NAME" value="<?=$arResult["USER"]["NAME"]?>" class="inputText">
                <label><?=GetMessage('PROFILE_LAST_NAME')?> </label>
                <input type="text" name="LAST_NAME" value="<?=$arResult["USER"]["LAST_NAME"]?>" class="inputText">
                <label><?=GetMessage('EMAIL')?></label>
                <input type="text" name="EMAIL" value="<?=$arResult["USER"]["EMAIL"]?>" class="inputText">
                <label><?=GetMessage('USER_MOBILE')?></label>
                <input type="text" name="USER_MOBILE" value="<?=$arResult["USER"]["PERSONAL_MOBILE"]?>" class="inputTel">
                <label><?=GetMessage('USER_CITY')?></label>
                <input type="text" name="USER_CITY" value="<?if(!empty($arResult["USER"]["PERSONAL_CITY"])):?><?=$arResult["USER"]["PERSONAL_CITY"]?><?else:?><?=$arResult["USER"]["CITY_NAME"]?><?endif;?>" class="inputTel">
                <label><?=GetMessage('USER_ZIP')?></label>
                <input type="text" name="USER_ZIP" value="<?=$arResult["USER"]["PERSONAL_ZIP"]?>" class="inputTel">
            </li>
            <li>
                    <label><?=GetMessage('USER_STREET')?></label>
                    <textarea rows="10" cols="45" name="USER_STREET"><?=$arResult["USER"]["PERSONAL_STREET"]?></textarea>
                    <span class="heading"><?=GetMessage("CHANGE_PASS")?></span>
                    <label><?=GetMessage("PASS")?></label>
                    <input type="text" name="USER_PASSWORD" value="" class="inputTel">
                    <label><?=GetMessage("REPASS")?></label>
                    <input type="text" name="USER_PASSWORD_CONFIRM" value="" class="inputTel">
                    <a href="#" class="submit"><?=GetMessage("SAVE")?></a>
            </li>
        </ul>
	</form>
</div>

<div id="elementError">
  <div id="elementErrorContainer">
    <span class="heading"><?=GetMessage("ERROR")?></span>
    <a href="#" id="elementErrorClose"></a>
    <p class="message"></p>
    <a href="#" class="close"><?=GetMessage("CLOSE")?></a>
  </div>
</div>