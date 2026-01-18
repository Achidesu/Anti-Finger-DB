<?php
    session_start();
    if (!isset($_SESSION['user'])){
        $_SESSION['error'] = "Please login!";
        header("location: index.php");
    }
   $ch = curl_init();
   curl_setopt($ch, CURLOPT_URL, "https://api.sheetbest.com/sheets/eb063465-9a3d-49c9-9922-76fde01f3c24"); 
   curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
   $output = curl_exec($ch);
   curl_close($ch); 

   $result = json_decode($output);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Anti Finger Database - Medical View</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@300;400;500;600&display=swap" rel="stylesheet">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                
                <div class="card border-0 shadow-lg rounded-4 overflow-hidden medical-card">
                    
                    <div class="card-header medical-header p-4 d-flex justify-content-between align-items-center">
                        <div>
                            <h2 class="mb-0 fw-bold"><i class="fa-solid fa-notes-medical me-2"></i> Anti Finger Database</h2>
                            <small class="opacity-75">Medical Record System</small>
                        </div>
                        <div class="badge bg-white text-primary rounded-pill px-3 py-2">
                            <i class="fa-solid fa-server me-1"></i> Online
                        </div>
                        <a href="logout.php" class="btn btn-light btn-sm rounded-pill px-4 fw-bold text-primary shadow-sm">
                            <i class="fa-solid fa-right-from-bracket me-1"></i> Logout
                        </a>
                    </div>

                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0 medical-table">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="ps-4">ID</th>
                                        <th><i class="fa-regular fa-calendar me-1"></i> Date</th>
                                        <th><i class="fa-solid fa-microchip me-1"></i> Machine ID</th>
                                        <th><i class="fa-solid fa-database me-1"></i> Data</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if(!empty($result)) : ?>
                                        <?php foreach($result as $key => $value): ?>
                                        <tr>
                                            <td class="ps-4 fw-semibold text-muted">#<?php echo $value->id; ?></td>
                                            <td>
                                                <span class="d-inline-block py-1 px-2 rounded bg-light text-dark">
                                                    <?php echo $value->Date; ?>
                                                </span>
                                            </td>
                                            <td class="text-primary fw-medium"><?php echo $value->Machine_ID; ?></td>
                                            <td><?php echo $value->Data; ?></td>
                                            <td class="text-center">
                                                <button onclick="deleteRow('<?php echo $value->id; ?>')" class="btn btn-outline-danger btn-sm rounded-pill px-3 delete-btn">
                                                    <i class="fa-regular fa-trash-can me-1"></i> Delete
                                                </button>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="5" class="text-center py-5 text-muted">
                                                <i class="fa-solid fa-inbox fa-3x mb-3 opacity-25"></i><br>
                                                No data available
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    <div class="card-footer bg-white border-top-0 p-3 text-end text-muted small">
                        Total Records: <?php echo count($result); ?>
                    </div>
                </div>

            </div>
        </div>
    </div>

</body>

<script>
    function deleteRow(id) {
        // Custom SweetAlert style confirmation could go here, but keeping standard for now
        if (!confirm("Confirm deletion of Record ID: " + id + "?")) {
            return; 
        }
        
        // Show loading state on button (optional logic could be added here)
        
        const url = `https://api.sheetbest.com/sheets/eb063465-9a3d-49c9-9922-76fde01f3c24/id/*${id}*`;

        fetch(url, {
            method: "DELETE",
        })
        .then((response) => response.json())
        .then((data) => {
            console.log("Success:", data);
            // Simple toast or reload
            location.reload();
        })
        .catch((error) => {
            console.error("Error:", error);
            alert("Delete failed. Please try again.");
        });
    }
</script>
</html>