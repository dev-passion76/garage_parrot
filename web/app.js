window.addEventListener("DOMContentLoaded", function () {
  document.querySelector(".paper_plane").addEventListener("click", function () {
    var formulaire = document.querySelector("form");
    formulaire.classList.remove("hidden");
  });
});
