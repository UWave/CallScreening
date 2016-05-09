function unpark() {
  fetch('action.php', {
    method: "POST",
    credentials: 'same-origin',
    body: JSON.stringify({
      action: "unpark",
      spot: $(this).data('spot')
    })
  });
}

function hangup() {
  fetch('action.php', {
    method: "POST",
    credentials: 'same-origin',
    body: JSON.stringify({
      action: "hangup",
      call: $(this).data('call')
    })
  });
}

function editDescription() {
  var old = $(this).data("description");
  var description = prompt("Please describe this caller", old);
  fetch('action.php', {
    method: "POST",
    credentials: 'same-origin',
    body: JSON.stringify({
      action: "describe",
      call: $(this).data('call'),
      description: description
    })
  });
}

function processUpdate(data) {
  $(".parked_call").remove();
  data.parked.each(function(call) {
    var row = $("<tr>").addClass("parked_call");
    row.append($("<td>").text(call.caller_id_number).addClass("caller_id_number").addClass('row_style0'));
    row.append($("<td>").text(call.caller_id_name).addClass("caller_id_name").addClass('row_style0'));
    row.append($("<td>").text(call.description).addClass("description").addClass('row_style1'));
    var answerButton = $("<button>").text("Answer").data("call", call.call).data("spot", call.spot);
    var hangupButton = $("<button>").text("Hang up").data("call", call.call);
    var describeButton = $("<button>").text("Description").data("description", call.description).data("call", call.call);
    row.append($("<td>").append(answerButton).append(hangupButton).append(describeButton).addClass("actions").addClass('row_style1'));
    $(".parked_list").append(row);
    answerButton.on('click', unpark);
    hangupButton.on('click', hangup);
    describeButton.on('click', editDescription);
  });
  if(data.current_call !== null) {
    var text = $("<b>").text("On the phone with " + data.current_call.cid_name + " (" + data.current_call.cid_num + ")");
    var btn = $("<button>").addClass('btn').text("hang up").data("call", data.current_call.uuid);
    $(".current_call").html($("<p>").append(text).append(" ").append(btn));
    btn.on('click', hangup);
  } else {
    $(".current_call").html("No one on the phone currently");
  }
}

function parseUpdate(response) {
  return response.json();
}

function update() {
  var request = new Request('status.json.php', {
    credentials: 'same-origin'
  });
  fetch(request).then(parseUpdate).then(processUpdate);
}

$(document).ready(update);
setInterval(update, 500);
