let form = document.querySelector("form");
let email = document.getElementById("email");
let flash = document.querySelector(".flashMessages");

function validateEmail(email) {
  alert(email);
}

form.addEventListener("submit", (e) => {
  const emailValue = email.value.trim();

  if (!emailValue) {
    flash.innerHTML =
      "<h3 style='text-align: center;'>Preencha o Campo de Email</h3>";

    email.style.borderColor = "red";

    email.addEventListener("click", () => {
      email.style.borderColor = "black";
    });

    e.preventDefault();
  }
});
