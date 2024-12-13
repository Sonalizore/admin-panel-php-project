<?php
include 'config/database.php';

// Set the headers to force download of an Excel file (CSV format)
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=grievance_data.csv");
header("Pragma: no-cache");
header("Expires: 0");

// Fetch data from the databases
$sql = "SELECT * FROM users";
$result = $con->query($sql);

// Print the column headers
echo "ID,Name,Folio No.,Shares Held,Postal Address,Phone,Email,Subject,Complaint Details,submitted_at\n";

// Print each row of the table
while($row = $result->fetch_assoc()) {
    echo $row['id'] . ",";
    echo $row['name'] . ",";
    echo $row['folio_no'] . ",";
    echo $row['shares_held'] . ",";
    echo "\"" . $row['postal_address'] . "\",";
    echo $row['phone'] . ",";
    echo $row['email'] . ",";
    echo "\"" . $row['subject'] . "\",";
    echo "\"" . $row['complaint_details'] . "\",";
    echo $row['submitted_at'] . "\n";
}

$con->close();
?>
