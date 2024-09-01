
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