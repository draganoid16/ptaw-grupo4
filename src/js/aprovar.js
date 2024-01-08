async function getPorAprovar() {
    const response = await fetch("api/itens/avaliar")

    if (response.ok) {
        let json = await response.json()

        json.forEach(obj => {
            let li = document.createElement("li");
            li.className = "list-group-item d-flex justify-content-between align-items-center";

            let b = document.createElement("b");
            b.textContent = obj['titulo'];

            let a = document.createElement("a");
            a.className = "btn btn-blue";
            a.href = `avaliacao.php?id=${obj.id}`;
            a.textContent = "Avaliar";

            li.appendChild(b);
            li.appendChild(a);

            document.getElementById('inserir').appendChild(li)
        });
    }
}

getPorAprovar()