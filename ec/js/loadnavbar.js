function loadPage(page) {
  fetch(page)
    .then(res => res.text())
    .then(data => {
      document.getElementById("conten").innerHTML = data;
    })
    .catch(err => console.log(err));
}