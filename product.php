<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Информация о товаре</title>
    <link rel="stylesheet" href="styles/style.css">
</head>

<body>
    <header>
        <nav>
            <ul>
                <li><a href="index.php">Главная</a></li>
                <li><a href="catalog.php">Магазин</a></li>
            </ul>
        </nav>
        <h1>Информация о товаре</h1>
    </header>

    <main>
        <div class="product-detail">
            <?php
            // Подключаемся к базе данных
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "shop_db";

            $conn = new mysqli($servername, $username, $password, $dbname);

            // Проверка подключения
            if ($conn->connect_error) {
                die("Ошибка подключения: " . $conn->connect_error);
            }

            // Получаем ID товара из URL
            $product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

            // SQL-запрос для получения информации о товаре
            $sql = "SELECT * FROM products WHERE id = $product_id";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                echo "<img src='" . $row["image_url"] . "' alt='" . $row["name"] . "'>";
                echo "<h2>" . $row["name"] . "</h2>";
                echo "<p><strong>Описание:</strong> " . $row["description"] . "</p>";
                echo "<p><strong>Цена:</strong> " . $row["price"] . " руб.</p>";
                echo "<p><strong>В наличии:</strong> " . $row["stock"] . "</p>";

                // Здесь можно добавить дополнительные характеристики
                
            } else {
                echo "<p>Товар не найден</p>";
            }

            // Закрываем соединение
            $conn->close();
            ?>
        </div>
    </main>

    <footer>
        <p>Связаться с нами: <a href="tel:896844455544">896844455544</a> | <a
                href="mailto:magazine@yandex.ru">magazine@yandex.ru</a></p>
        <p>&copy; 2024 ТехноМир. Все права защищены.</p>
    </footer>

</body>

</html>