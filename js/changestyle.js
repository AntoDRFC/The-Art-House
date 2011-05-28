$(document).ready(function() {
    
    $('#display-ops img').mouseenter(function() {
        var altText = $(this).attr('alt');
        $('#display-ops span').html(altText);
    });
    
    $('#display-ops img').mouseleave(function() {
        $('#display-ops span').html('');
    });
    
    $('#display-ops img').click(function() {
        var stylesheetToSet = $(this).attr('alt');
        
        switch(stylesheetToSet) {
            case 'Default':
                stylesheet = 'css/stylesheet.css';
                break;
            case 'Clear':
                stylesheet = 'css/clear.css';
                break;
            case 'Contrast':
                stylesheet = 'css/contrast.css';
                break;
        }
        
        $("link").attr("href", stylesheet);
    });
        
});