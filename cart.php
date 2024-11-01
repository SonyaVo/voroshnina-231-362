<?php

$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "shop_db"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}

$user_id = 1; 

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $cart_id = $_POST['cart_id'];
    if ($_POST['action'] === 'update') {
        $quantity = $_POST['quantity'];
        $stmt = $conn->prepare("UPDATE cart SET quantity = ? WHERE id = ? AND user_id = ?");
        $stmt->bind_param("iii", $quantity, $cart_id, $user_id);
        $stmt->execute();
        $stmt->close();
    } elseif ($_POST['action'] === 'remove') {
        $stmt = $conn->prepare("DELETE FROM cart WHERE id = ? AND user_id = ?");
        $stmt->bind_param("ii", $cart_id, $user_id);
        $stmt->execute();
        $stmt->close();
    }
}

$stmt = $conn->prepare("SELECT c.id, c.quantity, p.name, p.price FROM cart c JOIN products p ON c.product_id = p.id WHERE c.user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Корзина - ТехноМир</title>
    <link rel="stylesheet" href="styles/style.css">
</head>

<body>
    <header>
        <nav class="navbar">
            <ul>
                <li><a href="index.php">Главная</a></li>
                <li><a href="catalog.php">Магазин</a></li>
                <li><a href="cart.php">Корзина</a></li>
            </ul>
        </nav>
        <div class="auth">
            <?php if (isset($_POST['message']) && $_POST['message'] === "успешно"): ?>
                <span>Вы вошли как: <?php echo htmlspecialchars($_POST['phone']); ?></span>
                <a href="index.php">Выйти</a>
            <?php else: ?>
                <a href="login.php">Войти</a> | <a href="register.php">Регистрация</a>
            <?php endif; ?>
        </div>
        <h1>Корзина</h1>
    </header>

    <main>
        <h2>Содержимое вашей корзины</h2>

        <?php if ($result->num_rows > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Название товара</th>
                        <th>Количество</th>
                        <th>Цена</th>
                        <th>Итого</th>
                        <th>Действия</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $total = 0;
                    while ($row = $result->fetch_assoc()) {
                        $subtotal = $row['price'] * $row['quantity'];
                        $total += $subtotal;
                    ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['name']); ?></td>
                            <td>
                                <form action="cart.php" method="POST">
                                    <input type="hidden" name="cart_id" value="<?php echo $row['id']; ?>">
                                    <input type="number" name="quantity" value="<?php echo $row['quantity']; ?>" min="1">
                                    <input type="hidden" name="action" value="update">
                                    <input type="submit" value="Обновить">
                                </form>
                            </td>
                            <td><?php echo htmlspecialchars($row['price']); ?> Р</td>
                            <td><?php echo $subtotal; ?> Р</td>
                            <td>
                                <form action="cart.php" method="POST">
                                    <input type="hidden" name="cart_id" value="<?php echo $row['id']; ?>">
                                    <input type="hidden" name="action" value="remove">
                                    <input type="submit" value="Удалить">
                                </form>
                            </td>
                        </tr>
                    <?php } ?>
                    <tr>
                        <td colspan="3"><strong>Итого:</strong></td>
                        <td colspan="2"><?php echo $total; ?> Р</td>
                    </tr>
                </tbody>
            </table>
        <?php else: ?>
            <p>Ваша корзина пуста.</p>
        <?php endif; ?>

    </main>

    <footer>
        <p>Связаться с нами: <a href="tel:896844455544">896844455544</a> | <a
                href="mailto:magazine@yandex.ru">magazine@yandex.ru</a></p>
        <p>&copy; 2024 ТехноМир. Все права защищены.</p>
    </footer>

</body>

</html>

<?php
$conn->close();
?>
