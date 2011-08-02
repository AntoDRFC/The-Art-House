$(document).ready(function() {
	$( "#slider-range-min" ).slider({
		range: "min",
		value: 100,
		min: 80,
		max: 200,
		slide: function( event, ui ) {
            $("p, li, td").css("font-size", ui.value+"%");
            setCookie('fontsize', ui.value, 7);
            $("#header p").css("font-size", "");
		}
	});
	
	var fontsize = getCookie("fontsize");
	if(fontsize) {
		$("#slider-range-min").slider("value", fontsize);
		$("p, li, td").css("font-size", fontsize+"%");
        $("#header p").css("font-size", "");
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
        $("p, li, td").css("font-size", newFontSize+"%");
        $("#header p").css("font-size", "");
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
        $("p, li, td").css("font-size", newFontSize+"%");
        $("#header p").css("font-size", "");
    });
    
    $('#resetsize').click(function() {
        setCookie('fontsize', 100, -1);
		$("#slider-range-min").slider("value", 100);
        $("p, li, td").css("font-size", "");
    });
});