

document.addEventListener("DOMContentLoaded", function(event) {
    const changeButton= [...document.querySelectorAll(".change_btn")];
    const updatePopup = document.querySelectorAll(".upsent-pop-up")
    const closeBtn = document.querySelectorAll(".upsent_close_button")
    
    changeButton.forEach((e)=>{
        e.addEventListener('click',(j)=>{
         updatePopup.forEach((pop)=>{
            console.log(pop)
            pop.classList.add("reveal")
        })
          
        })
    })

    closeBtn.forEach((e)=>{
        e.addEventListener('click',()=>{
            updatePopup.forEach((pop)=>{
                pop.classList.remove("reveal");
            })
        })
    })
});