window.addEventListener("load", () => {
  const loginUsername = document.getElementById("loginUsername");
  const loginPassword = document.getElementById("loginPassword");
  const usernameError = document.getElementsByClassName("usernameError")[0];
  const passwordError = document.getElementsByClassName("passwordError")[0];

  loginUsername.onkeyup = function (e) {
    usernameError.style.display = "none";
    if (!e.target.classList.contains("filled")) {
      e.target.classList.add("filled");
    }
    if (e.target.value === "") {
      e.target.classList.remove("filled");
    }
  };
  loginPassword.onkeyup = function (e) {
    passwordError.style.display = "none";
    if (!e.target.classList.contains("filled")) {
      e.target.classList.add("filled");
    }
    if (e.target.value === "") {
      e.target.classList.remove("filled");
    }
  };
});
