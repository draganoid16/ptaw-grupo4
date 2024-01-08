async function insert() {
    let title = document.getElementById("title").value;
    let images = document.getElementById("images");
    let description = document.getElementById("description").value;
    let authDocuments = document.getElementById("authDocuments");
    let start_bid = document.getElementById("start_bid").value;
    let buy_now_price = document.getElementById("buy_now_price").value;
    let start_time = document.getElementById("start_time").value;
    let end_time = document.getElementById("end_time").value;
    let categoria = document.getElementById("categorias").value;

    document.getElementById("ltitle").style.color = !title ? "red" : "black";
    document.getElementById("limages").style.color = images.files.length == 0 ? "red" : "black";
    document.getElementById("ldescription").style.color = !description ? "red" : "black";
    document.getElementById("lauthDocuments").style.color = authDocuments.files.length == 0 ? "red" : "black";
    document.getElementById("lstart_bid").style.color = !start_bid ? "red" : "black";
    document.getElementById("lbuy_now_price").style.color = !buy_now_price ? "red" : "black";
    document.getElementById("lstart_time").style.color = !start_time ? "red" : "black";
    document.getElementById("lend_time").style.color = !end_time ? "red" : "black";
    document.getElementById("lcategoria").style.color = !categoria ? "red" : "black";

    if (title && images.files.length != 0 && description && authDocuments.files.length != 0 && start_bid && buy_now_price && start_time && end_time && categoria) {
        document.getElementById("mensagem").innerText = ""
        start_time = `${start_time.replace('T', ' ')}:00`
        end_time = `${end_time.replace('T', ' ')}:00`

        let star_time_data = new Date(start_time)
        let end_time_data = new Date(end_time)

        let hoje = new Date();
        hoje.setDate(hoje.getDate() + 2)

        if (star_time_data < hoje) {
            document.getElementById("mensagem").innerText = "Um leilão só pode começar daqui a dois dias !!"
            return
        }

        if (end_time_data <= star_time_data) {
            document.getElementById("mensagem").innerText = "A data de fim de leilão não pode ser menor que a data de inicio !!"
            return
        }

        const data = new FormData();

        const item = {
            "titulo": title,
            "desc": description,
            "id": id,
            "lInicial": start_bid,
            "Pvenda": buy_now_price,
            "DataComeco": start_time,
            "DataFim": end_time,
            "categoria": categoria
        }

        const allowedImages = ['jpg', 'png', 'jpge']
        for (const image of images.files) {

            if (!allowedImages.includes(getFileExtension(image.name))) {
                document.getElementById("mensagem").innerText = "Verifique a extensão das imagens que inseriu !!"
                document.getElementById("limages").style.color = "red"
                return
            }
            data.append('images[]', image, image.name);
        }

        const allowedFiles = ['pdf']
        for (const file of authDocuments.files) {
            if (!allowedFiles.includes(getFileExtension(file.name))) {
                document.getElementById("mensagem").innerText = "Verifique a extensão dos arquivos que inseriu !!"
                document.getElementById("lauthDocuments").style.color = "red"
                return
            }
            data.append('files[]', file, file.name);
        }

        Object.entries(item).map(([key, value]) =>
            data.append(`data[${key}]`, value)
        );

        try {

            const response = await fetch("api/itens/add", {
                method: 'POST',
                body: data,
                type: 'application/json'
            });

            if (response.ok) {

                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Item adicionado com Sucesso. Este vai ser agora submetido para avaliação !!',
                    showConfirmButton: false,
                    timer: 3000
                })
            }

            if (response.status === 500) {
                document.getElementById("mensagem").innerText = "Algo inesperado aconteceu, por favor tente mais tarde !!"
            }
        } catch (error) {
            document.getElementById("mensagem").innerText = "Algo inesperado aconteceu, por favor tente mais tarde !!"
        }
    } else {
        document.getElementById("mensagem").innerText = "Preencha todos os campos para inserir !"
    }
}

function getFileExtension(filename) {

    const extension = filename.split('.').pop();
    return extension;
}

document.getElementById("submit-item")?.addEventListener('click', () => insert())
