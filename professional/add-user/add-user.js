
notification = new URLSearchParams(window.location.search).get('notification');
if(notification != null) {

    message = new URLSearchParams(window.location.search).get('message');
    success = new URLSearchParams(window.location.search).get('success');
    if(success == "true"){
        openNotification(message, 3000, "0 0 10px rgba(0, 160, 0, 0.6)")
    }
    else{
        openNotification(message, 3000, "0 0 10px rgba(160,0 , 0, 0.8)")
    }
}

let type_select = document.getElementById('type_select')
let therapist_select = document.getElementById('therapist_select_container')
function toggleTherapistSelect(){
    if(type_select.value == "1"){
        therapist_select.style.visibility = "visible";
    }
    else{
        therapist_select.style.visibility = "hidden";
    }
}