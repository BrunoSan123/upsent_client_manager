document.addEventListener("DOMContentLoaded", function (event) {
  const changeButton = [...document.querySelectorAll(".change_btn")];
  const updatePopup = document.querySelectorAll(".upsent-pop-up");
  const closeBtn = document.querySelectorAll(".upsent_close_button");
  const closeBtnMap = document.querySelectorAll(".upsent_close_button_map")
  const clientMapBtn = document.querySelectorAll(".client_position");
  const clientMapPosition = document.querySelectorAll(".map_modal");
  var x = document.getElementById("demo");

  function getLocation() {
    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(showPosition);
    } else {
      x.innerHTML = "Geolocation is not supported by this browser.";
    }
  }

  function showPosition(position) {
    document.cookie = `coord_x= ${position.coords.latitude}`;
    document.cookie = `coord_y= ${position.coords.longitude}`;
  }

  async function rendermap() {
    const current_user=window.history=usuario
    const coordinates= await fetch(`http://localhost:8080/wp-json/upsent-api/v1/tasks/?funcionaro-responsavel=${current_user}`);
    const coord_results=await coordinates.json();
    
    
    for (const coords of coord_results){
        const map = new google.maps.Map(document.getElementById("map"), {
        mapId: "fd8fa89344b48be0",
        center: { lat: Number(coords.coord_x), lng: Number(coords.coord_y) },
        zoom: 16,
      });

      new google.maps.Marker({
        position: {
          lat: Number(coords.coord_x),
          lng: Number(coords.coord_y)
        },
        map,
        title: coords.funcionaro_responsavel,
      });
  
    }
  
  }

  let count = 0;
  changeButton.forEach((e, i) => {
    e.addEventListener("click", () => {
      console.log(count);
      let singlePop = document.getElementById("upsent-" + count);
      console.log(singlePop);
      singlePop.classList.add("reveal");
      getLocation();
      count++;
    });
  });

  closeBtn.forEach((e, i) => {
    e.addEventListener("click", () => {
      updatePopup[i].classList.remove("reveal");
    });
  });

  closeBtnMap.forEach((e, i) => {
    e.addEventListener("click", () => {
      clientMapPosition[i].classList.remove("reveal");
    });
  });

  clientMapBtn.forEach((e, i) => {
    e.addEventListener("click", () => {
      clientMapPosition[i].classList.add("reveal");
      rendermap();
    });
  });
});
