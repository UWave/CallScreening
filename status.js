function processUpdate(data) {
  console.log(data);
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
