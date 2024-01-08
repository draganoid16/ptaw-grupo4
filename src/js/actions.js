function catClick(obj) {
  let cats = document.getElementsByClassName("cat");

  for (let i = 0; i < cats.length; i++) {
    cats[i].removeAttribute("id");
    cats[i].style.backgroundColor = "white";
    cats[i].style.color = "black";
  }

  obj.setAttribute("id", "clickedCat");
  obj.style.backgroundColor = "#6b9ac4";
  obj.style.color = "white";
}

async function filter() {
    let cat = document.getElementById('clickedCat') !== null ? document.getElementById('clickedCat').value : '%'
    let min = document.getElementById('min-price').value <= 0 ? 0 : document.getElementById('min-price').value
    let max = document.getElementById('max-price').value <= 0 ? 999999999999999 : document.getElementById('max-price').value

  if (max < min) {
    document.getElementById("mensagem").innerText =
      "O preço máximo tem de ser superior ao mínimo !!";
    return;
  }

  const send = {
    categoria: cat,
    min: min,
    max: max === 0 ? 999999999999999 : max,
  };

  const response = await fetch(
    "api/itens/filter",
    {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify(send),
    }
  );

    if (response.ok) {
        let json = await response.json()

        document.getElementById('inserir').innerHTML = ''
        getItems(json).then(items => {
            items.forEach((item, i) => {
                assemble(i, item);
            });
        });
    }
}

async function sugestoes() {
  let send;
  document.getElementById("mensagem").innerText = "";

  let nome =
    document.getElementById("nome") != null
      ? document.getElementById("nome").value
      : null;
  let email =
    document.getElementById("email") != null
      ? document.getElementById("email").value
      : null;
  let assunto = document.getElementById("assunto").value;
  let mensagem = document.getElementById("message").value;

  if (
    document.getElementById("nome") === null &&
    document.getElementById("email") === null
  ) {
    if (!assunto) {
      document.getElementById("mensagem").innerText =
        "Preencha o campo do assunto !!";
      return;
    }
    const response = await fetch("api/sugestoes", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
        },
        body: JSON.stringify(send)
    })
    if (response.ok) {
        Swal.fire({
            position: 'top-end',
            icon: 'success',
            title: 'Obrigado pela sua sugestão !!',
            showConfirmButton: false,
            timer: 3000
        })
    }

    send = {
      nome: nomeD,
      email: emailD,
      assunto: assunto,
      mensagem: mensagem,
    };
  } else {
    if (!nome) {
      document.getElementById("mensagem").innerText = "Insira o Nome !!";
      return;
    }
    if (!email) {
      document.getElementById("mensagem").innerText = "Insira o email !!";
      return;
    }

    if (!assunto) {
      document.getElementById("mensagem").innerText =
        "Preencha o campo do assunto !!";
      return;
    }
    if (!mensagem) {
      document.getElementById("mensagem").innerText =
        "Preencha o campo da mensagem !!";
      return;
    }

    send = {
      nome: nome,
      email: email,
      assunto: assunto,
      mensagem: mensagem,
    };
  }
  const response = await fetch("api/sugestoes", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(send),
  });
  if (response.ok) {
    Swal.fire({
      position: "top-end",
      icon: "success",
      title: "Obrigado pela sua sugestão !!",
      showConfirmButton: false,
      timer: 3000,
    });
  }
}

async function licitar() {
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    const auction_id = urlParams.get('Leilão');
    const licitacao = document.getElementById("bidAmount").value;

    const response = await fetch(`api/licitacoes/${auction_id}/bid`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ licitacao: licitacao,
          user: id })
    });


    if (response.ok) {
        const text = await response.text();
        try {
            const result = JSON.parse(text);
            if (result.status === 'success') {
              Swal.fire({
                  title: 'Licitacao adicionada com sucesso!',
                  text: 'Sua licitacao foi adicionada.',
                  icon: 'success',
                  confirmButtonText: 'Ok'
              }).then((result) => {
                  if (result.isConfirmed) {
                      location.reload();
                  }
              });
          }          
        } catch (e) {
            console.error('The server response is not valid JSON:', text);
        }
    } else if (response.status === 400){
        Swal.fire({
            title: 'Erro ao adicionar licitacão!',
            text: 'A licitação que introduziu deve ser superior a licitação atual ou o item já foi comprado!',
            icon: 'error',
            confirmButtonText: 'Ok'
        });
    } else {
      Swal.fire({
          title: 'Erro ao adicionar licitacão!',
          text: 'Houve um problema ao adicionar sua licitacao.',
          icon: 'error',
          confirmButtonText: 'Ok'
      });
}
}

async function comprar_agora() {
  const queryString = window.location.search;
  const urlParams = new URLSearchParams(queryString);
  const auction_id = urlParams.get('Leilão');

  const response = await fetch(`api/licitacoes/${auction_id}/buy_now`, {
      method: 'POST',
      headers: {
          'Content-Type': 'application/json'
      }
  });

  const result = await response.json();

  if (response.ok && result.status === 'success') {
      Swal.fire({
          title: 'Compra realizada com sucesso!',
          text: 'O item foi comprado.',
          icon: 'success',
          confirmButtonText: 'Ok'
      }).then((result) => {
          if (result.isConfirmed) {
              location.reload();
          }
      });
  } else if (response.status === 400){
    Swal.fire({
        title: 'Erro ao comprar o item!',
        text: 'O item já foi comprado, por favor volte a pagina anterior!',
        icon: 'error',
        confirmButtonText: 'Ok'
    });
  } else {
      Swal.fire({
          title: 'Erro ao comprar o item!',
          text: 'Houve um problema ao comprar o item.',
          icon: 'error',
          confirmButtonText: 'Ok'
      });
  }

}

document.getElementById("filter")?.addEventListener("click", () => filter());
document.getElementById("enviar")?.addEventListener("click", () => sugestoes());
document.getElementById("submeter")?.addEventListener("click", () => licitar());
document.getElementById("comprar_agora").addEventListener("click", () => comprar_agora());