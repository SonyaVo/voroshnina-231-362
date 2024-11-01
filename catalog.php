<?php
$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "shop_db";

$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = $_POST['product_id'];
    

    $user_id = 1; 

   
    $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
      
        $stmt->close();
        
     
        $stmt = $conn->prepare("SELECT * FROM cart WHERE product_id = ? AND user_id = ?");
        $stmt->bind_param("ii", $product_id, $user_id);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows == 0) {
       
            $stmt->close();
            $stmt = $conn->prepare("INSERT INTO cart (product_id, user_id, quantity) VALUES (?, ?, 1)");
            $stmt->bind_param("ii", $product_id, $user_id);
        } else {
      
            $stmt->close();
            $stmt = $conn->prepare("UPDATE cart SET quantity = quantity + 1 WHERE product_id = ? AND user_id = ?");
            $stmt->bind_param("ii", $product_id, $user_id);
        }

   
        if ($stmt->execute()) {
            echo "Товар добавлен в корзину!";
        } else {
            echo "Ошибка добавления товара: " . $stmt->error;
        }
    } else {
        echo "Товар не найден.";
    }

 
    $stmt->close();
}


$conn->close();
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Магазин</title>
    <link rel="stylesheet" href="styles/style.css">
</head>

<body>
    <header>
        <nav class="navbar">
            <ul>
                <li><a href="index.php">Главная</a></li>
                <li><a href="catalog.php">Магазин</a></li>
            </ul>
        </nav>
        <div class="auth">
            <a href="login.php">Войти</a> | <a href="register.php">Регистрация</a>
        </div>
        <h1>Каталог товаров</h1>
    </header>

    <main>
        <div class="product-list">
            <?php
            // Подключаемся к базе данных
            $conn = new mysqli($servername, $username, $password, $dbname);

            if ($conn->connect_error) {
                die("Ошибка подключения: " . $conn->connect_error);
            }

         
            $sql = "SELECT * FROM products";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
               
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='product'>";
                    echo "<a href='product.php?id=" . $row["id"] . "'>";
                    echo "<img src='" . $row["image_url"] . "' alt='" . $row["name"] . "'>";
                    echo "<h2>" . $row["name"] . "</h2>";
                    echo "<p>" . $row["description"] . "</p>";
                    echo "</a>"; 

              
                    
                    echo "<form action='' method='POST'>";
                    echo "<input type='hidden' name='product_id' value='" . $row["id"] . "'>";
                    echo "<input type='submit' value='Добавить в корзину' class='btn'>";
                    echo "</form>";

                    echo "</div>";
                }
            } else {
                echo "<p>Товары не найдены</p>";
            }

            
            $conn->close();
            ?>
        </div>
    </main>

    <footer>
        <p>Связаться с нами: <a href="tel:896844455544">896844455544</a> | <a
                href="mailto:magazine@yandex.ru">magazine@yandex.ru</a></p>
        <p>&copy; 2024 ТехноМир. Все права защищены.</p>
    </footer>
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        // Анимация появления карточек товара
        const products = document.querySelectorAll('.product');
        products.forEach((product, index) => {
            product.style.opacity = 0;
            product.style.transform = 'translateY(20px)';
            setTimeout(() => {
                product.style.transition = 'opacity 0.5s, transform 0.5s';
                product.style.opacity = 1;
                product.style.transform = 'translateY(0)';
            }, index * 200); // Задержка для каждой карточки
        });

        // Анимация при наведении на карточки товара
        products.forEach(product => {
            product.addEventListener('mouseenter', () => {
                product.style.transform = 'scale(1.05)';
            });

            product.addEventListener('mouseleave', () => {
                product.style.transform = 'scale(1)';
            });
        });

        // Анимация при наведении на кнопки
        const buttons = document.querySelectorAll('.btn');
        buttons.forEach(button => {
            button.addEventListener('mouseenter', () => {
                button.style.transform = 'scale(1.1)';
            });

            button.addEventListener('mouseleave', () => {
                button.style.transform = 'scale(1)';
            });
        });
    });
</script>


</body>

</html>
