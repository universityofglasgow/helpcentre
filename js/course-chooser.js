$(document).ready(function() {
   $(".courseChooser").hide();
   $("#chooseCourse").click(function() {
       $('#chooseCourse').hide();
       $('.courseChooser').show();
       return false;
   });
});