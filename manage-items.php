<?php
include("services/auth.php");
session_start();
include("services/connection2.php"); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Items</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #0EBC17A1;">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Manage Items</a>
            <img src="images/MemLogo.png" alt="Logo" class="img-fluid" style="width: 100px; height: auto ;">
        </div>
    </nav>

    <div class="container my-5">
        <h2 class="text-center mb-4">Item Management</h2>
		
		<!-- Back Button -->
		<a href="adminpage.php" class="btn" style="background-color: #0EBC17A1; color: white ; position: absolute; top: 100px; left: 300px;">Back</a>

        
        <!-- Noodles Table -->
        <div class="mb-4">
            <h4>Noodles</h4>
            <br>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Type</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Price (RM)</th>
                        <th>Status</th>
                        <th>Image</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $noodlesQuery = "SELECT * FROM Noodles";
                    $result = $conn->query($noodlesQuery);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                                <td>{$row['id']}</td>
                                <td>{$row['type']}</td>
                                <td>{$row['name']}</td>
                                <td>{$row['description']}</td>
                                <td>{$row['price']}</td>
                                <td>{$row['status']}</td>
                                <td><img src='{$row['image_url']}' alt='Noodle Image' style='max-width: 50px;'></td>
                                <td>
                                    <button type='button' class='btn btn-warning edit-noodle-btn'
										data-id='{$row['id']}'
										data-type='{$row['type']}'
										data-name='{$row['name']}'
										data-description='{$row['description']}'
										data-price='{$row['price']}'
										data-status='{$row['status']}'
										data-image-url='{$row['image_url']}'
										data-bs-toggle='modal'
										data-bs-target='#editNoodleModal'>
										Edit
									</button>

                                    <button type='button' class='btn btn-danger delete-noodle-btn' 
										data-id='{$row['id']}'
										data-bs-toggle='modal' 
										data-bs-target='#deleteNoodleModal'>Delete
									</button>

                                </td>
                            </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='8' class='text-center'>No noodles found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
	
	<!-- Center the button under the noodle list -->
	<div class="d-flex justify-content-center mb-3">
		<button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addNoodleModal">
			<i class="bi bi-plus-circle"></i> Add New Noodle
		</button>
	</div>
	
	<!-- Toppings Section -->
	<div class="container my-5">
		<h4>Toppings</h4>
		<br>
		<table class="table table-striped">
			<thead>
				<tr>
					<th>ID</th>
					<th>Name</th>
					<th>Price (RM)</th>
					<th>Image</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$toppingsQuery = "SELECT * FROM Toppings";
				$result = $conn->query($toppingsQuery);

				if ($result->num_rows > 0) {
					while ($row = $result->fetch_assoc()) {
						echo "<tr>
							<td>{$row['id']}</td>
							<td>{$row['name']}</td>
							<td>{$row['price']}</td>
							<td><img src='{$row['image_url']}' alt='Topping Image' style='max-width: 50px;'></td>
							<td>
								<button type='button' class='btn btn-warning edit-topping-btn'
									data-id='{$row['id']}'
									data-name='{$row['name']}'
									data-price='{$row['price']}'
									data-image-url='{$row['image_url']}'
									data-bs-toggle='modal'
									data-bs-target='#editToppingModal'>
									Edit
								</button>
								<button type='button' class='btn btn-danger delete-topping-btn' 
									data-id='{$row['id']}'
									data-bs-toggle='modal' 
									data-bs-target='#deleteToppingModal'>Delete
								</button>
							</td>
						</tr>";
					}
				} else {
					echo "<tr><td colspan='4' class='text-center'>No toppings found</td></tr>";
				}
				?>
			</tbody>
		</table>
	</div>

	<!-- Add Topping Button -->
	<div class="d-flex justify-content-center mb-3">
		<button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addToppingModal">
			<i class="bi bi-plus-circle"></i> Add New Topping
		</button>
	</div>

	<!-- Add Topping Modal -->
	<div class="modal fade" id="addToppingModal" tabindex="-1" aria-labelledby="addToppingModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<form method="POST" action="add-topping.php">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="addToppingModalLabel">Add New Topping</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body">
						<div class="mb-3 text-center">
							<img id="add-topping-image-preview" src="" alt="Image Preview" class="img-fluid rounded mb-3" style="max-height: 200px;">
						</div>
						<div class="mb-3">
							<label for="topping-name" class="form-label">Name</label>
							<input type="text" class="form-control" id="topping-name" name="name" required>
						</div>
						<div class="mb-3">
							<label for="topping-price" class="form-label">Price</label>
							<input type="number" step="0.01" class="form-control" id="topping-price" name="price" required>
						</div>
						<div class="mb-3">
							<label for="topping-image-url" class="form-label">Image URL</label>
							<input type="text" class="form-control" id="topping-image-url" name="image_url" oninput="previewToppingImage()" required>
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



	<!-- Edit Topping Modal -->
	<div class="modal fade" id="editToppingModal" tabindex="-1" aria-labelledby="editToppingModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<form method="POST" action="edit-topping.php">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="editToppingModalLabel">Edit Topping</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body">
						<input type="hidden" id="edit-topping-id" name="id">
						<div class="mb-3 text-center">
							<img id="edit-topping-image-preview" src="" alt="Image Preview" class="img-fluid rounded mb-3" style="max-height: 200px;">
						</div>
						<div class="mb-3">
							<label for="edit-topping-name" class="form-label">Name</label>
							<input type="text" class="form-control" id="edit-topping-name" name="name" required>
						</div>
						<div class="mb-3">
							<label for="edit-topping-price" class="form-label">Price</label>
							<input type="number" step="0.01" class="form-control" id="edit-topping-price" name="price" required>
						</div>
						<div class="mb-3">
							<label for="edit-topping-image-url" class="form-label">Image URL</label>
							<input type="text" class="form-control" id="edit-topping-image-url" name="image_url" oninput="previewToppingImage()" required>
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



	<!-- Delete Topping Modal -->
	<div class="modal fade" id="deleteToppingModal" tabindex="-1" aria-labelledby="deleteToppingModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<form method="POST" action="delete-topping.php">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="deleteToppingModalLabel">Delete Topping</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body">
						<p>Are you sure you want to delete this topping?</p>
						<input type="hidden" id="delete-topping-id" name="id">
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
						<button type="submit" class="btn btn-danger">Delete</button>
					</div>
				</div>
			</form>
		</div>
	</div>

	<!-- JavaScript for Toppings -->
	<script>
		const editModal = document.getElementById('editToppingModal');
		editModal.addEventListener('show.bs.modal', function (event) {
			const button = event.relatedTarget;
			const id = button.getAttribute('data-id');
			const name = button.getAttribute('data-name');
			const price = button.getAttribute('data-price');
			const imageUrl = button.getAttribute('data-image-url');

			// Populate the fields
			document.getElementById('edit-topping-id').value = id;
			document.getElementById('edit-topping-name').value = name;
			document.getElementById('edit-topping-price').value = price;
			document.getElementById('edit-topping-image-url').value = imageUrl;
			
			// Update the preview image
			document.getElementById('edit-topping-image-preview').src = imageUrl;
		});
		
		function previewToppingImage() {
		const imageUrl = document.getElementById('topping-image-url').value;
		const imagePreview = document.getElementById('add-topping-image-preview');
		
		// If editing, use the correct preview element
		if (imagePreview) {
			imagePreview.src = imageUrl;
		}

		const editImageUrl = document.getElementById('edit-topping-image-url').value;
		const editImagePreview = document.getElementById('edit-topping-image-preview');
		
		// If editing, update the edit preview as well
		if (editImagePreview) {
			editImagePreview.src = editImageUrl;
			}
		}
	</script>
	<script>
		document.querySelectorAll('.delete-topping-btn').forEach(button => {
			button.addEventListener('click', () => {
				const id = button.getAttribute('data-id');
				document.getElementById('delete-topping-id').value = id;
			});
		});
	</script>

	<!-- Add Noodle Modal -->
	<div class="modal fade" id="addNoodleModal" tabindex="-1" aria-labelledby="addNoodleModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<form method="POST" action="add-noodle.php">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="addNoodleModalLabel">Add New Noodle</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body">
						<div class="mb-3 text-center">
							<img id="add-noodle-image-preview" src="" alt="Image Preview" class="img-fluid rounded mb-3" style="max-height: 200px; display: none;">
						</div>
						<div class="mb-3">
							<label for="type" class="form-label">Type</label>
							<input type="text" class="form-control" id="type" name="type" required>
						</div>
						<div class="mb-3">
							<label for="name" class="form-label">Name</label>
							<input type="text" class="form-control" id="name" name="name" required>
						</div>
						<div class="mb-3">
							<label for="description" class="form-label">Description</label>
							<textarea class="form-control" id="description" name="description" required></textarea>
						</div>
						<div class="mb-3">
							<label for="price" class="form-label">Price</label>
							<input type="number" step="0.01" class="form-control" id="price" name="price" required>
						</div>
						<div class="mb-3">
							<label for="status" class="form-label">Status</label>
							<input type="text" class="form-control" id="status" name="status" required>
						</div>
						<div class="mb-3">
							<label for="image_url" class="form-label">Image URL</label>
							<input type="text" class="form-control" id="image_url" name="image_url" oninput="previewAddImage()" required>
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


	<!-- Edit Noodle Modal -->
	<div class="modal fade" id="editNoodleModal" tabindex="-1" aria-labelledby="editNoodleModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
		<form method="POST" action="edit-noodle.php">
		  <div class="modal-content">
			<div class="modal-header">
			  <h5 class="modal-title" id="editNoodleModalLabel">Edit Noodle</h5>
			  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
			  <div class="mb-3 text-center">
				<img id="edit-noodle-image-preview" src="" alt="Image Preview" class="img-fluid rounded mb-3" style="max-height: 200px;">
			  </div>
			  <input type="hidden" id="edit-noodle-id" name="id">
			  <div class="mb-3">
				<label for="edit-type" class="form-label">Type</label>
				<input type="text" class="form-control" id="edit-noodle-type" name="type" required>
			  </div>
			  <div class="mb-3">
				<label for="edit-name" class="form-label">Name</label>
				<input type="text" class="form-control" id="edit-noodle-name" name="name" required>
			  </div>
			  <div class="mb-3">
				<label for="edit-description" class="form-label">Description</label>
				<textarea class="form-control" id="edit-noodle-description" name="description" required></textarea>
			  </div>
			  <div class="mb-3">
				<label for="edit-price" class="form-label">Price</label>
				<input type="number" step="0.01" class="form-control" id="edit-noodle-price" name="price" required>
			  </div>
			  <div class="mb-3">
				<label for="edit-status" class="form-label">Status</label>
				<input type="text" class="form-control" id="edit-noodle-status" name="status" required>
			  </div>
			  <div class="mb-3">
				<label for="edit-image-url" class="form-label">Image URL</label>
				<input type="text" class="form-control" id="edit-noodle-image-url" name="image_url" oninput="previewEditImage()" required>
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

    <!-- Delete Noodle Modal -->
    <div class="modal fade" id="deleteNoodleModal" tabindex="-1" aria-labelledby="deleteNoodleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="delete-noodle.php">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteNoodleModalLabel">Delete Noodle</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to delete this noodle?</p>
                        <input type="hidden" id="delete-noodle-id" name="id">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
	
	<script>
		function previewAddImage() {
			const imageUrl = document.getElementById('image_url').value;
			const imagePreview = document.getElementById('add-noodle-image-preview');
			if (imageUrl) {
				imagePreview.src = imageUrl;
				imagePreview.style.display = 'block';
			} else {
				imagePreview.style.display = 'none';
			}
		}

		function previewEditImage() {
			const imageUrl = document.getElementById('edit-image-url').value;
			const imagePreview = document.getElementById('edit-noodle-image-preview');
			if (imageUrl) {
				imagePreview.src = imageUrl;
			} else {
				imagePreview.src = '';
			}
		}
	</script>

	<script>
		const editNoodleModal = document.getElementById('editNoodleModal');
		editNoodleModal.addEventListener('show.bs.modal', function (event) {
			const button = event.relatedTarget; // Button that triggered the modal
			const id = button.getAttribute('data-id');
			const type = button.getAttribute('data-type');
			const name = button.getAttribute('data-name');
			const description = button.getAttribute('data-description');
			const price = button.getAttribute('data-price');
			const status = button.getAttribute('data-status');
			const imageUrl = button.getAttribute('data-image-url');

			// Populate the noodle modal fields
			document.getElementById('edit-noodle-id').value = id;
			document.getElementById('edit-noodle-type').value = type;
			document.getElementById('edit-noodle-name').value = name;
			document.getElementById('edit-noodle-description').value = description;
			document.getElementById('edit-noodle-price').value = price;
			document.getElementById('edit-noodle-status').value = status;
			document.getElementById('edit-noodle-image-url').value = imageUrl;
		});

	</script>


	<script>
    document.querySelectorAll('.delete-noodle-btn').forEach(button => {
        button.addEventListener('click', () => {
            const id = button.getAttribute('data-id');
            document.getElementById('delete-noodle-id').value = id;
        });
    });
	</script>
	
	<!-- Toasts container -->
	<div class="position-fixed top-0 end-0 p-3" style="z-index: 11;">
		<div id="successToast" class="toast align-items-center text-bg-success" role="alert" aria-live="assertive" aria-atomic="true">
			<div class="d-flex">
				<div class="toast-body">
					<strong>Success!</strong> Action completed successfully.
				</div>
				<button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
			</div>
		</div>
	</div>
	
	<script>
		// Check URL parameters to show corresponding toast
		const urlParams = new URLSearchParams(window.location.search);

		// Noodle-related parameters
		const noodleAdded = urlParams.get('noodle-added');
		const noodleEdited = urlParams.get('noodle-edited');
		const noodleDeleted = urlParams.get('noodle-deleted');

		// Topping-related parameters
		const toppingAdded = urlParams.get('topping-added');
		const toppingEdited = urlParams.get('topping-edited');
		const toppingDeleted = urlParams.get('topping-deleted');

		const toastElement = document.getElementById('successToast');
		const toastBody = toastElement.querySelector('.toast-body');

		// Noodle notifications
		if (noodleAdded === '1') {
			toastBody.innerHTML = '<strong>Success!</strong> Noodle added successfully.';
			const toast = new bootstrap.Toast(toastElement);
			toast.show();
		} else if (noodleEdited === '1') {
			toastBody.innerHTML = '<strong>Success!</strong> Noodle edited successfully.';
			const toast = new bootstrap.Toast(toastElement);
			toast.show();
		} else if (noodleDeleted === '1') {
			toastBody.innerHTML = '<strong>Success!</strong> Noodle deleted successfully.';
			const toast = new bootstrap.Toast(toastElement);
			toast.show();
		}

		// Topping notifications
		else if (toppingAdded === '1') {
			toastBody.innerHTML = '<strong>Success!</strong> Topping added successfully.';
			const toast = new bootstrap.Toast(toastElement);
			toast.show();
		} else if (toppingEdited === '1') {
			toastBody.innerHTML = '<strong>Success!</strong> Topping edited successfully.';
			const toast = new bootstrap.Toast(toastElement);
			toast.show();
		} else if (toppingDeleted === '1') {
			toastBody.innerHTML = '<strong>Success!</strong> Topping deleted successfully.';
			const toast = new bootstrap.Toast(toastElement);
			toast.show();
		}
	</script>



</body>
</html>
