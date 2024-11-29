let modal = document.querySelector(".modalForm");
let nome = document.querySelector("input[name=name]");
let email = document.querySelector("input[name=email]");
let birthdate = document.querySelector("input[name=birthdate]");
let total = document.querySelector("input[name=total]");
let submit = document.querySelector(".w100-submit");

function showForm(id, id_user, action) {
  modal.classList.add("showForm");

  if ((id, id_user)) {
    fetch(
      `http://localhost/Sistema_clientMaster/api/get${encodeURIComponent(
        action
      )}?id=${encodeURIComponent(id)}&id_user=${encodeURIComponent(id_user)}`,
      {
        method: "GET",
        headers: {
          "Content-type": "application/x-www-form-urlencoded",
        },
      }
    )
      .then((response) => {
        if (!response.ok) {
          throw new Error(`Erro: ${response.status}`);
        }
        return response.json();
      })
      .then((data) => {
        console.log(data);
        switch (action) {
          case "Cliente":
            nome.value = data.nome;
            email.value = data.email;
            birthdate.value = data.birthdate;
            break;

          case "User":
            nome.value = data.nome;
            email.value = data.email;
            birthdate.value = data.birthdate;
            break;

          case "Cupom":
            nome.value = data.nome;
            total.value = data.total;
            break;
        }

        submit.innerHTML = `
        <input type="hidden" name="id" value="${data.id}" />
        <button type="submit" name="action" value="update">Editar</button>
        `;
      })
      .catch((error) => {
        console.error("Erro na requisição:", error);
      });
  }
  submit.innerHTML = `<button type="submit" name="action" value="create">Cadastrar</button>`;

  switch (action) {
    case "Cliente":
      nome.value = "";
      email.value = "";
      birthdate.value = "";
      break;

    case "Cupom":
      nome.value = "";
      total.value = "";
      break;
  }
}

function closeForm() {
  modal.classList.remove("showForm");
}
