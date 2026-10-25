<?php
include("services/auth.php");
session_start();
include("services/connection.php");

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_SESSION['user_id']; // Retrieve email (user_id) from session
    $full_name = $_POST['full_name'];
    $new_email = $_POST['email'];
    $bio = $_POST['bio'];

    try {
        // Update user details in the database
        $query = "UPDATE Users SET full_name = :full_name, email = :new_email, bio = :bio WHERE email = :email";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':full_name', $full_name);
        $stmt->bindParam(':new_email', $new_email);
        $stmt->bindParam(':bio', $bio);
        $stmt->bindParam(':email', $email);

        if ($stmt->execute()) {
            // Update session variables
            $_SESSION['full_name'] = $full_name;
            $_SESSION['user_id'] = $new_email; // Update session email
            $_SESSION['bio'] = $bio;

            // Redirect to profile page with success message
            header("Location: profile.php?success=1");
            exit();
        } else {
            $error = "Failed to update profile. Please try again.";
        }
    } catch (PDOException $e) {
        $error = "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile - Mem's Kolo Mee</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
<?php include("navbar.php"); ?>

<div class="container my-5">
    <h3>Edit Profile</h3>
    <?php if (isset($error)): ?>
        <div class="alert alert-danger">
            <?php echo htmlspecialchars($error); ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="edit_profile.php">
        <div class="mb-3">
            <label for="full_name" class="form-label">Full Name</label>
            <input type="text" class="form-control" id="full_name" name="full_name" value="<?php echo htmlspecialchars($_SESSION['full_name']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($_SESSION['email']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="bio" class="form-label">Bio</label>
            <textarea class="form-control" id="bio" name="bio" rows="3"><?php echo htmlspecialchars($_SESSION['bio'] ?? ''); ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Save Changes</button>
        <a href="profile.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>
</body>
</html>
