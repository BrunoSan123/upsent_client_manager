

document.addEventListener("DOMContentLoaded", function(event) {
    const changeButton= document.querySelectorAll(".change_btn");
    const updatePopup = document.querySelector(".upsent-pop-up")
    changeButton.forEach((e)=>{
        e.addEventListener('click',()=>{
           updatePopup.classList.add("reveal");
        })
    })
});