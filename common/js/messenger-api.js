window.messengerAPI = {
  createNewConverstation: function (target) {
    const data = {
      target,
    };
    return fetch(`${window.socket.server}/converstation/create`, {
      method: "POST",
      body: JSON.stringify(data),
      headers: {
        authorization: localStorage.getItem("jwt"),
      },
    }).then((response) => response.json());
  },
  getConverstations: function () {
    return fetch(`${window.socket.server}/converstation/get-list`, {
      method: "GET",
      headers: {
        authorization: localStorage.getItem("jwt"),
      },
    }).then(function (response) {
      return response.json();
    });
  },
  getConverstationId: function () {
    if (window.socket.status == "offline") {
      console.log("server offline");
      return;
    }
    return fetch(
      `${
        window.socket.server
      }/converstation/get-by-member?target=${getParameterByName("profile")}`,
      {
        method: "GET",
        headers: {
          authorization: localStorage.getItem("jwt"),
        },
      }
    ).then(function (response) {
      return response.json();
    });
  },
  getConverstationTarget: function (converstationId) {
    if (window.socket.status == "offline") {
      console.log("server offline");
      return;
    }
    return fetch(
      `${window.socket.server}/converstation/get-target-info?converstationId=${converstationId}`,
      {
        method: "GET",
        headers: {
          authorization: localStorage.getItem("jwt"),
        },
      }
    ).then(function (response) {
      return response.json();
    });
  },
  updateLastSeen: function (converstationId, lastSeen) {
    return fetch(`${window.socket.server}/converstation/update-last-seen`, {
      method: "PUT",
      headers: {
        authorization: localStorage.getItem("jwt"),
      },
      body: JSON.stringify({
        converstationId,
        lastSeen,
      }),
    }).then((response) => response.json());
  },
  getMessagesByTime: function (converstationId, timestamp) {
    return fetch(
      `${window.socket.server}/message/get-by-time?converstationId=${converstationId}&timestamp=${timestamp}`,
      {
        method: "GET",
        headers: {
          authorization: localStorage.getItem("jwt"),
        },
      }
    ).then((response) => response.json());
  },
  getMessagesBySequence: function (converstationId, sequence, count = 10) {
    return fetch(
      `${window.socket.server}/message/get-by-sequence?converstationId=${converstationId}&sequence=${sequence}&count=${count}`,
      {
        method: "GET",
        headers: {
          authorization: localStorage.getItem("jwt"),
        },
      }
    ).then((response) => response.json());
  },
  sendMessage: function (converstationId, data, targetId) {
    return fetch(`${window.socket.server}/message/send-message`, {
      method: "POST",
      headers: {
        authorization: localStorage.getItem("jwt"),
      },
      body: JSON.stringify({
        converstationId,
        data,
        targetId,
      }),
    }).then((response) => response.json());
  },
  getUserInfo: function (targetId) {
    return fetch(`${window.socket.server}/user/get?target=${targetId}`, {
      headers: {
        authorization: localStorage.getItem("jwt"),
      },
    }).then((response) => response.json());
  },
};
