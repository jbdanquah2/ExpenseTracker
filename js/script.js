$(document).ready(function(){
  $("#myInput").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#myTable tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});


function myFunction() {

  var sign_up = document.getElementById("sign_up");
  var login = document.getElementById("landing");
  var sign = document.getElementById("sign");  
  if (sign_up.style.display === "none") {
    sign_up.style.display = "block";
     login.style.display = "none"; 
    sign.value ='Click to Login';
  } else {
    sign_up.style.display = "none";
    login.style.display = "block";
    sign.value ='Click to Sign Up';
  }
}


