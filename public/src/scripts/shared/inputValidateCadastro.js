let form = document.querySelector("form");
let nome = document.getElementById("nome");
let email = document.getElementById("email");
let pass = document.getElementById("password");
let cpf = document.getElementById("cpf");
let avatar = document.getElementById("avatar");
let flash = document.querySelector(".flashMessages");

function validateEmail(email) {
  alert(email);
}

form.addEventListener("submit", (e) => {
  const emailValue = email.value.trim();
  const passValue = pass.value.trim();

  if (!emailValue || !passValue || !cpf || !nome) {
    flash.innerHTML =
      "<h3 style='text-align: center;'>Preencha Todos os Campos</h3>";

    nome.style.borderColor = "red";
    email.style.borderColor = "red";
    pass.style.borderColor = "red";
    cpf.style.borderColor = "red";
    avatar.style.borderColor = "red";

    e.preventDefault();
  }
});
