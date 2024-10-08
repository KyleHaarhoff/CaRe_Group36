notificationContainer = document.getElementById('notificationContainer')
notificationText = document.getElementById('notificationText')


function openNotification(message = "", timeout= 2000, boxShadow = "0 0 10px rgba(0, 160, 0, 0.6)", shouldReload = false){
    notificationText.textContent= message
    notificationText.style["boxShadow"] = boxShadow

    notificationContainer.style.display = "flex"

    setTimeout(()=>{
        notificationContainer.style.display = "none";
        
        if (shouldReload) location.reload();
    }, timeout)
}