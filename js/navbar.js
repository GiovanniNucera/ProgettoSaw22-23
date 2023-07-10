 document.addEventListener('DOMContentLoaded', function (event) {
    let el = document.getElementById("menu-toggler");
    el.addEventListener("click", function() {document.body.classList.toggle("menu-active");});
  });
