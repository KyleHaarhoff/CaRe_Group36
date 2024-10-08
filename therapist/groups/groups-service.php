<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ob_start();
include_once __DIR__ . "/../../conf.php";


// Fetch all patients from the database
global $conn;
$patients = [];
$query = "SELECT id, first_name, last_name FROM Users WHERE user_type = 1"; // Assuming 1 is the Patient type
if ($result = $conn->query($query)) {
    while ($row = $result->fetch_assoc()) {
        $patients[] = $row;
    }
} else {
    echo "Error: " . $conn->error;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (isset($data['action'])) {
        switch ($data['action']) {
            case 'create_group':
                // Create Group
                $groupName = $data['groupName'];
                $selectedPatients = $data['selectedPatients'];

                // Check if group name is provided
                if (empty($groupName)) {
                    echo json_encode(['success' => false, 'message' => 'Group name is required.']);
                    exit;
                }

                // Check if any patients are selected
                if (empty($selectedPatients)) {
                    echo json_encode(['success' => false, 'message' => 'At least one patient must be selected.']);
                    exit;
                }

                // Insert group name into groups table
                $stmt = $conn->prepare("INSERT INTO groups (group_name, is_active) VALUES (?, ?)");
                $isActive = 1; // Assuming active by default
                $stmt->bind_param("si", $groupName, $isActive);
                if (!$stmt->execute()) {
                    echo json_encode(['success' => false, 'message' => 'Database error: ' . $stmt->error]);
                    exit;
                }

                // Get the last inserted group ID
                $groupId = $conn->insert_id;

                // Insert each selected patient into group_members table
                foreach ($selectedPatients as $patientId) {
                    $stmt = $conn->prepare("INSERT INTO group_members (group_id, user_id, created_by, created_date) VALUES (?, ?, ?, ?)");
                    $createdBy = 'admin'; //Need to replace with the actual username 
                    $createdDate = date('Y-m-d');
                    $stmt->bind_param("iiss", $groupId, $patientId, $createdBy, $createdDate);
                    if (!$stmt->execute()) {
                        echo json_encode(['success' => false, 'message' => $stmt->error]);
                        exit;
                    }
                }

                // Respond with success message
                header('Content-Type: application/json');
                echo json_encode(['success' => true]);
                break;

            case 'update_group':
                $groupName = $data['groupName'];
                $selectedPatients = $data['selectedPatients'];
                $groupId = $data['groupId'];

                // Check if group name is provided
                if (empty($groupName)) {
                    echo json_encode(['success' => false, 'message' => 'Group name is required.']);
                    exit;
                }

                // Check if any patients are selected
                if (empty($selectedPatients)) {
                    echo json_encode(['success' => false, 'message' => 'At least one patient must be selected.']);
                    exit;
                }

                $stmt = $conn->prepare("UPDATE groups SET group_name = ? WHERE id = ?");
                $stmt->bind_param("si", $groupName, $groupId);

                if (!$stmt->execute()) {
                    echo json_encode(['success' => false, 'message' => 'Database error: ' . $stmt->error]);
                    exit;
                }

                // Update group members: First, remove existing members for this group
                $stmt = $conn->prepare("DELETE FROM group_members WHERE group_id = ?");
                $stmt->bind_param("i", $groupId);

                if (!$stmt->execute()) {
                    echo json_encode(['success' => false, 'message' => 'Database error when deleting members: ' . $stmt->error]);
                    exit;
                }

                // Now, insert the updated members for this group
                foreach ($selectedPatients as $patientId) {
                    $stmt = $conn->prepare("INSERT INTO group_members (group_id, user_id, created_by, created_date) VALUES (?, ?, ?, ?)");
                    $createdBy = 'admin'; // Need to replace with the actual username
                    $createdDate = date('Y-m-d');
                    $stmt->bind_param("iiss", $groupId, $patientId, $createdBy, $createdDate);

                    if (!$stmt->execute()) {
                        echo json_encode(['success' => false, 'message' => $stmt->error]);
                        exit;
                    }
                }

                echo json_encode(['success' => true, 'message' => 'Group and members updated successfully.']);
                break;

            case 'delete_group':
                // Decode the JSON input properly
                $data = json_decode(file_get_contents('php://input'), true); // Ensure this is present if you don't have it

                if (isset($data['group_id'])) { // Use $data instead of $_POST
                    $group_id = intval($data['group_id']); // Get the group_id from $data

                    // Update the is_active flag to false for the correct group ID
                    $query = "UPDATE groups SET is_active = 0 WHERE id = ?";

                    // Prepare the statement
                    if ($stmt = $conn->prepare($query)) {
                        $stmt->bind_param("i", $group_id);

                        if ($stmt->execute()) {
                            // Return success response
                            echo json_encode(["status" => "success", "group_id" => $group_id]);
                        } else {
                            // Return failure response
                            echo json_encode(["status" => "error", "message" => "Failed to delete group."]);
                        }

                        $stmt->close();
                    } else {
                        echo json_encode(["status" => "error", "message" => "Failed to prepare the statement."]);
                    }
                } else {
                    echo json_encode(["status" => "error", "message" => "Group ID not provided."]);
                }
                break;

            case 'group_members':
                $groupId = $data['groupId'];
                $stmt = $conn->prepare("SELECT u.id, u.first_name, u.last_name 
                                FROM users u
                                JOIN group_members gm ON u.id = gm.user_id 
                                WHERE gm.group_id = ?");
                $stmt->bind_param("i", $groupId);
                $stmt->execute();
                $result = $stmt->get_result();

                $groupPatients = [];
                while ($row = $result->fetch_assoc()) {
                    $groupPatients[] = $row;
                }

                echo json_encode(['success' => true, 'groupPatients' => $groupPatients]); // Return the result as JSON
                break;

            case 'all_members':
                $stmt = $conn->prepare("SELECT id, first_name, last_name FROM Users WHERE user_type = 1");
                $stmt->execute();
                $result = $stmt->get_result();

                $patients = [];
                while ($row = $result->fetch_assoc()) {
                    $patients[] = $row;
                }

                echo json_encode(['success' => true, 'patients' => $patients]); // Return the result as JSON
                break;

            default:
                echo json_encode(['success' => false, 'message' => 'Invalid action.']);
                break;
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Action not specified.']);
    }
} else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (isset($data['action'])) {
        switch ($data['action']) {
            case 'group_members':
                $groupId = $data['groupId'];
                $stmt = $conn->prepare("SELECT u.id, u.first_name, u.last_name 
                            FROM users u
                            JOIN group_members gm ON u.id = gm.user_id 
                            WHERE gm.group_id = ?");
                $stmt->bind_param("i", $groupId);
                $stmt->execute();
                $result = $stmt->get_result();

                $groupPatients = [];
                while ($row = $result->fetch_assoc()) {
                    $groupPatients[] = $row;
                }

                echo json_encode(['success' => true, 'groupPatients' => $groupPatients]); // Return the result as JSON
                break;
            default:
                echo json_encode(['success' => false, 'message' => 'Invalid action.']);
                break;
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Action not specified.']);
    }
}


// Query to fetch active groups and their members
$query = "SELECT g.id AS group_id, g.group_name, u.first_name,u.last_name, gm.is_member FROM groups g LEFT JOIN group_members gm ON g.id = gm.group_id LEFT JOIN users u ON gm.user_id = u.id WHERE g.is_active = 1 AND gm.is_member = 1 ORDER BY g.id, u.first_name;";

$result = $conn->query($query);

$groups = [];
// Group data by group_id and populate members
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $groupId = $row['group_id'];
        if (!isset($groups[$groupId])) {
            $groups[$groupId] = [
                'group_name' => $row['group_name'],
                'members' => []
            ];
        }
        $groups[$groupId]['members'][] = $row['first_name'] . ' ' . $row['last_name'];
    }
}



// Close the connection
$conn->close();
ob_end_flush();

?>