function createChatBoxElement(info) {
  const newElement = document.createElement("div");
  newElement.setAttribute("id", `chat-id-${info.converstationId}`);
  newElement.className =
    "bg-white mx-2 d-flex flex-column border border-secondary rounded-top";
  newElement.style.width = "250px";
  newElement.style.height = "350px";

  newElement.innerHTML = `<div class="bg-primary p-2 d-flex text-white align-items-center">
                <div class="fs-5 d-flex align-items-center">
                <img src="${
                  "../" + info.target.avatar
                }" class="rounded-circle me-1 border border-primary" style ="height:40px;width:40px;">
                  <div>${info.target.name}</div>
                </div>
                <div class="collapse-chat ms-auto">
                  <i class="btn fas fa-minus fs-4 p-0 text-white"></i>
                </div>
                <div class="close-chat ms-2" >
                    <i class="btn fas fa-times fs-4 p-0 text-white"></i>
                </div>
            </div>
            <div class="chat-box bg-white flex-fill p-2"></div>
            <div class="border-top p-2">
                <textarea placeholder="Send a message" class="chat-input p-1" ${
                  info.converstationId.toString().includes("new")
                    ? `data-new-chat='${info.target.member_id}'`
                    : `data-exist-chat='${info.converstationId}'`
                }></textarea>
            </div>`;
  return newElement;
}

function createInfoMessageElement(target) {
  const newElement = document.createElement("div");
  newElement.className =
    "d-flex flex-column align-items-center justify-content-center my-2";

  // count for handling the number of infor about target (max 2)
  let count = 0;
  newElement.innerHTML = `<img src="${
    "../" + target.avatar
  }" class="rounded-circle border border-primary" style="height:50px;width:50px;">
        <div class="p-1 mx-1 fw-bold">${target.name}</div>
        ${
          target.place && count < 2 && ++count
            ? `<div><span class="fw-bold text-secondary">Place</span>: ${target.place}</div>`
            : ""
        }
        ${
          target.job && count < 2 && ++count
            ? `<div><span class="fw-bold text-secondary">Job</span>: ${target.job}</div>`
            : ""
        }
        ${
          target.subcribe_count && count < 2 && ++count
            ? `<div><span class="fw-bold text-secondary">Sub</span>: ${target.subcribe_count}</div>`
            : ""
        }`;
  return newElement;
}
function createMessageElement(author, content) {
  const isMe = content.created_by == window.user.member_id;
  const date = new Date(content.created_at);
  const { todayFormat, elseFormat, timeZone } = window.config.formatDate;
  const isToday = date.getDate() == new Date(Date.now()).getDate();
  let time = isToday
    ? date.toLocaleTimeString("vi-VN", { ...todayFormat, timeZone })
    : date.toLocaleTimeString("vi-VN", { ...elseFormat, timeZone });
  const newElement = document.createElement("div");
  newElement.className = "chat-message d-flex align-items-center";
  if (isMe) {
    newElement.classList.add("flex-row-reverse");
  }
  newElement.setAttribute("data-message-key", content.sequence);
  newElement.innerHTML = `<img src="../${
    isMe ? window.user.avatar : author.avatar
  }" class="rounded-circle border border-primary">
    <div class=" bg-primary text-white p-1 mx-1 ${
      isToday ? "" : "long-time"
    }" data-time="${time}" 
    >${content.data}</div>`;
  return newElement;
}

function createBubbleChatElement(info) {
  const newElement = document.createElement("div");
  newElement.setAttribute("id", `bubble-id-${info.converstationId}`);
  newElement.className = "bubble-chat my-2";
  newElement.setAttribute("title", info.target.name);
  newElement.innerHTML = `<img src="${
    "../" + info.target.avatar
  }" class="rounded-circle">
  <i class="btn fas fa-times p-0 text-white rounded-circle" ></i>`;
  return newElement;
}

function createConverstationElement(converstationInfo) {
  const { avatar, name, lastSeen } = converstationInfo.target;
  const { data, created_at, sequence } = converstationInfo.messages[0];

  let isSeen = true;
  if (!converstationInfo.lastSeen || converstationInfo.lastSeen < sequence) {
    isSeen = false;
    changeNotiNewMessage(true);
  }
  const newElement = document.createElement("div");
  newElement.className = `converstation p-2 d-flex align-items-center w-100 rounded-3`;
  newElement.setAttribute(
    "data-converstation-id",
    converstationInfo.converstationId
  );
  newElement.setAttribute(
    "last-message-time",
    new Date(created_at).getTime() / 1000
  );
  newElement.setAttribute("last-message-sequence", sequence);

  const time = window.config.getMessageElapsedTime(created_at);
  newElement.innerHTML = `
      <img src="../${avatar}" class="rounded-circle me-1 border border-primary" style ="height:60px;width:60px;">
      <div class="ms-2 w-75">
          <div class="converstation-name fs-5 text-truncate w-100 ${
            isSeen ? "" : "fw-bold"
          }">
              ${name}
          </div>
          <div class="converstation-last-message d-flex justify-content-between w-100 ${
            isSeen ? "text-secondary" : "text-primary fw-bold"
          }" >
              <div class="text-truncate w-50">
                  ${data}
              </div>
              <div>
                ${time.time} ${time.type}
              </div>
          </div>
      </div>
  `;
  return newElement;
}

//handle info abou messenger
// {converstations: list of converstation to store,
//  boxs: list of opening converstation chat box( max 2),
//  bubbles: list of bubble chat( only view top 3)
//  utils: object of handy function to manager messenger }
window.messenger = { utils: {}, converstations: [], boxs: [], bubbles: [] };
const M = window.messenger;

function initConverstationEvent(converstationElement) {
  const converstationInfo = M.converstations.getConverstationById(
    converstationElement.getAttribute("data-converstation-id")
  );
  converstationElement.onclick = () => {
    M.utils.openChatBox(converstationInfo);
    window.messengerAPI
      .updateLastSeen(
        converstationInfo.converstationId,
        converstationInfo.messages[0].sequence
      )
      .then((data) => {
        changeSeenStatus(converstationElement, true);
        changeNotiNewMessage(false);
      });
  };
}

function changeNotiNewMessage(isOn) {
  const notiNewMessageEle = document.getElementById("noti-new-message");
  if (isOn) {
    notiNewMessageEle.classList.remove("d-none");
  } else {
    notiNewMessageEle.classList.add("d-none");
  }
}

function changeSeenStatus(converstationElement, isSeen) {
  const titleEle = converstationElement.querySelector(".converstation-name");
  const lastMessageEle = converstationElement.querySelector(
    ".converstation-last-message"
  );
  if (isSeen) {
    titleEle.classList.remove("fw-bold");
    lastMessageEle.classList.remove("text-primary");
    lastMessageEle.classList.remove("fw-bold");
    lastMessageEle.classList.add("text-secondary");
  } else {
    titleEle.classList.add("fw-bold");
    lastMessageEle.classList.remove("text-secondary");
    lastMessageEle.classList.add("text-primary");
    lastMessageEle.classList.add("fw-bold");
  }
}

async function changeLastMessage(converstationElement, lastMessage) {
  await lastMessage;
  converstationElement.setAttribute(
    "last-message-time",
    new Date(lastMessage.created_at).getTime() / 1000
  );
  converstationElement.setAttribute(
    "last-message-sequence",
    lastMessage.sequence
  );

  const textEle = converstationElement.querySelector(
    ".converstation-last-message div:nth-of-type(1)"
  );
  textEle.innerText = lastMessage.data;

  const timeEle = converstationElement.querySelector(
    ".converstation-last-message div:nth-of-type(2)"
  );
  const timeTextObj = window.config.getMessageElapsedTime(
    lastMessage.created_at
  );
  timeEle.innerText = `${timeTextObj.time} ${timeTextObj.type}`;
}

// handle chat input
function initInputChatBehavior(chatBoxWrapperElement) {
  const chatInput = chatBoxWrapperElement.querySelector(".chat-input");
  // auto height
  chatInput.oninput = (e) => {
    const target = e.target;
    target.style.height = "0px";
    target.style.height = target.scrollHeight + "px";
  };
  // send message
  chatInput.onkeypress = (e) => {
    const target = e.target;
    if (e.key == "Enter" && !e.shiftKey) {
      e.preventDefault();
      if (target.getAttribute("data-new-chat")) {
        // store new converstation on server
        const msgText = target.value;
        const targetId = target.getAttribute("data-new-chat");
        window.messengerAPI.createNewConverstation(targetId).then((data) => {
          target.removeAttribute("data-new-chat");
          target.setAttribute("data-exist-chat", data.converstationId);
          chatBoxWrapperElement.setAttribute(
            "id",
            "chat-id-" + data.converstationId
          );
          // referenced to M.converstations
          const converstationInfo = M.boxs.replaceConverstationIdById(
            "new-" + targetId,
            data.converstationId
          );
          // need add logic about sending that first message
          initChatBoxEvent(converstationInfo);
          console.log(msgText);
          window.messengerAPI
            .sendMessage(
              data.converstationId,
              msgText,
              converstationInfo.target.member_id
            )
            .then((data) => {
              converstationInfo.sequence = data.newCount;
              M.utils.syncConverstationMessages(data.converstationId, [
                data.newMessage,
              ]);
              M.utils.handleRenderConverstationList();
            });
        });
      } else if (target.getAttribute("data-exist-chat")) {
        const converstationId = target.getAttribute("data-exist-chat");
        const converstationInfo =
          M.converstations.getConverstationById(converstationId);
        window.messengerAPI
          .sendMessage(
            converstationId,
            target.value,
            converstationInfo.target.member_id
          )
          .then((data) => {
            console.log(data);
            converstationInfo.sequence = data.newCount;
            M.utils.syncConverstationMessages(converstationId, [
              data.newMessage,
            ]);
          });
      }
      target.value = "";
      target.style.height = "0px";
      target.style.height = target.scrollHeight + "px";
    }
  };
}

function initChatBoxEvent(converstationInfo) {
  const chatBoxWrapperElement = document.getElementById(
    "chat-id-" + converstationInfo.converstationId
  );

  const collapse = chatBoxWrapperElement.querySelector(".collapse-chat");
  collapse.onclick = () => {
    const bubbleInfo = M.boxs.removeConverstationById(
      converstationInfo.converstationId
    );
    M.utils.collapseToBubble(bubbleInfo);
  };

  const closeEle = chatBoxWrapperElement.querySelector(".close-chat");
  closeEle.onclick = () => {
    chatBoxWrapperElement.remove();
    M.boxs.removeConverstationById(converstationInfo.converstationId);
  };

  chatBoxElement = chatBoxWrapperElement.querySelector(".chat-box");
  chatBoxElement.onscroll = (e) => {
    if (!converstationInfo.pullingHistory && e.target.scrollTop <= 10) {
      converstationInfo.pullingHistory = true;
      console.log("pulling");
      const oldestSequence = chatBoxElement
        .querySelector(".chat-message")
        .getAttribute("data-message-key");
      const messages = M.utils.requestMessageFromTabStore(
        converstationInfo.converstationId,
        oldestSequence
      );
      handleRenderChatBoxMessages(converstationInfo.converstationId, messages);

      // pull history
    }
  };

  initInputChatBehavior(chatBoxWrapperElement);
}

// reuse code
M.utils.initChatBoxElement = (converstationInfo) => {
  if (
    M.boxs.getIndexOfConverstationById(converstationInfo.converstationId) > -1
  ) {
    return;
  }
  const ChatBoxFrame = createChatBoxElement(converstationInfo);
  document.getElementById("converstation-list").appendChild(ChatBoxFrame);
  M.boxs.push(converstationInfo);

  // if too many, collapse converstation to bubble list
  const maxCurrentChatBox = 2;
  if (M.boxs.length > maxCurrentChatBox) {
    const bubbleInfo = M.boxs.shift();
    M.utils.collapseToBubble(bubbleInfo);
  }
  initChatBoxEvent(converstationInfo);
};

// handle open new converstation ( won't store to db until send message)
M.utils.openNewChatBox = (targetInfo) => {
  const newConverstation = {
    converstationId: "new-" + targetInfo.member_id,
    target: targetInfo,
  };
  // check unique
  if (
    M.converstations.getIndexOfConverstationById(
      newConverstation.converstationId
    ) < 0
  ) {
    M.converstations.push(newConverstation);
  }
  M.utils.initChatBoxElement(newConverstation);
  const newChatBoxElement = document.getElementById(
    `chat-id-${newConverstation.converstationId}`
  );
  newChatBox = newChatBoxElement.querySelector(".chat-box");
  newChatBox.appendChild(createInfoMessageElement(targetInfo));
};

M.utils.openChatBox = (converstationInfo) => {
  if (
    M.converstations.getIndexOfConverstationById(
      converstationInfo.converstationId
    ) < 0
  ) {
    M.converstations.push(converstationInfo);
  }
  let bubbleConverstation = M.bubbles.getConverstationById(
    converstationInfo.converstationId
  );
  if (bubbleConverstation) {
    M.utils.reopenFromBubble(bubbleConverstation);
    return;
  }
  M.utils.initChatBoxElement(converstationInfo);
  const messages = M.utils.requestMessageFromTabStore(
    converstationInfo.converstationId
  );
  handleRenderChatBoxMessages(converstationInfo.converstationId, messages);
};

// handle bubble
M.utils.collapseToBubble = (bubbleInfo) => {
  document.getElementById("chat-id-" + bubbleInfo.converstationId).remove();
  M.bubbles.push(bubbleInfo);
  const BubbleChatFrame = createBubbleChatElement(bubbleInfo);
  document.getElementById("bubble-list").appendChild(BubbleChatFrame);

  const bubbleChat = document.getElementById(
    "bubble-id-" + bubbleInfo.converstationId
  );
  // reopen event
  bubbleChat.onclick = () => {
    let chatInfo = M.bubbles.removeConverstationById(
      bubbleInfo.converstationId
    );
    bubbleChat.remove();
    M.utils.reopenFromBubble(chatInfo);
  };
  // close event
  const closeBtn = bubbleChat.querySelector("i");
  closeBtn.onclick = (e) => {
    e.stopPropagation();
    M.bubbles.removeConverstationById(bubbleInfo.converstationId);
    bubbleChat.remove();
  };
};
M.utils.reopenFromBubble = (converstationInfo) => {
  M.utils.initChatBoxElement(converstationInfo);
  const messages = M.utils.requestMessageFromTabStore(
    converstationInfo.converstationId,
    9999
  );
  handleRenderChatBoxMessages(converstationInfo.converstationId, messages);
};

M.utils.handleRenderConverstationList = () => {
  const converstationList = document.getElementById("message-list");
  for (let i = 0; i < M.converstations.length; i++) {
    const converstationListElement =
      converstationList.querySelectorAll(".converstation");
    const converstationElement =
      converstationListElement.findPositionConverstation(
        M.converstations[i].converstationId
      );
    // not exsit then create
    if (!converstationElement) {
      const newConverstationElement = createConverstationElement(
        M.converstations[i]
      );
      console.log(M.converstations[i].messages[0].sequence);
      converstationList.appendChild(newConverstationElement);
      initConverstationEvent(newConverstationElement);
    } else {
      // exist then update
      console.log(M.converstations[i].messages[0].sequence);
      console.log(converstationElement.getAttribute("last-message-sequence"));
      if (
        converstationElement.getAttribute("last-message-sequence") <
        M.converstations[i].messages[0].sequence
      ) {
        changeLastMessage(
          converstationElement,
          M.converstations[i].messages[0]
        );
      }
    }
  }
  M.utils.sortConverstationList();
};

M.utils.sortConverstationList = () => {
  const converstationList = document.getElementById("message-list");
  const childNodes = converstationList.querySelectorAll(".converstation");
  const newArray = [];
  for (let i = 0; i < childNodes.length; i++) {
    newArray.push(childNodes[i]);
  }

  newArray.sort((a, b) => {
    return (
      b.getAttribute("last-message-time") - a.getAttribute("last-message-time")
    );
  });
  newArray.forEach((element) => {
    converstationList.appendChild(element);
  });
};

function handleRenderChatBoxMessages(converstationId, messages) {
  const chatBoxWrappperElement = document.getElementById(
    "chat-id-" + converstationId
  );
  if (!chatBoxWrappperElement) {
    return;
  }
  const converstationInfo =
    M.converstations.getConverstationById(converstationId);
  const chatBoxElement = chatBoxWrappperElement.querySelector(".chat-box");

  const isScrollBottom =
    chatBoxElement.scrollHeight -
      chatBoxElement.scrollTop -
      chatBoxElement.offsetHeight <=
    10;

  for (let i = 0; i < messages.length; i++) {
    const messagesListElement =
      chatBoxElement.querySelectorAll(".chat-message");
    const relevantNode = messagesListElement.findPositionMessage(
      messages[i].sequence
    );
    if (!relevantNode) {
      const messageNode = createMessageElement(
        converstationInfo.target,
        messages[i]
      );
      chatBoxElement.appendChild(messageNode);
    } else if (
      relevantNode.getAttribute("data-message-key") == messages[i].sequence
    ) {
      continue;
    } else if (
      relevantNode.getAttribute("data-message-key") > messages[i].sequence
    ) {
      const messageNode = createMessageElement(
        converstationInfo.target,
        messages[i]
      );
      chatBoxElement.insertBefore(messageNode, relevantNode);
    } else {
      const messageNode = createMessageElement(
        converstationInfo.target,
        messages[i]
      );
      chatBoxElement.insertBefore(messageNode, relevantNode.nextSibling);
    }
    // add info message
    if (messages[i].sequence <= 1) {
      chatBoxElement.prepend(
        createInfoMessageElement(converstationInfo.target)
      );
    }
    if (isScrollBottom) {
      M.utils.scrollToBottom(chatBoxElement);
    }
    // reset pulling status
    if (messages.length > 0) {
      converstationInfo.pullingHistory = false;
    }
  }
}

M.utils.requestConverstationInfoFromServer = () => {};
M.utils.requestConverstationInfoFromHostTab = () => {};

M.utils.scrollToBottom = (chatBoxElement) => {
  chatBoxElement.scrollTo(
    0,
    chatBoxElement.scrollHeight - chatBoxElement.offsetHeight
  );
};

// request from this tab => host => server

M.utils.requestMessageFromServer = (
  converstationId,
  sequence = null, // mean auto get lastest
  count = 10
) => {
  return window.messengerAPI
    .getMessagesBySequence(converstationId, sequence, count)
    .then((data) => {
      //logic sync in this tab (main)
      console.log("request from server");
      console.log(data);
      M.utils.syncConverstationMessages(converstationId, data);
      M.utils.handleRenderConverstationList();
      return data;
    });
};

//pull from host tab which is main connection to server
M.utils.requestMessageFromHostTab = (converstationId, sequence, count = 10) => {
  // if this tab is host => request to server, else request to host
  if (window.socket.instance) {
    M.utils.requestMessageFromServer(converstationId, sequence, count);
    return;
  }
  window.tabManager.requestMessages(converstationId, sequence, count);
};

// pull from own tab data
M.utils.requestMessageFromTabStore = (
  converstationId,
  sequence = 500000,
  count = 10
) => {
  const converstationInfo =
    M.converstations.getConverstationById(converstationId);

  if (
    !converstationInfo ||
    !converstationInfo.messages ||
    !converstationInfo.messages.length
  ) {
    //request to host tab
    M.utils.requestMessageFromHostTab(converstationId, sequence, count);
    return [];
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
    // if isn't enough messages (count) from local then check host tab
    if (converstationInfo.messages.length - firstSequenceMeet < count) {
      M.utils.requestMessageFromHostTab(converstationId, sequence, count);
      return [];
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
  // login handle sync messages
  console.log("request from tab");
  console.log(messageList);
  return messageList;
};

M.utils.syncConverstations = (converstations) => {
  // loop incoming converstations
  for (let i = 0; i < converstations.length; i++) {
    const converstationInfo = M.converstations.getConverstationById(
      converstations[i]
    );
    if (!converstationInfo) {
      M.converstations.push(converstations[i]);
    } else {
      // check first message
      if (
        converstations[i].messages[0].sequence >
        converstationInfo.messages[0].sequence
      ) {
        converstationInfo.messages.unshift(converstations[i].messages[0]);
      }
      // general info
      converstationInfo.sequence = converstations[i].sequence;
      converstationInfo.lastSeen = converstations[i].lastSeen;
      converstationInfo.target = converstations[i].target;
    }
  }
  M.converstations.sort(window.config.sortByLastMessage);
};

M.utils.syncConverstationMessages = async (converstationId, messages) => {
  let converstationInfo =
    M.converstations.getConverstationById(converstationId);
  if (!converstationInfo) {
    console.error("converstation not exist");
    converstationInfo = {
      converstationId: converstationId,
    };
    M.converstations.push(converstationInfo);
  }
  if (!converstationInfo.messages) {
    converstationInfo.messages = [];
  }
  let incomingLargestSequence = messages[0].sequence;
  let startInsert;
  for (
    startInsert = 0;
    startInsert < converstationInfo.messages.length;
    startInsert++
  ) {
    if (
      converstationInfo.messages[startInsert].sequence <=
      incomingLargestSequence
    ) {
      break;
    }
  }
  // loop incoming messages
  for (let i = 0; i < messages.length; i++, startInsert++) {
    if (!converstationInfo.messages[startInsert]) {
      // add incoming to end of local
      converstationInfo.messages.push(messages[i]);
      continue;
    }
    const sequenceOfCurrent = converstationInfo.messages[startInsert].sequence;
    const sequenceOfIncoming = messages[i].sequence;
    if (sequenceOfCurrent == sequenceOfIncoming) {
      continue;
    } else if (sequenceOfCurrent < sequenceOfIncoming) {
      // insert incoming to this position of local (startInsert)
      converstationInfo.messages.splice(startInsert, 0, messages[i]);
      continue;
    }
  }
  // render to chat box
  if (M.boxs.getIndexOfConverstationById(converstationId) > -1) {
    handleRenderChatBoxMessages(converstationId, messages);
  }
};
window.addEventListener("load", () => {});
