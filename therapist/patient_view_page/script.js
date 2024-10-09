//
message = new URLSearchParams(window.location.search).get('message');
if(message != null) {

    success = new URLSearchParams(window.location.search).get('success');
    if(success == "true"){
        openNotification(message, 3000, "0 0 10px rgba(0, 160, 0, 0.6)")
    }
    else{
        openNotification(message, 3000, "0 0 10px rgba(160,0 , 0, 0.8)")
    }
}

function saveInfo(){
        form = document.createElement('form');
        form.method = 'POST';  
        form.action = "patient_view_backend.php";  
        
        input = document.getElementById("followup")
        form.appendChild(input);
        
        input = document.getElementById("patient_id")
        form.appendChild(input);

        input = document.getElementById("note")
        form.appendChild(input);
        input = document.getElementById("case_type")
        form.appendChild(input);

        //Append the form to the body and submit it
        document.body.appendChild(form);
        form.submit();
}


function addConsultation(){
    form = document.createElement('form');
    form.method = 'POST';  
    form.action = "add-consultation.php";  
    
    input = document.getElementById("patient_id")
    form.appendChild(input);

    input = document.getElementById("session_length")
    form.appendChild(input);

    //Append the form to the body and submit it
    document.body.appendChild(form);
    form.submit();
}

function openAddConsultation(){
    document.getElementById("add-consultation-container").style.display = "block";

}
function closeAddConsultation(){
    document.getElementById("add-consultation-container").style.display = "none";

}