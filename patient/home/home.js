
message = new URLSearchParams(window.location.search).get('message');
if(message != null) {

    success = new URLSearchParams(window.location.search).get('success');
    if(success == "true"){
        openNotification(message, 3000, "0 0 10px rgba(0, 160, 0, 0.6)")
    }
    else{
        openNotification(message, 3000, "0 0 10px rgba(160,0 , 0, 0.8)")
    }
}

document.addEventListener('DOMContentLoaded', function () {
    editButton = document.getElementById('editButton')
    if (affirmation && editButton) {
        editButton.addEventListener('click', () => {
            editButton = document.getElementById('editButton')


            const affirmationHeader = document.getElementById("affirmation");
            affirmationHeader.contentEditable = true;
            affirmationHeader.focus();

            //change the button to save
            saveButton = document.createElement('button');
            saveButton.innerHTML = "Save";
            editButton.parentNode.replaceChild(saveButton, editButton);

            saveButton.classList.add('careButton')
            saveButton.addEventListener('click', () => {
                
                var form = document.createElement('form');
                form.method = 'POST';  
                form.action = "update-affirmation.php";  
                
                input = document.createElement('input');
                input.type = 'hidden';
                input.name = "affirmation";
                input.value = affirmationHeader.textContent;
                form.appendChild(input);

                document.body.appendChild(form);
                form.submit();

            })

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
