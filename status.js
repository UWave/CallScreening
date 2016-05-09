function unpark() {
  fetch('action.php', {
    method: "POST",
    credentials: 'same-origin',
    body: JSON.stringify({
      action: "unpark",
      spot: this.dataset.spot
    })
  });
}

function processUpdate(data) {
  $(".parked_call").remove();
  data.parked.each(function(call) {
    var row = $("<tr>").data("call", call.call).data("spot", call.spot).addClass("parked_call");
    row.append($("<td>").text(call.caller_id_number).addClass("caller_id_number").addClass('row_style0'));
    row.append($("<td>").text(call.caller_id_name).addClass("caller_id_name").addClass('row_style0'));
    row.append($("<td>").text(call.description).addClass("description").addClass('row_style1'));
    row.append($("<td>").text("-").addClass("actions").addClass('row_style1'));
    $(".parked_list").append(row);
    row.on('click', unpark);
  });
  if(data.current_call !== null) {
    $(".current_call").html("<b class=\"call_active\">On the phone with " + data.current_call.cid_name + " (" + data.current_call.cid_num + ")");
  } else {
    $(".current_call").html("No one on the phone currently");
  }
  setTimeout(update, 1000);
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
