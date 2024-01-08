async function single_images() {
  let object = JSON.parse(item)
  let carroca = document.getElementById("carroca")

  let response = await fetch(`api/images/count/${object.id}`);
  let data = await response.json();

  for (let i = 1; i <= data.count; i++) {
    let item = document.createElement("div");
    item.setAttribute("class", "carousel-item");
    item.style = "height: 520px"
    item.innerHTML = `<img src="uploads/images/${object.id}_${i}" class="d-block w-100" alt="..." />`
    carroca.appendChild(item);
  }
  carroca.firstElementChild.classList.add('active')
}

single_images()