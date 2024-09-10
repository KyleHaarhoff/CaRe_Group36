//simple check and redirect to simulate login
//will be removed when access control is implementd

email = new URLSearchParams(window.location.search).get('email');
if(email == null) email = ""; 
if(email.includes("patient")){
    window.location.href = "patient/home/home.php";
}
else if (email.includes("therapist")){

    window.location.href = "therapist/home_page/index.php";
}
else{
    //show incorrect login
    openNotification("Use therapist or patient as the email to go to the respective landing page", 8000, "0 0 10px rgba(160,0 , 0, 0.8)")
}