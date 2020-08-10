function RSGOPRO_SetHeight() {
	setTimeout(function(){
		// reset
		$('.mainsections').find('li.section').css('minHeight',0);
		// in line
		var position = 0,
        $mainSection = $('.mainsections').find('li.section:first');

    if ($mainSection.length > 0) {
      position = $mainSection.offset().top;
    }

		var last_index = 0;
		var max_height = 0;
		$('.mainsections').find('li.section').each(function(i){
			if( $(this).offset().top!=position )
			{
				if(last_index>0)
				{
					$('.mainsections').find('li.section:lt('+(i)+'):gt('+last_index+')').css('minHeight',max_height);
				} else {
					$('.mainsections').find('li.section:lt('+(i)+')').css('minHeight',max_height);
				}
				last_index = (i-1);
				position = $(this).offset().top;
				max_height = $(this).outerHeight(true)+2;
			} else {
				if( $(this).outerHeight(true)>max_height )
					max_height = $(this).outerHeight(true)+2;
			}
		});
		if(last_index>0)
			$('.mainsections').find('li.section:gt('+last_index+')').css('minHeight',max_height);
		else
			$('.mainsections').find('li.section').css('minHeight',max_height);
	},100);
}

$(document).ready(function(){
	RSGOPRO_SetHeight();
	$(window).bind('resize', RSGOPRO_SetHeight);
});

$(window).on('load', function(){
	RSGOPRO_SetHeight();

	setTimeout(function(){ // fix for slow shit
		RSGOPRO_SetHeight();
	}, 50);
});
