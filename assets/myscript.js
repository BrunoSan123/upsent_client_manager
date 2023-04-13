document.addEventListener("DOMContentLoaded", function (event) {
  const changeButton = document.querySelectorAll(".change_btn");
  const changeButtonMobile=document.querySelectorAll(".change_btn_mobile")
  const page_tarefas_cadastradas= document.body.classList.contains("emt_page_tarefas");
  const page_tarefas_do_funcionario =document.body.classList.contains("emt_page_usuario");
  const taskTable= document.querySelectorAll(".upsent_table");
  const updatePopup = document.querySelectorAll(".upsent-pop-up");
  const closeBtn = document.querySelectorAll(".upsent_close_button");
  const closeBtnMap = document.querySelectorAll(".upsent_close_button_map")
  const clientMapBtn = document.querySelectorAll(".client_position");
  const clientMapBtnMobile =document.querySelectorAll(".client_position_mobile")
  const employeeMapBtn=document.querySelectorAll(".employee_position")
  const employerMapBtnMobile=document.querySelectorAll(".employee_position_mobile");
  const clientMapPosition = document.querySelectorAll(".map_modal");
  const finishButtonBtn=document.querySelectorAll(".finish");
  const uploadInput = document.querySelectorAll(".upload_button");
  const selectState= document.querySelectorAll(".states");
  const fileInput = document.querySelectorAll('input[type="file"]');
  const clientAddress= document.getElementById("address");
  const coord_x=document.getElementById("coord_x")
  const coord_y=document.getElementById("coord_y")
  const deleteButton= document.querySelectorAll(".delete_task")
  const employerSubmitButton= document.querySelectorAll(".button_upsent");
  const form= document.querySelectorAll(".upload_button")



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

  async function getClientCoords(value){
    const localeRequest= await fetch(`https://maps.googleapis.com/maps/api/geocode/json?address=${value}&key=AIzaSyChwlr0dGv_YSZfJkVdblKgIV47MK3tkks`)
    const localeResponse=await localeRequest.json();
    if(coord_x && coord_y){
      return
    }else{
      clientAddress.innerHTML=`
      <input type="hidden" name="coord_X" id="coord_x" placeholder="cordenada x" value="${localeResponse.results[0].geometry.location.lat}">
      <input type="hidden" name="coord_y" id="coord_y" placeholder="cordenada y" value="${localeResponse.results[0].geometry.location.lng}">
      `

    }

  }

  
  changeButton.forEach((e, i) => {
    e.addEventListener("click", () => {
      updatePopup[i].classList.add("reveal");
      getLocation();
    });
  });

  changeButtonMobile.forEach((e, i) => {
    e.addEventListener("click", () => {
      updatePopup[i].classList.add("reveal");
      getLocation();
    });
  });

  selectState.forEach((e,i)=>{
      e.addEventListener('change',()=>{
        console.log(e.selectedOptions[0].value);
        if(e.selectedOptions[0].value=="completa"){
          uploadInput[i].classList.add("reveal")
        }else{
          uploadInput[i].classList.remove("reveal");
        }
      })
  })


  

  fileInput.forEach((e,i)=>{
    e.addEventListener("change",(evt)=>{
      const allowedExtensions = /(\.png|\.jpg|\.jpeg)$/i;
      if (!allowedExtensions.exec(e.value)) {
        alert('Por favor, selecione um arquivo de imagem válido (PNG, JPG ou JPEG).');
        e.value = '';
        return false;
      }else{
        var tmppath = URL.createObjectURL(evt.target.files[0]);
        console.log(tmppath)
        const uploadImage=document.createElement("img")
        uploadImage.setAttribute("src",tmppath)
        uploadImage.setAttribute("width","200")
        uploadImage.setAttribute("height","200")
        form[i].appendChild(uploadImage);
      }
      })

  })

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

  if(page_tarefas_do_funcionario){
    clientMapBtn.forEach((e, i) => {
      e.addEventListener("click", async  () => {
        const current_user=window.history=usuario
        clientMapPosition[i].classList.add("reveal");
        const coordinates= await fetch(`http://localhost:8080/wp-json/upsent-api/v1/tasks_employee/?funcionaro_responsavel=${current_user}&entregue=0`);
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
        
      });
    });

    clientMapBtnMobile.forEach((e, i) => {
      e.addEventListener("click", async  () => {
        const current_user=window.history=usuario
        clientMapPosition[i].classList.add("reveal");
        const coordinates= await fetch(`http://localhost:8080/wp-json/upsent-api/v1/tasks_employee/?funcionaro_responsavel=${current_user}&entregue=0`);
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
        
      });
    });

    taskTable.forEach((e,i)=>{
      finishButtonBtn[i].addEventListener('click',async ()=>{
       const current_user=window.history=usuario
       const task_info= await fetch(`http://localhost:8080/wp-json/upsent-api/v1/tasks_employee/?funcionaro_responsavel=${current_user}&entregue=0`);
       const task_results=await task_info.json();
       console.log(task_results[i].concluida)
       if(task_results[i].concluida==0){
         alert('precisa concluir a tarefa primeiro')
       }else{
          e.remove();
          await fetch(`http://localhost:8080/wp-json/upsent-api/v1/tasks/`,{
               method:'PUT',
               headers: { 'Content-Type': 'application/json' },
               body: JSON.stringify({ id: task_results[i].id, entregue: 1 })
           })
         }
      })
     })

     employerSubmitButton.forEach((e,i)=>{
      e.addEventListener('submit',(evt)=>{
        console.log(fileInput[i].value)
        if(fileInput[i].value==""){
          evt.preventDefault();
          alert("Precisa da comprovação");
        }
      })
    })
  

  }



  if(page_tarefas_cadastradas){
    var user_maped =window.history=usuario_maped;
    console.log(user_maped);

    employeeMapBtn.forEach((e,i)=>{
      e.addEventListener("click", async()=>{
        clientMapPosition[i].classList.add("reveal");
        const employee_coordinates= await fetch(`http://localhost:8080/wp-json/upsent-api/v1/tasks`);
        const coord_results=await employee_coordinates.json()
        const map = new google.maps.Map(document.querySelectorAll(".map")[i], {
          mapId: "fd8fa89344b48be0",
          center: { lat: Number(coord_results[i].employeer_position_x), lng: Number(coord_results[i].employeer_position_Y) },
          zoom: 16,
        });
  
        new google.maps.Marker({
          position: {
            lat: Number(coord_results[i].employeer_position_x),
            lng: Number(coord_results[i].employeer_position_Y)
          },
          map,
          title: coord_results[i].funcionaro_responsavel,
        });
        
      })
    })

    taskTable.forEach((e,i)=>{
      deleteButton[i].addEventListener('click',async ()=>{
       const task_info= await fetch(`http://localhost:8080/wp-json/upsent-api/v1/tasks`);
       const task_results=await task_info.json();
       console.log(task_results[i])
       e.remove();
       await fetch(`http://localhost:8080/wp-json/upsent-api/v1/tasks/delete?id=${task_results[i].id}`,{
            method:'DELETE',
            headers: { 'Content-Type': 'application/json' },
        })
      })

      finishButtonBtn[i].addEventListener('click',async ()=>{
        const task_info= await fetch(`http://localhost:8080/wp-json/upsent-api/v1/tasks`);
        const task_results=await task_info.json();
        console.log(task_results[i].concluida)
        await fetch(`http://localhost:8080/wp-json/upsent-api/v1/tasks/`,{
          method:'PUT',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ id: task_results[i].id, entregue: 0 })
      })

       })
     })

    employerMapBtnMobile.forEach((e,i)=>{
      e.addEventListener("click", async()=>{
        clientMapPosition[i].classList.add("reveal");
        const employee_coordinates= await fetch(`http://localhost:8080/wp-json/upsent-api/v1/tasks`);
        const coord_results=await employee_coordinates.json()
        const map = new google.maps.Map(document.querySelectorAll(".map")[i], {
          mapId: "fd8fa89344b48be0",
          center: { lat: Number(coord_results[i].employeer_position_x), lng: Number(coord_results[i].employeer_position_Y) },
          zoom: 16,
        });
  
        new google.maps.Marker({
          position: {
            lat: Number(coord_results[i].employeer_position_x),
            lng: Number(coord_results[i].employeer_position_Y)
          },
          map,
          title: coord_results[i].funcionaro_responsavel,
        });
        
      })
    })

    clientAddress.addEventListener("change",(e)=>{
      getClientCoords(e.target.value);
    })
  }




});

