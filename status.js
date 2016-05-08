function processUpdate(data) {
  $(".parked_call").remove();
  data.parked.each(function(call) {
    var row = $("<tr>").data("call", call.call).addClass("parked_call");
    row.append($("<td>").text(call.caller_id_number).addClass("caller_id_number").addClass('row_style0'));
    row.append($("<td>").text(call.caller_id_name).addClass("caller_id_name").addClass('row_style0'));
    row.append($("<td>").text(call.description).addClass("description").addClass('row_style1'));
    row.append($("<td>").text("-").addClass("actions"));
    $(".parked_list").append(row);
  });
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
