<div id="requestPrice" data-load="<?=SITE_TEMPLATE_PATH?>/images/picLoad.gif">
	<div id="requestPriceContainer">
		<div class="requestPriceHeading">To request the value of the goods <a href="#" class="close closeWindow"></a></div>
		<div class="requstProductContainer">
			<div class="productColumn">
				<div class="productImageBlock">
					<a href="#" class="requestPriceUrl" target="_blank"><img src="<?=SITE_TEMPLATE_PATH?>/images/picLoad.gif" alt="" class="requestPricePicture"></a>
				</div>
				<div class="productNameBlock">
					<a href="#" class="productUrl requestPriceUrl" target="_blank">
						<span class="middle">Download of the product</span>
					</a>
				</div>
			</div>
			<div class="formColumn">
				<div class="requestPriceFormHeading">Fill in the details for price request</div>
				<form id="requestPriceForm" method="GET">
					<input type="text" name="name" value="" placeholder="Name" id="requestPriceFormName">
					<input type="text" name="telephone" value="" data-required="Y" placeholder="Phone*" id="requestPriceFormTelephone">
					<input type="hidden" name="productID" value="" id="requestPriceProductID">
					<input name="id" type="hidden" id="requestPriceFormId" value="">
					<input name="act" type="hidden" id="requestPriceFormAct" value="requestPrice">
					<input name="SITE_ID" type="hidden" id="requestPriceFormSiteId" value="<?=SITE_ID?>">
					<textarea name="message" placeholder="Message"></textarea>
					<a href="#" id="requestPriceSubmit"><img src="<?=SITE_TEMPLATE_PATH?>/images/request.png" alt="To request a price">To request a price</a>
				</form>
			</div>
		</div>
		<div id="requestPriceResult">
			<div id="requestPriceResultTitle"></div>
			<div id="requestPriceResultMessage"></div>
			<a href="" id="requestPriceResultClose" class="closeWindow">Close window</a>
        </div>
	</div>
</div>