$(document).ready(function() {
	$( "#slider-range-min" ).slider({
		range: "min",
		value: 100,
		min: 80,
		max: 200,
		slide: function( event, ui ) {
            $("p, li").css("font-size", ui.value+"%");
            setCookie('fontsize', ui.value, 7);
		}
	});
	
	var fontsize = getCookie("fontsize");
	if(fontsize) {
		$("#slider-range-min").slider("value", fontsize);
		$("p, li").css("font-size", fontsize+"%");
	}
	
    $('#smaller_text').click(function() {
        var fontsize = getCookie("fontsize");
		if(fontsize) {
		  newFontSize = Number(fontsize)-10;
		} else {
		  newFontSize = 90;
		}
		
		if(newFontSize < 80) {
		  newFontSize = 80;
		}
		
		setCookie('fontsize', newFontSize, 7);
		$("#slider-range-min").slider("value", newFontSize);
        $("p, li").css("font-size", newFontSize+"%");
    });
    
    $('#bigger_text').click(function() {
        var fontsize = getCookie("fontsize");
		if(fontsize) {
		  newFontSize = Number(fontsize)+10;
		} else {
		  newFontSize = 110;
		}
		
		if(newFontSize > 200) {
		  newFontSize = 200;
		}
		
		setCookie('fontsize', newFontSize, 7);
		$("#slider-range-min").slider("value", newFontSize);
        $("p, li").css("font-size", newFontSize+"%");
    });
});