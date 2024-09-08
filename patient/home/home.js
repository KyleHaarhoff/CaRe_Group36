
document.addEventListener('DOMContentLoaded', function () {
    console.log("click")
    console.log("affirmation editButton 1",affirmation,editButton)
    if (affirmation && editButton) {
        console.log("affirmation editButton",affirmation,editButton)
        editButton.addEventListener('click', () => {


            const affirmationHeader = document.getElementById("affirmation");
            affirmationHeader.contentEditable = true;
            affirmationHeader.focus();
        });
    }
});

document.addEventListener('DOMContentLoaded', function () {
    const buttons = document.querySelectorAll('.careButton-patientHome');

    buttons.forEach(button => {
        button.addEventListener('click', function () {
            const targetUrl = this.getAttribute('data-target');
            if (targetUrl) {
                window.location.href = targetUrl;
            }
        });
    });
});
