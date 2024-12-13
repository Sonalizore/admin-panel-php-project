<?php
include 'config/database.php';

// Check if the request is a POST request and if 'id' is provided
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
   
    $id = intval($_POST['id']);

    // Prepare an update query to mark the submission as viewed
    $sql = "UPDATE users SET viewed_status = 1 WHERE id = ?";

   
    if ($stmt = $con->prepare($sql)) {
        // Bind the ID parameter to the statement
        $stmt->bind_param("i", $id);

        // Execute the statement
        if ($stmt->execute()) {
            // Output success message if the record was updated
            echo "Submission ID $id marked as viewed.";
        } else {
           
            echo "Error: " . $stmt->error;
        }

      
        $stmt->close();
    } else {
        // Output error message if the preparation failed
        echo "Error: " . $con->error;
    }

    
    $con->close();
} else {

    echo "Invalid request or missing ID.";
}
