
# Please note
The project is intended to be run with XAMPP from with the following file path htdocs/www/[project root folder]/     <br>
**If any changes to this are made, update the $base_url variable in the conf.php file with the correct route to the project root folder**<br>
For the test users use the following:<br>
patient:<br>
email: jackTheRosser@gmail.com  - password: password <br>
therapist:<br>
email: jessC@gmail.com  - password: password <br>
professional staff:<br>
email: Thandz@gmail.com -  password: password <br>
auditor:<br>
email: sa@gmail.com -  password: password <br>
<br>
<br>
# Git Commands for team members
<h2>Copy the repo into a folder</h2>
<p>git clone https://github.com/KyleHaarhoff/CaRe_Group36.git</p>
<h2>add the repo as the upstream origin</h2>
<p>git remote add upstream https://github.com/KyleHaarhoff/CaRe_Group36.git</p>
<h2>Get code from the repo</h2>
<p>git fetch upstream develop:upstream-develop</p>
<p>git merge upstream-develop</p>
<h2>push code to the repo</h2>
<p>git add . </p>
<p>git commit -m ""
<p>git push </p>
<h2>create a branch</h2>
<p>git branch branch_name</p>
<h2>switch to a brach</h2>
<p>git checkout branch_name</p>
<h2>The workflow should be as follows</h2>
<ul>
  <li>get the code from the repo</li>
  <li>to add a feature make sure you are on the develop branch and create a new branch from it - naming it appropriately</li>
  <li>use git pull regularly to ensure you are up to date</li>
  <li>commit and push changes to your branch regularly</li>
  <li>when you want other members to have your work, go to github and create a pull request to merge your branch into develop</li>
</ul>
