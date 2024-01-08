async function insert() {
  let fn = document.getElementById("fn").value;
  let ln = document.getElementById("ln").value;
  let email = document.getElementById("email").value;
  let pwd = document.getElementById("pwd").value;
  let pwdR = document.getElementById("pwdR").value;

  document.getElementById("fn-input").style.color = !fn ? "red" : "black";
  document.getElementById("ln-input").style.color = !ln ? "red" : "black";
  document.getElementById("email-input").style.color = !email ? "red" : "black";
  document.getElementById("pwd-input").style.color = !pwd ? "red" : "black";
  document.getElementById("pwdR-input").style.color = !pwdR ? "red" : "black";

  document.getElementById("mensagem").innerText =
    pwd !== pwdR ? "As duas palavras passe não são iguais !!" : "";

  if (fn && ln && email && pwd && pwdR && pwd === pwdR) {
    const user = {
      fn: fn,
      ln: ln,
      email: email,
      password: pwd,
    };

    try {
      const response = await fetch("api/users/add", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify(user),
      });

      if (response.ok) {
        Swal.fire({
          position: "top-end",
          icon: "success",
          title: "Sucesso ao registar !!",
          showConfirmButton: false,
          timer: 3000,
        });

        setTimeout(() => {
          document.location.href = "login.html";
        }, 3500);
      }

      if (response.status === 409) {
        document.getElementById("mensagem").innerText =
          "O email que pretende registar já se encontra registado !!";
      }

      if (response.status === 500) {
        document.getElementById("mensagem").innerText =
          "Algo inesperado aconteceu, por favor tente mais tarde !!";
      }
    } catch (error) {
      document.getElementById("mensagem").innerText =
        "Algo inesperado aconteceu, por favor tente mais tarde !!";
    }
  }
}

async function login() {
  let email = document.getElementById("mailuid").value;
  let pwd = document.getElementById("pwd").value;

  document.getElementById("email-input").style.color = !email ? "red" : "black";
  document.getElementById("pwd-input").style.color = !pwd ? "red" : "black";

  document.getElementById("mensagem").innerText =
    !email && !pwd ? "Preencha todos os campos !!" : "";

  if (email && pwd) {
    let user = {
      email: email,
      password: pwd,
    };

    try {
      const response = await fetch("api/users/login", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify(user),
      });

      if (response.ok) {
        Swal.fire({
          position: "top-end",
          icon: "success",
          title: "Login Sucesso!!",
          showConfirmButton: false,
          timer: 3000,
        });

        setTimeout(() => {
          document.location.href = "index.php";
        }, 3500);
      }

      if (response.status === 404) {
        document.getElementById("mensagem").innerText =
          "Endereço de email inexistente !!";
      }

      if (response.status === 401) {
        document.getElementById("mensagem").innerText = "Password incorreta !!";
      }

      if (response.status === 500) {
        document.getElementById("mensagem").innerText =
          "Algo inesperado aconteceu, por favor tente mais tarde !!";
      }
    } catch (error) {
      document.getElementById("mensagem").innerText =
        "Algo inesperado aconteceu, por favor tente mais tarde !!";
    }
  }
}

async function logout() {
  Swal.fire({
    title: "Deseja fazer logout ?",
    showDenyButton: true,
    showCancelButton: false,
    confirmButtonText: "Sim",
    denyButtonText: `Não`,
  }).then(async (result) => {
    if (result.isConfirmed) {
      await fetch(`kill.php`);
      setTimeout(() => {
        document.location.href = "index.php";
      }, 1000);
    }
  });
}

function openPopup() {
  // Faz a chamada AJAX para buscar os dados do usuário
  fetch(`api/users/${id}`, {
    method: "GET",
    headers: {
      "Content-Type": "application/json",
    },
  })
    .then((response) => response.json())
    .then((data) => {
      const user = data;

      Swal.fire({
        title: "Editar perfil",
        html: `<input type="text" id="primeiroNome" class="swal2-input" placeholder="Primeiro Nome" value="${user.primeiro_nome}">
              <input type="text" id="ultimoNome" class="swal2-input" placeholder="Ultimo Nome" value="${user.ultimo_nome}">
              <input type="email" id="email" class="swal2-input" placeholder="Email" value="${user.email}">
              <input type="password" id="password" class="swal2-input" placeholder="Senha" value="${user.password}">
              <input type="text" id="sobre" class="swal2-input" placeholder="Sobre" value="${user.sobre != null ? user.sobre : ""}">`,
        showCancelButton: true,
        confirmButtonText: "Salvar",
        cancelButtonText: "Cancelar",
        reverseButtons: true,
        preConfirm: () => {
          const email = Swal.getPopup().querySelector("#email").value;
          const password = Swal.getPopup().querySelector("#password").value;
          const primeiro_nome =
            Swal.getPopup().querySelector("#primeiroNome").value;
          const ultimo_nome =
            Swal.getPopup().querySelector("#ultimoNome").value;
          const sobre = Swal.getPopup().querySelector("#sobre").value;
          const object = {
            id: id,
            email: email,
            password: password,
            fn: primeiro_nome,
            ln: ultimo_nome,
            sobre: sobre,
          };
          console.log(object);
          return object;
        },
      }).then((result) => {
        if (result.isConfirmed) {
          const data = {
            id: id,
            email: result.value.email,
            password: result.value.password,
            fn: result.value.fn,
            ln: result.value.ln,
            sobre: result.value.sobre,
            imagem_perfil: result.value.imagem_perfil,
          };

          // Faz a chamada AJAX para atualizar o perfil do usuário
          fetch("api/users/atualiza", {
            method: "POST",
            body: JSON.stringify(data),
            headers: {
              "Content-Type": "application/json",
            },
          })
            .then((response) => response.json())
            .then((data) => {
              Swal.fire({
                title: "Sucesso",
                text: "Perfil atualizado com sucesso!",
                icon: "success",
                confirmButtonText: "OK",
              });
              getInfo(user.id);
            })
            .catch((error) => {
              Swal.fire({
                title: "Erro",
                text: "Erro ao atualizar o perfil: " + error,
                icon: "error",
                confirmButtonText: "OK",
              });
            });
        }
      });
    })
    .catch((error) => {
      Swal.fire({
        title: "Erro",
        text: "Erro ao carregar os dados do perfil: " + error,
        icon: "error",
        confirmButtonText: "OK",
      });
    });
}


function performClick(elemId) {
  let elem = document.getElementById(elemId);
  if (elem && document.createEvent) {
    var evt = document.createEvent("MouseEvents");
    evt.initEvent("click", true, false);
    elem.dispatchEvent(evt);
  }
  $("#image").change(function () { openA() });
}

async function openA() {
  const data = new FormData()
  const image = document.getElementById("image")

  data.append("image", image.files[0])

  const allowedImages = ['jpg', 'png', 'jpge']
  if (!allowedImages.includes(getFileExtension(image.files[0].name))) {
    Swal.fire({
      title: "Erro",
      text: "Tipo de Ficheiros Incorreto: ",
      icon: "error",
      confirmButtonText: "OK",
    });
    return
  }

  const response = await fetch(`api/users/add_img/${id}`, {
    method: 'POST',
    body: data
  });

  if (response.ok) {
    Swal.fire({
      title: "Sucesso",
      text: "Imagem Inserida com sucesso!",
      icon: "success",
      confirmButtonText: "OK",
    }).then(() => {
      setTimeout(() => {
        location.reload()
      }, 500);
    });
  }
}

function getInfo(userID) {
  fetch("api/users/" + userID)
    .then((response) => response.json())
    .then((data) => {
      console.log(data);
      const dataJSON = data;
      document.getElementById("sobre-content").innerHTML = data.sobre;
      document.getElementById("nome-content").innerHTML =
        data.primeiro_nome + " " + data.ultimo_nome;
      return data;
    })
    .catch((error) => {
      console.error("Error:", error);
    });
}
function getItens(userID) {
  fetch("api/itens/leiloesativos/" + userID)
    .then((response) => response.json())
    .then((data) => {
      console.log(data);
      $("#leiloesAtivos").DataTable({
        data: data,
        columns: [
          { title: "ID", data: "id" },
          { title: "Titulo", data: "titulo" },
          { title: "Descricao", data: "descricao" },
          { title: "Preço inicial", data: "primeira_licitacao" },
          { title: "Preco compra", data: "comprar_agora_preco" },
          { title: "Licitação atual", data: "licitacao_corrente" },
          { title: "Número de licitações", data: "num_licitacoes" },
          { title: "Fim do leilão", data: "data_final" },
        ],
      });
    })
    .catch((error) => {
      console.error("Error:", error);
    });
}

function getItensRecentes(userID) {
  console.log(userID + "ID DO USER")
  fetch("api/itens/leiloesrecentes/" + userID)
    .then((response) => response.json())
    .then((data) => {

      console.log(data);
      console.log(userID + "ID DO USER")
      $("#leiloesRecentes").DataTable({
        data: data,
        columns: [
          { title: "ID", data: "id" },
          { title: "Titulo", data: "titulo" },
          { title: "Descricao", data: "descricao" },
          { title: "Preço inicial", data: "primeira_licitacao" },
          { title: "Preço Licitado", data: "valor" },
          { title: "Licitação atual", data: "licitacao_corrente" },
          { title: "Número de licitações", data: "num_licitacoes" },
          { title: "Fim do leilão", data: "data_final" },
        ],
      });
    })
    .catch((error) => {
      console.error("Error:", error);
    });
}
async function getImagemPerfil() {
  const image = document.getElementById("perfil_img")
  const response = await fetch(`uploads/user_images/user_${id}`);
  if (response.ok) {
    image.src = `uploads/user_images/user_${id}`
  } else {
    image.src = `assets/img/place.png`
  }
}

function getFileExtension(filename) {
  const extension = filename.split('.').pop();
  return extension;
}

document
  .getElementById("signup-submit")
  ?.addEventListener("click", () => insert());
document
  .getElementById("login-submit")
  ?.addEventListener("click", () => login());
document.getElementById("logout")?.addEventListener("click", () => logout());
document.getElementById("back")?.addEventListener("click", () => {
  window.history.back();
});
