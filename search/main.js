function getParameterByName(name, url = window.location.href) {
  name = name.replace(/[\[\]]/g, "\\$&");
  var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
    results = regex.exec(url);
  if (!results) return null;
  if (!results[2]) return "";
  return decodeURIComponent(results[2].replace(/\+/g, " "));
}

function renderType(type, ele) {
  return `<div class="resultCard">
    <div class="resultType type${type}">${type}</div>
    <div class="marker"></div>
    <div class="resultCardInfo">
        <div >
            <img class="authorImg border-primary border border-2 rounded-circle" src="../${
              ele.avatar
            }" >
        </div>
        <div class="authorInfoWrapper">
            <div class="authorName">
                <a href="../profile/profile.php?profile=${ele.user_id}">${
    ele.name
  }</a>
            </div>
            ${!!ele.time ? `<div class="authorCreated">${ele.time}</div>` : ""}
        </div>
    </div>
    <div class="resultCardDetails">
    ${
      ele.title
        ? `
        <div class="resultCardTitle">
          <a
            class="resultCardTitleLink"
            href="../post/post.php?id=${ele.post_id}"
          >
            ${ele.title}
          </a>
        </div>`
        : ""
    }
        ${
          ele.hasOwnProperty("tags")
            ? `
            <div class="d-flex ">
                ${ele.tags.reduce((res, cur) => {
                  return (
                    res +
                    `<div class="btn btn-outline-primary rounded-pill disabled m-1">${cur}</div>`
                  );
                }, "")}
            </div>
        `
            : ""
        }
        ${
          ele.description != null && ele.description
            ? `<div class="resultCardDes">${ele.description}</div>`
            : ""
        }
        ${
          ele.content != null && ele.content
            ? `<div class="resultCardDes">${ele.content}</div>`
            : ""
        }
        ${
          ele.hasOwnProperty("view")
            ? `<div class="resultCardView">View: ${ele.view}</div>`
            : ""
        }
    </div>
</div>`;
}

function render(data, pattern) {
  const containter = document.getElementsByClassName("searchResult")[0];
  let dataHTML;
  if (data.length) {
    containter.classList.replace("animation-second", "animation-first");
    dataHTML = data.reduce((res, current) => {
      switch (current["type"]) {
        case "post":
          return res + renderType("Post", current);
        case "comment":
          return res + renderType("Comment", current);
        case "user":
          return res + renderType("User", current);
        default:
          break;
      }
    }, "");
  } else {
    dataHTML = `<div class="text-center rounded-pill border border-primary border-2 py-3 fs-3">No result for "<b>${pattern}</b>"</div>`;
  }
  containter.innerHTML = dataHTML;
  setTimeout(() => {
    containter.classList.replace("animation-first", "animation-second");
    console.log("render");
  }, 50);
}

const search = function (pattern, type = "all", tag = "all") {
  let formData = new FormData();
  formData.append("search", 1);
  formData.append("pattern", pattern);
  formData.append("tag", tag);
  formData.append("type", type);
  return fetch("./xuly-search.php", {
    method: "POST",
    body: formData,
  })
    .then(function (response) {
      return response.json();
    })
    .then(function (body) {
      render(body, pattern);
      return body;
    });
};
window.search = search;

function filterType(e, type) {
  let filTypes = document.getElementsByClassName("filterType");
  for (let ele of filTypes) {
    ele.classList.remove("active");
  }
  e.target.classList.add("active");
  filterTypeVar = type.toLowerCase();
  if (filterTypeVar !== "post") {
    document.getElementById("filTagAll").click();
  }
}
function filterTag(e, tag) {
  let filTags = document.getElementsByClassName("filterTag");
  for (let ele of filTags) {
    ele.classList.remove("active");
  }
  e.target.classList.add("active");
  tagTypeVar = tag.toLowerCase();
  if (tag !== "All") {
    document.getElementById("filPost").click();
  }
  handleSearch();
}

async function handleSearch() {
  const textSearch = document.getElementById("search-bar-input").value;
  const data = await search(textSearch, filterTypeVar, tagTypeVar);
  const newUrl = new URL(window.location);
  newUrl.searchParams.set("search", textSearch);
  history.pushState(
    {
      search: textSearch,
      data: data,
      type: filterTypeVar,
      tag: tagTypeVar,
    },
    "",
    newUrl
  );
}

let filterTypeVar = "all";
let tagTypeVar = "all";

window.addEventListener("load", () => {
  //filter
  document
    .getElementById("filTypeAll")
    .addEventListener("click", (e) => filterType(e, "All"));
  document
    .getElementById("filPost")
    .addEventListener("click", (e) => filterType(e, "Post"));
  document
    .getElementById("filComment")
    .addEventListener("click", (e) => filterType(e, "Comment"));
  document
    .getElementById("filUser")
    .addEventListener("click", (e) => filterType(e, "User"));
  //tags
  document
    .getElementById("filTagAll")
    .addEventListener("click", (e) => filterTag(e, "All"));
  document
    .getElementById("filArt")
    .addEventListener("click", (e) => filterTag(e, "Art"));
  document
    .getElementById("filBiology")
    .addEventListener("click", (e) => filterTag(e, "Biology"));
  document
    .getElementById("filMechanic")
    .addEventListener("click", (e) => filterTag(e, "Mechanic"));
  document
    .getElementById("filNews")
    .addEventListener("click", (e) => filterTag(e, "News"));
  document
    .getElementById("filScience")
    .addEventListener("click", (e) => filterTag(e, "Science"));
  document
    .getElementById("filSocial")
    .addEventListener("click", (e) => filterTag(e, "Social"));
  document
    .getElementById("filTech")
    .addEventListener("click", (e) => filterTag(e, "Tech"));

  document
    .getElementById("search-bar-input")
    .addEventListener("keypress", (e) => {
      if (e.key == "Enter") {
        handleSearch();
      }
    });
  search(getParameterByName("search"), filterTypeVar, tagTypeVar).then(
    (data) => {
      window.history.replaceState(
        { search: getParameterByName("search"), data },
        ""
      );
    }
  );
});
window.back = () => {
  history.back();
};
window.addEventListener("popstate", (e) => {
  document.getElementById("search-bar-input").value = e.state.search;
  render(e.state.data);
});

// // data
// const data = [
//   {
//     id: 1,
//     type: "Post",
//     authorName: "ethank99",
//     authorCreated: 2020,
//     title: "MongoDB Architecture",
//     tags: ["Tech", "Social", "News"],
//     description:
//       "MongoDB is a source-available cross-platform document-oriented database program",
//     view: 3152,
//   },
//   {
//     id: 2,
//     type: "Comment",
//     authorName: "depzai13",
//     authorCreated: 2019,
//     title: "PhP Introduction",
//     tags: ["Tech"],
//     description: "I have never learnt it",
//   },
//   {
//     id: 3,
//     type: "User",
//     authorName: "son124",
//     title: "Son Of Code",
//   },
//   {
//     id: 4,
//     type: "User",
//     authorName: "Tonia",
//     title: "Tibu the one",
//   },
//   {
//     id: 5,
//     type: "Comment",
//     authorName: "Nessie",
//     authorCreated: 2014,
//     tags: ["Mechanic", "News", "Social", "Tech", "Science"],
//     title: "Meter Guayaquil",
//     description: "Nice to meet you and wish to you",
//   },
//   {
//     id: 6,
//     type: "Post",
//     authorName: "Adelle",
//     authorCreated: 2020,
//     tags: ["Social", "Biology", "Tech"],
//     title: "Erich Dibrugarh",
//     description: "this is a dump description , end",
//     view: 9361,
//   },
//   {
//     id: 7,
//     type: "Post",
//     authorName: "Coral",
//     authorCreated: 2015,
//     tags: ["Tech", "Science", "Social", "News"],
//     title: "Hourigan Brasília",
//     description: "The last text of this sentence is end",
//     view: 192,
//   },
//   {
//     id: 8,
//     type: "Post",
//     authorName: "Janeczka",
//     authorCreated: 2010,
//     tags: ["Nature", "News", "Mechanic", "Biology"],
//     title: "Suk Belmopan",
//     description:
//       "sentence description hello description sentence best two work example two one two work best one work test two one sentence best example test sentence best hello work example hello one sentence two test description one work two work two one example example test two description test one sentence hello one best test description description sentence best example hello best sentence test two test  to you",
//     view: 9866,
//   },
//   {
//     id: 9,
//     type: "Post",
//     authorName: "Violet",
//     authorCreated: 2017,
//     tags: ["Art", "Social", "Science", "Art", "Mechanic"],
//     title: "Sabella Asunción",
//     description:
//       "one one description test best description test test one test description one sentence two work description description one two test work description description example sentence test hello description hello hello best description one work example example one one description best best best best one  to you",
//     view: 5442,
//   },
//   {
//     id: 10,
//     type: "Comment",
//     authorName: "Bernie",
//     authorCreated: 2010,
//     tags: ["Biology", "News", "Science", "Social"],
//     title: "Ephrem Guadalajara",
//     description:
//       "two sentence test one hello work example sentence one description  end",
//   },
//   {
//     id: 11,
//     type: "User",
//     authorName: "Madelle",
//     title: "Bari Invercargill",
//   },
//   {
//     id: 12,
//     type: "Comment",
//     authorName: "Althea",
//     authorCreated: 2021,
//     tags: ["Mechanic", "Art", "News", "Science", "Tech", "Social"],
//     title: "Jammal City of San Marino",
//     description:
//       "best hello best hello work work description one description work one sentence description sentence best work best hello sentence description test work test one hello test test one two test description sentence best description description best one example one description example work two best best one work example sentence  to you",
//   },
//   {
//     id: 13,
//     type: "Comment",
//     authorName: "Joy",
//     authorCreated: 2011,
//     tags: ["Biology", "Art", "Mechanic", "Tech", "Science"],
//     title: "Cleo Semarang",
//     description:
//       "hello test description best hello one two sentence description test one example test hello one hello description best sentence sentence sentence best sentence hello example description two example sentence example one one test work sentence one work sentence hello test sentence hello test example example hello hello two example hello hello one description sentence one one description two one hello test one example test sentence work sentence test work two one best two hello two sentence test work description description work one example best  end",
//   },
//   {
//     id: 14,
//     type: "Post",
//     authorName: "Ivett",
//     authorCreated: 2020,
//     tags: ["News", "Nature", "Mechanic", "Social"],
//     title: "Alarise Nouakchott",
//     description:
//       "description test two best two two sentence best example one best sentence example two best description description example example best two two one description two one two work best work description work work two example work hello description hello test hello description work sentence work two two description sentence best  to you",
//     view: 9567,
//   },
//   {
//     id: 15,
//     type: "User",
//     authorName: "Alexine",
//     title: "Wesle Nouméa",
//     description:
//       "example one work work work hello sentence work sentence best two best sentence work work best two two example two test two hello work one best work description sentence sentence example work  end",
//   },
// ];
