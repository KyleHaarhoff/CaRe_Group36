

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