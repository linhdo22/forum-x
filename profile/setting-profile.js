// avatar
window.addEventListener("load", () => {
  document
    .getElementById("upload-avatar-btn")
    .addEventListener("click", uploadAvatar);

  const inputAvatar = document.getElementById("input-avatar");
  const modalAvatar = document.getElementById("modal-avatar");
  const avatarHelp = document.getElementById("avatarHelp");

  const avatarSetting = document.getElementById("avatar-setting");
  avatarSetting.addEventListener("click", () => {
    inputAvatar.value = "";
    modalAvatar.src = avatarSetting.src;
  });

  inputAvatar.addEventListener("change", (e) => {
    avatarHelp.classList.remove("text-danger");
    if (!["image/jpeg", "image/png"].includes(inputAvatar.files[0].type)) {
      avatarHelp.classList.add("text-danger");
      return;
    }
    modalAvatar.src = URL.createObjectURL(inputAvatar.files[0]);
  });
});

function uploadAvatar() {
  const inputAvatar = document.getElementById("input-avatar");
  if (!inputAvatar.files[0]) {
    return;
  }
  const form_data = new FormData();

  form_data.append("avatar", inputAvatar.files[0]);
  form_data.append("userId", window.user.member_id);
  fetch("../upload-image/upload-avatar.php", {
    method: "POST",
    body: form_data,
  })
    .then(function (response) {
      return response.json();
    })
    .then(function (responseData) {
      if (responseData.status == "success") {
        document.getElementById("avatar-setting").src =
          "../" + responseData.image_source;
      }
    });
}

// info
let infoToast;
window.addEventListener("load", () => {
  infoToast = new bootstrap.Toast(document.getElementById("info-toast"), {
    delay: 10000,
  });
  document
    .getElementById("apply-info-btn")
    .addEventListener("click", applyInfo);
});

function applyInfo() {
  let description = "";
  let place = "";
  let job = "";
  let birth = null;
  if (document.getElementById("info-desc-cb").checked) {
    description = document.getElementById("info-desc-value").value;
  }
  if (document.getElementById("info-place-cb").checked) {
    place = document.getElementById("info-place-value").value;
  }
  if (document.getElementById("info-job-cb").checked) {
    job = document.getElementById("info-job-value").value;
  }
  if (document.getElementById("info-birth-cb").checked) {
    birth = document.getElementById("info-birth-value").value;
  }
  const form_data = new FormData();
  form_data.append("update-info", 1);
  form_data.append("desc", description);
  form_data.append("place", place);
  form_data.append("job", job);
  form_data.append("birth", birth);
  form_data.append("memberId", window.user.member_id);
  fetch("./xuly-profile.php", {
    method: "POST",
    body: form_data,
  })
    .then((response) => {
      return response.json();
    })
    .then((data) => {
      console.log(data);
      if (data) {
        console.log(infoToast);
        infoToast.show();
      }
    });
}

//contacts
let contactToast;
window.addEventListener("load", () => {
  contactToast = new bootstrap.Toast(document.getElementById("contact-toast"), {
    delay: 10000,
  });
  document
    .getElementById("apply-contacts-btn")
    .addEventListener("click", applyContacts);
});
function applyContacts() {
  let facebook = "";
  let youtube = "";
  let linkedin = "";
  let stackOverflow = "";

  let facebookCB = document.getElementById("contact-facebook-cb").checked;
  let youtubeCB = document.getElementById("contact-youtube-cb").checked;
  let linkedinCB = document.getElementById("contact-linkedin-cb").checked;
  let stackOverFlowCB = document.getElementById(
    "contact-stack-overflow-cb"
  ).checked;
  if (facebookCB) {
    facebook = document.getElementById("contact-facebook-value").value;
  }
  if (youtubeCB) {
    youtube = document.getElementById("contact-youtube-value").value;
  }
  if (linkedinCB) {
    linkedin = document.getElementById("contact-linkedin-value").value;
  }
  if (stackOverFlowCB) {
    stackOverflow = document.getElementById(
      "contact-stack-overflow-value"
    ).value;
  }
  const form_data = new FormData();
  form_data.append("update-contacts", 1);
  form_data.append(
    "facebook",
    JSON.stringify({ value: facebook, public: facebookCB ? 1 : 0 })
  );
  form_data.append(
    "youtube",
    JSON.stringify({ value: youtube, public: youtubeCB ? 1 : 0 })
  );
  form_data.append(
    "linkedin",
    JSON.stringify({ value: linkedin, public: linkedinCB ? 1 : 0 })
  );
  form_data.append(
    "stackOverflow",
    JSON.stringify({
      value: stackOverflow,
      public: stackOverFlowCB ? 1 : 0,
    })
  );
  form_data.append("memberId", window.user.member_id);
  fetch("./xuly-profile.php", {
    method: "POST",
    body: form_data,
  })
    .then((response) => {
      return response.json();
    })
    .then((data) => {
      console.log(data);
      if (data) {
        console.log(contactToast);
        contactToast.show();
      }
    });
}
