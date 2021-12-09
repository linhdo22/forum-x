window.addEventListener("load", () => {
  const createBtn = document.getElementById("create-btn");
  const postTitle = document.getElementById("post-title");
  //   const createBtn = document.getElementById("create-btn");
  createBtn.addEventListener("click", () => {
    console.log(tinymce.get("textarea").getContent());
  });
});
