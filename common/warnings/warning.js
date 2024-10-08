//Get the page elements
warningContainer = document.getElementById('warningContainer')
warningTitle = document.getElementById('warningTitle')
acceptWarningButton = document.getElementById('acceptWarningButton')


/*
    function to display the confirmation dialogue with the given message
    the acceptFuncvtion and declineFunction will be called when the relevant button is clicked
    then the dialogue will be 'closed'
*/

function openWarnings(Message = "", acceptFunction){
    warningTitle.textContent = Message

    /*
        Due to the way anonymous functions work 
        I will be cloning the buttons so that
        they can be disposed of after the callback function has been called
    */
    

    clonedAccept = acceptWarningButton.cloneNode(true);
    acceptWarningButton.parentNode.replaceChild(clonedAccept, acceptWarningButton);
    
    warningContainer.style.display = "block";

    clonedAccept.addEventListener("click", ()=>{
        closeWarning()
        //remove the clones so that the function isn't called on subsequent clicks
        clonedAccept.parentNode.replaceChild(acceptWarningButton, clonedAccept);
        delete clonedAccept
    })

}

function closeWarning(){
    warningContainer.style.display = "none"
}