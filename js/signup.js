$(document).ready(function(){
   
   $('#patronShow').click(function(){
       $('#patron').show();
       $('#artist').hide();
   });
   
   $('#artistShow').click(function(){
       $('#patron').hide();
       $('#artist').show();
   });
   
   $('input.membership').click(function(){
      
      var divShow = $(this).attr('value');
      
      $('.information').hide();
      $('#' + divShow).show();
      $('#generic').show();
       
   });
    
});