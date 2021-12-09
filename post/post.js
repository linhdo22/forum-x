function getParameterByName(name, url = window.location.href) {
  name = name.replace(/[\[\]]/g, "\\$&");
  var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
    results = regex.exec(url);
  if (!results) return null;
  if (!results[2]) return "";
  return decodeURIComponent(results[2].replace(/\+/g, " "));
}
function addComment() {
  if (!window.user) {
    document.getElementById("write-comment-warn").style.display = "block";
    return;
  }
  const content = tinymce.activeEditor.getContent();
  if (content == "") {
    return;
  }
  let formData = new FormData();
  formData.append("add-comment", 1);
  formData.append("content", content);
  formData.append("writeBy", window.user.member_id);
  formData.append("postId", getParameterByName("id"));
  return fetch("./xuly-post.php", {
    method: "POST",
    body: formData,
  })
    .then(function (response) {
      tinymce.activeEditor.setContent("");
      return response.json();
    })
    .then(function (body) {
      getCountPages();
      return body;
    });
}

function updateView() {
  let formData = new FormData();
  formData.append("update-view", 1);
  formData.append("postId", getParameterByName("id"));
  return fetch("./xuly-post.php", {
    method: "POST",
    body: formData,
  }).then(function (response) {
    return response.json();
  });
}
function getCountPages() {
  let formData = new FormData();
  formData.append("get-count-comments", 1);
  formData.append("postId", getParameterByName("id"));
  return fetch("./xuly-post.php", {
    method: "POST",
    body: formData,
  })
    .then(function (response) {
      return response.json();
    })
    .then(function (body) {
      countPages = Math.ceil(body / 5);
      getComments(1);
    });
}

function getComments(page) {
  let formData = new FormData();
  formData.append("get-comments", 1);
  formData.append("page", page);
  formData.append("postId", getParameterByName("id"));
  return fetch("./xuly-post.php", {
    method: "POST",
    body: formData,
  })
    .then(function (response) {
      return response.json();
    })
    .then(function (body) {
      let html = "";
      body.forEach((comment) => {
        html += renderComment(comment);
      });
      document.getElementById("comment-list").innerHTML = html;
      renderPageSelection(page);
    });
}

function renderComment(comment) {
  const date = new Date(comment.createdAt);
  const options = {
    hour: "numeric",
    minute: "numeric",
    year: "numeric",
    month: "2-digit",
    day: "2-digit",
  };
  const time = date.toLocaleDateString("en-US", options);
  return `<div class="border shadow-sm mb-4 px-3 py-1 ">
<div class=" d-flex justify-content-between my-2 ">
    <div class="fw-bold fst-italic ${
      window.authorId == comment.writeBy ? "text-primary" : ""
    }"><a href="../profile/profile.php?profile=${comment.writeBy}">${
    comment.name
  }</a></div>
    <div class="fw-light">${time}</div>
</div>
<div>${comment.content}</div>
</div>`;
}

function renderPageSelection(page) {
  let preBtn;
  let pageLeft;
  let pageMid;
  let pageRight;
  let nextBtn;
  if (page == countPages) {
    nextBtn = false;
    pageRight = page;
    pageMid = page - 1 < 1 ? null : page - 1;
    pageLeft = page - 2 < 1 ? null : page - 2;
    preBtn = page - 2 < 1 ? false : true;
  }
  if (page < countPages && page != 1) {
    nextBtn = true;
    pageRight = page + 1;
    pageMid = page;
    pageLeft = page - 1 < 1 ? null : page - 1;
    preBtn = page - 1 < 1 ? false : true;
  }
  if (page < countPages && page == 1) {
    console.log(page);
    console.log(countPages);
    nextBtn = true;
    pageRight = page + 2 > countPages ? null : page + 2;
    pageMid = page + 1;
    pageLeft = page;
    preBtn = false;
  }
  document.getElementById(
    "pageination-comment"
  ).innerHTML = `<ul class="pagination justify-content-center">
  <li class="page-item ${!preBtn && "disabled"}" onclick="${
    preBtn && `changePage(${page - 1})`
  }">
      <span class="page-link">Previous</span>
  </li>
  ${
    pageLeft
      ? `<li class="page-item ${page == pageLeft && "active"}" onclick="${
          page != pageLeft && `changePage(${pageLeft})`
        }"><span class="page-link btn">${pageLeft}</span></li>`
      : ""
  }
  ${
    pageMid
      ? `<li class="page-item ${page == pageMid && "active"}" onclick="${
          page != pageMid && `changePage(${pageMid})`
        }"><span class="page-link btn">${pageMid}</span></li>`
      : ""
  }
  ${
    pageRight
      ? `<li class="page-item ${page == pageRight && "active"}" onclick="${
          page != pageRight && `changePage(${pageRight})`
        }"><span class="page-link btn">${pageRight}</span></li>`
      : ""
  }
  
  
  <li class="page-item ${!nextBtn && "disabled"}"  onclick="${
    preBtn && `changePage(${page + 1})`
  }">
      <span class="page-link btn">Next</span>
  </li>
</ul>`;
}

function changePage(page) {
  if (page > countPages || page < 1) {
    return;
  }
  getComments(page);
}

function updateVote(value) {
  let formData = new FormData();
  formData.append("update-vote", 1);
  formData.append("userId", window.user.member_id);
  formData.append("postId", getParameterByName("id"));
  formData.append("value", value);
  fetch("./xuly-post.php", {
    method: "POST",
    body: formData,
  });
}

function votePost(value) {
  if (!window.user) {
    return;
  }
  const count = document.getElementById("count-vote");
  const upVote = document.getElementById("up-vote");
  const downVote = document.getElementById("down-vote");
  if (value == 1) {
    if (upVote.classList.contains("text-primary")) {
      upVote.classList.replace("text-primary", "text-dark");
      count.innerText = parseInt(count.innerText) - 1;
      updateVote(0);
      return;
    }
    upVote.classList.replace("text-dark", "text-primary");
    count.innerText = parseInt(count.innerText) + 1;
    if (downVote.classList.contains("text-danger")) {
      downVote.classList.replace("text-danger", "text-dark");
      count.innerText = parseInt(count.innerText) + 1;
    }
    updateVote(value);
  }
  if (value == -1) {
    if (downVote.classList.contains("text-danger")) {
      downVote.classList.replace("text-danger", "text-dark");
      count.innerText = parseInt(count.innerText) + 1;
      updateVote(0);
      return;
    }
    downVote.classList.replace("text-dark", "text-danger");
    count.innerText = parseInt(count.innerText) - 1;
    if (upVote.classList.contains("text-primary")) {
      upVote.classList.replace("text-primary", "text-dark");
      count.innerText = parseInt(count.innerText) - 1;
    }
    updateVote(value);
  }
}

function scrollEvent() {
  //vote
  document
    .getElementById("up-vote")
    .addEventListener("click", () => votePost(1));
  document
    .getElementById("down-vote")
    .addEventListener("click", () => votePost(-1));

  // scroll
  const postInfo = document.getElementById("post-info");
  const postContent = document.querySelector(".post-content");
  const bottomPostMark = postContent.offsetTop + postContent.scrollHeight;
  const bottomPostInfoMark = postInfo.offsetTop + postInfo.scrollHeight;
  const overPoint = bottomPostMark - bottomPostInfoMark;
  let isMarkOver = false;

  window.onscroll = () => {
    if (document.documentElement.scrollTop > overPoint && !isMarkOver) {
      postInfo.style.position = "absolute";
      postInfo.style.top = overPoint + postInfo.offsetTop + "px";
      isMarkOver = true;
      return;
    }
    if (document.documentElement.scrollTop < overPoint && isMarkOver) {
      postInfo.style.position = "fixed";
      postInfo.style.top = "20%";
      isMarkOver = false;
      return;
    }
  };
}
let countPages = 0;
let currentCommentPage = 1;
window.addEventListener("load", () => {
  getCountPages();
  scrollEvent();

  document
    .getElementById("create-comment")
    .addEventListener("click", addComment);
});
