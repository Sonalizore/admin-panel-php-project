<?php
include 'config/database.php';

// Initialize error array
$errors = [];

// Helper function to sanitize input
function clean_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Validate and Sanitize Inputs
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Name Validation
    if (empty($_POST['name'])) {
        $errors['name'] = "Name is required.";
    } else {
        $name = clean_input($_POST['name']);
        if (!preg_match("/^[A-Za-z\s]+$/", $name)) {
            $errors['name'] = "Only letters and spaces are allowed in the name.";
        }
    }

    // Folio No Validation
    if (empty($_POST['folio_no'])) {
        $errors['folio_no'] = "Folio No./DP ID/Client ID is required.";
    } else {
        $folio_no = clean_input($_POST['folio_no']);
    }

    // Shares Held Validation
    if (empty($_POST['shares_held'])) {
        $errors['shares_held'] = "Number of shares held is required.";
    } else {
        $shares_held = clean_input($_POST['shares_held']);
        if (!is_numeric($shares_held)) {
            $errors['shares_held'] = "Only numeric values are allowed for shares held.";
        }
    }

    // Postal Address Validation
    if (empty($_POST['postal_address'])) {
        $errors['postal_address'] = "Postal address is required.";
    } else {
        $postal_address = clean_input($_POST['postal_address']);
    }

    // Phone Validation
    if (empty($_POST['phone'])) {
        $errors['phone'] = "Phone number is required.";
    } else {
        $phone = clean_input($_POST['phone']);
        if (!preg_match("/^\d{10}$/", $phone)) {
            $errors['phone'] = "Phone number must be 10 digits.";
        }
    }

    // Email Validation
    if (empty($_POST['email'])) {
        $errors['email'] = "Email is required.";
    } else {
        $email = clean_input($_POST['email']);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = "Invalid email format.";
        }
    }

    // Subject Validation
    if (empty($_POST['subject'])) {
        $errors['subject'] = "Nature of Subject is required.";
    } else {
        $subject = clean_input($_POST['subject']);
    }

    // Complaint Details Validation
    if (empty($_POST['complaint_details'])) {
        $errors['complaint_details'] = "Details of the complaint are required.";
    } else {
        $complaint_details = clean_input($_POST['complaint_details']);
    }

    // File Upload Handling
    $target_dir = "uploads/";
    $attachment = "";
    if (isset($_FILES['attachment']) && $_FILES['attachment']['error'] == 0) {
        $allowed_types = ['jpg', 'jpeg', 'png', 'pdf'];
        $file_type = strtolower(pathinfo($_FILES['attachment']['name'], PATHINFO_EXTENSION));

        if (!in_array($file_type, $allowed_types)) {
            $errors['attachment'] = "Only JPG, JPEG, PNG, and PDF files are allowed.";
        } else {
            $attachment = $target_dir . basename($_FILES['attachment']['name']);
            if (!move_uploaded_file($_FILES['attachment']['tmp_name'], $attachment)) {
                $errors['attachment'] = "Failed to upload the file.";
            }
        }
    }

    // If there are no errors, insert into the database
    if (empty($errors)) {
        $sql = "INSERT INTO users (name, folio_no, shares_held, postal_address, phone, email, subject, complaint_details, attachment) 
                VALUES ('$name', '$folio_no', '$shares_held', '$postal_address', '$phone', '$email', '$subject', '$complaint_details', '$attachment')";

        if ($con->query($sql) === TRUE) {
            echo "Form submitted successfully!";
        } else {
            echo "Error: " . $sql . "<br>" . $con->error;
        }

        // Close the connection
        $con->close();
    } else {
        // If there are validation errors, display them
        foreach ($errors as $error) {
            echo "<p style='color: red;'>" . $error . "</p>";
        }
    }
}
?>
