<!DOCTYPE html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Investor Grievance Form</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background: linear-gradient(120deg, #f0f8ff 40%, #ffffff 100%);
        }

        .container {
            background-color: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 30px;
            border-radius: 10px;
            max-width: 900px;
            margin: 40px auto;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .form-control:focus {
            box-shadow: none;
            border-color: #007bff;
        }

        h2 {
            font-weight: bold;
            color: #007bff;
        }

        label {
            font-weight: 500;
        }

        .mb-4 {
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <h2 class="mb-4">INVESTORS GRIEVANCE</h2>
        <p class="text-center">Empowering Investors, Resolving Grievances: Fill out our form for prompt assistance.</p>
        <form action="submit_form.php" method="post" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-6 form-group">
                    <label for="name">Name *</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="col-md-6 form-group">
                    <label for="folio_no">Folio No./DP ID/Client ID *</label>
                    <input type="text" class="form-control" id="folio_no" name="folio_no" required>
                </div>
                <div class="col-md-6 form-group">
                    <label for="shares_held">No. of shares held *</label>
                    <input type="number" class="form-control" id="shares_held" name="shares_held" required>
                </div>
                <div class="col-md-6 form-group">
                    <label for="phone">Phone *</label>
                    <input type="text" class="form-control" id="phone" name="phone" required>
                </div>
                <div class="col-md-6 form-group">
                    <label for="email">Email *</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="col-md-6 form-group">
                    <label for="subject">Nature of Subject *</label>
                    <input type="text" class="form-control" id="subject" name="subject" required>
                </div>
                <div class="col-md-6 form-group">
                    <label for="attachment">Attachment</label>
                    <input type="file" class="form-control" id="attachment" name="attachment" style="border-radius: 4px; padding: 5px; width:840px">
                </div>

            </div>
            <div class="row">
                <div class="col-md-12 form-group">
                    <label for="postal_address">Postal Address *</label>
                    <textarea class="form-control" id="postal_address" name="postal_address" rows="3" required></textarea>
                </div>
                <div class="col-md-12 form-group">
                    <label for="complaint_details">Details of Complaint *</label>
                    <textarea class="form-control" id="complaint_details" name="complaint_details" rows="4" required></textarea>
                </div>
            </div>
            <button type="submit" class="btn btn-primary ">Submit</button>
        </form>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>