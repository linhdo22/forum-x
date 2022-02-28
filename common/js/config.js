// store format date
window.config = {};
window.config.formatDate = {
  timeZone: Intl.DateTimeFormat().resolvedOptions().timeZone,
  todayFormat: { hour: "numeric", minute: "numeric" },
  elseFormat: {
    hour: "2-digit",
    minute: "2-digit",
    year: "numeric",
    month: "long",
    day: "numeric",
  },
};

window.config.getMessageElapsedTime = function (date) {
  const timeElapsed = (Date.now() - new Date(date).getTime()) / 1000; // second
  let timeElapsedObject = {};
  for (let i = 0; i < 5; i++) {
    let tempTimeElapsed;
    switch (i) {
      case 0: // year
        tempTimeElapsed = Math.floor(timeElapsed / 30240000);
        type = "year";
        break;
      case 1: // week
        tempTimeElapsed = Math.floor(timeElapsed / 604800);
        type = "week";
        break;
      case 2: // day
        tempTimeElapsed = Math.floor(timeElapsed / 86400);
        type = "day";
        break;
      case 3: // hour
        tempTimeElapsed = Math.floor(timeElapsed / 3600);
        type = "hour";
        break;
      case 4: // minute
        tempTimeElapsed = Math.floor(timeElapsed / 60);
        type = "minute";
        break;
    }
    if (tempTimeElapsed > 0) {
      timeElapsedObject = {
        time: tempTimeElapsed,
        type,
      };
      break;
    }
    if (i == 4) {
      timeElapsedObject = {
        time: 1,
        type: "minute",
      };
    }
  }
  return timeElapsedObject;
};

window.config.sortByLastMessage = (a, b) => {
  const timeA = new Date(a.messages[0].created_at);
  const timeB = new Date(b.messages[0].created_at);
  return timeB.getTime() - timeA.getTime();
};

// override function
Array.prototype.getIndexOfConverstationById = function (converstationId) {
  for (let i = 0; i < this.length; i++) {
    if (this[i].converstationId == converstationId) {
      return i;
    }
  }
  return -1;
};

Array.prototype.getConverstationById = function (converstationId) {
  const index = this.getIndexOfConverstationById(converstationId);
  if (index < 0) {
    return null;
  }
  return this[index];
};

Array.prototype.removeConverstationById = function (removeId) {
  let converstation = null;
  for (let i = 0; i < this.length; i++) {
    if (this[i].converstationId == removeId) {
      converstation = this[i];
      this.splice(i, 1);
      break;
    }
  }
  return converstation;
};

Array.prototype.replaceConverstationIdById = function (before, after) {
  let converstation = null;
  for (let i = 0; i < this.length; i++) {
    if (this[i].converstationId == before) {
      converstation = this[i];
      this[i].converstationId = after;
      break;
    }
  }
  return converstation;
};

// messages
function binarySearchMessageNodeList(array, left, right, sequence, lastNode) {
  if (left <= right) {
    let mid = Math.floor((left + right) / 2);
    if (array[mid].getAttribute("data-message-key") == sequence) {
      return array[mid];
    } else if (array[mid].getAttribute("data-message-key") > sequence) {
      return binarySearchMessageNodeList(
        array,
        left,
        mid - 1,
        sequence,
        array[mid]
      );
    } else {
      return binarySearchMessageNodeList(
        array,
        mid + 1,
        right,
        sequence,
        array[mid]
      );
    }
  }
  return lastNode;
}

NodeList.prototype.findPositionMessage = function (sequence) {
  if (this.length == 0) {
    return null;
  }
  return binarySearchMessageNodeList(this, 0, this.length - 1, sequence, null);
};

// converstation
NodeList.prototype.findPositionConverstation = function (converstationId) {
  for (let i = 0; i < this.length; i++) {
    if (this[i].getAttribute("data-converstation-id") == converstationId) {
      return this[i];
    }
  }
  return null;
};
