<?php
// Подключаемся к базе данных
$servername = "localhost";
$username = "root"; // Замените на ваше имя пользователя базы данных
$password = ""; // Замените на ваш пароль базы данных
$dbname = "shop_db"; // Замените на имя вашей базы данных

$conn = new mysqli($servername, $username, $password, $dbname);

// Проверка подключения
if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}

$loginMessage = "";

// Проверяем, была ли отправлена форма
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Получаем введенные данные
    $phone = $_POST['phone'];
    $password = $_POST['password'];

    // Подготовка SQL-запроса для поиска пользователя
    $stmt = $conn->prepare("SELECT password FROM users WHERE phone = ?");
    $stmt->bind_param("s", $phone);
    $stmt->execute();
    $stmt->store_result();

    // Проверка, существует ли пользователь с таким номером телефона
    if ($stmt->num_rows > 0) {
        // Получаем хеш пароля из базы данных
        $stmt->bind_result($hashed_password);
        $stmt->fetch();

        // Проверяем введенный пароль с хешированным паролем
        if (password_verify($password, $hashed_password)) {
            // Успешная авторизация
            $loginMessage = "успешно";
        } else {
            $loginMessage = "Неверный номер телефона или пароль!";
        }
    } else {
        $loginMessage = "Неверный номер телефона или пароль!";
    }

    // Закрытие подготовленного выражения
    $stmt->close();

    // Если авторизация успешна, перенаправляем на index.php с сообщением
    if ($loginMessage === "успешно") {
        // Форма для перенаправления с POST данными
        echo '<form id="redirectForm" action="index.php" method="POST">
                <input type="hidden" name="message" value="' . $loginMessage . '">
                                <input type="hidden" name="phone" value="' . $phone . '">

              </form>';
        echo '<script>document.getElementById("redirectForm").submit();</script>';
        
        exit();
    }
}

// Закрываем соединение
$conn->close();
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вход</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles/style.css">
</head>

<body>

    <div class="container">
        <h1>Вход</h1>

        <form action="" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label class="form-label" for="phone">Номер телефона</label>
                <input type="text" name="phone" id="phone" required>
            </div>
            <div class="form-group">
                <label class="form-label" for="password">Пароль</label>
                <input type="password" name="password" id="password" required>
            </div>

            <input class="btn" type="submit" value="Войти">
        </form>

        
      <button class="btn" onclick="location.href='index.php'">На главную</button>

        <div class="text-centre">
            <?php if ($loginMessage): ?>
                <p><?php echo $loginMessage; ?></p>
            <?php endif; ?>
        </div>
    </div>

</body>

</html>