showHidden = false
toggleHiddenButton = document.getElementById("toggleHiddenButton")
goalsTable = document.getElementById("goalsTable")

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
    //check if complete is checked and add hidden as needed
    goalCheckbox = row.querySelectorAll('.goalCheckbox')[0];
    if (goalCheckbox.checked){
        if (showHidden)
            row.style.display = 'table-row'; 
        row.classList.add("hidden");
    }
    else{
        if (row.classList.contains("hidden"))
            row.classList.remove("hidden");
    }
    
    //make text non editable
    goalTitle = row.querySelectorAll('.goalTitle')[0];
    goalTitle.setAttribute('readonly', true);
    goalTitle.classList.remove("editing")

    //change the save button to edit
    saveButton = row.querySelectorAll('.tableButton')[0]

    //create new button 
    editButton = document.createElement('button');
    editButton.className = 'tableButton';
    editButton.textContent = 'Edit';
    editButton.addEventListener("click",() =>{
        makeEditable(editButton); 
    })
    saveButton.parentNode.replaceChild(editButton, saveButton);
    saveButton.remove()
    openNotification("Saved!", 3000)
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
        //get row
        row = inputElement.closest('tr');
        row.remove()
        openNotification("Successfully deleted!", 3000)
    }, ()=>{})
}