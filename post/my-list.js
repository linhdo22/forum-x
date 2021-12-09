function getList(authorId) {
  let formData = new FormData();
  formData.append("authorId", authorId);
  return fetch("./xuly-list.php", {
    method: "POST",
    body: formData,
  })
    .then(function (response) {
      return response.json();
    })
    .then(function (body) {
      return body;
    });
}

function renderPostView(post) {
  return `<div data-post="${post.post_id}" class="post ${
    post.public == 1 ? "public" : "private"
  } p-3 my-3">
    <div  class="d-flex justify-content-between">
        <div class="w-75">
          <a href="./post.php?id=${post.post_id}">
            <h4 class="text-truncate">${post.title}</h4>
            <div>
                <span class="d-inline-block w-25 text-secondary"><i class="me-1 fas fa-eye"></i>${
                  post.view
                }</span>
                <span class="d-inline-block me-4 text-primary"><i class="me-1 far fa-thumbs-up"></i>${
                  post.vote
                }</span>
            </div>
            <p class="my-1"><span class="fw-bold">Created At:</span> ${
              post.createdAt
            }</p>
            <p class="my-1"><span class="fw-bold">Updated At:</span> ${
              post.updatedAt
            }</p>
          <a/>
        </div>
        <div>
            <div class="d-flex w-100 mb-5 justify-content-end">
                <div class="btn btn-outline-${
                  post.public == 1 ? "success" : "secondary"
                }" title="Click to change status of post" onclick='openConfirmStatusModal(this)' data-post-id="${
    post.post_id
  }" data-post-title="${post.title}" data-post-change-to="${
    post.public == 1 ? 0 : 1
  }">${post.public == 1 ? "Public" : "Private"}</div>
            </div>
            <div class="btn btn-danger">Delete</div>
            <a href="./update-post.php?id=${post.post_id}">
              <div class="btn btn-primary ">Update</div>
            </a>
        </div>
    </div>
</div>`;
}

function openConfirmStatusModal(target) {
  const postId = target.getAttribute("data-post-id");
  const title = target.getAttribute("data-post-title");
  const changeTo = target.getAttribute("data-post-change-to");
  const postEle = document.querySelector(`[data-post="${postId}"]`);

  document.getElementById(
    "confirm-status-body"
  ).innerHTML = `Are you sure about changing status of <b>${title}</b> to <b>${
    changeTo == 1 ? "Public" : "Private"
  }</b>`;

  confirmStatusModal.show();

  document.getElementById("confirm-change-btn").onclick = () => {
    let formData = new FormData();
    formData.append("postToChangeStatus", postId);
    formData.append("status", changeTo);
    fetch("./xuly-list.php", {
      method: "POST",
      body: formData,
    })
      .then(function (response) {
        return response.json();
      })
      .then(function (body) {
        postEle.classList.replace(
          `${changeTo != 1 ? "public" : "private"}`,
          `${changeTo == 1 ? "public" : "private"}`
        );

        target.classList.replace(
          `btn-outline-${changeTo != 1 ? "success" : "secondary"}`,
          `btn-outline-${changeTo == 1 ? "success" : "secondary"}`
        );
        target.textContent = changeTo == 1 ? "Public" : "Private";
        target.setAttribute("data-post-change-to", changeTo == 1 ? "0" : "1");
        return body;
      });
    confirmStatusModal.hide();
  };
}

let postList, confirmStatusModal;
window.addEventListener("load", () => {
  postList = document.getElementById("post-list");
  confirmStatusModal = new bootstrap.Modal(
    document.getElementById("confirm-status-modal")
  );

  getList(window.user.member_id).then((result) => {
    let html = "";
    let view = 0;
    let vote = 0;
    let postCount = 0;
    if (!result.length) {
      html += "<h4>No post created</h4>";
    } else {
      result.forEach((post) => {
        view += parseInt(post.view);
        vote += parseInt(post.vote);
        postCount++;
        html += renderPostView(post);
      });
    }
    document.getElementById("all-view-count").innerText = view;
    document.getElementById("all-vote-count").innerText = vote;
    document.getElementById("all-posts-count").innerText = postCount;
    postList.innerHTML = html;
  });
});
