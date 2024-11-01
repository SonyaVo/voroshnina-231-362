<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Магазин техники:</title>
    <link rel="stylesheet" href="styles/style.css">
</head>


<body>
    <header>
    
        <nav class="navbar">
            <ul>
                <li><a href="index.php">Главная</a></li>
                <li><a href="catalog.php">Магазин</a></li>
                <?php if (isset($_POST['message']) && $_POST['message'] === "успешно"): ?>
                    <li><a href="cart.php">Корзина</a></li>
                <?php endif; ?>
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

        <h1>ТехноМир</h1>
    </header>
    <main>
        <h2>Добро пожаловать в "ТехноМир" – ваш надежный магазин современной электроники и бытовой техники!</h2>

        <p>В нашем магазине вы найдете широкий ассортимент товаров: от последних моделей смартфонов и ноутбуков до умных
            гаджетов для дома и качественной бытовой техники. Мы работаем напрямую с ведущими производителями, что
            гарантирует оригинальность и высокое качество всей продукции.</p>

        <h2>Почему выбирают "ТехноМир"?</h2>
        <ul>
            <li>Широкий выбор – у нас представлены только самые востребованные модели техники для дома, офиса и
                личного
                пользования.</li>
            <li>Конкурентные цены – мы стремимся сделать высокие технологии доступными для каждого.</li>
            <li>Квалифицированная поддержка – наша команда всегда готова помочь вам с выбором и ответить на все ваши
                вопросы.</li>
            <li>Гарантия и надежность – вся продукция имеет гарантию, а наш сервисный центр всегда готов решить
                возможные
                проблемы.</li>
        </ul>
        <h2>Ассортимент продукции включает:</h2>
        <p>смартфоны, ноутбуки, планшеты, умные часы, аксессуары, бытовую технику,
            аудиоустройства, игровые консоли и многое другое.</p>


        <?php if (isset($_POST['message']) && $_POST['message'] === "успешно"): ?>
            <h2>Поделитесь вашими впечатлениями!</h2>
            <div class="container">
                <form action="home.php" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label class="form-label" for="name">ФИО</label>
                        <input type="text" name="name" id="name" placeholder="Иванов Иван Иванович"
                            value="<?php echo isset($_POST['name']) ? $_POST['name'] : ''; ?>" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="email">Почта</label>
                        <input type="email" name="email" id="email" placeholder="ivanov@yandex.ru"
                            value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>" required>
                    </div>

                    <div class="form-group">
                        <p class="form-label">Как вы узнали о нас?</p>
                    </div>
                    <div class="form-group">
                        <input type="radio" name="source" id="advertising" value="advertising" <?php echo (isset($_POST['source']) && $_POST['source'] == 'advertising') ? 'checked' : ''; ?>>
                        <label for="advertising">Реклама в интернете</label>
                    </div>
                    <div class="form-group">
                        <input type="radio" name="source" id="friends" value="friends" <?php echo (isset($_POST['source']) && $_POST['source'] == 'friends') ? 'checked' : ''; ?>>
                        <label for="friends">Рассказали знакомые</label>
                    </div>


                    <div class="form-group">
                        <label class="form-label" for="category">Категория обращения</label>
                        <select name="category" id="category">
                            <option value="proposal" <?php echo (isset($_POST['category']) && $_POST['category'] == 'proposal') ? 'selected' : ''; ?>>Предложение</option>
                            <option value="grievance" <?php echo (isset($_POST['category']) && $_POST['category'] == 'grievance') ? 'selected' : ''; ?>>Жалоба</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="message">Текст сообщения</label>
                        <textarea name="message" id="message" cols="30" rows="10"
                            placeholder="Введите сообщение"></textarea>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="attachment">Вложение</label>
                        <input type="file" name="attachment" id="attachment">
                    </div>

                    <div class="form-group">
                        <input type="checkbox" name="agreement" id="agreement" value="yes" <?php echo (isset($_POST['agreement']) && $_POST['agreement'] == 'yes') ? 'checked' : ''; ?>>
                        <label for="agreement">Даю согласие на обработку данных</label>
                    </div>

                    <input class="btn" type="submit" value="Отправить">
                </form>
            </div>
        <?php endif; ?>

    </main>
    <footer>
        <p>Связаться с нами: <a href="tel:896844455544">896844455544</a> | <a
                href="mailto:magazine@yandex.ru">magazine@yandex.ru</a></p>
        <p>&copy; 2024 ТехноМир. Все права защищены.</p>

    </footer>

</body>

</html>