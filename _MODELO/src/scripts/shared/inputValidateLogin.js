let form = document.querySelector("form");
let email = document.getElementById("email");
let pass = document.getElementById("password");
let flash = document.querySelector(".flashMessages");

function validateEmail(email) {
  alert(email);
}

form.addEventListener("submit", (e) => {
  const emailValue = email.value.trim();
  const passValue = pass.value.trim();

  if (!emailValue || !passValue) {
    flash.innerHTML =
      "<h3 style='text-align: center;'>Preencha Todos os Campos</h3>";

    email.style.borderColor = "red";
    pass.style.borderColor = "red";

    e.preventDefault();
  } else if (!emailValue) {
    flash.innerHTML =
      "<h3 style='text-align: center;'>Preencha o Campo de Email</h3>";

    email.style.borderColor = "red";

    email.addEventListener("click", () => {
      email.style.borderColor = "black";
    });

    e.preventDefault();
  } else if (!passValue) {
    flash.innerHTML =
      "<h3 style='text-align: center;'>Preencha o Campo de Senha</h3>";
    pass.style.borderColor = "red";

    pass.addEventListener("click", () => {
      email.style.borderColor = "black";
    });

    e.preventDefault();
  }
});
