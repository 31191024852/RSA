<!DOCTYPE html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="<?php echo BASE_URL?>/public/css/style.css" />
</head>

<body>
    <?php 
        require_once './mvc/controllers/libra.php';
        $libra = new libra();
        $libra->nav();
    ?>
    <div class="container">
        <div class="d-flex p-5 justify-content-center">

            <form method="post" action="">
                <div class="row justify-content-center">
                    <?php 
                        if(isset($_GET['kq'])&&$_GET['kq']=='done'){
                            echo "<b style='color: green; font-size: 14px;'>Đăng kí thành công</b>";
                        } 
                    ?>        
                </div>
                <div class="mb-3">
                    <label class="form-label">Email address</label>
                    <input type="email" name="email" class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control">
                </div>
                <div class="row justify-content-center">
                    <button type="submit" name="login" class="col-5 btn btn-info btn-login">Login</button>
                </div>
            </form>

        </div>
    </div>

</body>