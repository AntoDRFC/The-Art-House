$(document).ready(function(){
      
    $('input.membership').click(function(){
        var type = $(this).val();
        
        switch(type) {
            case 'individual':
                $('.group').hide();
                $('.artistform').hide();
                $('#individual_choices').show();
                break;
            case 'joint':
                $('.individual').show();
                $('.company').hide();
                $('.group').hide();
                $('#individual_choices').hide();
                $('.artistform').show();
                break;
            case 'group':
                $('.individual').hide();
                $('.company').hide();
                $('.group').show();
                $('#individual_choices').hide();
                $('.artistform').show();
                break;
        }
    });
      
    $('.individual_choice').click(function(){
        var type = $(this).val();
        
        switch(type) {
            case 'member':
                $('.company').hide();
                $('.individual').show();
                $('.artistform').show();
                break;
            case 'company':
                $('.company').show();
                $('.individual').hide();
                $('.artistform').show();
                break;
        }
    });
    
});