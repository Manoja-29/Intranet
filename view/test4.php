<?php
include_once "../commons/dbConnection.php";

$db = new dbConnection(); 

$currentWeekOffset = isset($_GET['offset']) ? (int)$_GET['offset'] : 0; 
$weekResult = []; 

$startDate = new DateTime();
$startDate->modify("monday this week +$currentWeekOffset week");
$endDate = clone $startDate;
$endDate->modify("+6 days");

$sql = "SELECT date, check_in, check_out FROM attendance WHERE date BETWEEN '{$startDate->format('Y-m-d')}' AND '{$endDate->format('Y-m-d')}'";
$result = $db->conn->query($sql); 

while ($row = $result->fetch_assoc()) {
    $weekResult[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weekly Attendance</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .present-bg {
            background-color: #46d492;
        }
        .absent-bg {
            background-color: #e86f6f;
        }
        .holiday-bg {
            background-color: #cf7fdb;
        }
        .weekend-bg {
            background-color: #f7eb83;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="week-attendance">
                <a href="?offset=<?php echo $currentWeekOffset - 1; ?>" class="previous" style="text-decoration:none; display:inline-block; padding: 8px 16px; background-color: transparent;" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='transparent';"> &lt; </a>
                <span id="dateRange">Loading...</span>
                <a href="?offset=<?php echo $currentWeekOffset + 1; ?>" class="next" style="text-decoration:none; display:inline-block; padding: 8px 16px; background-color: transparent;" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='transparent';"> &gt; </a>
            </div>

            <div id="weekDates">Loading attendance...</div>

            <div class="card-body">
                <table id="datatables-thisWeek" class="table">
                    <thead>
                        <tr>
                            <th width="80"></th>
                            <th width="90">Check-in</th>
                            <th></th>
                            <th width="100">Check Out</th>
                            <th width="110">Total Hours</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $daysOfWeek = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun']; 
                        $weekAttendance = []; 

                        foreach ($weekResult as $row) {
                            $date = new DateTime($row['date']);
                            $weekAttendance[$date->format('D')] = $row; // Map attendance to the day
                        }
                        
                        foreach ($daysOfWeek as $day) {
                            // Determine the date for this day in the current week
                            $date = new DateTime();
                            $dayOfWeek = $date->format('N'); // Get the current day of the week (1 = Monday, 7 = Sunday)
                            $offset = array_search($day, $daysOfWeek) - ($dayOfWeek - 1) + $currentWeekOffset * 7; // Include week offset
                            $currentDayDate = $date->modify("$offset days");
                            
                            // Format the date as '10, Thu'
                            $formattedDate = $currentDayDate->format('j, D'); 

                            // Default values
                            $formattedCheckIn = '-';
                            $formattedCheckOut = '-';
                            $totHours = '-';
                            $progressBarClass = '';
                            
                            // Check if attendance data exists for this day
                            if (isset($weekAttendance[$day])) {
                                $row = $weekAttendance[$day];
                                $checkInTime = new DateTime($row['check_in']);
                                $checkOutTime = $row['check_out'] ? new DateTime($row['check_out']) : null;

                                $formattedCheckIn = $checkInTime->format('h:i A'); 
                                $formattedCheckOut = $checkOutTime ? $checkOutTime->format('h:i A') : '-';

                                // Calculate total hours if check-out time exists
                                if ($checkOutTime) {
                                    $interval = $checkInTime->diff($checkOutTime);
                                    $totHours = sprintf('%02d:%02d', $interval->h, $interval->i);
                                }
                            }
                        ?>
                            <tr>
                                <td width="80"><strong><?php echo $formattedDate; ?></strong></td>
                                <td width="90"><?php echo $formattedCheckIn; ?></td>
                                <td>
                                    <div class="progress" style="height:2px;">
                                        <div class="progress-bar <?php echo $progressBarClass; ?>" style="width: 100%;">
                                        </div>
                                    </div>
                                </td>
                                <td width="100"><?php echo $formattedCheckOut; ?></td>
                                <td width="110"><strong><?php echo $totHours; ?> Hrs</strong></td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody> 
                </table>
            </div>
        </div>
    </div>
    <script>
        let currentWeekOffset = <?php echo $currentWeekOffset; ?>;

        function getFullWeekRange(offset){
            const today = new Date();
            const dayOfWeek = today.getDay();
            const daysToMonday = dayOfWeek === 0 ? 6 : dayOfWeek - 1;
            const monday = new Date(today);

            monday.setDate(today.getDate() - daysToMonday + (offset * 7));

            const weekDates = [];

            for (let i = 0; i < 7; i++) {
                const day = new Date(monday);
                day.setDate(monday.getDate() + i); 
                const formattedDate = day.toISOString().split('T')[0];
                weekDates.push(formattedDate);
            }
            
            return weekDates;
        }

        function updateDateRange() {
            const weekDates = getFullWeekRange(currentWeekOffset);
            const monday = new Date(weekDates[0]);
            const sunday = new Date(weekDates[6]);

            const options = { year: 'numeric', month: 'short', day: '2-digit' };
            const mondayTitle = monday.toLocaleDateString('en-US', options).toUpperCase();
            const sundayTitle = sunday.toLocaleDateString('en-US', options).toUpperCase();

            document.getElementById("dateRange").textContent =  `${mondayTitle} To ${sundayTitle}`;
            document.getElementById("weekDates").innerHTML = weekDates.join('<br>');
        }

        function changeWeek(direction) {
            currentWeekOffset += direction;
            updateDateRange();
        }

        window.onload = updateDateRange;
    </script>
</body>
</html>
