<?php
// Error and success messages
$errors = [];
$successMsg = "";

// If form submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    foreach ($_POST as $field => $value) {
        $value = trim($value);

        switch ($field) {
            case "name":
                if ($value == "") {
                    $errors[$field] = "Name is required";
                } elseif (preg_match("/[0-9]/", $value)) {
                    $errors[$field] = "Name cannot contain numbers";
                }
                break;

            case "email":
                if ($value == "") {
                    $errors[$field] = "Email is required";
                } elseif (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $errors[$field] = "Invalid email format";
                }
                break;

            case "password":
                if ($value == "") {
                    $errors[$field] = "Password is required";
                } elseif (strlen($value) < 6) {
                    $errors[$field] = "Password must be at least 6 characters";
                }
                break;

            case "mobile":
                if ($value == "") {
                    $errors[$field] = "Mobile number is required";
                } elseif (!preg_match("/^[0-9]{10}$/", $value)) {
                    $errors[$field] = "Enter a valid 10-digit mobile number";
                }
                break;

            default:
                if ($value == "") {
                    $errors[$field] = ucfirst($field) . " is required";
                }
        }
    }

    // If no errors → save to file
    if (empty($errors)) {
        $data = "---- New Submission ----\n";
        foreach ($_POST as $key => $val) {
            $data .= ucfirst($key) . ": " . htmlspecialchars($val) . "\n";
        }
        $data .= "-------------------------\n";

        file_put_contents("submissions.txt", $data, FILE_APPEND);

        $successMsg = "✅ Form submitted successfully!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Form Validation Result</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
  <h2>Form Submission Result</h2>

  <?php if ($successMsg) { ?>
    <div class="alert alert-success"><?php echo $successMsg; ?></div>
  <?php } ?>

  <?php if (!empty($errors)) { ?>
    <div class="alert alert-danger"><b>Errors found:</b>
      <ul>
        <?php foreach ($errors as $err) echo "<li>$err</li>"; ?>
      </ul>
    </div>
  <?php } ?>

  <a href="index.html" class="btn btn-primary">Go Back</a>
</div>
</body>
</html>
