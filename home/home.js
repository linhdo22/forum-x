function getTimeString(time) {
  const date = new Date(time);
  const options = {
    day: "2-digit",
    year: "numeric",
    month: "long",
  };
  return date.toLocaleDateString("en-US", options);
}

window.addEventListener("load", () => {
  loadLastestPost();
  loadLastestNews();
});

const loadLastestPost = () => {
  let formData = new FormData();
  formData.append("get-lastest-post", 1);
  return fetch("./xuly-home.php", {
    method: "POST",
    body: formData,
  })
    .then(function (response) {
      return response.json();
    })
    .then(function (body) {
      console.log(body);
      renderNewPost(body[0], body[1]);
      renderSubNewPost(body[2], body[3]);
      renderListPost(body);
    });
};

const loadLastestNews = () => {
  let formData = new FormData();
  formData.append("get-lastest-news", 1);
  return fetch("./xuly-home.php", {
    method: "POST",
    body: formData,
  })
    .then(function (response) {
      return response.json();
    })
    .then(function (body) {
      console.log(body);
      renderNewNews(body);
    });
};

const renderNewPost = (firstPost, secondPost) => {
  const newPost = document.getElementById("new-posts");
  let strHtml = "";
  if (firstPost) {
    
    strHtml += `<div class="col-md-7 ">
      <div class="article flex-column">
      <div style="width: 100%;height: 200px;" class="cover-img">
      ${
        firstPost.image
          ? `
         <a href="../post/post.php?id=${firstPost.post_id}"><img style="width: 100%;height: 100%;" src="../${firstPost.image}" ></a>
      `
          : ""
      }
      </div>
      <div class="">
      <a href="../post/post.php?id=${firstPost.post_id}" class="">
      <h2>${firstPost.title}</h2>
      </a>
      <span class="item-author">${firstPost.name}</span><br>
      <span class="item-author">${getTimeString(firstPost.time)}</span>
      </div>
      </div>
      </div>`;
  }
  if (secondPost) {
    strHtml += `<div class="col-md-5 ">
      <div class="article flex-column">
      <div style="width: 100%;height: 200px;" class="cover-img">
      ${
        secondPost.image
          ? `
         <a href="../post/post.php?id=${secondPost.post_id}"><img style="width: 100%;height: 100%;" src="../${secondPost.image}" ></a>
      `
          : ""
      }
      </div>
      <div >
      <a href="../post/post.php?id=${secondPost.post_id}" >
      <h2>${secondPost.title}</h2>
      </a>
      <span class="item-author">${secondPost.name}</span><br>
      <span class="item-author">${getTimeString(secondPost.time)}</span>
      </div>
      </div>
      </div>`;
  }
  newPost.innerHTML = strHtml;
};

const renderSubNewPost = (thirdPost, fourthPost) => {
  const subNewPost = document.getElementById("sub-new-posts");
  let strHtml = "";
  if (thirdPost) {
    strHtml += `<div class="col-md-6 ">
        <div class="article">
        <div style="width: 30%; height:150px;" class="cover-img me-1">
        ${
          thirdPost.image
            ? `
           <a href="../post/post.php?id=${thirdPost.post_id}"><img style="width: 100%;height: 100%;" src="../${thirdPost.image}" ></a>
        `
            : ""
        }
        </div>
        <div class="">
        <a href="../post/post.php?id=${thirdPost.post_id}" class="">
        <h2>${thirdPost.title}</h2>
        </a>
        <span class="item-author">${thirdPost.name}</span><br>
        <span class="item-author">${getTimeString(thirdPost.time)}</span>
        </div>
        </div>
        </div>`;
  }
  if (fourthPost) {
    strHtml += `<div class="col-md-6 ">
    <div class="article">
    <div style="width: 30%; height:150px;" class="cover-img me-1">
    ${
      fourthPost.image
        ? `
       <a href="../post/post.php?id=${fourthPost.post_id}"><img style="width: 100%;height: 100%;" src="../${fourthPost.image}" ></a>
    `
        : ""
    }
    </div>
    <div class="">
    <a href="../post/post.php?id=${fourthPost.post_id}" class="">
    <h2>${fourthPost.title}</h2>
    </a>
    <span class="item-author">${fourthPost.name}</span><br>
    <span class="item-author">${getTimeString(fourthPost.time)}</span>
    </div>
    </div>
    </div>`;
  }
  subNewPost.innerHTML = strHtml;
};

const renderListPost = (data) => {
  const listPost = document.getElementById("list-posts");
  let strHtml = data.reduce((pre, cur) => {
    return (
      pre +
      `<div class="col-md-12 my-3">
        <div class="article ">
            <div >
                <a href="../post/post.php?id=${cur.post_id}" >
                    <h2>${cur.title}</h2>
                </a>
                <span class="item-author">${cur.name}</span><br>
                <span class="item-author">${getTimeString(cur.time)}</span>
            </div>
        </div>
    </div>`
    );
  }, "");
  listPost.innerHTML = strHtml
};

const renderNewNews = (list) => {
  const listNews = document.getElementById("list-news");
  const strHtml = list.reduce((pre, cur) => {
    const date = new Date(cur.time);
    const options = {
      day: "2-digit",
      year: "numeric",
      month: "long",
    };
    const time = date.toLocaleDateString("en-US", options);
    return (
      pre +
      `<div class="story">
        <img style="width:30%; object-fit:cover; object-position:center;" src="../${cur.image}">
        <div class="story-detail ms-2">
            <div class="type-post ps-2">NEWS</div>
            <a href="../post/post?id=${cur.post_id}">
                <h3 class="ps-1">${cur.title}</h3>
            </a>
            <a href="../profile/profile.php?profile=${cur.member_id}"><div class="author fw-bold p-2">${cur.name}</div></a>
            <div class="p-2">${time}</div>
        </div>
    </div>`
    );
  }, "");
  listNews.innerHTML = strHtml;
};
