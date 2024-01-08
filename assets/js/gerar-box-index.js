function randomIntFromInterval(min, max) {
  // min and max included
  return Math.floor(Math.random() * (max - min + 1) + min);
}

function corpo() {
  let section = document.createElement("div");
  section.setAttribute("class", "card-body");

  let a = document.createElement("a");
  a.setAttribute("class", "h4 text-decoration-none text-dark");
  a.setAttribute("href", "shop-single.html");
  a.innerHTML = "<b>Exemplo arte 133</b>";

  let hr1 = document.createElement("hr");

  let bidInfoDiv = document.createElement("div");
  bidInfoDiv.setAttribute(
    "class",
    "d-flex justify-content-between align-items-center mb-3"
  );

  let currentBidDiv = document.createElement("div");
  currentBidDiv.innerHTML =
    '<i class="bi bi-currency-euro"></i> <b>Licitação Atual:</b> <span> <b class="text-primary font-weight-bold h5">480.00€</b></span>';

  let buyNowDiv = document.createElement("div");
  buyNowDiv.innerHTML =
    '<i class="bi bi-basket"></i> <b>Comprar Agora:</b> <span> <b class="text-primary font-weight-bold h5">1000.00€</b></span>';

  bidInfoDiv.appendChild(currentBidDiv);
  bidInfoDiv.appendChild(buyNowDiv);

  let hr2 = document.createElement("hr");

  let timeBidsDiv = document.createElement("div");
  timeBidsDiv.setAttribute(
    "class",
    "d-flex justify-content-between align-items-center mb-3"
  );

  let timeLeftDiv = document.createElement("div");
  timeLeftDiv.innerHTML =
    '<i class="bi bi-clock"></i> <b>Tempo Restante: <span>5 dias, 3 horas</b></span>';

  let bidsDiv = document.createElement("div");
  bidsDiv.innerHTML =
    '<i class="bi bi-person"></i> <b>Licitações: <span>10</b></span>';

  timeBidsDiv.appendChild(timeLeftDiv);
  timeBidsDiv.appendChild(bidsDiv);

  let bidButton = document.createElement("a");
  bidButton.setAttribute("class", "btn btn-primary w-100");
  bidButton.setAttribute("href", "shop-single.html");
  bidButton.innerText = "Licitar";

  section.appendChild(a);
  section.appendChild(hr1);
  section.appendChild(bidInfoDiv);
  section.appendChild(hr2);
  section.appendChild(timeBidsDiv);
  section.appendChild(bidButton);

  return section;
}

function imagem(num) {
  let carousel = document.createElement("div");
  carousel.setAttribute("id", `card-${num}`);
  carousel.setAttribute("class", "carousel slide");
  carousel.setAttribute("data-bs-ride", "carousel");
  carousel.setAttribute(
    "data-bs-interval",
    `${randomIntFromInterval(5000, 15000)}`
  );

  let inner = carrouselInner();

  let btn1 = document.createElement("button");
  btn1.setAttribute(
    "class",
    "carousel-control-prev bg-transparent border-transparent"
  );
  btn1.setAttribute("type", "button");
  btn1.setAttribute("data-bs-target", `#card-${num}`);
  btn1.setAttribute("data-bs-slide", "prev");
  btn1.innerHTML = `<span class="carousel-control-prev-icon" aria-hidden="true"></span>`;

  let btn2 = document.createElement("button");
  btn2.setAttribute(
    "class",
    "carousel-control-next bg-transparent border-transparent"
  );
  btn2.setAttribute("type", "button");
  btn2.setAttribute("data-bs-target", `#card-${num}`);
  btn2.setAttribute("data-bs-slide", "prev");
  btn2.innerHTML = `<span class="carousel-control-next-icon" aria-hidden="true"></span>`;

  carousel.appendChild(inner);
  carousel.appendChild(btn1);
  carousel.appendChild(btn2);
  return carousel;
}

function carrouselInner(nImages, urls) {
  let div = document.createElement("div");
  div.setAttribute("class", "carousel-inner");

  let item1 = document.createElement("div");
  item1.setAttribute("class", "carousel-item active");
  item1.innerHTML = `<img src="./assets/img/old/adam.jpg" class="d-block w-100 img-fluid" alt="...">`;

  let item2 = document.createElement("div");
  item2.setAttribute("class", "carousel-item");
  item2.innerHTML = `<img src="./assets/img/old/imagem.jpg" class="d-block w-100 img-fluid" alt="...">`;

  let item3 = document.createElement("div");
  item3.setAttribute("class", "carousel-item");
  item3.innerHTML = `<img src="./assets/img/old/guernica.jpg" class="d-block w-100 img-fluid" alt="...">`;

  div.appendChild(item1);
  div.appendChild(item2);
  div.appendChild(item3);

  return div;
}

function assemble(num) {
  let div = document.createElement("div");
  div.setAttribute("class", "col-12 col-md-3 mb-5 rd");

  let card = document.createElement("div");
  card.setAttribute("class", "card h-100");

  div.appendChild(card);
  card.appendChild(imagem(num));
  card.appendChild(corpo());

  document.getElementById("inserir").appendChild(div);
}

for (let i = 0; i < 3; i++) {
  assemble(i);
}
