<?php
// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'config/database.php';
session_start();

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin_login.php");
    exit();
}

// Fetch the records
$sql = 'SELECT *, DATE_FORMAT(submitted_at,"%Y-%m-%d %h:%i:%s %p") as submitted_at_formatted, viewed_status FROM users ORDER BY id DESC';      
$result = $con->query($sql);

if ($result === false) {
    echo "Error executing query: " . $con->error;
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <!-- Include Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/2.1.6/css/dataTables.dataTables.css" rel="stylesheet">
    <style>
        /* Custom CSS for debugging */
        .debug-info { color: red; }
    </style>
</head>
<body>
    <div class="w-100 mt-1">
        <nav class="bg-white mb-1 px-2 position-sticky top-0 w-100 z-1">
            <div class="d-flex justify-content-between align-items-center py-2">
                <img src="assest/images/logo.png" alt="BF Utilities Logo" class="img-fluid" style="max-width: 200px;">
                <div class="d-flex justify-content-between mb-1">
                    <!-- Export button -->
                    <a href="export_excel.php" class="btn btn-primary me-2">Export</a>
                    <!-- Admin logout button -->
                    <a href="admin_logout.php" class="btn btn-danger">Logout</a>
                </div>
            </div>
        </nav>

        <div class="container-fluid position-relative mt-1">
            <table class="table table-bordered table-striped" id="example" style="width:100%">
                <thead>
                    <tr class="table-primary">
                        <th>ID</th>
                        <th>Name</th>
                        <th>Folio No.</th>
                        <th>Shares</th>
                        <th>Postal Address</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Subject</th>
                        <th>Complaint Details</th>
                        <th>Attachment</th>
                        <th>Submitted At</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $btnClass = isset($row['viewed_status']) && $row['viewed_status'] == 1 ? 'btn-light' : 'btn-info';
                            echo "<tr>
                                <td>" . htmlspecialchars($row['id']) . "</td>
                                <td>" . htmlspecialchars($row['name']) . "</td>
                                <td>" . htmlspecialchars($row['folio_no']) . "</td>
                                <td>" . htmlspecialchars($row['shares_held']) . "</td>
                                <td>" . htmlspecialchars($row['postal_address']) . "</td>
                                <td>" . htmlspecialchars($row['phone']) . "</td>
                                <td>" . htmlspecialchars($row['email']) . "</td>
                                <td>" . htmlspecialchars($row['subject']) . "</td>
                                <td>" . htmlspecialchars($row['complaint_details']) . "</td>
                                <td>";
                            if ($row['attachment']) {
                                echo "<a href='" . htmlspecialchars($row['attachment']) . "' download>Download</a>";
                            }
                            echo "</td>
                                <td>" . htmlspecialchars($row['submitted_at_formatted']) . "</td>
                                <td>
                                   <button class='btn $btnClass' data-bs-toggle='modal' data-bs-target='#viewModal' 
                                    onclick='populateModal(" . json_encode($row, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) . "); markAsViewed(" . $row['id'] . ", event, this)'>
                                    View
                                    </button>
                                </td>
                            </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='12'>No submissions found.</td></tr>";
                    }
                    $con->close();
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div id="printcontent">
                    <div class="modal-header">
                        <div class="w-100 d-flex flex-column">
                            <div class="w-100 d-flex justify-content-center">
                                <img src="assest/images/logo.png" alt="BF Utilities Logo" class="img-fluid" style="max-width: 200px;">
                            </div>
                            <h5 class="modal-title px-2" id="viewModalLabel">Grievance Details</h5>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="modalContent">
                        <!-- Data will be populated here via JavaScript -->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="downloadPDF()">Download as PDF</button>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript to populate modal, mark viewed status, and download PDF -->
    <script>
        // Function to populate the modal with row data
        function populateModal(rowData) {
            console.log(rowData); // Debug: check if data is received
            const modalContent = document.getElementById('modalContent');
            modalContent.innerHTML = `
                <table class="table">
                    <tr><th>ID</th><td>${rowData.id}</td></tr>
                    <tr><th>Name</th><td>${rowData.name}</td></tr>
                    <tr><th>Folio No.</th><td>${rowData.folio_no}</td></tr>
                    <tr><th>No. of Shares Held</th><td>${rowData.shares_held}</td></tr>
                    <tr><th>Postal Address</th><td>${rowData.postal_address}</td></tr>
                    <tr><th>Phone</th><td>${rowData.phone}</td></tr>
                    <tr><th>Email</th><td>${rowData.email}</td></tr>
                    <tr><th>Subject</th><td>${rowData.subject}</td></tr>
                    <tr><th>Complaint Details</th><td>${rowData.complaint_details}</td></tr>
                    <tr><th>Submitted At</th><td>${rowData.submitted_at_formatted}</td></tr>
                    <tr><th>Attachment</th><td>${rowData.attachment ? `<a href="${rowData.attachment}" download>Download</a>` : '-'}</td></tr>
                </table>
            `;
        }

        // Function to mark the submission as viewed (AJAX request to update viewed status)
        function markAsViewed(id, event, buttonElement) {
            if (event) {
                event.preventDefault();
            }

            const xhr = new XMLHttpRequest();
            xhr.open("POST", "mark_viewed.php", true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    console.log(xhr.responseText); // Log the response from mark_viewed.php
                    if (buttonElement) {
                        buttonElement.classList.remove('btn-info');
                        buttonElement.classList.add('btn-light');
                    }
                }
            };

            xhr.send("id=" + id);
        }

        // Function to download the modal content as PDF
    
function downloadPDF() {
    const element = document.getElementById('printcontent');

    // Use html2pdf to generate PDF from the content of #printcontent
    html2pdf().from(element).save(`Grievance_${document.getElementById('modalContent').querySelector('tr').children[1].innerText}.pdf`);
}

    </script>

    <!-- Include Bootstrap JS and other required libraries -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.datatables.net/2.1.6/js/dataTables.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            new DataTable('#example');
        });
    </script>
</body>
</html>
