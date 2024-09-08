//constant elements for easier access
const groupManagerCover = document.getElementById("managerCover")
const groupCount = document.getElementById('groupCount')
const allCount = document.getElementById('allCount')
const groupPatientList = document.getElementById("groupPatientList")
const allPatientList = document.getElementById("allPatientList")

//function to toggle visibility of group content
function toggleDropdown(icon, contentID){
    contentList = document.getElementById(contentID)

    if(icon.classList.contains("vInvert")){
        //if the icon is inverted the dropdown is open, close it
        icon.classList.remove("vInvert")
        contentList.style.display = 'none';
    }
    else{
        icon.classList.add("vInvert")
        contentList.style.display = 'block';
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
    console.log(groupManagerCover.querySelector('.patientSearch'))
    Array.prototype.forEach.call(groupManagerCover.querySelector('.patientSearch'), patientSearch =>{
        console.log(patientSearch)
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
    openConfirmation("Are you sure you want to save?", showNotification, ()=>{})
}

function showNotification(){
    closeGroupManager()
    openNotification("Saved!", 3000)
}


function deleteGroup(id){
    openConfirmation("Are you sure you want to delete the group?", ()=>{
        groupDiv = document.getElementById(id)
        groupDiv.remove()
        openNotification("Successfully deleted "+id+"!", 3000)
    }, ()=>{})
    
    
}


function searchGroups(searchInput){
    search = searchInput.value.toLowerCase()
    //get all groups
    groups = document.getElementsByClassName("groupContainer")
    //in each group
    Array.prototype.forEach.call(groups, group => {
        display = "none"

        //check title
        title = group.querySelector('.groupTitle').textContent;
        if(title.toLowerCase().includes(search))
            display = "block"
        //check all patients
        patientList = group.querySelector('.patientList');
        Array.prototype.forEach.call( patientList.children, patient =>{
            if(patient.textContent.toLowerCase().includes(search))
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