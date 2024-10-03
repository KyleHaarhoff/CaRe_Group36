//constant elements for easier access
const groupManagerCover = document.getElementById("managerCover")
const groupCount = document.getElementById('groupCount')
const allCount = document.getElementById('allCount')
const groupPatientList = document.getElementById("groupPatientList")
const allPatientList = document.getElementById("allPatientList")
const minCountInput = document.getElementById("minCount")
const groupSearchInput = document.getElementById("groupSearchInput");

function clearPopup() {
    document.getElementById("groupTitleInput").value = "";
    document.getElementById("groupIdForUpdate").innerHTML = "";
}

function populateAllPatients(ids) {
    const data = {
        action: 'all_members',
    };

    fetch('groups-service.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    })
        .then(response => response.json())
        .then(data => {
            var groupPatientList = document.getElementById('allPatientList');

            // Clear the previous list
            groupPatientList.innerHTML = "";

            // Populate the div with the group-specific patients
            data.patients.forEach(patient => {
                let isAlreadyMember = ids.some(id => id === patient.id);
                if (isAlreadyMember) return;

                var span = document.createElement('span');
                span.setAttribute('data-id', patient.id);
                span.innerText = patient.first_name + " " + patient.last_name;
                span.onclick = function () {
                    toggleSelected(span); // Optional: if you want to toggle selection
                };
                groupPatientList.appendChild(span);
            });
        })
}

function toggleDropdown(element, listId) {
    var content = document.getElementById(listId);
    if (content.style.display === "block") {
        content.style.display = "none";
    } else {
        content.style.display = "block";
    }
}


function openGroupManager(group = null) {
    
    if (group != null) {
        //we are editing an existing group
        //add title name
        groupElement = document.getElementById(group)
        title = groupElement.querySelector('.groupTitle').textContent
        document.getElementById("groupTitleInput").value = title
        let groupId = group.slice(5);
        document.getElementById("groupIdForUpdate").innerHTML = groupId;

        if (!groupId === "" || !isNaN(groupId)) {
            const data = {
                action: 'group_members', // Specify the action
                groupId: Number(groupId)
            };

            fetch('groups-service.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data)
            })
                .then(response => response.json())
                .then(data => {
                    var groupPatientList = document.getElementById('groupPatientList');

                    // Clear the previous list
                    groupPatientList.innerHTML = "";

                    let ids = [];
                    // Populate the div with the group-specific patients
                    data.groupPatients.forEach(function (patient) {
                        ids.push(patient.id);
                        var span = document.createElement('span');
                        span.setAttribute('data-id', patient.id);
                        span.innerText = patient.first_name + " " + patient.last_name;
                        span.onclick = function () {
                            toggleSelected(span); // Optional: if you want to toggle selection
                        };
                        groupPatientList.appendChild(span);
                    });
                    populateAllPatients(ids);
                })
        }
        else {
            populateAllPatients([]);
        }

    }
    else {
        populateAllPatients([]);
    }
    //make it visible
    setTimeout(() => updateCounts(), 500)
    groupManagerCover.style.display = "block"
}
function toggleSelected(div) {


    if (div.classList.contains("selected")) {
        div.classList.remove("selected")
    }
    else {
        div.classList.add("selected")
    }
}
function closeGroupManager() {
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
    Array.prototype.forEach.call(allPatientList.children, patient => {
        //make sure its visible as well
        patient.style.display = "block"
        if (patient.classList.contains("selected")) {
            patient.classList.remove("selected")
        }
    })
    //make sure the search bars are empty
    searchBars = document.getElementsByClassName("patientSearch")
    Array.prototype.forEach.call(searchBars, patientSearch => {
        patientSearch.value = ""
    })
    clearPopup();
}

function movePatientsLeft() {


    //move patients
    //iterate through in reverse order to resolve issues
    let children = Array.from(allPatientList.children);
    for (let i = children.length - 1; i >= 0; i--) {
        patient = children[i]
        if (patient.classList.contains("selected")) {
            allPatientList.removeChild(patient);
            groupPatientList.appendChild(patient);
        }
    }

    //make sure all elements are unselected
    Array.prototype.forEach.call(groupPatientList.children, patient => {
        if (patient.classList.contains("selected")) {
            patient.classList.remove("selected")
        }
    })
    updateCounts()
}
function movePatientsRight() {

    //move patients
    //iterate through in reverse order to resolve issues
    let children = Array.from(groupPatientList.children);
    for (let i = children.length - 1; i >= 0; i--) {
        patient = children[i]
        if (patient.classList.contains("selected")) {
            groupPatientList.removeChild(patient);
            allPatientList.appendChild(patient);
        }
    }

    //make sure all elements are unselected
    Array.prototype.forEach.call(allPatientList.children, patient => {
        if (patient.classList.contains("selected")) {
            patient.classList.remove("selected")
        }
    })
    updateCounts()
}

function confirmSave() {
    const groupTitleInput = document.getElementById('groupTitleInput');
    const groupName = groupTitleInput.value.trim();
    const groupPatientList = document.getElementById('groupPatientList');
    const groupId = document.getElementById("groupIdForUpdate").innerHTML;

    if (!groupName) {
        openConfirmation("Group name is required.", showNotification, () => { });
        return;
    }

    const selectedPatients = Array.from(groupPatientList.children)
        .map(patient => patient.getAttribute('data-id'));

    // Check if any patients are selected
    if (selectedPatients.length === 0) {
        openConfirmation("At least one patient must be in the group.", showNotification, () => { });
        return;
    }


    if (groupId === "" || isNaN(groupId)) {
        const data = {
            action: 'create_group', // Specify the action
            groupName: groupName,
            selectedPatients: selectedPatients
        };

        fetch('groups-service.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    openNotification("Successfully saved!", 3000)
                    // Clear input and reset selections
                    //groupTitleInput.value = '';
                    // selectedPatients.forEach(patientId => {
                    //     const patient = groupPatientList.querySelector(`[data-id="${patientId}"]`);
                    //     if (patient) {
                    //         groupPatientList.removeChild(patient);
                    //         allPatientList.appendChild(patient); // Move back to all patients
                    //     }
                    // });
                    // updateCounts(); // Update the counts after saving
                } else {
                    alert('Error saving group: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while saving the group.');
            });
    }
    else {
        const data = {
            action: 'update_group', // Specify the action
            groupName: groupName,
            groupId: Number(groupId),
            selectedPatients: selectedPatients
        };

        fetch('groups-service.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    openNotification("Successfully saved!", 3000)
                    // Clear input and reset selections
                    //groupTitleInput.value = '';
                    // selectedPatients.forEach(patientId => {
                    //     const patient = groupPatientList.querySelector(`[data-id="${patientId}"]`);
                    //     if (patient) {
                    //         groupPatientList.removeChild(patient);
                    //         allPatientList.appendChild(patient); // Move back to all patients
                    //     }
                    // });
                    // updateCounts(); // Update the counts after saving
                } else {
                    alert('Error saving group: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while saving the group.');
            });
    }

}

function showNotification() {
    closeGroupManager()
    openNotification("Saved!", 3000)
}


function deleteGroup(groupId) {
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "groups-service.php", true);
    xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                try {
                    const response = JSON.parse(xhr.responseText);
                    if (response.status === "success") {
                        const groupDiv = document.getElementById("Group" + groupId);
                        if (groupDiv) {
                            groupDiv.remove();
                            openNotification("Successfully deleted Group !", 3000);
                        }
                        else {
                            openNotification("Error: " + response.message, 3000);
                        }
                    } else {
                        openNotification("Error: Could not delete Group " + groupId + ".", 3000);
                    }
                } catch (e) {
                    console.error("Error parsing JSON:", e);
                }
            }
        }
    };

    const requestData = JSON.stringify({ action: 'delete_group', group_id: groupId }); // Ensure to use group_id
    xhr.send(requestData);
}





function searchGroups() {
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
        if (title.toLowerCase().includes(search) && count >= minCount)
            display = "block"
        //check all patients
        Array.prototype.forEach.call(patientList.children, patient => {
            if (patient.textContent.toLowerCase().includes(search) && count >= minCount)
                display = "block"
        })
        //choose display
        group.style.display = display
    });

}

function updateCounts() {
    allCount.textContent = "Count: " + allPatientList.children.length
    groupCount.textContent = "Count: " + groupPatientList.children.length
}

function searchGroupPatients(searchInput) {
    search = searchInput.value.toLowerCase()
    Array.prototype.forEach.call(groupPatientList.children, patient => {
        if (patient.textContent.toLowerCase().includes(search))
            patient.style.display = "block"
        else {
            patient.style.display = "none"
        }
    })
}
function searchAllPatients(searchInput) {
    search = searchInput.value.toLowerCase()
    Array.prototype.forEach.call(allPatientList.children, patient => {
        if (patient.textContent.toLowerCase().includes(search))
            patient.style.display = "block"
        else {
            patient.style.display = "none"
        }
    })
}