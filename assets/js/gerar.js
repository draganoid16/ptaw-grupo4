async function getItems(data) {

    if (!data) {
        let response = await fetch('api/itens');
        data = await response.json();
    }

    // Filter data based on conditions
    let filteredData = data.filter(item => {
        let dateParts = item.data_final.split(/[- :]/);
        let date_final = new Date(Date.UTC(dateParts[0], dateParts[1] - 1, dateParts[2], dateParts[3], dateParts[4], dateParts[5]));
        let currentDate = new Date();
        return item.estado == "aprovado" && date_final > currentDate;
    });

    return filteredData;
}



function randomIntFromInterval(min, max) { // min and max included
    return Math.floor(Math.random() * (max - min + 1) + min)
}

function corpo(item) {
    let section = document.createElement("div");
    section.setAttribute("class", "card-body");

    let a = document.createElement("a");
    a.setAttribute("class", "h4 text-decoration-none text-dark");
    a.setAttribute("href", "shop-single.php");
    a.innerHTML = `<b>${item.titulo}</b>`;

    let hr1 = document.createElement("hr");

    let bidInfoDiv = document.createElement("div");
    bidInfoDiv.setAttribute("class", "d-flex justify-content-between align-items-center mb-3");

    let currentBidDiv = document.createElement("div");
    currentBidDiv.innerHTML = `<i class="bi bi-currency-euro"></i> <b>Licitação Atual:</b> <br> <span> <b class="text-blue font-weight-bold h5">${item.licitacao_corrente != null ? item.licitacao_corrente : "0"}€</b></span>`;

    let buyNowDiv = document.createElement("div");
    buyNowDiv.innerHTML = `<i class="bi bi-basket"></i> <b>Comprar Agora:</b> <br> <span> <b class="text-blue font-weight-bold h5">${item.comprar_agora_preco}€</b></span>`;

    bidInfoDiv.appendChild(currentBidDiv);
    bidInfoDiv.appendChild(buyNowDiv);

    let hr2 = document.createElement("hr");

    let timeBidsDiv = document.createElement("div");
    timeBidsDiv.setAttribute("class", "my-flex align-items-center mb-3");

    let timeLeftDiv = document.createElement("div");
    let timeLeft = getDateDiff(new Date(item.data_final));
    timeLeftDiv.innerHTML = `<i class="bi bi-clock"></i> <b>Tempo Restante: <br><span>${timeLeft}</b></span>`;

    let bidsDiv = document.createElement("div");
    bidsDiv.innerHTML = `<i class="bi bi-person"></i> <b>Licitações: <br> <span>${item.num_licitacoes != null ? item.num_licitacoes : "0"}</b></span>`;

    timeBidsDiv.appendChild(timeLeftDiv);
    timeBidsDiv.appendChild(bidsDiv);

    let bidButton = document.createElement("a");
    bidButton.setAttribute("class", "btn btn-blue w-100");
    bidButton.setAttribute("href", "shop-single.php?Leilão=" + encodeURIComponent(JSON.stringify(item.id)) + "&TempoRestante=" + encodeURIComponent(timeLeft));
    bidButton.innerText = "Licitar / Comprar";
    bidButton.innerText = "Licitar / Comprar";

    section.appendChild(a);
    section.appendChild(hr1);
    section.appendChild(bidInfoDiv);
    section.appendChild(hr2);
    section.appendChild(timeBidsDiv);
    section.appendChild(bidButton);

    return section;
}

async function imagem(num, item) {


    let carousel = document.createElement("div");
    carousel.setAttribute("id", `card-${num}`)
    carousel.setAttribute("class", "carousel slide");
    carousel.setAttribute("data-bs-ride", "carousel");
    carousel.setAttribute("data-bs-interval", `${randomIntFromInterval(5000, 15000)}`);

    let inner = await carrouselInner(item.id);

    let btn1 = document.createElement("button");
    btn1.setAttribute("class", "carousel-control-prev bg-transparent border-transparent");
    btn1.setAttribute("type", "button");
    btn1.setAttribute("data-bs-target", `#card-${num}`);
    btn1.setAttribute("data-bs-slide", "prev");
    btn1.innerHTML = `<span class="carousel-control-prev-icon" aria-hidden="true"></span>`;

    let btn2 = document.createElement("button");
    btn2.setAttribute("class", "carousel-control-next bg-transparent border-transparent");
    btn2.setAttribute("type", "button");
    btn2.setAttribute("data-bs-target", `#card-${num}`);
    btn2.setAttribute("data-bs-slide", "next");
    btn2.innerHTML = `<span class="carousel-control-next-icon" aria-hidden="true"></span>`;

    carousel.appendChild(inner);
    carousel.appendChild(btn1);
    carousel.appendChild(btn2);
    return carousel;
}

async function carrouselInner(id) {
    console.log(id)

    let response = await fetch(`api/images/count/${id}`);
    let data = await response.json();
    console.log(data);

    let div = document.createElement("div");
    div.setAttribute("class", "carousel-inner");


    for (let i = 1; i <= data.count; i++) {
        let item = document.createElement("div");
        item.setAttribute("class", "carousel-item");
        item.style = "height: 220px"
        item.innerHTML = `<img src="uploads/images/${id}_${i}" class="d-block w-100 img-fluid" alt="...">`
        div.appendChild(item);
    }

    div.firstElementChild.classList.add('active')

    return div;
}

async function assemble(num, item) {
    let div = document.createElement("div");
    div.setAttribute("class", "cartao col-12 col-md-4 mb-5 rd");

    let card = document.createElement("div");
    card.setAttribute("class", "card h-100");

    div.appendChild(card);
    card.appendChild(await imagem(num, item));
    card.appendChild(corpo(item)); // Passed item as argument

    document.getElementById("inserir").appendChild(div);
}


getItems().then(items => {
    items.forEach((item, i) => {
        assemble(i, item);
    });
});


//funções para lidar com conversões e diferenças de horas
const timeUnits = {
    ano: 31536e6,
    mes: 2592e6,
    semana: 6048e5,
    dia: 864e5,
    hora: 36e5,
    minuto: 6e4,
    segundo: 1e3,
};

const isFuture = (date) => date > Date.now();

const dateDiffStructure = (date, units = timeUnits) => {
    let delta = Math.abs(date - Date.now());
    return Object.entries(units).reduce((acc, [key, value]) => {
        acc[key] = Math.floor(delta / value);
        delta -= acc[key] * value;
        return acc;
    }, {});
};

const getDateDiff = (date) => {
    const diffStructure = dateDiffStructure(date);
    const diffStructureEntries = Object.entries(diffStructure).filter(([, value]) => value);
    if (!diffStructureEntries.length) return 'agora mesmo';
    const suffix = isFuture(date) ? '' : 'atrás';
    const diffString = diffStructureEntries.reduce((acc, [key, value]) => {
        const timeUnit = value > 1 ? ` ${key}s` : ` ${key}`;
        acc = acc ? `${acc} ` : '';
        // return `${acc}${value}${timeUnit}`;
        return `${acc}${value}${key.toUpperCase().charAt(0)}${timeUnit.toUpperCase().charAt(0)}`;
    }, '');
    return `${diffString} ${suffix}`;
};
