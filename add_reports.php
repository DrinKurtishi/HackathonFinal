 <?php
 // Database connection parameters
 require 'db.php';
 
 // Generate unique report_id
 $report_id = uniqid();
 
 // Check if report_id already exists in the table
 $query = "SELECT * FROM reports_t WHERE report_id = :report_id";
 $stmt = $conn->prepare($query);
 $stmt->bindParam(':report_id', $report_id);
 $stmt->execute();
 
 if ($stmt->rowCount() > 0) {
   // If report_id already exists, generate a new one
   $report_id = uniqid();
 }
 
 // Get other data (position_id, desc) from form or other source
 $position_id = $_POST['position_id'] ?? null;
 $desc = $_POST['desc'] ?? null;
 
 // Handle file upload
 $image_path = null;
 $uploadDir = "uploads/";
 $fileName = basename($_FILES["avatar"]["name"]);
 $target_file = $uploadDir . $fileName;
 $uploadOk = 1;
 $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
 $target_file = $uploadDir . uniqid() . '.' . $imageFileType; // Generate a unique filename
 
 if (move_uploaded_file($_FILES['avatar']['tmp_name'], $target_file)) {
   $image_path = $target_file; // Save the path to the uploaded file
 }
 
 $insert_query = "INSERT INTO reports_t (report_id, position_id, `desc`, image_path) 
 VALUES (:report_id, :position_id, :desc, :image_path)";
 $insert_stmt = $conn->prepare($insert_query);
 $insert_stmt->bindParam(':report_id', $report_id);
 $insert_stmt->bindParam(':position_id', $position_id);
 $insert_stmt->bindParam(':desc', $desc);
 $insert_stmt->bindParam(':image_path', $image_path);
 
 if ($insert_stmt->execute()) {
   echo "New record created successfully";
 } else {
   $errorInfo = $insert_stmt->errorInfo();
   echo "Error: " . $errorInfo[2];
 }
 
 // Close connection
 $conn = null;

 
// //Database connection parameters
// require 'db.php';

// // Generate unique report_id
// $report_id = uniqid();

// // Check if report_id already exists in the table
// $query = "SELECT * FROM reports_t WHERE report_id = :report_id";
// $stmt = $conn->prepare($query);
// $stmt->bindParam(':report_id', $report_id);
// $stmt->execute();

// if ($stmt->rowCount() > 0) {
//   // If report_id already exists, generate a new one
//   $report_id = uniqid();
// }

// // Get other data (position_id, desc) from form or other source
// $position_id = $_POST['position_id'] ?? null;
// $desc = $_POST['desc'] ?? null;

// $uploadDir = "uploads/";
// $fileName = basename($_FILES["avatar"]["name"]);
// $target_file = $uploadDir . $fileName;
// $uploadOk = 1;
// $imageFileType = $uploadDir . strtolower(pathinfo($target_file, PATHINFO_BASENAME)); // Include full path in imageFileType

// if (move_uploaded_file($_FILES['avatar']['tmp_name'], $target_file)) {
//   $image_path = $target_file; // Save the path to the uploaded file
// }

// $insert_query = "INSERT INTO reports_t (report_id, position_id, `desc`, image_path) 
// VALUES (:report_id, :position_id, :desc, :image_path)";
// $insert_stmt = $conn->prepare($insert_query);
// $insert_stmt->bindParam(':report_id', $report_id);
// $insert_stmt->bindParam(':position_id', $position_id);
// $insert_stmt->bindParam(':desc', $desc);
// $insert_stmt->bindParam(':image_path', $imageFileType);

// if ($insert_stmt->execute()) {
// echo "New record created successfully";
// } else {
// $errorInfo = $insert_stmt->errorInfo();
// echo "Error: ".$errorInfo[2];
// }

// // Close connection
// $conn = null; -->

// Handle file upload
//  $image_path = null;

// $uploadDir = "uploads/";
// $fileName = basename($_FILES["avatar"]["name"]);
// $target_file = $uploadDir . $fileName;
// $uploadOk = 1;
// $imageFileType = strtolower(pathinfo($target_file, PATHINFO_BASENAME)); // Include filename with extension in imageFileType



// Now $imageFileType will contain the full path (including "uploads/") with the filename and extension




// if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
//   $uploadDir = 'uploads/';
//   $uploadFile = $uploadDir . basename($_FILES['avatar']['name']);
//   if (move_uploaded_file($_FILES['avatar']['tmp_name'], $uploadFile)) {
//     $image_path = $uploadFile;
//   } else {
//     echo "Error moving uploaded file.";
//   }
// } else {
//   echo "File upload error: ".$_FILES['avatar']['error'];
// }

// Insert data into the table if image_path is set
// if ($image_path !== null) {


// } else {
//   echo "Image upload failed or image path is not valid.";
// }




/*
//Database connection parameters
require 'db.php';

// Generate unique report_id
$report_id = uniqid();

// Check if report_id already exists in the table
$query = "SELECT * FROM reports_t WHERE report_id = :report_id";
$stmt = $conn->prepare($query);
$stmt->bindParam(':report_id', $report_id);
$stmt->execute();

if ($stmt->rowCount() > 0) {
  // If report_id already exists, generate a new one
  $report_id = uniqid();
}

// Get other data (position_id, desc) from form or other source
$position_id = $_POST['position_id'] ?? null;
$desc = $_POST['desc'] ?? null;

// // Handle file upload
// $image_path = null;
// echo "para se me hi";
// if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
//   echo "hinem";
//   $uploadDir = 'C:\xampp\htdocs\Hackathon\uploads';
//   $uploadFile = $uploadDir . basename($_FILES['avatar']['name']);
//   echo "$uploadFile"; //maybe debug to check if the avatar itself is being registered
//   // if (move_uploaded_file($_FILES['avatar']['tmp_name'], $uploadFile)) {
//   //   $image_path = $uploadFile;
//   // }
// }

$image_path = null;
echo "Start of script<br>";

if (isset($_FILES['avatar'])) {
  echo "File 'avatar' is set<br>";
  if ($_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
    echo "File upload is OK<br>";
    $uploadDir = 'C:\xampp\htdocs\Hackathon\uploads\\';  // Ensure the path ends with a backslash
    $uploadFile = $uploadDir . basename($_FILES['avatar']['name']);
    echo "Upload file path: $uploadFile<br>";

    // Uncomment and test the actual file move operation
    // if (move_uploaded_file($_FILES['avatar']['tmp_name'], $uploadFile)) {
    //   $image_path = $uploadFile;
    //   echo "File successfully uploaded to: $uploadFile<br>";
    // } else {
    //   echo "Failed to move uploaded file.<br>";
    // }
  } else {
    echo "File upload error: " . $_FILES['avatar']['error'] . "<br>";
  }
} else {
  echo "File 'avatar' is not set<br>";
}

// Insert data into the table
$insert_query = "INSERT INTO reports_t (report_id, position_id, `desc`, image_path) 
                 VALUES (:report_id, :position_id, :desc, :image_path)";
$insert_stmt = $conn->prepare($insert_query);
$insert_stmt->bindParam(':report_id', $report_id);
$insert_stmt->bindParam(':position_id', $position_id);
$insert_stmt->bindParam(':desc', $desc);
$insert_stmt->bindParam(':image_path', $image_path);

if ($insert_stmt->execute()) {
  echo "New record created successfully";
} else {
  $errorInfo = $insert_stmt->errorInfo();
  echo "Error: " . $errorInfo[2];
}

// Close connection
$conn = null;
/*

//Database connection parameters
require 'db.php';

// Generate unique report_id
$report_id = uniqid();

// Check if report_id already exists in the table
$query = "SELECT * FROM reports_t WHERE report_id = :report_id";
$stmt = $conn->prepare($query);
$stmt->bindParam(':report_id', $report_id);
$stmt->execute();

if ($stmt->rowCount() > 0) {
  // If report_id already exists, generate a new one
  $report_id = uniqid();
}

// Get other data (position_id, desc, image_path) from form or other source
$position_id = $_POST['position_id'] ?? null;
$desc = $_POST['desc'] ?? null;
$image_path = $_POST['image_path'] ?? null;

// Insert data into the table
$insert_query = "INSERT INTO reports_t (report_id, position_id, `desc`, image_path) 
                 VALUES (:report_id, :position_id, :desc, :image_path)";
$insert_stmt = $conn->prepare($insert_query);
$insert_stmt->bindParam(':report_id', $report_id);
$insert_stmt->bindParam(':position_id', $position_id);
$insert_stmt->bindParam(':desc', $desc);
$insert_stmt->bindParam(':image_path', $image_path);

if ($insert_stmt->execute()) {
  echo "New record created successfully";
} else {
  $errorInfo = $insert_stmt->errorInfo();
  echo "Error: " . $errorInfo[2];
}

// Close connection
$conn = null;




/* Database connection parameters
require 'db.php';

// Generate unique report_id
$report_id = uniqid();

// Check if report_id already exists in the table
$query = "SELECT * FROM reports_t WHERE report_id = :report_id";
$stmt = $conn->prepare($query);
$stmt->bindParam(':report_id', $report_id);
$stmt->execute();

if ($stmt->rowCount() > 0) {
    // If report_id already exists, generate a new one
    $report_id = uniqid();
}

// Get other data (position_id, desc, image_path) from form or other source
$position_id = $_POST['position_id'] ?? null;
$desc = $_POST['desc'] ?? null;
$image_path = $_POST['image_path'] ?? null;

// Insert data into the table
$insert_query = "INSERT INTO reports_t (report_id, position_id, `desc`, image_path) 
                 VALUES (:report_id, :position_id, :desc, :image_path)";
$insert_stmt = $conn->prepare($insert_query);
$insert_stmt->bindParam(':report_id', $report_id);
$insert_stmt->bindParam(':position_id', $position_id);
$insert_stmt->bindParam(':desc', $desc);
$insert_stmt->bindParam(':image_path', $image_path);

if ($insert_stmt->execute()) {
    echo "New record created successfully";
} else {
    $errorInfo = $insert_stmt->errorInfo();
    echo "Error: " . $errorInfo[2];
}

// Close connection
$conn = null;
?>
*/

?>