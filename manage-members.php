<?php
include("services/auth.php");
session_start();
include("services/connection2.php");

// Handle Add Member
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] === 'add') {
        $fullName = $_POST['full_name'];
        $email = $_POST['email'];
        $passwordHash = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $role = $_POST['role'];
        $bio = $_POST['bio']; 

        $addQuery = "INSERT INTO Users (full_name, email, password_hash, role, bio) VALUES (?, ?, ?, ?,?)";
        $stmt = $conn->prepare($addQuery);
        $stmt->bind_param('sssss', $fullName, $email, $passwordHash, $role, $bio);  
        $stmt->execute();
        $stmt->close();
    }

    // Handle Edit Member
    if ($_POST['action'] === 'edit') {
        $id = $_POST['id'];
        $fullName = $_POST['full_name'];
        $email = $_POST['email'];
        $role = $_POST['role'];
        $bio = $_POST['bio'];  

        $editQuery = "UPDATE Users SET full_name = ?, email = ?, role = ?, bio = ? WHERE id = ?";
        $stmt = $conn->prepare($editQuery);
        $stmt->bind_param('ssssi', $fullName, $email, $role, $bio, $id);  
        $stmt->execute();
        $stmt->close();
    }

    // Handle Delete Member
    if ($_POST['action'] === 'delete') {
        $id = $_POST['id'];

        $deleteQuery = "DELETE FROM Users WHERE id = ?";
        $stmt = $conn->prepare($deleteQuery);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $stmt->close();
    }

    // Redirect to prevent form resubmission
    header('Location: manage-members.php');
    exit;
}

// Fetch Members
$membersQuery = "SELECT id, full_name, email, role, bio, created_at FROM Users";
$membersResult = $conn->query($membersQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Members</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
	<!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #0EBC17A1;">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Manage Members</a>
            <img src="images/MemLogo.png" alt="Logo" class="img-fluid" style="width: 100px; height: auto ;">
        </div>
    </nav>
	
    <div class="container my-5">
        <!-- Back Button -->
        <a href="adminpage.php" class="btn" style="background-color: #0EBC17A1; color: white ; position: absolute; top: 150px; left: 200px;">Back</a>
        <h2>Manage Members</h2>
        
        <!-- Add Member Button -->
        <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addMemberModal">Add Member</button>

        <!-- Members Table -->
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Bio</th> 
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $membersResult->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['full_name']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td><?php echo $row['role']; ?></td>
                    <td><?php echo $row['bio']; ?></td>
                    <td><?php echo $row['created_at']; ?></td>
                    <td>
                        <!-- Edit Button -->
                        <button class="btn btn-warning btn-sm" 
                            data-bs-toggle="modal" 
                            data-bs-target="#editMemberModal" 
                            data-id="<?php echo $row['id']; ?>" 
                            data-full_name="<?php echo $row['full_name']; ?>" 
                            data-email="<?php echo $row['email']; ?>" 
                            data-role="<?php echo $row['role']; ?>"
                            data-bio="<?php echo $row['bio']; ?>">
                            Edit
                        </button>

                        <!-- Delete Button -->
                        <form method="POST" style="display:inline-block;">
                            <input type="hidden" name="action" value="delete">
                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                            <button class="btn btn-danger btn-sm" type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <!-- Add Member Modal -->
    <div class="modal fade" id="addMemberModal" tabindex="-1" aria-labelledby="addMemberModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addMemberModalLabel">Add Member</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="action" value="add">
                        <div class="mb-3">
                            <label for="full_name" class="form-label">Full Name</label>
                            <input type="text" class="form-control" id="full_name" name="full_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="mb-3">
                            <label for="role" class="form-label">Role</label>
                            <select class="form-control" id="role" name="role" required>
                                <option value="Guest">Guest</option>
                                <option value="Member">Member</option>
                                <option value="Admin">Admin</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="bio" class="form-label">Bio</label>
                            <textarea class="form-control" id="bio" name="bio" rows="4" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success">Add</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Member Modal -->
    <div class="modal fade" id="editMemberModal" tabindex="-1" aria-labelledby="editMemberModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editMemberModalLabel">Edit Member</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="action" value="edit">
                        <input type="hidden" id="edit_id" name="id">
                        <div class="mb-3">
                            <label for="edit_full_name" class="form-label">Full Name</label>
                            <input type="text" class="form-control" id="edit_full_name" name="full_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="edit_email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_role" class="form-label">Role</label>
                            <select class="form-control" id="edit_role" name="role" required>
                                <option value="Guest">Guest</option>
                                <option value="Member">Member</option>
                                <option value="Admin">Admin</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="edit_bio" class="form-label">Bio</label>
                            <textarea class="form-control" id="edit_bio" name="bio" rows="4"required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-warning">Save Changes</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Populate Edit Modal with data
        const editMemberModal = document.getElementById('editMemberModal');
        editMemberModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const id = button.getAttribute('data-id');
            const fullName = button.getAttribute('data-full_name');
            const email = button.getAttribute('data-email');
            const role = button.getAttribute('data-role');
            const bio = button.getAttribute('data-bio');  

            document.getElementById('edit_id').value = id;
            document.getElementById('edit_full_name').value = fullName;
            document.getElementById('edit_email').value = email;
            document.getElementById('edit_role').value = role;
            document.getElementById('edit_bio').value = bio;  
        });
    </script>
</body>
</html>
