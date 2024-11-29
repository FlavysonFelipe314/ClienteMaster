var menuIcon = document.querySelector(".menu-hamburguer i");
var menuBody = document.getElementById("menu-bar");
var close = document.querySelector(".close");
var siteBody = document.getElementById("site-body");

menuIcon.addEventListener("click", () => {
  if (menuBody.classList.contains("toogleMenu")) {
    menuBody.classList.remove("toogleMenu");
    siteBody.classList.remove("resizeBody");
  } else {
    menuBody.classList.add("toogleMenu");
    siteBody.classList.add("resizeBody");
  }
});

close.addEventListener("click", () => {
  if (menuBody.classList.contains("toogleMenu")) {
    menuBody.classList.remove("toogleMenu");
    siteBody.classList.remove("resizeBody");
  } else {
    menuBody.classList.add("toogleMenu");
    siteBody.classList.add("resizeBody");
  }
});
