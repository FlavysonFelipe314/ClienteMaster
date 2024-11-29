let listUsers = document.querySelectorAll(".modalCupom");
let TriggerCupom = document.querySelectorAll(".cupom");
let CloseCupom = document.querySelectorAll(".closeCupom");

TriggerCupom.forEach((item, index) => {
  TriggerCupom[index].addEventListener("click", () => {
    listUsers[index].classList.add("apareceCupom");
  });
});

CloseCupom.forEach((item, index) => {
  CloseCupom[index].addEventListener("click", () => {
    listUsers[index].classList.remove("apareceCupom");
  });
});
