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
    console.log(searchVal);
}