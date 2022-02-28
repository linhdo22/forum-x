function handleRequestMessages(converstationId, sequence, count = 10) {
  const converstationInfo =
    window.messenger.converstations.getConverstationById(converstationId);

  if (
    !converstationInfo ||
    !converstationInfo.messages ||
    !converstationInfo.messages.length
  ) {
    //request to server
    window.messenger.utils
      .requestMessageFromServer(converstationId, sequence, count)
      .then((data) => {
        window.tabManager.responseMessages(converstationId, data);
      });
    return;
  }
  let firstSequenceMeet = converstationInfo.messages.length;

  for (let i = 0; i < converstationInfo.messages.length; i++) {
    if (converstationInfo.messages[i].sequence <= sequence) {
      firstSequenceMeet = i;
      break;
    }
  }

  // if local data isn't top message
  if (
    converstationInfo.messages[converstationInfo.messages.length - 1]
      .sequence != 1
  ) {
    // if isn't enough messages (count) from local then check server
    if (converstationInfo.messages.length - firstSequenceMeet < count) {
      window.messenger.utils
        .requestMessageFromServer(converstationId, sequence, count)
        .then((data) => {
          window.tabManager.responseMessages(converstationId, data);
        });
      return;
    }
  }
  // pull from this tab
  let messageList = [];
  const rangeList = Math.min(
    count,
    converstationInfo.messages.length - firstSequenceMeet
  );
  for (let j = 0; j < rangeList; j++, firstSequenceMeet++) {
    messageList.push(converstationInfo.messages[firstSequenceMeet]);
  }
  console.log(messageList);
  window.tabManager.responseMessages(converstationId, messageList);
}

function handleSyncConverstationInfo({ converstationId, target }) {
  const index =
    window.messenger.converstations.getConverstationById(converstationId);
  if (index < 0) {
    window.messenger.converstations.push({ converstationId, target });
  }
}

window.tabManager = {};
window.tabManager.handleMessengerStatus = (isOff = true) => {
  const MessageTitle = document.getElementById("messenger-title");
  // prevent user click before get status of messenger server
  MessageTitle.classList.remove("disabled");
  if (isOff) {
    // prevent re-assign
    if (window.socket.status !== "offline") {
      MessageTitle.classList.remove("btn-primary");
      MessageTitle.classList.add("btn-danger");
      MessageTitle.title = "Messenger server not available";
      window.socket.status = "offline";
    }
    console.log("status offline");
  } else {
    // prevent re-assign
    if (window.socket.status !== "online") {
      MessageTitle.classList.remove("btn-danger");
      MessageTitle.title = "";
      MessageTitle.classList.add("btn-primary");
      window.socket.status = "online";
    }
    console.log("status online");
  }
};
window.tabManager.initTab = () => {
  window.name = new Date().getTime();
  const rawTabs = localStorage.getItem("tabs");
  let tabs = [];
  if (rawTabs) {
    tabs = JSON.parse(rawTabs);
  }
  tabs.push(window.name);
  localStorage.setItem("tabs", JSON.stringify(tabs));
};

window.tabManager.removeTab = () => {
  const tabs = JSON.parse(localStorage.getItem("tabs"));
  localStorage.setItem(
    "tabs",
    JSON.stringify(tabs.filter((tab) => tab != window.name))
  );
};

window.tabManager.getTopTabId = () => {
  return JSON.parse(localStorage.getItem("tabs"))[0];
};

window.tabManager.connectSocket = (text) => {
  if (!localStorage.getItem("socket") && window.user) {
    fetch("/forum/jwt.php", {
      method: "GET",
    })
      .then((response) => {
        return response.text();
      })
      .then((data) => {
        localStorage.setItem("jwt", data);
        socket.instance = io("http://localhost:3000", {
          auth: {
            token: data,
          },
        });
        localStorage.setItem("socket", window.name);
        console.log("this host");
        window.socket.initInstanceEvent();
        window.messengerAPI.getConverstations().then((data) => {
          M.utils.syncConverstations(data);
          window.messenger.utils.handleRenderConverstationList();
        });
      });
  } else if (window.user) {
    window.socket.initInstanceEvent();
    window.tabManager.requestConverstationInfos();
  }
};

window.tabManager.requestConverstationInfos = () => {
  window.tabManager.requestingConverstationInfos = true;
  localStorage.setItem("request-converstation-infos", true);
  localStorage.removeItem("request-converstation-infos");
};
window.tabManager.responseConverstationInfos = () => {
  const converstations = window.messenger.converstations;
  localStorage.setItem(
    "response-converstation-infos",
    JSON.stringify(converstations)
  );
  localStorage.removeItem("response-converstation-infos");
};

window.tabManager.requestMessages = (converstationId, sequence, count = 10) => {
  window.tabManager.requestingMessages = true;
  localStorage.setItem(
    "request-messages",
    JSON.stringify({ converstationId, sequence, count })
  );
  localStorage.removeItem("request-messages");
};

window.tabManager.responseMessages = (converstationId, data) => {
  localStorage.setItem(
    "response-messages",
    JSON.stringify({ converstationId, data })
  );
  localStorage.removeItem("response-messages");
};

window.tabManager.syncConverstationInfo = ({ converstationId, target }) => {
  localStorage.setItem(
    "sync-converstation-info",
    JSON.stringify({ converstationId, target })
  );
  localStorage.removeItem("sync-converstation-info");
};

window.addEventListener("storage", (e) => {
  const { connectSocket, getTopTabId, handleMessengerStatus } =
    window.tabManager;
  if (window.user) {
    if (e.storageArea["socket-status"] == "connected") {
      handleMessengerStatus(false);
    } else {
      handleMessengerStatus(true);
    }
  }

  if (e.key == "msg" && e.newValue) {
    console.log(e.newValue);
  }
  if (e.key == "socket" && !e.newValue) {
    if (window.name == getTopTabId()) {
      connectSocket();
    }
  }
  if (
    e.key == "request-converstation-infos" &&
    e.newValue &&
    window.socket.instance
  ) {
    console.log("responing info");
    window.tabManager.responseConverstationInfos();
  }
  if (
    e.key == "response-converstation-infos" &&
    e.newValue &&
    window.tabManager.requestingConverstationInfos
  ) {
    const converstation = JSON.parse(e.newValue);
    console.log(converstation);
    M.utils.syncConverstations(converstation);
    window.messenger.utils.handleRenderConverstationList();
    window.tabManager.requestingConverstationInfos = false;
  }
  if (e.key == "request-messages" && e.newValue && window.socket.instance) {
    const { converstationId, sequence, count } = JSON.parse(e.newValue);
    handleRequestMessages(converstationId, sequence, count);
  }
  if (
    e.key == "response-messages" &&
    e.newValue &&
    window.tabManager.requestingMessages
  ) {
    window.tabManager.requestingMessages = false;
    const { converstationId, data } = JSON.parse(e.newValue);
    console.log("request from host");
    console.log(data);
    // handle sync messages
    window.messenger.utils.syncConverstationMessages(converstationId, data);
  }
  if (e.key == "sync-converstation-info" && e.newValue) {
    handleSyncConverstationInfo(JSON.parse(e.newValue));
  }
});

window.addEventListener("unload", (e) => {
  window.tabManager.removeTab();
  if (socket.instance) {
    localStorage.removeItem("socket");
  }
});
