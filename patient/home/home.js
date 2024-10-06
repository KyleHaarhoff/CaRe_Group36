
document.addEventListener('DOMContentLoaded', function () {
    if (affirmation && editButton) {
        editButton.addEventListener('click', () => {


            const affirmationHeader = document.getElementById("affirmation");
            affirmationHeader.contentEditable = true;
            affirmationHeader.focus();
        });
    }
});

document.addEventListener('DOMContentLoaded', function () {
    const buttons = document.querySelectorAll('.careButton-editGoals');

    buttons.forEach(button => {
        button.addEventListener('click', function () {
            const targetUrl = this.getAttribute('data-target');
            if (targetUrl) {
                window.location.href = targetUrl;
            }
        });
    });
});

document.addEventListener('DOMContentLoaded', function () {
    const buttons = document.querySelectorAll('.careButton-writing');

    buttons.forEach(button => {
        button.addEventListener('click', function () {
            const targetUrl = this.getAttribute('data-target');
            if (targetUrl) {
                window.location.href = targetUrl;
            }
        });
    });
});
