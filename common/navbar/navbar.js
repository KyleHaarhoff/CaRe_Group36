profileSettingsOpen = false
profileDropdownImage = document.getElementById("profileDropdownImage")
logoutContainer = document.getElementById("logoutContainer")

function toggleProfileSettings(){
    if(profileSettingsOpen){
        //close it
        profileDropdownImage.classList.remove("vInvert")
        logoutContainer.style.display = 'none';
    }
    else{
        //open it
        profileDropdownImage.classList.add("vInvert")
        logoutContainer.style.display = 'block';

    }


    profileSettingsOpen = !profileSettingsOpen
}

function redirect(url){
    window.location.replace(url)
}