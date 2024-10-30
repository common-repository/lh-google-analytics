  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
  
  
if (document.currentScript.getAttribute('data-tracking_codes')){
    
var str = document.currentScript.getAttribute('data-tracking_codes');
var str_array = str.split(',');

for(var i = 0; i < str_array.length; i++) {

  ga('create', str_array[i], 'auto', 'tracker_' + i);
  
  if (document.currentScript.getAttribute('data-user_id')){
      
      
ga('tracker_' + i + '.set', 'userId', document.currentScript.getAttribute('data-user_id'));
      
  }
  
  
  
  ga('tracker_' + i + '.send', 'pageview');

  
}


  
  }