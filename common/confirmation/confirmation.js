//Get the page elements
confirmationContainer = document.getElementById('confirmationContainer')
confirmationTitle = document.getElementById('confirmationTitle')
acceptConfirmationButton = document.getElementById('acceptConfirmationButton')
declineConfirmationButton = document.getElementById('declineConfirmationButton')

/*
    function to display the confirmation dialogue with the given message
    the acceptFuncvtion and declineFunction will be called when the relevant button is clicked
    then the dialogue will be 'closed'
*/

function openConfirmation(Message = "", acceptFunction, declineFunction){
    confirmationTitle.textContent = Message

    /*
        Due to the way anonymous functions work 
        I will be cloning the buttons so that
        they can be disposed of after the callback function has been called
    */
    

    clonedAccept = acceptConfirmationButton.cloneNode(true);
    acceptConfirmationButton.parentNode.replaceChild(clonedAccept, acceptConfirmationButton);
    
    clonedDecline = declineConfirmationButton.cloneNode(true);
    declineConfirmationButton.parentNode.replaceChild(clonedDecline, declineConfirmationButton);

    //add the accept function
    clonedAccept.addEventListener("click", ()=>{
        acceptFunction()
        closeConfirmation()
        //remove the clones so that the function isn't called on subsequent clicks
        clonedAccept.parentNode.replaceChild(acceptConfirmationButton,clonedAccept);
        clonedDecline.parentNode.replaceChild(declineConfirmationButton,clonedDecline);
        delete clonedAccept
        delete clonedDecline
    })
    //add the decline function
    clonedDecline.addEventListener("click", ()=>{
        declineFunction()
        closeConfirmation()
        //remove the clones so that the function isn't called on subsequent clicks
        clonedAccept.parentNode.replaceChild(acceptConfirmationButton,clonedAccept);
        clonedDecline.parentNode.replaceChild(declineConfirmationButton,clonedDecline);
        delete clonedAccept
        delete clonedDecline
    })
    //make it visible 
    confirmationContainer.style.display = "block"

}

function closeConfirmation(){
    confirmationContainer.style.display = "none"
}