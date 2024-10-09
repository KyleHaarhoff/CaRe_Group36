showHidden = false
toggleHiddenButton = document.getElementById("toggleHiddenButton")
goalsTable = document.getElementById("goalsTable")

//check for any notifications to display

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



function makeEditable(inputElement){
    //get row
    row = inputElement.closest('tr');
    //make the goal text editable
    goalTitle = row.querySelectorAll('.goalTitle')[0];
    goalTitle.removeAttribute('readonly');
    goalTitle.classList.add("editing")
    //change the edit button to save
    editButton = row.querySelectorAll('.tableButton')[0]

    //create new button 
    saveButton = document.createElement('button');
    saveButton.className = 'tableButton';
    saveButton.textContent = 'Save';
    saveButton.addEventListener("click",() =>{
        saveGoal(saveButton); 
    })
    editButton.parentNode.replaceChild(saveButton, editButton);
    editButton.remove()
}

function saveGoal(inputElement){
    //get row
    row = inputElement.closest('tr');
    //Create a form to mimic the submision proccess
    var form = document.createElement('form');
    form.method = 'POST';  
    form.action = "goals_backend.php";  

    //Check if we are adding or updating
    if (row.hasAttribute('data-id')) {
        //we are updating
        input = document.createElement('input');
        input.type = 'hidden';
        input.name = "type";
        input.value = "update";
        form.appendChild(input);
        
        input = document.createElement('input');
        input.type = 'hidden';
        input.name = "goal_id";
        input.value = row.getAttribute('data-id');
        form.appendChild(input);
        
        //check if complete is checked
        input = document.createElement('input');
        input.type = 'hidden';
        input.name = "is_completed";
        goalCheckbox = row.querySelectorAll('.goalCheckbox')[0];
        if (goalCheckbox.checked){
            input.value = 1
        }
        else{
            input.value = 0
        }
        form.appendChild(input);

        
        goalTitle = row.querySelectorAll('.goalTitle')[0]
        input = document.createElement('input');
        input.type = 'hidden';
        input.name = "goal_text";
        input.value = goalTitle.value;
        form.appendChild(input);

    } else {
        //we are adding a new goal
        input = document.createElement('input');
        input.type = 'hidden';
        input.name = "type";
        input.value = "add";
        form.appendChild(input);
        
        //check if complete is checked
        input = document.createElement('input');
        input.type = 'hidden';
        input.name = "is_completed";
        goalCheckbox = row.querySelectorAll('.goalCheckbox')[0];
        if (goalCheckbox.checked){
            input.value = 1
        }
        else{
            input.value = 0
        }
        form.appendChild(input);
        
        goalTitle = row.querySelectorAll('.goalTitle')[0]
        input = document.createElement('input');
        input.type = 'hidden';
        input.name = "goal_text";
        input.value = goalTitle.value;
        form.appendChild(input);
    }
    //Append the form to the body and submit it
    document.body.appendChild(form);
    form.submit();
}

function toggleHidden(){
    if(showHidden){
        //hide elements
        const goals = goalsTable.querySelectorAll('.hidden');
        Array.prototype.forEach.call( goals, goal =>{
            goal.style.display = 'none';  
        });
        //change the text
        toggleHiddenButton.textContent = "Show Completed"
    }
    else{
        //show elements
        const goals = document.querySelectorAll('.hidden');
        Array.prototype.forEach.call( goals, goal =>{
            goal.style.display = 'table-row';  
        });

        //change the text
        toggleHiddenButton.textContent = "Hide Completed"
    }
    showHidden = !showHidden
}

function addGoal(){
    tableBody = goalsTable.querySelectorAll('tbody')[0];
    tableBody.innerHTML +=
                `<tr>
                        <td><input type="checkbox" class="goalCheckbox" onclick="makeEditable(this)"></td>
                        <td><input type="text" value = "" class="goalTitle editing"></td>
                        <td><button class="tableButton" onclick="saveGoal(this)">Save</button></td>
                        <td><button class="tableButton" onclick="confirmRemoveGoal(this)">Remove</button></td>
                </tr>`
}

function confirmRemoveGoal(inputElement){
    openConfirmation("Are you sure you want to delete the goal?", ()=>{
        row = inputElement.closest('tr');
        form = document.createElement('form');
        form.method = 'POST';  
        form.action = "goals_backend.php";  
        
        input = document.createElement('input');
        input.type = 'hidden';
        input.name = "type";
        input.value = "delete";
        form.appendChild(input);
        
        input = document.createElement('input');
        input.type = 'hidden';
        input.name = "goal_id";
        input.value = row.getAttribute('data-id');
        form.appendChild(input);

        //Append the form to the body and submit it
        document.body.appendChild(form);
        form.submit();
    }, ()=>{})
}

