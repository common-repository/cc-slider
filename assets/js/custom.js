      jQuery(document).ready(function($) {
          var direction;
          var control;
          var hover;
          if(phpInfo.directionNav=='1')
          {
              direction=true;
          }
          else{
              direction=false;
          }
          if(phpInfo.controlNav=='1')
          {
              control=true;
          }
          else{
              control=false;
          }
          if(phpInfo.hover=='1')
          {
              hover=true;
          }
          else{
              hover=false;
          }
      $("#owl-demo").owlCarousel({
      singleItem : true,
      navigation : direction,
      navigationText : ["<",">"],
      pagination : control,
      autoPlay : phpInfo.pauseTime,
      transitionStyle: phpInfo.effect,
      rewindNav: true,
      stopOnHover : hover,
      });
      // show first caption
  $("#slider .caption").addClass("animate-me");
  
   $("#slide-next").click(function(){
     $("#slider .caption").removeClass("animate-me");
      $slider.trigger('owl.next');
      $("#slider .caption").addClass("animate-me");
   });
   
   $("#slide-prev").click(function(){
     $("#slider .caption").removeClass("animate-me");
      $slider.trigger('owl.prev');
     $("#slider .caption").addClass("animate-me");
   });      
    });