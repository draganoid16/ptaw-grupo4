async function avaliar() {
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);

    let titulo = document.getElementById('titulo')
    let compra = document.getElementById('compra')
    let autor = document.getElementById('autor')
    let desc = document.getElementById('desc')
    let data_sub = document.getElementById('data_sub')


    const response = await fetch(`api/itens/${urlParams.get('id')}`)


    if (response.ok) {
        let item = await response.json()

        titulo.innerText = item.titulo
        compra.innerText = item.comprar_agora_preco + " €"
        desc.innerText = item.descricao
        data_sub.innerText = item.data_sub

        const userR = await fetch(`api/users/${item.vendedor_id}`)
        if (userR.ok) {
            let user = await userR.json()
            autor.innerText = `${user.primeiro_nome} ${user.ultimo_nome}`
        }

        const countR = await fetch(`api/file/count/${item.id}`)
        if (countR.ok) {
            let count = await countR.json()

            for (let i = 1; i <= count.count; i++) {

                let li = document.createElement("li");
                li.className = "list-group-item";

                let ie = document.createElement("i");
                ie.className = "fa fa-file-text-o";
                ie.setAttribute("aria-hidden", "true");

                let b = document.createElement("b");
                b.textContent = `Documento ${i}`;

                let a = document.createElement("a");
                a.href = `uploads/files/${item.id}_${i}`;
                a.target = "_blank"
                a.className = "btn btn-blue btn-sm float-end";
                a.textContent = "Visualizar";

                li.appendChild(ie);
                li.appendChild(b);
                li.appendChild(a);

                document.getElementById('inserir').appendChild(li)
            }
        }

        const imageR = await fetch(`api/images/count/${item.id}`)
        if (imageR.ok) {
            let count = await imageR.json()
            let carroca = document.getElementById("carroca")

            for (let i = 1; i <= count.count; i++) {

                let div = document.createElement("div");
                div.setAttribute("class", "carousel-item");

                let img = document.createElement("img");
                img.src = `uploads/images/${item.id}_${i}`;
                img.className = "d-block w-100";
                div.appendChild(img)
                carroca.appendChild(div)
            }
            carroca.firstElementChild.classList.add('active')
        }
    }
}

async function aceitar() {
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);

    Swal.fire({
        title: 'Deseja aceitar o produto ?',
        showDenyButton: true,
        showCancelButton: false,
        confirmButtonText: 'Sim',
        denyButtonText: `Não`,
    }).then(async (result) => {
        if (result.isConfirmed) {
            const response = await fetch(`api/itens/avaliar/aceitar/${urlParams.get('id')}`)
            if (response.ok) {
                setTimeout(() => {
                    document.location.href = "perfilavaliador.php"
                }, 500);
            }
        }
    })
}


async function rejeitar() {
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);

    Swal.fire({
        title: 'Deseja rejeitar o produto ?',
        showDenyButton: true,
        showCancelButton: false,
        confirmButtonText: 'Sim',
        denyButtonText: `Não`,
    }).then(async (result) => {
        if (result.isConfirmed) {
            const response = await fetch(`api/itens/avaliar/rejeitar/${urlParams.get('id')}`)
            if (response.ok) {
                setTimeout(() => {
                    document.location.href = "perfilavaliador.php"
                }, 500);
            }
        }
    })
}

document.getElementById("aceitar")?.addEventListener('click', () => aceitar())
document.getElementById("rejeitar")?.addEventListener('click', () => rejeitar())
avaliar()