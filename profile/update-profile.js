
flag = document.getElementById("flag")
if(flag.value == "1") {
    if(flag.dataset.flag == "1"){
        openNotification("Successfully updated", 3000, "0 0 10px rgba(0, 160, 0, 0.6)")
    }
    else{
        openNotification("A server error occurred", 3000, "0 0 10px rgba(160,0 , 0, 0.8)")
    }
}


document.getElementById('file-upload').addEventListener('change', function(event) {
    const file = event.target.files[0];
    if (file && file.type.startsWith('image/')) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('profile-img').src = e.target.result;
        };
        reader.readAsDataURL(file);
    } else {
        alert('Please select a valid image file.');
    }
});