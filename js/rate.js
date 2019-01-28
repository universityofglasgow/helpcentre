$(document).ready(function() {
   $("a.rate-badge").click(function() {
       $("#rating").attr("value", ($(this).attr("data-value")));
       $("a.rate-badge").removeClass("selected");
       $(this).addClass("selected");
   });
});