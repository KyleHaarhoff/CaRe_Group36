document.addEventListener('DOMContentLoaded', () => {
    const groupTitles = document.querySelectorAll('.group-title');

    groupTitles.forEach(title => {
        title.addEventListener('click', () => {
            const groupContent = title.nextElementSibling; // This selects the .group-content div
            const arrow = title.querySelector('.arrow');
            const isVisible = groupContent.style.display === 'block';

            // Toggle the display of the group content
            groupContent.style.display = isVisible ? 'none' : 'block';

            // Toggle the arrow direction
            arrow.innerHTML = isVisible ? '&#9660;' : '&#9650;';
        });
    });
});
