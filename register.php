<?php
$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "shop_db"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}

$authorizationMessage = "";
$registrationSuccess = false; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  
    $surname = $_POST['surname'];
    $name = $_POST['name'];
    $patronymic = $_POST['patronymic'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];
    $agree = isset($_POST['agree']) ? 1 : 0; 


    if ($agree) {
        
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        
        $stmt = $conn->prepare("INSERT INTO users (surname, name, patronymic, phone, password) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $surname, $name, $patronymic, $phone, $hashed_password);

        if ($stmt->execute()) {
            $authorizationMessage = "Регистрация прошла успешно!";
            $registrationSuccess = true; 
        } else {
            $authorizationMessage = "Ошибка регистрации: " . $stmt->error;
        }

        
        $stmt->close();
    } else {
        $authorizationMessage = "Вы должны согласиться с обработкой данных.";
    }
    if ($loginMessage === "успешно") {
        echo '<form id="redirectForm" action="index.php" method="POST">
                <input type="hidden" name="message" value="' . $loginMessage . '">
                <input type="hidden" name="phone" value="' . $phone . '">
              </form>';
        
        echo '<script>document.getElementById("redirectForm").submit();</script>';
        exit();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles/style.css">
    <script>
        function redirectToHome() {
            window.location.href = 'index.php';
        }
    </script>
</head>

<body>

    <div class="container">
        <h1>Регистрация</h1>



        <form action="" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label class="form-label" for="surname">Фамилия</label>
                <input type="text" name="surname" id="surname" required>
            </div>

            <div class="form-group">
                <label class="form-label" for="name">Имя</label>
                <input type="text" name="name" id="name" required>
            </div>
            <div class="form-group">
                <label class="form-label" for="patronymic">Отчество</label>
                <input type="text" name="patronymic" id="patronymic">
            </div>

            <div class="form-group">
                <label class="form-label" for="phone">Номер телефона</label>
                <input type="text" name="phone" id="phone" required>
            </div>
            <div class="form-group">
                <label class="form-label" for="password">Пароль</label>
                <input type="password" name="password" id="password" required>
            </div>

            <div class="form-group">
                <input type="checkbox" name="agree" id="agree" value="yes">
                <label for="agree">Согласен с обработкой данных</label>
            </div>

            <input class="btn" type="submit" value="Зарегистрироваться">
        </form>
        <button class="btn" onclick="location.href='index.php'">На главную</button>
        <div class="text-centre">
            <?php if ($authorizationMessage): ?>
                <p><?php echo $authorizationMessage; ?></p>

            <?php endif; ?>
        </div>
    </div>

</body>

</html>