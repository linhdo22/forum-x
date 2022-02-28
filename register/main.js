window.addEventListener("load", () => {
  const registerUsername = document.getElementById("registerUsername");
  const registerPassword = document.getElementById("registerPassword");
  const usernameError = document.getElementsByClassName("usernameError")[0];
  const passwordError = document.getElementsByClassName("passwordError")[0];

  registerUsername.onkeyup = function (e) {
    usernameError.style.display = "none";
    if (!e.target.classList.contains("filled")) {
      e.target.classList.add("filled");
    }
    if (e.target.value === "") {
      e.target.classList.remove("filled");
    }
  };
  registerPassword.onkeyup = function (e) {
    passwordError.style.display = "none";
    if (!e.target.classList.contains("filled")) {
      e.target.classList.add("filled");
    }
    if (e.target.value === "") {
      e.target.classList.remove("filled");
    }
  };
});
