document.addEventListener("DOMContentLoaded", function (event) {
  const changeButton = document.querySelectorAll(".change_btn");
  const changeButtonMobile = document.querySelectorAll(".change_btn_mobile");
  const page_tarefas_cadastradas =
    document.body.classList.contains("emt_page_tarefas");
  const page_tarefas_do_funcionario =
    document.body.classList.contains("emt_page_usuario");
  const tarefas_concluidas=document.body.classList.contains("emt_page_tarefas_concluidas");
  const taskTable = document.querySelectorAll(".upsent_table");
  const taskTableMobile = document.querySelectorAll(".upsent_table-mobile");
  const updatePopup = document.querySelectorAll(".upsent-pop-up");
  const closeBtn = document.querySelectorAll(".upsent_close_button");
  const closeBtnMap = document.querySelectorAll(".upsent_close_button_map");
  const closeBtnImg = document.querySelectorAll(".upsent_close_button_img");
  const closeBtnDesc = document.querySelectorAll(
    ".upsent_close_button_description"
  );
  const clientMapBtn = document.querySelectorAll(".client_position");
  const clientMapBtnMobile = document.querySelectorAll(
    ".client_position_mobile"
  );
  const employeeMapBtn = document.querySelectorAll(".employee_position");
  const employerMapBtnMobile = document.querySelectorAll(
    ".employee_position_mobile"
  );
  const clientMapPosition = document.querySelectorAll(".map_modal");
  const finishButtonBtn = document.querySelectorAll(".finish");
  const finishButtonBtnMobile=document.querySelectorAll(".finished")
  const uploadInput = document.querySelectorAll(".upload_button");
  const selectState = document.querySelectorAll(".states");
  const fileInput = document.querySelectorAll('input[type="file"]');
  const clientAddress = document.getElementById("address");
  const coord_x = document.getElementById("coord_x");
  const coord_y = document.getElementById("coord_y");
  const deleteButton = document.querySelectorAll(".delete_task");
  const employerSubmitButton = document.querySelectorAll(".button_upsent");
  const form = document.querySelectorAll(".upload_button");
  const description = document.querySelectorAll(".description");
  const descriptionMobile = document.querySelectorAll(".descriptionMobile");
  const modelDescription = document.querySelectorAll(".description-pop");
  const img_pop_up = document.querySelectorAll(".img_comprovante");
  const comprovant_field = document.querySelectorAll(".comprovante");
  const comprovant_filed_mobile =
    document.querySelectorAll(".comprovanteMobile");
  const taskConclued= document.querySelectorAll(".conclued")
  

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
  //função para conseguir as cordenadas do cliente usando a API do google

  async function getClientCoords(value) {
    const localeRequest = await fetch(
      `https://maps.googleapis.com/maps/api/geocode/json?address=${value}&key=AIzaSyChwlr0dGv_YSZfJkVdblKgIV47MK3tkks`
    );
    const localeResponse = await localeRequest.json();
    if (coord_x && coord_y) {
      return;
    } else {
      clientAddress.innerHTML = `
      <input type="hidden" name="coord_X" id="coord_x" placeholder="cordenada x" value="${localeResponse.results[0].geometry.location.lat}">
      <input type="hidden" name="coord_y" id="coord_y" placeholder="cordenada y" value="${localeResponse.results[0].geometry.location.lng}">
      `;
    }
  }

  async function getTaskQuery() {
    const por_pag = (window.history = per_page);
    const atual_page = (window.history = actual_page);
    const task = await fetch(
      `http://localhost:8080/wp-json/upsent-api/v1/tasks/?per_page=${por_pag}&page=${atual_page}`
    );
    const task_results = await task.json();
    return task_results;
  }

  // função para renderizar o mapa
  function getTaskMap(position, query) {
    clientMapPosition[position].classList.add("reveal");
    const coord_results = query;
    const map = new google.maps.Map(
      document.querySelectorAll(".map")[position],
      {
        mapId: "fd8fa89344b48be0",
        center: {
          lat: Number(coord_results[position].employeer_position_x),
          lng: Number(coord_results[position].employeer_position_Y),
        },
        zoom: 16,
      }
    );

    new google.maps.Marker({
      position: {
        lat: Number(coord_results[position].employeer_position_x),
        lng: Number(coord_results[position].employeer_position_Y),
      },
      map,
      title: coord_results[position].funcionaro_responsavel,
    });
  }

  // função para deletar tarefa

  async function deleteTask(element, position) {
    deleteButton[position].addEventListener("click", async () => {
      const por_pag = (window.history = per_page);
      const atual_page = (window.history = actual_page);
      switch (filter_selection) {
        case "parado":
          task = await fetch(
            `http://localhost:8080/wp-json/upsent-api/v1/tasks/filter?per_page=${por_pag}&page=${atual_page}&status=${filter_selection}`
          );
          task_results = await task.json();
          break;
        case "em_andamento":
          task = await fetch(
            `http://localhost:8080/wp-json/upsent-api/v1/tasks/filter?per_page=${por_pag}&page=${atual_page}&status=${filter_selection}`
          );
          task_results = await task.json();
          break;
        case "concluida":
          task = await fetch(
            `http://localhost:8080/wp-json/upsent-api/v1/tasks/filter?per_page=${por_pag}&page=${atual_page}&status=completa`
          );
          task_results = await task.json();
          break;

        default:
          task = await fetch(
            `http://localhost:8080/wp-json/upsent-api/v1/tasks/?per_page=${por_pag}&page=${atual_page}`
          );
          task_results = await task.json();
          break;
      }
      console.log(element);
      element.remove();
      await fetch(
        `http://localhost:8080/wp-json/upsent-api/v1/tasks/delete?id=${task_results[position].id}`,
        {
          method: "DELETE",
          headers: { "Content-Type": "application/json" },
        }
      );
    });
  }

  // função para reabrir a tarefa

  async function reopenTask(element, position) {
    const por_pag = (window.history = per_page);
    const atual_page = (window.history = actual_page);
    const task_info = (task = await fetch(
      `http://localhost:8080/wp-json/upsent-api/v1/tasks/filter?per_page=${por_pag}&page=${atual_page}&status=completa`
    ));
    const task_results = await task_info.json();
    console.log(task_results[position].concluida);
    element.remove();
    await fetch(`http://localhost:8080/wp-json/upsent-api/v1/tasks/`, {
      method: "PUT",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ id: task_results[position].id, entregue: 0 }),
    });
  }

  //função para entregar a tarefa

  async function finishTask(element, position,query) {
   if(query[position].concluida!=1){
      alert("é preciso concluir primeiro")
    }else{
      element.remove();
      await fetch(`http://localhost:8080/wp-json/upsent-api/v1/tasks/`, {
        method: "PUT",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ id: query[position].id, entregue: 1 }),
      });
    }

  }

 // evento de elteração de estatus
  changeButton.forEach((e, i) => {
    e.addEventListener("click", () => {
      updatePopup[i].classList.add("reveal");
      getLocation();
    });
  });

  // alteração para componentes mobile
  changeButtonMobile.forEach((e, i) => {
    e.addEventListener("click", () => {
      updatePopup[i].classList.add("reveal");
      getLocation();
    });
  });

  // seleção de estados
  selectState.forEach((e, i) => {
    e.addEventListener("change", () => {
      console.log(e.selectedOptions[0].value);
      if (e.selectedOptions[0].value == "completa") {
        uploadInput[i].classList.add("reveal");
      } else {
        uploadInput[i].classList.remove("reveal");
      }
    });
  });

  // upload de arquivo
  fileInput.forEach((e, i) => {
    e.addEventListener("change", (evt) => {
      const allowedExtensions = /(\.png|\.jpg|\.jpeg)$/i;
      if (!allowedExtensions.exec(e.value)) {
        alert(
          "Por favor, selecione um arquivo de imagem válido (PNG, JPG ou JPEG)."
        );
        e.value = "";
        return false;
      } else {
        var tmppath = URL.createObjectURL(evt.target.files[0]);
        console.log(tmppath);
        const uploadImage = document.createElement("img");
        uploadImage.setAttribute("src", tmppath);
        uploadImage.setAttribute("width", "200");
        uploadImage.setAttribute("height", "200");
        form[i].appendChild(uploadImage);
      }
    });
  });

  //fechamento de botões da modal de alteração
  closeBtn.forEach((e, i) => {
    e.addEventListener("click", () => {
      updatePopup[i].classList.remove("reveal");
    });
  });

  //fechamento de botões da modal do mapa
  closeBtnMap.forEach((e, i) => {
    e.addEventListener("click", () => {
      clientMapPosition[i].classList.remove("reveal");
    });
  });

  //eventos para a página do funcionario

  if (page_tarefas_do_funcionario) {
    clientMapBtn.forEach(async (e, i) => {
      const current_user = (window.history = usuario);
      const coordinates = await fetch(
        `http://localhost:8080/wp-json/upsent-api/v1/tasks_employee/?funcionaro_responsavel=${current_user}&entregue=0`
      );
      const coord_results = await coordinates.json();
      e.addEventListener("click", () => {
        clientMapPosition[i].classList.add("reveal");
        getTaskMap(i, coord_results);
      });
    });

    clientMapBtnMobile.forEach(async (e, i) => {
      const current_user = (window.history = usuario);
      const coordinates = await fetch(
        `http://localhost:8080/wp-json/upsent-api/v1/tasks_employee/?funcionaro_responsavel=${current_user}&entregue=0`
      );
      const coord_results = await coordinates.json();
      e.addEventListener("click", () => {
      clientMapPosition[i].classList.add("reveal");
      getTaskMap(i,coord_results);
      });
    });

    taskTable.forEach((e, i) => {
      finishButtonBtn[i].addEventListener("click", async () => {
        const current_user = (window.history = usuario);
        const coordinates = await fetch(
          `http://localhost:8080/wp-json/upsent-api/v1/tasks_employee/?funcionaro_responsavel=${current_user}&entregue=0`
        );
        const coord_results = await coordinates.json();
        finishTask(e,i,coord_results);
      });
      description[i].addEventListener("click", async () => {
        modelDescription[i].classList.add("reveal");
        closeBtnDesc[i].addEventListener("click", () => {
          modelDescription[i].classList.remove("reveal");
        });
      });
      if(taskConclued[i].getAttribute("data-target")==1){
        comprovant_field[i].classList.add("reveal")
        comprovant_field[i].addEventListener("click", () => {
          img_pop_up[i].classList.add("reveal");
          closeBtnImg[i].addEventListener("click", () => {
            img_pop_up[i].classList.remove("reveal");
          });
        });

      }
    });

    taskTableMobile.forEach((e, i) => {
      finishButtonBtnMobile[i].addEventListener("click", async () => {
        const current_user = (window.history = usuario);
        const coordinates = await fetch(
          `http://localhost:8080/wp-json/upsent-api/v1/tasks_employee/?funcionaro_responsavel=${current_user}&entregue=0`
        );
        const coord_results = await coordinates.json();
        finishTask(e,i,coord_results);
      });
      if(taskConclued[i].getAttribute("data-target")==1){
        comprovant_filed_mobile[i].addEventListener("click", () => {
          img_pop_up[i].classList.add("reveal");
          closeBtnImg[i].addEventListener("click", () => {
            img_pop_up[i].classList.remove("reveal");
          });
        });
      }
   
      descriptionMobile[i].addEventListener("click", async () => {
        modelDescription[i].classList.add("reveal");
        closeBtnDesc[i].addEventListener("click", () => {
          modelDescription[i].classList.remove("reveal");
        });
      });
    });
    
  }
  
  //evventos para a pagina de tarefas do admin
  if (page_tarefas_cadastradas) {
    var user_maped = (window.history = usuario_maped);
    console.log(user_maped);
    const filter = document.querySelector(".filter_selection");
    const filter_selection = filter.getAttribute("data-target");

    employeeMapBtn.forEach(async (e, i) => {
      console.log(filter_selection);
      let task = null;
      let task_results = null;
      const por_pag = (window.history = per_page);
      const atual_page = (window.history = actual_page);

      switch (filter_selection) {
        case "parado":
          task = await fetch(
            `http://localhost:8080/wp-json/upsent-api/v1/tasks/filter?per_page=${por_pag}&page=${atual_page}&status=${filter_selection}`
          );
          task_results = await task.json();
          break;
        case "em_andamento":
          task = await fetch(
            `http://localhost:8080/wp-json/upsent-api/v1/tasks/filter?per_page=${por_pag}&page=${atual_page}&status=${filter_selection}`
          );
          task_results = await task.json();
          break;
        case "concluida":
          task = await fetch(
            `http://localhost:8080/wp-json/upsent-api/v1/tasks/filter?per_page=${por_pag}&page=${atual_page}&status=completa`
          );
          task_results = await task.json();
          break;

        default:
          task = await fetch(
            `http://localhost:8080/wp-json/upsent-api/v1/tasks/?per_page=${por_pag}&page=${atual_page}`
          );
          task_results = await task.json();
          break;
      }

      e.addEventListener("click", () => {
        getTaskMap(i, task_results);
      });
    });

    taskTable.forEach((e, i) => {
      deleteTask(e, i);
  
      finishButtonBtn[i].addEventListener("click", async (e) => {
        reopenTask(finishButtonBtn[i], i);
      });

      description[i].addEventListener("click", async () => {
        modelDescription[i].classList.add("reveal");
        closeBtnDesc[i].addEventListener("click", () => {
          modelDescription[i].classList.remove("reveal");
        });
      });


          if(taskConclued[i].getAttribute("data-target")==1){
            comprovant_field[i].classList.add("reveal")
            comprovant_field[i].addEventListener("click", () => {
              img_pop_up[i].classList.add("reveal");
              closeBtnImg[i].addEventListener("click", () => {
                img_pop_up[i].classList.remove("reveal");
              });
            });

          }  

        
    });

    taskTableMobile.forEach((e, i) => {
      comprovant_filed_mobile[i].addEventListener("click", () => {
        img_pop_up[i].classList.add("reveal");
        closeBtnImg[i].addEventListener("click", () => {
          img_pop_up[i].classList.remove("reveal");
        });
      });
      descriptionMobile[i].addEventListener("click", async () => {
        modelDescription[i].classList.add("reveal");
        closeBtnDesc[i].addEventListener("click", () => {
          modelDescription[i].classList.remove("reveal");
        });
      });
    });
    employerMapBtnMobile.forEach((e, i) => {
      e.addEventListener("click", async () => {
        clientMapPosition[i].classList.add("reveal");
        let task = null;
        let task_results = null;
        const por_pag = (window.history = per_page);
        const atual_page = (window.history = actual_page);

        switch (filter_selection) {
          case "parado":
            task = await fetch(
              `http://localhost:8080/wp-json/upsent-api/v1/tasks/filter?per_page=${por_pag}&page=${atual_page}&status=${filter_selection}`
            );
            task_results = await task.json();
            break;
          case "em_andamento":
            task = await fetch(
              `http://localhost:8080/wp-json/upsent-api/v1/tasks/filter?per_page=${por_pag}&page=${atual_page}&status=${filter_selection}`
            );
            task_results = await task.json();
            break;
          case "concluida":
            task = await fetch(
              `http://localhost:8080/wp-json/upsent-api/v1/tasks/filter?per_page=${por_pag}&page=${atual_page}&status=completa`
            );
            task_results = await task.json();
            break;

          default:
            task = await fetch(
              `http://localhost:8080/wp-json/upsent-api/v1/tasks/?per_page=${por_pag}&page=${atual_page}`
            );
            task_results = await task.json();
            break;
        }

        getTaskMap(i, task_results);
      });
    });

    clientAddress.addEventListener("change", (e) => {
      getClientCoords(e.target.value);
    });
  }

  if(tarefas_concluidas){
    taskTable.forEach((e, i) => {
      deleteTask(e, i);
      finishButtonBtn[i].addEventListener("click", async () => {
          reopenTask(e,i);
      });
    })
  }
});
