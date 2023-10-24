function myFunction() {
  var x = document.getElementById("password");
  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }

  var y = document.getElementById("password_confirmation");
  if (y.type === "password") {
    y.type = "text";
  } else {
    y.type = "password";
  }
}