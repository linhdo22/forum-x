// handle information aboud socketio
// { host: is this tab host,
//    instance: socket instance ,
//    status: online or offline(prevent use localstorage too much)}
window.socket = { server: "http://localhost:3000", status: "" };

window.socket.initInstanceEvent = function () {
  const { handleMessengerStatus } = window.tabManager;
  if (window.socket.instance) {
    const socketInstance = window.socket.instance;
    socketInstance.on("connect", () => {
      localStorage.setItem("socket-status", "connected");
      handleMessengerStatus(false);
    });
    socketInstance.on("disconnect", () => {
      localStorage.setItem("socket-status", "disconnected");
      handleMessengerStatus(true);
    });
    socketInstance.on("connect_error", (error) => {
      localStorage.setItem("socket-status", "disconnected");
      handleMessengerStatus(true);
    });
    socketInstance.on("have-new-messages", async ({ converstationId }) => {
      if (!M.converstations.getConverstationById(converstationId)) {
        const targetInfo = await window.messengerAPI.getConverstationTarget(
          converstationId
        );
        if (targetInfo.error) {
          console.error(targetInfo.error);
          return;
        }
        M.converstations.push({
          converstationId,
          target: targetInfo,
        });
      }
      const converstation =
        window.messenger.converstations.getConverstationById(converstationId);
      window.messenger.utils.initChatBoxElement(converstation);

      window.messenger.utils.requestMessageFromServer(
        converstationId,
        9999,
        10
      );
    });
  } else {
    if (localStorage.getItem("socket-status") == "connected") {
      handleMessengerStatus(false);
    } else {
      handleMessengerStatus(true);
    }
  }
};
window.addEventListener("load", () => {
  const { initTab, connectSocket } = window.tabManager;
  initTab();
  connectSocket();
});
