function getParameterByName(name, url = window.location.href) {
  name = name.replace(/[\[\]]/g, "\\$&");
  var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
    results = regex.exec(url);
  if (!results) return null;
  if (!results[2]) return "";
  return decodeURIComponent(results[2].replace(/\+/g, " "));
}

function sort(e, compareAsc, compareDesc) {
  const sortTypes = document.getElementsByClassName("sortType");
  const sortIcons = document.getElementsByClassName("sortIcon");
  if (e.target.classList.contains("asc")) {
    data.sort(compareDesc);
    e.target.classList.remove("asc");
    e.target.classList.add("desc");
  } else {
    Object.keys(sortTypes).map((v) => {
      sortTypes[v].classList.remove("desc", "asc");
    });
    Object.keys(sortIcons).map((v) => {
      sortIcons[v].classList.remove("fa", "fa-sort");
    });
    e.target.classList.add("asc");
    e.target.childNodes[1].classList.add("fa", "fa-sort");
    data.sort(compareAsc);
  }
  render(data);
}
function sortView(e) {
  let type = "view";
  function compareAsc(a, b) {
    return parseInt(a[type]) - parseInt(b[type]);
  }
  function compareDesc(a, b) {
    return parseInt(b[type]) - parseInt(a[type]);
  }
  sort(e, compareAsc, compareDesc);
}
function sortDate(e) {
  let type = "date";
  function compareAsc(a, b) {
    return parseInt(a[type]) - parseInt(b[type]);
  }
  function compareDesc(a, b) {
    return parseInt(b[type]) - parseInt(a[type]);
  }
  sort(e, compareAsc, compareDesc);
}
function sortAz(e) {
  let type = "title";
  function compareAsc(a, b) {
    if (a[type] < b[type]) return -1;
    if (a[type] > b[type]) return 1;
    return 0;
  }
  function compareDesc(a, b) {
    if (a[type] > b[type]) return -1;
    if (a[type] < b[type]) return 1;
    return 0;
  }
  sort(e, compareAsc, compareDesc);
}

function updateSubcribe(value) {
  let formData = new FormData();
  formData.append("update-subcribe", 1);
  formData.append("value", value);
  formData.append("target", getParameterByName("profile"));
  formData.append("subBy", window.user.member_id);
  return fetch("./xuly-profile.php", {
    method: "POST",
    body: formData,
  })
    .then(function (response) {
      return response.json();
    })
    .then(function (body) {
      console.log(body);
      render(body);
    });
}

function subcribe(e) {
  if (!window.user) {
    e.target.checked = !e.target.checked;
    return;
  }
  let subCountView = document.getElementsByClassName("subText")[0];
  let subCount = parseInt(subCountView.innerText);
  if (e.target.checked) {
    subCount += 1;
    updateSubcribe(1);
  } else {
    subCount -= 1;
    updateSubcribe(0);
  }
  subCountView.innerText = subCount;
}


function getPublicPosts() {
  let formData = new FormData();
  formData.append("get-public-posts", 1);
  formData.append("user_id", getParameterByName("profile"));
  return fetch("./xuly-profile.php", {
    method: "POST",
    body: formData,
  })
    .then(function (response) {
      return response.json();
    })
    .then(function (body) {
      console.log(body);
      render(body);
    });
}

function render(data) {
  const listpost = document.getElementsByClassName("listpost")[0];
  datahtml = data.map((v, i) => {
    const date = new Date(v.updatedAt);
    const updatedTime = date.toLocaleDateString("en-EN", {
      year: "numeric",
      month: "long",
      day: "numeric",
    });
    return `<div class="postcontainer" >
        <a href="../post/post.php?id=${v.post_id}">
            <div class="fs-2 fw-bold">${v.title}</div>
            <p class="postdescription">${
              !v.preContent ? "" : v.preContent.replace(/[><\/]/g, "")
            }</p>
            <div class="postimg">
            ${!v.preImg ? "" : `<img src="../${v.preImg}" alt="">`}
            </div>
        </a>
        <div class="d-flex justify-content-between">
            <div>
                <span class='mx-2'>View: ${v.view}</span>
                <span class='mx-2'>Vote: ${v.vote}</span>
            </div>
            <span class="fst-italic text-secondary">${updatedTime}</span>
        </div>
        </div>`;
  });
  listpost.innerHTML = datahtml.reduce((pre, cur) => {
    return pre + cur;
  }, "");
}

window.onload = () => {
  // document.getElementById("sortView").addEventListener("click", sortView);
  // document.getElementById("sortNewest").addEventListener("click", sortDate);
  // document.getElementById("sortAz").addEventListener("click", sortAz);
  document.getElementsByClassName("subButtonCb")[0].onchange = subcribe;
  getPublicPosts();
};

// const data = [
//   {
//     post_id: 1,
//     title: "The way to do something 1",
//     preContet: "the one thing u need to do some thing is",
//     preImg: "",
//     date: "date",
//     view: "3512",
//     vote: "123"
//   },
// ];
