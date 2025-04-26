// Hamburger menu function

function hamburger() {

  var menu = document.getElementById("menu-links");

  if (menu.style.display =="block") {

   menu.style.display = "none";

 } else {

   menu.style.display = "block";

 }

}

function formChecker() {
  var name = document.getElementById("name").value;
  var email = document.getElementById("email").value;
  var message = document.getElementById("message").value;

  if (name == "" || email == "" || message == "") {
      alert("Please fill out all fields.");
      return false; // Prevent form submission
  }
  return true; // Allow form submission
}

