let type_select = document.getElementById('type_select')
let therapist_select = document.getElementById('therapist_select')
function toggleTherapistSelect(){
    if(type_select.value == "1"){
        therapist_select.style.visibility = "visible";
    }
    else{
        therapist_select.style.visibility = "hidden";
    }
}