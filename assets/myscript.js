document.addEventListener("DOMContentLoaded", function (event) {
  const changeButton = [...document.querySelectorAll(".change_btn")];
  const taskTable= document.querySelectorAll(".upsent_table");
  const updatePopup = document.querySelectorAll(".upsent-pop-up");
  const closeBtn = document.querySelectorAll(".upsent_close_button");
  const closeBtnMap = document.querySelectorAll(".upsent_close_button_map")
  const clientMapBtn = document.querySelectorAll(".client_position");
  const clientMapPosition = document.querySelectorAll(".map_modal");
  const finishButtonBtn=document.querySelectorAll(".finish");
  var x = document.getElementById("demo");

  function getLocation() {
    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(showPosition);
    } else {
      x.innerHTML = "Geolocation is not supported by this browser.";
    }
  }

  // pega a posição atual do funcionario e salva como cookie

  function showPosition(position) {
    document.cookie = `coord_x= ${position.coords.latitude}`;
    document.cookie = `coord_y= ${position.coords.longitude}`;
  }


  //let count = 0;
  changeButton.forEach((e, i) => {
    e.addEventListener("click", () => {
      //console.log(count);
      let singlePop = document.getElementById("upsent-" + i);
      console.log(singlePop);
      singlePop.classList.add("reveal");
      getLocation();
      //count++;
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

  //adiciona mapa com a localização do cliente para o funcionario

  clientMapBtn.forEach((e, i) => {
    e.addEventListener("click", async  () => {
      const current_user=window.history=usuario
      const coordinates= await fetch(`http://localhost:8080/wp-json/upsent-api/v1/tasks/?funcionaro-responsavel=${current_user}`);
      const coord_results=await coordinates.json();
      const map = new google.maps.Map(document.querySelectorAll(".map")[i], {
        mapId: "fd8fa89344b48be0",
        center: { lat: Number(coord_results[i].coord_x), lng: Number(coord_results[i].coord_y) },
        zoom: 16,
      });

      new google.maps.Marker({
        position: {
          lat: Number(coord_results[i].coord_x),
          lng: Number(coord_results[i].coord_y)
        },
        map,
        title: coord_results[i].funcionaro_responsavel,
      });
      clientMapPosition[i].classList.add("reveal");
    });
  });

  finishButtonBtn.forEach((e,i)=>{
    e.addEventListener('click',async ()=>{
      const current_user=window.history=usuario
      const task_info= await fetch(`http://localhost:8080/wp-json/upsent-api/v1/tasks/?funcionaro-responsavel=${current_user}`);
      const task_results=await task_info.json();
      await fetch(`http://localhost:8080/wp-json/upsent-api/v1/tasks/`,{
          method:'PUT',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ id: task_results[i].id, entregue: 1 })
      })
      taskTable[i].remove();
    })
  })
});
