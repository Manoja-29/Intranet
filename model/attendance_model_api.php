<?php
// Replace these values with your database credentials
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "intranet";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode(['error' => 'Failed to connect to the database']));
}

header('Content-Type: application/json');

$action = $_REQUEST['action'] ?? '';

switch ($action) {
    case 'get_users':
        get_users($conn);
        break;
    case 'check_in_out':
        check_in_out($conn);
        break;

    default:
        echo json_encode(['error' => 'Invalid action']);
        break;
}

function get_users($conn) {
    $user_id = $_GET['user_id'] ?? '';
    date_default_timezone_set('Asia/Colombo');

    $dateToday=date("Y-m-d");

    if (empty($user_id)) {
        echo json_encode(['error' => 'Invalid building ID']);
        return;
    }
    $sql_present = "SELECT user_id, check_in, check_out, is_present FROM attendance WHERE user_id = ? AND is_present = 1 AND date='$dateToday'";
    $sql_absent = "SELECT user_id, check_in, check_out, is_present FROM attendance WHERE user_id = ? AND is_present = 0 AND date='$dateToday'";

    $stmt_present = $conn->prepare($sql_present);
    $stmt_present->bind_param("i", $user_id);
    $stmt_present->execute();
    $result_present = $stmt_present->get_result()->fetch_all(MYSQLI_ASSOC);

    $stmt_absent = $conn->prepare($sql_absent);
    $stmt_absent->bind_param("i", $user_id);
    $stmt_absent->execute();
    $result_absent = $stmt_absent->get_result()->fetch_all(MYSQLI_ASSOC);

    echo json_encode(['present' => $result_present, 'absent' => $result_absent]);
}
function check_in_out($conn) {
    date_default_timezone_set('Asia/Colombo');

    $user_id = $_POST['user_id'] ?? '';
    $is_present = $_POST['is_present'] ?? '';
    $dateToday=date("Y-m-d");

    try{
    if (empty($user_id)) {
        echo json_encode(['error' => 'Invalid user ID']);
        return;
    }
    include '../model/attendance_model.php';
    $attendanceObj=new Attendance();

    $time = date( 'h:i A', time () );

    $zero=0;
    $one=1;

    $checkedout=$attendanceObj->CheckedIn($user_id,$dateToday);
    if($checkedout == false){

        /*check in if is_present is 0 and check out if is_present is 1*/
        $sql = "UPDATE attendance SET is_present = ?,check_in='$time'  WHERE user_id = ? AND date='$dateToday'";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $one, $user_id);

        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['error' => 'Failed to update user status']);
        }

    }else{
        $sql = "UPDATE attendance SET is_present = ?,check_out='$time'  WHERE user_id = ? AND date='$dateToday'";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $zero, $user_id);

        if ($stmt->execute()) {
            echo json_encode(['success' => true]);

        } else {
            echo json_encode(['error' => 'Failed to update user status']);
        }
    }

    }
    catch (Exception $exception)
    {
        $msg=$exception->getMessage();
        $msg=base64_encode($msg);

        ?>
        <script>
            window.location = "../view/dashboard.php?msg=<?php echo $msg; ?>"
        </script>

        <?php
    }
}
$conn->close();
