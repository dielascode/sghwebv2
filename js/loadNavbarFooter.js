fetch("./components/top_bottom/navbar.php")
  .then((res) => res.text())
  .then((data) => {
    document.getElementById("navbar").innerHTML = data;

    const navbarCollapse = document.querySelector(".navbar-collapse");

    const normalLinks = document.querySelectorAll(
      "#navbar a:not(.dropdown-toggle):not(.dropdown-item)",
    );

    normalLinks.forEach((link) => {
      link.addEventListener("click", () => {
        if (navbarCollapse.classList.contains("show")) {
          navbarCollapse.classList.remove("show");
        }
      });
    });

    const dropdownItems = document.querySelectorAll("#navbar .dropdown-item");

    dropdownItems.forEach((item) => {
      item.addEventListener("click", () => {
        if (navbarCollapse.classList.contains("show")) {
          navbarCollapse.classList.remove("show");
        }
      });
    });
  });

fetch("./components/top_bottom/footer.php")
  .then((res) => res.text())
  .then((data) => {
    document.getElementById("footer").innerHTML = data;
  });

document
  .querySelectorAll(".navbar-nav .nav-link, .dropdown-item")
  .forEach(function (el) {
    el.addEventListener("click", function () {
      var navbar = document.querySelector(".navbar-collapse");
      var bsCollapse = new bootstrap.Collapse(navbar, { toggle: false });
      bsCollapse.hide();
    });
  });
