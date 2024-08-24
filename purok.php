<?php include 'server/server.php'; ?>

<?php
    $query = "SELECT tblpurok.*, COUNT(tblresident.id) as residents_count
              FROM tblpurok
              LEFT JOIN tblresident ON tblpurok.id = tblresident.purok
              GROUP BY tblpurok.id
              ORDER BY tblpurok.name";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $result = $stmt->get_result();

    $purok = array();
    while ($row = $result->fetch_assoc()) {
        $purok[] = $row;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'templates/header.php'; ?>
    <title>Barangay's - Barangay Management System</title>
</head>
<body>
<?php include 'templates/loading_screen.php'; ?>
    <div class="wrapper">
        <!-- Main Header -->
        <?php include 'templates/main-header.php'; ?>
        <!-- End Main Header -->

        <!-- Sidebar -->
        <?php include 'templates/sidebar.php'; ?>
        <!-- End Sidebar -->

        <div class="main-panel">
            <div class="content">
                <div class="panel-header bg-primary-gradient">
                    <div class="page-inner">
                        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
                            <div>
                                <h2 class="text-white fw-bold">Settings</h2>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="page-inner">
                    <div class="row mt--2">
                        <div class="col-md-12">

                            <?php if (isset($_SESSION['message'])): ?>
                                <div class="alert alert-<?= $_SESSION['success'] == 'danger' ? 'bg-danger text-light' : $_SESSION['success']; ?>" role="alert">
                                    <?= htmlspecialchars($_SESSION['message'], ENT_QUOTES, 'UTF-8'); ?>
                                </div>
                                <?php unset($_SESSION['message']); ?>
                            <?php endif; ?>

                            <div class="card">
                                <div class="card-header">
                                    <div class="card-head-row">
                                        <div class="card-title">Barangay's</div>
                                        <div class="card-tools">
                                            <a href="#add" data-toggle="modal" class="btn btn-info btn-border btn-round btn-sm">
                                                <i class="fa fa-plus"></i>
                                                Barangay
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th scope="col">No.</th>
                                                    <th scope="col">Barangay</th>
                                                    <th scope="col">Registered Residents</th>
                                                    <th scope="col">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if (!empty($purok)): ?>
                                                    <?php $no = 1; foreach ($purok as $row): ?>
                                                        <tr>
                                                            <td><?= $no; ?></td>
                                                            <td><?= htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8'); ?></td>
                                                            <td><?= $row['residents_count']; ?></td>
                                                            <td>
                                                                <div class="form-button-action">
                                                                    <a href="#edit" data-toggle="modal" class="btn btn-link btn-primary" title="Edit Purok" onclick="editPurok(this)"
                                                                       data-name="<?= htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8'); ?>"
                                                                       data-id="<?= $row['id']; ?>">
                                                                        <i class="fa fa-edit"></i>
                                                                    </a>
                                                                    <a href="javascript:void(0);" onclick="viewResidents(<?= $row['id']; ?>)" class="btn btn-link btn-info" title="View Residents">
                                                                    <i class="fa fa-eye"></i>
                                                                    </a>
                                                                    <a href="model/remove_purok.php?id=<?= $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this purok?');" class="btn btn-link btn-danger" data-original-title="Remove">
                                                                        <i class="fa fa-times"></i>
                                                                    </a>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <?php $no++; endforeach; ?>
                                                <?php else: ?>
                                                    <tr>
                                                        <td colspan="4" class="text-center">No Available Data</td>
                                                    </tr>
                                                <?php endif; ?>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th scope="col">No.</th>
                                                    <th scope="col">Purok</th>
                                                    <th scope="col">Registered Residents</th>
                                                    <th scope="col">Action</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Create Barangay</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="model/save_purok.php">
                                <div class="form-group">
                                    <label>Barangay Name</label>
                                    <input type="text" class="form-control" placeholder="Enter Purok Name" name="purok" required>
                                </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Create</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Edit Barangay</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="model/edit_purok.php">
                                <div class="form-group">
                                    <label>Barangay Name</label>
                                    <input type="text" class="form-control" id="purok" placeholder="Enter Purok Name" name="purok" required>
                                </div>
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" id="purok_id" name="id">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Residents Modal -->
<div class="modal fade" id="viewResidents" tabindex="-1" role="dialog" aria-labelledby="viewResidentsLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewResidentsLabel">Residents in Purok</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">No.</th>
                                <th scope="col">Resident Name</th>
                                <th scope="col">Age</th>
                                <th scope="col">Gender</th>
                                <th scope="col">Address</th>
                            </tr>
                        </thead>
                        <tbody id="residentsTableBody">
                            <!-- Resident rows will be populated here -->
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


            <!-- Main Footer -->
            <?php include 'templates/main-footer.php'; ?>
            <!-- End Main Footer -->
        </div>
    </div>
    <?php include 'templates/footer.php'; ?>
    <script>
        function viewResidents(purokId) {
    // Make an AJAX call to fetch the residents based on Purok ID
    $.ajax({
        url: 'model/fetch_resident.php',
        type: 'GET',
        data: { purok_id: purokId },
        success: function(data) {
            $('#residentsTableBody').html(data);
            $('#viewResidents').modal('show');
        },
        error: function() {
            alert('Failed to fetch residents. Please try again.');
        }
    });
}
    </script>
</body>
</html>
