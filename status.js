function processUpdate(data) {
  data.parked.each(function(call) {
    var row = $("<tr>").data("call", call.call);
    row.append($("<td>").text(call.caller_id_number).addClass("caller_id_number"));
    row.append($("<td>").text(call.caller_id_name).addClass("caller_id_name"));
    row.append($("<td>").text(call.description).addClass("description"));
    row.append($("<td>").text("-").addClass("actions"));
    $(".parked_list").append(row);
  });
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
