
document.addEventListener('DOMContentLoaded', function () {
    console.log("click")
    const affirmation = document.getElementById('affirmation');
    const editButton = document.getElementById('editButton');
    console.log("affirmation editButton 1",affirmation,editButton)
    if (affirmation && editButton) {
        console.log("affirmation editButton",affirmation,editButton)
        editButton.addEventListener('click', () => {
            const input = document.createElement('input');
            input.type = 'text';
            input.value = affirmation.textContent;

            // Replace h2 text with input field
            affirmation.innerHTML = '';
            affirmation.appendChild(input);
            input.focus();
            input.addEventListener('blur', saveChanges);
            input.addEventListener('keydown', (e) => {
                if (e.key === 'Enter') {
                    saveChanges();
                }
            });

            function saveChanges() {
                affirmation.textContent = input.value;
                input.removeEventListener('blur', saveChanges);
                input.removeEventListener('keydown', saveChanges);

            }
        });
    }
});