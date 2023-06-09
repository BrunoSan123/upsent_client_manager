document.addEventListener("DOMContentLoaded", function (event) {
  const changeButton = document.querySelectorAll(".change_btn");
  const changeButtonMobile = document.querySelectorAll(".change_btn_mobile");
  const page_tarefas_cadastradas =
    document.body.classList.contains("emt_page_tarefas");
  const page_tarefas_do_funcionario =
    document.body.classList.contains("emt_page_usuario");
  const tarefas_concluidas = document.body.classList.contains(
    "emt_page_tarefas_concluidas"
  );
  const cadastroDeTarefas =
    document.body.classList.contains("emt_page_cadastro");
  const taskTable = document.querySelectorAll(".upsent_table");
  const taskTableMobile = document.querySelectorAll(".upsent_table-mobile");
  const updatePopup = document.querySelectorAll(".upsent-pop-up");
  const updatePopDesc = document.querySelectorAll(".upsent-pop-up-desc");
  const closeBtn = document.querySelectorAll(".upsent_close_button");
  const closeBtnMap = document.querySelectorAll(".upsent_close_button_map");
  const closeBtnImg = document.querySelectorAll(".upsent_close_button_img");
  const closeButtonObservation = document.querySelectorAll(
    ".upsent_close_button-desc"
  );
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
  const finishButtonBtnMobile = document.querySelectorAll(".finished");
  const uploadInput = document.querySelectorAll(".upload_button");
  const selectState = document.querySelectorAll(".states");
  const fileInput = document.querySelectorAll('input[type="file"]');
  const clientAddress = document.getElementById("address");
  const coord_x = document.getElementById("coord_x");
  const coord_y = document.getElementById("coord_y");
  const deleteButton = document.querySelectorAll(".delete_task");
  const deleteButtonMobile = document.querySelectorAll(".delete_task_mobile");
  const employerSubmitButton = document.querySelectorAll(".button_upsent");
  const form = document.querySelectorAll(".upload_button");
  const description = document.querySelectorAll(".description");
  const descriptionMobile = document.querySelectorAll(".descriptionMobile");
  const modelDescription = document.querySelectorAll(".description-pop");
  const img_pop_up = document.querySelectorAll(".img_comprovante");
  const comprovant_field = document.querySelectorAll(".comprovante");
  const comprovant_filed_mobile =
    document.querySelectorAll(".comprovanteMobile");
  const taskConclued = document.querySelectorAll(".conclued");
  const site_url = (window.history = siteUrl);
  const employerDescription = document.querySelectorAll(".employer-describe");
  const employerTime = document.querySelectorAll(".quantity_hour");
  const employerObservation = document.querySelectorAll(
    ".employer_observation"
  );
  const observationButton = document.querySelectorAll(".desc_button");
  const reportButton = document.querySelectorAll(".report_button");
  const popEmployerDescritive=document.querySelectorAll(".description-pop-employer")
  const employerDescriptionButton=document.querySelectorAll(".client-description")
  const employerButoncloseExplication= document.querySelectorAll(".upsent_close_button_employer_desc")
  const employerDescriptionexplainMobile=document.querySelectorAll(".descriptionMobileEmployer")

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

  function getTaskMapClient(position, query) {
    clientMapPosition[position].classList.add("reveal");
    const coord_results = query;
    const map = new google.maps.Map(
      document.querySelectorAll(".map")[position],
      {
        mapId: "fd8fa89344b48be0",
        center: {
          lat: Number(coord_results[position].coord_x),
          lng: Number(coord_results[position].coord_y),
        },
        zoom: 16,
      }
    );

    new google.maps.Marker({
      position: {
        lat: Number(coord_results[position].coord_x),
        lng: Number(coord_results[position].coord_y),
      },
      map,
      title: coord_results[position].funcionaro_responsavel,
    });
  }

  // função para deletar tarefa

  function deleteTask(element, position) {
    deleteButton[position].addEventListener("click", () => {
      swal({
        title: "tem certeza?",
        text: "uma vez deletada não pode ser realocada",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      }).then(async (willDelete) => {
        if (willDelete) {
          swal("Tarefa deletada", {
            icon: "success",
          });
          const filter = document.querySelector(".filter_selection");
          const filter_selection = filter.getAttribute("data-target");
          const por_pag = (window.history = per_page);
          const atual_page = (window.history = actual_page);
          switch (filter_selection) {
            case "parado":
              task = await fetch(
                `${site_url}/wp-json/upsent-api/v1/tasks/filter?per_page=${por_pag}&page=${atual_page}&status=${filter_selection}`
              );
              task_results = await task.json();
              break;
            case "em_andamento":
              task = await fetch(
                `${site_url}/wp-json/upsent-api/v1/tasks/filter?per_page=${por_pag}&page=${atual_page}&status=${filter_selection}`
              );
              task_results = await task.json();
              break;
            case "concluida":
              task = await fetch(
                `${site_url}/wp-json/upsent-api/v1/tasks/filter?per_page=${por_pag}&page=${atual_page}&status=completa`
              );
              task_results = await task.json();
              break;

            default:
              task = await fetch(
                `${site_url}/wp-json/upsent-api/v1/tasks/?per_page=${por_pag}&page=${atual_page}`
              );
              task_results = await task.json();
              break;
          }

          element.remove();
          await fetch(
            `${site_url}/wp-json/upsent-api/v1/tasks/delete?id=${task_results[position].id}`,
            {
              method: "DELETE",
              headers: { "Content-Type": "application/json" },
            }
          );
        } else {
          swal("não deletada");
        }
      });
    });
  }

  function delete_task_mobile(element, position) {
    deleteButtonMobile[position].addEventListener("click", () => {
      swal({
        title: "Tem certeza??",
        text: "Uma vez deletada não pode mais ser realocada",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      }).then(async (willDelete) => {
        if (willDelete) {
          swal("Tarefa deletada com sucesso", {
            icon: "success",
          });

          const filter = document.querySelector(".filter_selection");
          const filter_selection = filter.getAttribute("data-target");
          const por_pag = (window.history = per_page);
          const atual_page = (window.history = actual_page);
          switch (filter_selection) {
            case "parado":
              task = await fetch(
                `${site_url}/wp-json/upsent-api/v1/tasks/filter?per_page=${por_pag}&page=${atual_page}&status=${filter_selection}`
              );
              task_results = await task.json();
              break;
            case "em_andamento":
              task = await fetch(
                `${site_url}/wp-json/upsent-api/v1/tasks/filter?per_page=${por_pag}&page=${atual_page}&status=${filter_selection}`
              );
              task_results = await task.json();
              break;
            case "concluida":
              task = await fetch(
                `${site_url}/wp-json/upsent-api/v1/tasks/filter?per_page=${por_pag}&page=${atual_page}&status=completa`
              );
              task_results = await task.json();
              break;

            default:
              task = await fetch(
                `${site_url}/wp-json/upsent-api/v1/tasks/?per_page=${por_pag}&page=${atual_page}`
              );
              task_results = await task.json();
              break;
          }
          element.remove();
          await fetch(
            `${site_url}/wp-json/upsent-api/v1/tasks/delete?id=${task_results[position].id}`,
            {
              method: "DELETE",
              headers: { "Content-Type": "application/json" },
            }
          );
        } else {
          swal("não deletada");
        }
      });
    });
  }

  async function delete_finish_task(element, position) {
    const por_pag = (window.history = per_page);
    const atual_page = (window.history = actual_page);
    const task_info = (task = await fetch(
      `${site_url}/wp-json/upsent-api/v1/tasks/finished/?page=${atual_page}&per_page=${por_pag}&entregue=1`
    ));
    const task_results = await task_info.json();
    element.remove();
    await fetch(
      `${site_url}/wp-json/upsent-api/v1/tasks/delete?id=${task_results[position].id}`,
      {
        method: "DELETE",
        headers: { "Content-Type": "application/json" },
      }
    );
  }

  // função para reabrir a tarefa

  async function reopenTask(position) {
    const por_pag = (window.history = per_page);
    const atual_page = (window.history = actual_page);
    const task_info = (task = await fetch(
      `${site_url}/wp-json/upsent-api/v1/tasks/finished/?page=${atual_page}&per_page=${por_pag}&entregue=1`
    ));
    //element.remove();
    const task_results = await task_info.json();
    await fetch(`${site_url}/wp-json/upsent-api/v1/tasks/`, {
      method: "PUT",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ id: task_results[position].id, entregue: 0 }),
    });
  }

  //função para entregar a tarefa

  async function finishTask(element, position, query) {
    if (query[position].concluida != 1) {
      alert("é preciso concluir primeiro");
    } else {
      element.remove();
      await fetch(`${site_url}/wp-json/upsent-api/v1/tasks/`, {
        method: "PUT",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ id: query[position].id, entregue: 1 }),
      });
    }
  }

/*   function money_mask(string,element){

  } */

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
      if (e.selectedOptions[0].value == "completa") {
        uploadInput[i].classList.add("reveal");
        employerDescription[i].classList.add("reveal");
        employerTime[i].classList.add("reveal");
        employerObservation[i].classList.add("reveal");
        observationButton[i].classList.add("reveal");
      } else {
        uploadInput[i].classList.remove("reveal");
        employerDescription[i].classList.remove("reveal");
        employerTime[i].classList.remove("reveal");
        employerObservation[i].classList.remove("reveal");
        observationButton[i].classList.remove("reveal");
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
        const images = evt.target.files;
        ArrayImages = Array.from(images);
        const divContainerImages = document.createElement("div");
        divContainerImages.classList.add("container_images");
        ArrayImages.forEach((j, k) => {
          const divImage = document.createElement("div");
          const uploadImage = document.createElement("img");
          uploadImage.setAttribute("src", URL.createObjectURL(j));
          uploadImage.setAttribute("width", "200")
            ? screen.width == 900
            : uploadImage.setAttribute("width", "50");
          uploadImage.setAttribute("height", "200")
            ? screen.width == 900
            : uploadImage.setAttribute("height", "50");
          divImage.appendChild(uploadImage);
          divContainerImages.appendChild(divImage);
          form[i].appendChild(divContainerImages);
        });
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
        `${site_url}/wp-json/upsent-api/v1/tasks_employee/?funcionaro_responsavel=${current_user}&entregue=0`
      );
      const coord_results = await coordinates.json();
      e.addEventListener("click", () => {
        clientMapPosition[i].classList.add("reveal");
        getTaskMapClient(i, coord_results);
      });
    });

    observationButton.forEach((e, i) => {
      e.addEventListener("click", () => {
        updatePopDesc[i].classList.add("reveal");
        closeButtonObservation[i].addEventListener("click", () => {
          const emp_describe = document.querySelectorAll(".employer_describe");
          const begin_hour = document.querySelectorAll(".begin_hour");
          const finishHour = document.querySelectorAll(".finish_hour");
          const emp_observation = document.querySelectorAll(
            ".employer-observation"
          );
          document.cookie = `descricao_do_usuario=${emp_describe[i].value}`;
          document.cookie = `hora_de_inicio=${begin_hour[i].value}`;
          document.cookie = `hora_da_conclusao=${finishHour[i].value}`;
          document.cookie = `observacoes_do_tecnico=${emp_observation[i].value}`;
          updatePopDesc[i].classList.remove("reveal");
        });
      });
    });

    clientMapBtnMobile.forEach(async (e, i) => {
      const current_user = (window.history = usuario);
      const coordinates = await fetch(
        `${site_url}/wp-json/upsent-api/v1/tasks_employee/?funcionaro_responsavel=${current_user}&entregue=0`
      );
      const coord_results = await coordinates.json();
      e.addEventListener("click", () => {
        clientMapPosition[i].classList.add("reveal");
        getTaskMapClient(i, coord_results);
      });
    });

    taskTable.forEach((e, i) => {
      finishButtonBtn[i].addEventListener("click", async () => {
        const current_user = (window.history = usuario);
        const coordinates = await fetch(
          `${site_url}/wp-json/upsent-api/v1/tasks_employee/?funcionaro_responsavel=${current_user}&entregue=0`
        );
        const coord_results = await coordinates.json();
        finishTask(e, i, coord_results);
      });
      description[i].addEventListener("click", async () => {
        modelDescription[i].classList.add("reveal");
        closeBtnDesc[i].addEventListener("click", () => {
          modelDescription[i].classList.remove("reveal");
        });
      });


      if (taskConclued[i].getAttribute("data-target") == 1) {
        comprovant_field[i].classList.add("reveal");
        comprovant_field[i].addEventListener("click", () => {
          img_pop_up[i].classList.add("reveal");
          closeBtnImg[i].addEventListener("click", () => {
            img_pop_up[i].classList.remove("reveal");
          });
        });
        employerDescriptionButton[i].classList.add("reveal")
        employerDescriptionButton[i].addEventListener("click",()=>{
          popEmployerDescritive[i].classList.add("reveal");
          employerButoncloseExplication[i].addEventListener("click",()=>{
            popEmployerDescritive[i].classList.remove("reveal");
          })
        })
      }
    });

    taskTableMobile.forEach((e, i) => {
      finishButtonBtnMobile[i].addEventListener("click", async () => {
        const current_user = (window.history = usuario);
        const coordinates = await fetch(
          `${site_url}/wp-json/upsent-api/v1/tasks_employee/?funcionaro_responsavel=${current_user}&entregue=0`
        );
        const coord_results = await coordinates.json();
        finishTask(e, i, coord_results);
      });
      if (taskConclued[i].getAttribute("data-target") == 1) {
        employerDescriptionexplainMobile[i].classList.add("upsent-table-item")
        employerDescriptionexplainMobile[i].addEventListener("click",()=>{
          popEmployerDescritive[i].classList.add("reveal");
          employerButoncloseExplication[i].addEventListener("click",()=>{
            popEmployerDescritive[i].classList.remove("reveal");
          })
        })
        comprovant_filed_mobile[i].classList.add("upsent-table-item");
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
    //var user_maped = (window.history = usuario_maped);
    const filter = document.querySelector(".filter_selection");
    const filter_selection = filter.getAttribute("data-target");

    employeeMapBtn.forEach(async (e, i) => {
      let task = null;
      let task_results = null;
      const por_pag = (window.history = per_page);
      const atual_page = (window.history = actual_page);

      switch (filter_selection) {
        case "parado":
          task = await fetch(
            `${site_url}/wp-json/upsent-api/v1/tasks/filter?per_page=${por_pag}&page=${atual_page}&status=${filter_selection}`
          );
          task_results = await task.json();
          break;
        case "em_andamento":
          task = await fetch(
            `${site_url}/wp-json/upsent-api/v1/tasks/filter?per_page=${por_pag}&page=${atual_page}&status=${filter_selection}`
          );
          task_results = await task.json();
          break;
        case "concluida":
          task = await fetch(
            `${site_url}/wp-json/upsent-api/v1/tasks/filter?per_page=${por_pag}&page=${atual_page}&status=completa`
          );
          task_results = await task.json();
          break;

        default:
          task = await fetch(
            `${site_url}/wp-json/upsent-api/v1/tasks/?per_page=${por_pag}&page=${atual_page}`
          );
          task_results = await task.json();
          break;
      }

      e.addEventListener("click", () => {
        getTaskMap(i, task_results);
      });
    });

    reportButton.forEach((e, i) => {
      e.addEventListener("click", () => {
        updatePopDesc[i].classList.add("reveal");
        closeButtonObservation[i].addEventListener("click", () => {
          const emp_budget = document.querySelectorAll(".valor_orçamento");
          const emp_project = document.querySelectorAll(".projeto");
          const emp_value_incoming =
            document.querySelectorAll(".valor_receber");
          const emp_aditional_value =
            document.querySelectorAll(".valor_adicional");
          const emp_km = document.querySelectorAll(".km");
          const emp_km_value = document.querySelectorAll(".valor_em_km");
          const emp_aditional_coust =
            document.querySelectorAll(".custos_adicionais");
          const emp_budget_value =
            document.querySelectorAll(".valor_orcamento");
          const task_date = document.querySelectorAll(".data_da_atividade");
          const city = document.querySelectorAll(".cidade");
          const uf = document.querySelectorAll(".uf");
          const emp_paprovment_responseble = document.querySelectorAll(
            ".responsavel_aprovacao"
          );
          const budget_describe = document.querySelectorAll(
            ".descricao_orcamento"
          );
          const solutionObservation=document.querySelectorAll(".solution-observation")

          document.cookie = `descritivo_ortcamento=${emp_budget[i].value}`;
          document.cookie = `projeto=${emp_project[i].value}`;
          document.cookie = `valor_a_receber=${emp_value_incoming[i].value}`;
          document.cookie = `valor_adicional=${emp_aditional_value[i].value}`;
          document.cookie = `km=${emp_km[i].value}`;
          document.cookie = `valor_km=${emp_km_value[i].value}`;
          document.cookie = `custo_adicional=${emp_aditional_coust[i].value}`;
          document.cookie = `valor-orcamento=${emp_budget_value[i].value}`;
          document.cookie = `data_da_atividade=${task_date[i].value}`;
          document.cookie = `cidade=${city[i].value}`;
          document.cookie = `uf=${uf[i].value}`;
          document.cookie = `aprovacao_responsavel=${emp_paprovment_responseble[i].value}`;
          document.cookie = `orcamento_descricao=${budget_describe[i].value}`;
          document.cookie=`observacao_solution=${solutionObservation[i].value}`
          updatePopDesc[i].classList.remove("reveal");
        });
      });
    });

    taskTable.forEach((e, i) => {
      deleteTask(e, i);

      description[i].addEventListener("click", async () => {
        modelDescription[i].classList.add("reveal");
        closeBtnDesc[i].addEventListener("click", () => {
          modelDescription[i].classList.remove("reveal");
        });
      });

      if (taskConclued[i].getAttribute("data-target") == 1) {
        comprovant_field[i].classList.add("reveal");
        comprovant_field[i].addEventListener("click", () => {
          img_pop_up[i].classList.add("reveal");
          closeBtnImg[i].addEventListener("click", () => {
            img_pop_up[i].classList.remove("reveal");
          });
        });
        employerDescriptionButton[i].classList.add("reveal")
        employerDescriptionButton[i].addEventListener("click",()=>{
          popEmployerDescritive[i].classList.add("reveal");
          employerButoncloseExplication[i].addEventListener("click",()=>{
            popEmployerDescritive[i].classList.remove("reveal");
          })
        })
      }
    });

    taskTableMobile.forEach((e, i) => {
      if (taskConclued[i].getAttribute("data-target") == 1) {
        comprovant_filed_mobile[i].classList.add("upsent-table-item");
        comprovant_filed_mobile[i].addEventListener("click", () => {
          img_pop_up[i].classList.add("reveal");
          closeBtnImg[i].addEventListener("click", () => {
            img_pop_up[i].classList.remove("reveal");
          });
        });

        employerDescriptionexplainMobile[i].classList.add("upsent-table-item")
        employerDescriptionexplainMobile[i].addEventListener("click",()=>{
          popEmployerDescritive[i].classList.add("reveal");
          employerButoncloseExplication[i].addEventListener("click",()=>{
            popEmployerDescritive[i].classList.remove("reveal");
          })
        })
      }

      descriptionMobile[i].addEventListener("click", async () => {
        modelDescription[i].classList.add("reveal");
        closeBtnDesc[i].addEventListener("click", () => {
          modelDescription[i].classList.remove("reveal");
        });
      });
      delete_task_mobile(e, i);
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
              `${site_url}/wp-json/upsent-api/v1/tasks/filter?per_page=${por_pag}&page=${atual_page}&status=${filter_selection}`
            );
            task_results = await task.json();
            break;
          case "em_andamento":
            task = await fetch(
              `${site_url}/wp-json/upsent-api/v1/tasks/filter?per_page=${por_pag}&page=${atual_page}&status=${filter_selection}`
            );
            task_results = await task.json();
            break;
          case "concluida":
            task = await fetch(
              `${site_url}/wp-json/upsent-api/v1/tasks/filter?per_page=${por_pag}&page=${atual_page}&status=completa`
            );
            task_results = await task.json();
            break;

          default:
            task = await fetch(
              `${site_url}/wp-json/upsent-api/v1/tasks/?per_page=${por_pag}&page=${atual_page}`
            );
            task_results = await task.json();
            break;
        }

        getTaskMap(i, task_results);
      });
    });
  }

  if (cadastroDeTarefas) {
    clientAddress.addEventListener("change", (e) => {
      getClientCoords(e.target.value);
    });
  }

  if (tarefas_concluidas) {
    taskTable.forEach((e, i) => {
      deleteButton[i].addEventListener("click", () => {
        swal({
          title: "Tem certeza?",
          text: "Uma vez deletada não poderar realocar mais",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        }).then((willDelete) => {
          if (willDelete) {
            delete_finish_task(e, i);
            swal("tarefa deletada com sucesso", {
              icon: "success",
            });
          } else {
            swal("Não deletada");
          }
        });
      });

      finishButtonBtn[i].addEventListener("click", async () => {
        e.remove();
        reopenTask(i);
      });
    });
    taskTableMobile.forEach((e, i) => {
      deleteButtonMobile[i].addEventListener("click", () => {
        swal({
          title: "Tem certeza?",
          text: "Uma vez deletada não poderar realocar mais",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        }).then((willDelete) => {
          if (willDelete) {
            delete_finish_task(e, i);
            swal("tarefa deletada com sucesso", {
              icon: "success",
            });
          } else {
            swal("Não deletada");
          }
        });
      });

      finishButtonBtnMobile[i].addEventListener("click", async () => {
        e.remove();
        reopenTask(i);
      });
    });
  }
});
