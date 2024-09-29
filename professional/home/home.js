
const dropdown = document.getElementById("user_type");



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
    let selectedValue = dropdown.value;
    var table = document.getElementById('user_table');
    var rows = table.getElementsByTagName("tr");

    for (var i = 1; i < rows.length; i++) {
        console.log(rows[i].dataset)
        if (rows[i].dataset.userType == selectedValue || selectedValue=="All") {
            rows[i].style.display = "";
        } else {
            rows[i].style.display = "none";
        }
    }
}

//check for any notifications to display

notification = new URLSearchParams(window.location.search).get('notification');
if(notification != null) {

    message = new URLSearchParams(window.location.search).get('message');
    success = new URLSearchParams(window.location.search).get('success');
    if(success == "true"){
        openNotification(message, 3000, "0 0 10px rgba(0, 160, 0, 0.6)")
    }
    else{
        openNotification(message, 3000, "0 0 10px rgba(160,0 , 0, 0.8)")
    }
}