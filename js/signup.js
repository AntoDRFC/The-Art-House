$(document).ready(function(){
   
   $('#supporterShow').click(function(){
       $('#supporter').show();
       $('#artist').hide();
   });
   
   $('#artistShow').click(function(){
       $('#supporter').hide();
       $('#artist').show();
   });
   
   $('input.membership').click(function(){
      
      var divShow = $(this).attr('value');
      
      $('.information').hide();
      $('#' + divShow).show(); 
      $('#generic').show();
      
      if(divShow == 'group') {
          $('#individual').show();
          $('#individual').find('p:first').hide();
      } else {
          $('#individual').find('p:first').show();
      }
       
   });
    
});