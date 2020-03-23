$(document).ready(function(){
  $("#myInput").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#myTable tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});


sign_up.style.display = "none";
function myFunction() {

  var sign_up = document.getElementById("sign_up");
  var login = document.getElementById("landing");
  var sign = document.getElementById("sign");  
  
  if (sign_up.style.display == "none") {
    sign_up.style.display = "block";
     login.style.display = "none"; 
    sign.value ='Login';
  } else {
    sign_up.style.display = "none";
    login.style.display = "block";
    sign.value ='Sign Up';
  }
}

function askDelete(id,count) {
      if (count != 1) {
        alertify.confirm("<p class='bg-muted'><span class='text-warning'>Expense</span><span class='text-secondary'>|</span><span class='text-danger'>Tracker</span>","Delete? Are you sure?</p>", 
        function onOk() {
            //delay showing the confirm again 
            //till the first confirm is actually closed.
             window.location = "home.php?deleteExpense=" + id;
             window.location = "home.php";
                alertify.alert("<p class='bg-muted'><span class='text-warning'>Expense</span><span class='text-secondary'>|</span><span class='text-danger'>Tracker</span>","Expense has been Deleted!</p>");
        },
        function onCancel() {
            //no delay, this will fail to show!
            alertify.confirm("this will not be shown!");
        }
     );

    }else {
          alertify.alert("<p class='bg-muted'><span class='text-warning'>Expense</span><span class='text-secondary'>|</span><span class='text-danger'>Tracker</span>","Can't Delete! Number of Expense can't be zero</p>");
    }
}


