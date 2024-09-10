<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient View Page</title>
    <link rel="stylesheet" href="home.css">
    <link rel="stylesheet" href="../../style.css">
    <link rel="stylesheet" href="../../common/navbar/navbar.css">
    <link rel="stylesheet" href="../patient_view_page/view_page.css">
</head>
<body>
    <header>
        <?php include "../../common/navbar/navbar.php"; ?>
    </header>

    <main>
        <div class="container">
            <div class="profile-journal">
                <div class="profile">
                    <img src="../../assets/images/profile.avif" alt="Profile Picture" class="profile-img">
                    <h1>Ben White</h1>
                </div>
                <section class="journal">
                    <div class="journal-list">
                        <table>
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Entry</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>08/08/2024</td>
                                    <td>This is the start of a journal entry. It will cut off after...</td>
                                    <td>&#128512;</td>
                                </tr>
                                <tr>
                                    <td>07/08/2024</td>
                                    <td>This is the start of a journal entry. It will cut off after...</td>
                                    <td>&#128512;</td>
                                </tr>
                                <tr>
                                    <td>06/08/2024</td>
                                    <td>This is the start of a journal entry. It will cut off after...</td>
                                    <td>&#128512;</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <a href="../../therapist/history/history.php">
                    <button class="viewHistory">View Full History</button>
                    </a>
                </section>
            </div>
            <div class="main-content">
                <div class="patient-details">
                    <h2>General Patient Details</h2>
                    <p>Condition: PTSD</p>
                    <p>Age: 34</p>
                    <p>Email: benwhite321@gmail.com</p>
                    <p>Phone Number: +61542352363</p>
                    <p>Address: 21 street ave</p>
                </div>
                <div class="therapist-notes">
                    <h2>Therapist Notes</h2>
                    <textarea>Ben is experiencing heightened work-related stress...</textarea>
                    <div class="actions"></div>
                    
                    
                    <label for="followup">Requires Follow Up</label>
                    <input type="checkbox" id="followup" name="followup"><br>
                    
                    <button class="viewHistory">Save Notes</button>
                   
                    <br>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script src="home.js"></script>
    <script src="../../common/navbar/navbar.js"></script>
</body>
</html>
