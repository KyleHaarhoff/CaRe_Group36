document.getElementById('start-writing').addEventListener('click', () => {
    alert('Start writing your journal entry');
});

document.getElementById('edit-goals').addEventListener('click', () => {
    alert('Edit your weekly goals');
});

function editAffirmation() {
    console.log("Edit Affirmation")
    let affirmation = prompt("Edit the daily affirmation:");
    if (affirmation) {
        document.querySelector('.affirmation h2').textContent = `"${affirmation}"`;
    }
}