<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>History </title>
    <link rel="stylesheet" href="history.css">

</head>

<body>
    <header>
        <?php include "../../common/navbar/navbar.php"; ?>
    </header>
    <main class="main">

        <table class="history_table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Entry</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
            <?php
                $sql= "SELECT * FROM journal_entries  where patient_id = ? ORDER BY journal_date DESC LIMIT 4;";
                if ($stmt = mysqli_prepare($conn, $sql)) {
                    mysqli_stmt_bind_param($stmt, 'i', $_SESSION['id']);

                    mysqli_stmt_execute($stmt);

                    if($result = mysqli_stmt_get_result($stmt)) {
                        if(mysqli_num_rows($result)> 0) {
                            while($row=mysqli_fetch_assoc($result)) {
                                ?>
                                <tr onclick="journalRedirect(<?= $row['id'] ?>)">
                                    <td><?= $row['journal_date'] ?></td>
                                    <td><?php
                                    if (mb_strlen($row['journal_entry']) > 100) {
                                        echo mb_substr($row['journal_entry'], 0, 100) . '...';
                                    } else {
                                        echo $row['journal_entry'];
                                    }
                                    ?></td>
                                    <td><?= $moods[$row['mood']] ?></td>
                                </tr>
                                <?php
                            }
                        }
                    }
                }
            ?>
                

            </tbody>


        </table>


    </main>
    <script src="history.js"></script>

</body>

</html>