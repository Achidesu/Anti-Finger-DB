<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Medical System</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@300;400;500;600&display=swap" rel="stylesheet">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="login-bg">
    
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card medical-card border-0 shadow-lg" style="width: 400px;">
            
            <div class="card-header medical-header text-white text-center py-4">
                <div class="mb-3">
                    <i class="fa-solid fa-user-doctor fa-3x"></i>
                </div>
                <h4 class="mb-0 fw-bold">Login Portal</h4>
                <small class="opacity-75">Anti Finger Database System</small>
            </div>

            <div class="card-body p-4">
                
                <?php if (isset($_SESSION['error'])){ ?>
                    <div class="alert alert-danger d-flex align-items-center" role="alert">
                        <i class="fa-solid fa-circle-exclamation me-2"></i>
                        <div>
                            <?php 
                                echo $_SESSION['error'];
                                unset($_SESSION['error']);
                            ?>
                        </div>
                    </div>
                <?php } ?>
                
                <?php if (isset($_SESSION['success'])){ ?>
                    <div class="alert alert-success d-flex align-items-center" role="alert">
                        <i class="fa-regular fa-circle-check me-2"></i>
                        <div>
                            <?php 
                                echo $_SESSION['success'];
                                unset($_SESSION['success']);
                            ?>
                        </div>
                    </div>
                <?php } ?>

                <form action="login_action.php" method="post">
                    
                    <div class="mb-3">
                        <label for="username" class="form-label text-muted small fw-bold text-uppercase">Username</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 text-primary">
                                <i class="fa-solid fa-user"></i>
                            </span>
                            <input type="text" class="form-control bg-light border-start-0 ps-0" name="username" placeholder="Enter ID" required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="password" class="form-label text-muted small fw-bold text-uppercase">Password</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 text-primary">
                                <i class="fa-solid fa-lock"></i>
                            </span>
                            <input type="password" class="form-control bg-light border-start-0 ps-0" name="password" id="password" placeholder="Enter Password" required>
                        </div>
                    </div>

                    <div class="d-grid">
                        <button type="submit" value="LOGIN" name="LOGIN" class="btn btn-primary btn-lg medical-btn-gradient">
                            Login <i class="fa-solid fa-arrow-right-to-bracket ms-2"></i>
                        </button>
                    </div>

                </form>
            </div>
            
            <div class="card-footer bg-white border-0 text-center py-3">
                <small class="text-muted">Medical Database Access Only</small>
            </div>
        </div>
    </div>

</body>
</html>