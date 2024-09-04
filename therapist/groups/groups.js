groupManagerCover = document.getElementById("managerCover")


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
    if(group == null){
        //we are adding a group
    }
    else{
        //we are editing an existing group
    }
    //make it visible
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
function closeGroupManager(groupDiv = null){
    groupManagerCover.style.display = "none"
}

function confirmSave(){
    openConfirmation("Are you sure you want to save?", showNotification, ()=>{})
}

function showNotification(){
    closeGroupManager()
    openNotification("Saved!", 3000)
}


function deleteGroup(id){
    openConfirmation("Are you sure you want to save?", ()=>{
        groupDiv = document.getElementById(id)
        groupDiv.style.display = "none"
        openNotification("Successfully deleted "+id+"!", 3000)
    }, ()=>{})
    
    
}