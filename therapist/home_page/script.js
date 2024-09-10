// document.getElementById('search-box').addEventListener('keydown', function(event) {
//     if (event.key === 'Enter') {
//         const searchTerm = document.getElementById('search-box').value;
//         const resultElement = document.getElementById('search-result');
        
//         if (searchTerm.trim() !== '') {
//             resultElement.textContent = `You searched for: "${searchTerm}"`;
//         } else {
//             resultElement.textContent = 'Please enter a search term!';
//         }
//     }
// });

function myFunction(){
    let searchVal=document.getElementById('inp').value.toUpperCase();
    let tr=document.getElementsByTagName("tr");

    for(let i=0; i<tr.length; i++)
    {
        let td=tr[i].getElementsByTagName("td")[0];
        if(td){
            let text=td.innerText;
            if(text.toUpperCase().indexOf(searchVal)>-1){
                tr[i].style.display=""
            }else{
                tr[i].style.display="none"
            }
            
        }

    }
}

function filterTable(){
    var dropdown = document.getElementById("journal_status");
    var selectedValue = dropdown.value;
    console.log("Dropdown Selected Value: ", selectedValue);
    var table = document.getElementById('patient_table');
    var rows = table.getElementsByTagName("tr");

    for (var i = 1; i < rows.length; i++) {
        var row = rows[i];
        var journalStatus = row.cells[1].textContent.trim();
        if (selectedValue == "All" || journalStatus == selectedValue) {
            row.style.display = "";
        } else {
            row.style.display = "none";
        }
    }
}

