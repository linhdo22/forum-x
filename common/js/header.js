window.addEventListener("load", () => {
  var clockrun = document.getElementById("greeting");
  function time() {
    var d = new Date();
    var s = d.getSeconds();
    var m = d.getMinutes();
    var h = d.getHours();
    if (h >= 0 && h < 12) {
      clockrun.textContent =
        ("0" + h).substr(-2) +
        ":" +
        ("0" + m).substr(-2) +
        ":" +
        ("0" + s).substr(-2);
    } else if (h >= 12 && h <= 23) {
      clockrun.textContent =
        ("0" + h).substr(-2) +
        ":" +
        ("0" + m).substr(-2) +
        ":" +
        ("0" + s).substr(-2);
    }
  }
  time();
  //clock
  setInterval(time, 1000);


  //search
  const searchForm = document.getElementsByClassName("searchForm")[0];
  const navSearchHeader = document.getElementsByClassName("navSearchHeader")[0];
  const navSearchContent =
    document.getElementsByClassName("navSearchContent")[0];
  const navSearchInput = document.getElementsByClassName("navSearchInput")[0];
  navSearchHeader.addEventListener("click", () => {
    //mo input
    if (!navSearchHeader.classList.contains("searchOn")) {
      navSearchHeader.classList.add("searchOn");
      navSearchContent.style.display = "flex";

      setTimeout(() => {
        searchForm.style.width = "100%";
      }, 0);
      navSearchInput.focus();
    }
    //submit
    else if (navSearchHeader.classList.contains("searchOn")) {
      console.log("submit");
      // navSearchHeader.classList.remove('searchOn');
      // searchForm.style.width = '0%';
      // searchForm.submit();
    }
  });
  searchForm.addEventListener("submit", (e) => {
    if (navSearchInput.value === "") {
      e.preventDefault();
    }
  });
  navSearchInput.addEventListener("blur", () => {
    if (navSearchInput.value === "") {
      navSearchHeader.classList.remove("searchOn");
      searchForm.style.width = "0%";
      navSearchContent.style.display = "none";
    }
  });
});
