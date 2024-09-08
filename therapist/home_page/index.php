<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Therapist Home Page</title>
    <link rel="stylesheet" href="style.css">

</head>

<body>
    <header>
        <?php include "../../common/navbar/navbar.php"; ?>
    </header>
    <main class="main_container">
        <div class="patient_list_header">
            <h2>Patient List</h2>
            <div class="controls">
                <button class="filter-btn">Filter</button>
                <input type="search" placeholder="Search..." class="search-box" id="inp" onkeyup="myFunction()">
            </div>
        </div>

        <table class="patient_table">
            <thead>
                <tr>
                    <th>Patient Name</th>
                    <th>Journal Status</th>
                    <th>Requires Follow-up</th>
                    <th class="last_column">Created On</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Jack Ross</td>
                    <td class="status_unread">Unread</td>
                    <td>No</td>

                    <td>02/08/2024</td>
                </tr>
                <tr>
                    <td>David Jones</td>
                    <td class="status_uptodate">Up to date</td>
                    <td>Yes</td>

                    <td>02/08/2024</td>
                </tr>
                <tr>
                    <td>Mike Leo</td>
                    <td class="status_unread">Unread</td>
                    <td>Yes</td>

                    <td>02/08/2024</td>
                </tr>
                <tr>
                    <td>Josh Chen</td>
                    <td class="status_uptodate">Up to date</td>
                    <td>No</td>

                    <td>02/08/2024</td>
                </tr>
                <tr>
                    <td>Jack Ross</td>
                    <td class="status_unread">Unread</td>
                    <td>Yes</td>

                    <td>02/08/2024</td>
                </tr>
            </tbody>


        </table>
        <button class="add-patient-btn">Add Patients</button>


    </main>
    <script src="script.js"></script>

</body>

</html>