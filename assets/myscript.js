document.addEventListener("DOMContentLoaded", function (event) {
  const changeButton = [...document.querySelectorAll(".change_btn")];
  const updatePopup = document.querySelectorAll(".upsent-pop-up");
  const closeBtn = document.querySelectorAll(".upsent_close_button");
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

  function redermap() {
    const map = new google.maps.Map(document.getElementById("map"), {
      mapId: "fd8fa89344b48be0",
      center: { lat: 38.00511, lng: -131.11143 },
      zoom: 16,
    });

    new google.maps.Marker({
      position: {
        lat: position.coords.latitude,
        lng: position.coords.longitude,
      },
      map,
      title: "funcionario",
    });
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

  clientMapBtn.forEach((e, i) => {
    e.addEventListener("click", () => {
      clientMapPosition[i].classList.toggle("reveal");
      redermap();
    });
  });
});
