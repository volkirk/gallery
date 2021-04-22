<?php
include 'functions.php';
ini_set('display_errors','Off');
session_start();

//session_destroy();
//$_SESSION['auth']=0;
define('URL', 'http://localhost/authorization/index.php'); // URL текущей страницы
define('UPLOAD_MAX_SIZE', 1000000); // 1mb
define('ALLOWED_TYPES', ['image/jpeg', 'image/png', 'image/gif']);
define('UPLOAD_DIR', 'uploads');
// $link = mysqli_connect("localhost", "root", "", "gallery");
$errors = [];
// echo 'URL=' . URL;
// echo '<br> seession=';
// print_r($_SESSION);
// echo '<br> id=';
// print_r($_COOKIE['id']);
if(isset($_POST['submit'])){
    addFiletoDB();
}

if (!empty($_FILES)) {

    for ($i = 0; $i < count($_FILES['files']['name']); $i++) {

        $fileName = $_FILES['files']['name'][$i];

        if ($_FILES['files']['size'][$i] > UPLOAD_MAX_SIZE) {
            $errors[] = 'Недопостимый размер файла ' . $fileName;
            continue;
        }

        if (!in_array($_FILES['files']['type'][$i], ALLOWED_TYPES)) {
            $errors[] = 'Недопустимый формат файла ' . $fileName;
            continue;
        }

        $filePath = UPLOAD_DIR . '/' . basename($fileName);
        //Пытаемся загрузить файл, в случае ошибки переход к следующей итерации
        if (!move_uploaded_file($_FILES['files']['tmp_name'][$i], $filePath)) {
            $errors[] = 'Ошибка загрузки файла ' . $fileName;
            echo $filePath;
            continue;
        }
    }
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <title>Pictures gallery</title>
</head>

<body>
    
   <a href="login.php">Войти</a>
    <a href="register.php">Зарегистрироваться</a>
    <a href="logout.php">Выйти</a>
    <?php if ($_SESSION['auth'])
    {echo 'Авторизированный пользователь';
    ?>
    <div class="container pt-4">
        <h1 class="mb-4">Загрузка файлов</h1>

        <?php if (!empty($errors)) : ?>
            <div class="alert alert-danger">
                <ul>
                    <?php foreach ($errors as $error) : ?>
                        <li><?php echo $error; ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <?php if (!empty($_FILES) && empty($errors)) {
            addFiletoDB();
             ?>
            <div class="alert alert-success">Файлы успешно загружены</div>
        <?php } ?>

        <form action="" method="post" enctype="multipart/form-data">
            <div class="custom-file">
                <input type="file" class="custom-file-input" name="files[]" id="customFile" multiple required>
                <label class="custom-file-label" for="customFile" data-browse="Выбрать">Выберите файлы</label>
                <small class="form-text text-muted">
                    Максимальный размер файла: <?php echo UPLOAD_MAX_SIZE / 1000000; ?>Мб.
                    Допустимые форматы: <?php echo implode(', ', ALLOWED_TYPES) ?>.
                </small>
            </div>
            <hr>
            <form action="" method='POST'>
            <button type="submit" class="btn btn-primary">Загрузить</button>
            <a href="<?php echo URL; ?>" class="btn btn-secondary ml-3">Сброс</a>
            </form>
        </form>
    </div>
    <?php 
    } 
    // $postCheck= isset($_POST['sumbit']);
    // print_r($postCheck);
    // if (!empty($postCheck))
    // {
    //     echo ('RABOTAY SUKA');
    //     print_r($postCheck);
    //     addFiletoDB();
    // }

    ?>
    <div>
    <h1>Галерея Изображений</h1>
        <?php
        $result= getFileFromDBPRO();
        echo '<ul>';
        while ($u=mysqli_fetch_assoc($result)){
            echo '<li><img src="uploads/'.$u['pic_name'].'" alt=""></li>';
            echo 'user posted - '.$u['user_login'];
        }
        echo '</ul>';
        ?>




    </div>

    

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bs-custom-file-input@1.3.4/dist/bs-custom-file-input.min.js"></script>
    <script>
        $(() => {
            bsCustomFileInput.init();
        })
    </script>
</body>

</html>