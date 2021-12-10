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
    <div class='container'>
        <div class="p-5 justify-content-center">
            <h2>Hướng dẫn sử dụng</h2>
            <hr/>
            <p>Đầu tiên: Nếu chưa có tài khoản thì hãy tạo một tài khoản và đăng nhập vào.</p>
            <p>Sau đó bạn sẽ được cung cấp một PUBLIC_KEY trong thông tin tài khoản vào một PRIVATE_KEY ẩn được lại đâu đó</p>
        </div>
    </div>

</body>