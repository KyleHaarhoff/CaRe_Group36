//simple check and redirect to simulate login
//will be removed when access control is implementd

email = new URLSearchParams(window.location.search).get('email');
if(email == null) email = ""; 
if(email.includes("patient")){
    window.location.href = "patient/home/home.php";
}
else if (email.includes("therapist")){

    window.location.href = "therapist/home/home.php";
}
else{
    //show incorrect login
}