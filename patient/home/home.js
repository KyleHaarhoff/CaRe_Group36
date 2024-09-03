function editAffirmation() {
    console.log("Edit Affirmation")
    let affirmation = prompt("Edit the daily affirmation:");
    if (affirmation) {
        document.querySelector('.affirmation h2').textContent = `"${affirmation}"`;
    }
}