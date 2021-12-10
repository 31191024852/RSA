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
    <div class="row justify-content-center">
        <div class="col-8 p-5">
            <form action="" method="post">
                <div class="mb-3">
                    <label class="form-label">Email address</label>
                    <input type="email" name="email" class="form-control">
                </div>
                <div class="row">
                    <div class="mb-3 col-6">
                        <label class="form-label">Password</label>
                        <input id="password" type="password" name="password" class="form-control">
                    </div>
                    <div class="mb-3 col-6">
                        <label class="form-label">Re-Password</label>
                        <input id="re-password" type="password" name="re_password" class="form-control">
                        <div class="check-password"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="mb-3 col-6">
                        <label class="form-label">Họ Và Tên</label>
                        <input type="input" name="fullname" class="form-control">
                    </div>
                    <div class="mb-3 col-6">
                        <label class="form-label">Căn Cước Công Dân</label>
                        <input type="input" name="cccd" class="form-control">
                    </div>
                </div>
                
                <div class="row justify-content-center">
                    <button type="submit" name="register" class="col-5 btn btn-info btn-login">Đăng Kí</button>
                </div>
            </form>

        </div>
    </div>
    <script src="<?php echo BASE_URL; ?>/public/js/rsa.js"></script>
</body>