function processUpdate(data) {
  console.log(data);
}

function parseUpdate(response) {
  return response.json();
}

function update() {
  fetch('status.json.php').then(parseUpdate).then(processUpdate);
}

$(document).ready(update);
