//simple check and redirect to simulate login
//will be removed when access control is implementd

email = new URLSearchParams(window.location.search).get('email');
if(email == null) email = ""; 
if(email != ""){
    //show incorrect login
    openNotification("Incorrect Credentials", 8000, "0 0 10px rgba(160,0 , 0, 0.8)")
}