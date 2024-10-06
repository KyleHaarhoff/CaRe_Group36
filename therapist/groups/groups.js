//constant elements for easier access
const groupManagerCover = document.getElementById("managerCover")
const groupCount = document.getElementById('groupCount')
const allCount = document.getElementById('allCount')
const groupPatientList = document.getElementById("groupPatientList")
const allPatientList = document.getElementById("allPatientList")
const minCountInput = document.getElementById("minCount")
const groupSearchInput = document.getElementById("groupSearchInput")

//function to toggle visibility of group content
// function toggleDropdown(icon, contentID){
//     contentList = document.getElementById(contentID)

//     if(icon.classList.contains("vInvert")){
//         //if the icon is inverted the dropdown is open, close it
//         icon.classList.remove("vInvert")
//         contentList.style.display = 'none';
//     }
//     else{
//         icon.classList.add("vInvert")
//         contentList.style.display = 'block';
//     }
// }

function toggleDropdown(element, listId) {
    var content = document.getElementById(listId);
    if (content.style.display === "block") {
        content.style.display = "none";
    } else {
        content.style.display = "block";
    }
}


function openGroupManager(group = null){
    if(group != null){
        //we are editing an existing group
        //add title name
        groupElement = document.getElementById(group)
        title = groupElement.querySelector('.groupTitle').textContent
        document.getElementById("groupTitleInput").value = title
        //check patients

        patientList = groupElement.querySelector('.patientList');
        Array.prototype.forEach.call( patientList.children, patient =>{
            //find the patient id within the all patient list and add it to the group list

            Array.prototype.forEach.call( allPatientList.children, allPatient =>{
                if(allPatient.dataset.id == patient.dataset.id){
                    allPatientList.removeChild(allPatient);
                    groupPatientList.appendChild(allPatient);
                }
            })
        })

    }
    //make it visible
    updateCounts()
    groupManagerCover.style.display = "block"
}
function toggleSelected(div){
    

    if(div.classList.contains("selected")){
        div.classList.remove("selected")
    }
    else{
        div.classList.add("selected")
    }
}
function closeGroupManager(){
    groupManagerCover.style.display = "none"
    //make sure all elements are in all patients

    //iterate through in reverse order to resolve issues
    let children = Array.from(groupPatientList.children);
    for (let i = children.length - 1; i >= 0; i--) {
        patient = children[i]
        groupPatientList.removeChild(patient);
        allPatientList.appendChild(patient);
    }
    //make sure all elements are unselected
    Array.prototype.forEach.call( allPatientList.children, patient =>{
        //make sure its visible as well
        patient.style.display = "block"
        if(patient.classList.contains("selected")){
            patient.classList.remove("selected")
        }
    })
    //make sure the search bars are empty
    searchBars = document.getElementsByClassName("patientSearch")
    Array.prototype.forEach.call(searchBars, patientSearch =>{
        patientSearch.value = ""
    })
    
}

function movePatientsLeft(){

    
    //move patients
    //iterate through in reverse order to resolve issues
    let children = Array.from(allPatientList.children);
    for (let i = children.length - 1; i >= 0; i--) {
        patient = children[i]
        if(patient.classList.contains("selected")){
            allPatientList.removeChild(patient);
            groupPatientList.appendChild(patient);
        }
    }

    //make sure all elements are unselected
    Array.prototype.forEach.call( groupPatientList.children, patient =>{
        if(patient.classList.contains("selected")){
            patient.classList.remove("selected")
        }
    })
    updateCounts()
}
function movePatientsRight(){
    
    //move patients
    //iterate through in reverse order to resolve issues
    let children = Array.from(groupPatientList.children);
    for (let i = children.length - 1; i >= 0; i--) {
        patient = children[i]
        if(patient.classList.contains("selected")){
            groupPatientList.removeChild(patient);
            allPatientList.appendChild(patient);
        }
    }

    //make sure all elements are unselected
    Array.prototype.forEach.call( allPatientList.children, patient =>{
        if(patient.classList.contains("selected")){
            patient.classList.remove("selected")
        }
    })
    updateCounts()
}

function confirmSave(){
    //openConfirmation("Are you sure you want to save?", showNotification, ()=>{})
        const groupTitleInput = document.getElementById('groupTitleInput');
        const groupName = groupTitleInput.value.trim();
        const groupPatientList = document.getElementById('groupPatientList');

    if (!groupName) {
        //alert('Group name is required.');
        openConfirmation("Group name is required.", showNotification, ()=>{})
        return;
    }

   

    const selectedPatients = Array.from(groupPatientList.children)
    .map(patient => patient.getAttribute('data-id'));

    

        // Check if any patients are selected
    if (selectedPatients.length === 0) {
        openConfirmation("At least one patient must be in the group.", showNotification, ()=>{})
        return;
    }
    const data = {
        groupName: groupName,
        selectedPatients: selectedPatients
    };
     // Send data to the server via AJAX
     fetch('groups.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Group saved successfully!');
            // Optionally clear the input and reset selections
            groupTitleInput.value = '';
            selectedPatients.forEach(patientId => {
                const patient = groupPatientList.querySelector(`[data-id="${patientId}"]`);
                if (patient) {
                    groupPatientList.removeChild(patient);
                    allPatientList.appendChild(patient); // Move back to all patients
                }
            });
            updateCounts(); // Update the counts after saving
        } else {
            alert('Error saving group: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while saving the group.');
    });
}

function showNotification(){
    closeGroupManager()
    openNotification("Saved!", 3000)
}


function deleteGroup(groupId){
    // openConfirmation("Are you sure you want to delete the group?", ()=>{
    //     groupDiv = document.getElementById(id)
    //     groupDiv.remove()
    //     openNotification("Successfully deleted "+id+"!", 3000)
    // }, ()=>{})
        openConfirmation("Are you sure you want to delete the group?", () => {
            // AJAX call to update the is_active flag in the database
            const xhr = new XMLHttpRequest();
            xhr.open("POST", "groups.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4) {
                    if (xhr.status === 200) {
                        const response = JSON.parse(xhr.responseText);
                        if (response.status === "success") {
                            // On success, remove the group from the page
                            const groupDiv = document.getElementById("Group" + groupId);
                            if (groupDiv) {
                                groupDiv.remove();
                                openNotification("Successfully deleted Group " + groupId + "!", 3000);
                            }
                        } else {
                            openNotification("Error: " + response.message, 3000);
                        }
                    } else {
                        openNotification("Error: Could not delete Group " + groupId + ".", 3000);
                    }
                }
            };
        
            // Send the request with the correct group ID
            xhr.send("group_id=" + encodeURIComponent(groupId));
        }, () => {});
}

function searchGroups(){
    search = groupSearchInput.value.toLowerCase()
    minCount = minCountInput.value

    //get all groups
    groups = document.getElementsByClassName("groupContainer")
    //in each group
    Array.prototype.forEach.call(groups, group => {
        display = "none"
        //get grpup patient count
        patientList = group.querySelector('.patientList');

        count = patientList.children.length
        //check title
        title = group.querySelector('.groupTitle').textContent;
        if(title.toLowerCase().includes(search) && count >= minCount)
            display = "block"
        //check all patients
        Array.prototype.forEach.call( patientList.children, patient =>{
            if(patient.textContent.toLowerCase().includes(search)&& count >= minCount)
                display = "block"
        })
        //choose display
        group.style.display = display
    });
    
}

function updateCounts(){
    allCount.textContent = "Count: "+allPatientList.children.length
    groupCount.textContent = "Count: "+groupPatientList.children.length
}

function searchGroupPatients(searchInput){
    search = searchInput.value.toLowerCase()
    Array.prototype.forEach.call( groupPatientList.children, patient =>{
        if(patient.textContent.toLowerCase().includes(search))
            patient.style.display = "block"
        else{
            patient.style.display = "none"
        }
    })
}
function searchAllPatients(searchInput){
    search = searchInput.value.toLowerCase()
    Array.prototype.forEach.call( allPatientList.children, patient =>{
        if(patient.textContent.toLowerCase().includes(search))
            patient.style.display = "block"
        else{
            patient.style.display = "none"
        }
    })
}