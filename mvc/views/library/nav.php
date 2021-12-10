<nav class="navbar navbar-expand-sm navbar-dark bg-dark">
        <div class="container">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo BASE_URL?>/home">Trang Chủ</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo BASE_URL?>/kiemtra">Kiểm Tra</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo BASE_URL?>/giaima">Giải Mã</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo BASE_URL?>/chukyso">Chữ Ký Số</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo BASE_URL?>/mahoa">Mã Hóa</a>
                </li>
            </ul>
            <ul class="navbar-nav mr-auto">
                <?php
                    if(isset($_SESSION['Id'])){
                        echo '<!-- Đã đăng nhập -->
                        <li class="nav-item ">
                            <a class="btn btn-info btn-login" type="button" href="'.BASE_URL.'/profile">Thông Tin Tài Khoản</a>
                        </li>
                        <li class="nav-item float-end">
                            <a class="btn btn-info btn-login" type="button" href="'.BASE_URL.'/logout">Đăng Xuất</a>
                        </li>';
                    }else{
                        echo '<!-- Chưa đăng nhập -->
                        <li class="nav-item ">
                            <a class="btn btn-info btn-login" type="button" href="'.BASE_URL.'/login">Đăng Nhập</a>
                        </li>
                        <li class="nav-item float-end">
                            <a class="btn btn-info btn-login" type="button" href="'.BASE_URL.'/register">Đăng Kí</a>
                        </li>
                        ';
                    }
                ?>
                
                
            </ul>

        </div>
    </nav>