

document.addEventListener("DOMContentLoaded", function(event) {
    const changeButton= [...document.querySelectorAll(".change_btn")];
    const updatePopup = document.querySelectorAll(".upsent-pop-up")
    const closeBtn = document.querySelectorAll(".upsent_close_button")
    
    let count = 0;
    changeButton.forEach((e)=>{
        e.addEventListener('click',(j)=>{
        console.log(count)
        let singlePop = document.getElementById("upsent-"+count);
        console.log(singlePop);
        singlePop.classList.add("reveal");
        count++
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