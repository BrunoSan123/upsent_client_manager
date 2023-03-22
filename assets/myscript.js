

document.addEventListener("DOMContentLoaded", function(event) {
    const changeButton= [...document.querySelectorAll(".change_btn")];
    const updatePopup = document.querySelectorAll(".upsent-pop-up")
    const closeBtn = document.querySelectorAll(".upsent_close_button")
    var x = document.getElementById("demo");

    function getLocation() {
        if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(showPosition);
        } else { 
          x.innerHTML = "Geolocation is not supported by this browser.";
        }
      }

      function showPosition(position) {
        x.innerHTML = "Latitude: " + position.coords.latitude + 
        "<br>Longitude: " + position.coords.longitude;
      }
    
    
    
    let count = 0;
    changeButton.forEach((e)=>{
        e.addEventListener('click',()=>{
        console.log(count)
        let singlePop = document.getElementById("upsent-"+count);
        console.log(singlePop);
        singlePop.classList.add("reveal");
        getLocation()
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