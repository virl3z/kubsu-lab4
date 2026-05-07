<?php
header('Content-Type: text/html; charset=UTF-8');

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $messages = array();

    // Сообщение об успешном сохранении
    if (!empty($_COOKIE['save'])) {
        setcookie('save', '', 100000);
        $messages[] = 'Спасибо, результаты сохранены.';
    }

    // Массивы для ошибок и значений
    $errors = array();
    $values = array();

    // Поля для проверки
    $fields = ['full_name', 'phone', 'email', 'birth_date', 'gender', 'languages', 'biography', 'agreed'];

    foreach ($fields as $field) {
        $errors[$field] = !empty($_COOKIE[$field . '_error']);
        $values[$field] = $_COOKIE[$field . '_value'] ?? '';
        
        // Удаляем куки после чтения
        if ($errors[$field]) {
            setcookie($field . '_error', '', 100000);
            setcookie($field . '_value', '', 100000);
        }
    }

    // Выводим сообщения об ошибках
    if ($errors['full_name']) {
        $messages[] = '<div class="error-message">Ошибка в поле "ФИО": ФИО должно содержать только буквы, пробелы и дефисы (не более 150 символов).</div>';
    }
    if ($errors['phone']) {
        $messages[] = '<div class="error-message">Ошибка в поле "Телефон": Телефон должен содержать только цифры, пробелы, +, (, ), - (5-20 символов).</div>';
    }
    if ($errors['email']) {
        $messages[] = '<div class="error-message">Ошибка в поле "E-mail": Введите корректный email (пример: name@domain.ru).</div>';
    }
    if ($errors['birth_date']) {
        $messages[] = '<div class="error-message">Ошибка в поле "Дата рождения": Введите корректную дату рождения.</div>';
    }
    if ($errors['gender']) {
        $messages[] = '<div class="error-message">Ошибка в поле "Пол": Выберите пол.</div>';
    }
    if ($errors['languages']) {
        $messages[] = '<div class="error-message">Ошибка в поле "Любимый язык программирования": Выберите хотя бы один язык из списка.</div>';
    }
    if ($errors['agreed']) {
        $messages[] = '<div class="error-message">Ошибка: Вы должны ознакомиться с контрактом.</div>';
    }

    include('form.php');
    exit();
}

// POST запрос - обработка формы
$errors = false;

// 1. ФИО
if (empty($_POST['full_name'])) {
    setcookie('full_name_error', '1', time() + 24 * 60 * 60);
    $errors = true;
} elseif (strlen($_POST['full_name']) > 150) {
    setcookie('full_name_error', '1', time() + 24 * 60 * 60);
    $errors = true;
} elseif (!preg_match('/^[a-zA-Zа-яА-ЯёЁ\s\-]+$/u', $_POST['full_name'])) {
    setcookie('full_name_error', '1', time() + 24 * 60 * 60);
    $errors = true;
}
setcookie('full_name_value', $_POST['full_name'], time() + 30 * 24 * 60 * 60);

// 2. Телефон
if (empty($_POST['phone'])) {
    setcookie('phone_error', '1', time() + 24 * 60 * 60);
    $errors = true;
} elseif (!preg_match('/^[\d\s\+\(\)-]{5,20}$/', $_POST['phone'])) {
    setcookie('phone_error', '1', time() + 24 * 60 * 60);
    $errors = true;
}
setcookie('phone_value', $_POST['phone'], time() + 30 * 24 * 60 * 60);

// 3. Email
if (empty($_POST['email'])) {
    setcookie('email_error', '1', time() + 24 * 60 * 60);
    $errors = true;
} elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    setcookie('email_error', '1', time() + 24 * 60 * 60);
    $errors = true;
}
setcookie('email_value', $_POST['email'], time() + 30 * 24 * 60 * 60);

// 4. Дата рождения
if (empty($_POST['birth_date'])) {
    setcookie('birth_date_error', '1', time() + 24 * 60 * 60);
    $errors = true;
} elseif (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $_POST['birth_date']) || !strtotime($_POST['birth_date'])) {
    setcookie('birth_date_error', '1', time() + 24 * 60 * 60);
    $errors = true;
}
setcookie('birth_date_value', $_POST['birth_date'], time() + 30 * 24 * 60 * 60);

// 5. Пол
if (empty($_POST['gender']) || !in_array($_POST['gender'], ['male', 'female'])) {
    setcookie('gender_error', '1', time() + 24 * 60 * 60);
    $errors = true;
}
setcookie('gender_value', $_POST['gender'], time() + 30 * 24 * 60 * 60);

// 6. Языки программирования
$allowed_langs = ['Pascal', 'C', 'C++', 'JavaScript', 'PHP', 'Python', 'Java', 'Haskell', 'Clojure', 'Prolog', 'Scala', 'Go'];
if (empty($_POST['languages'])) {
    setcookie('languages_error', '1', time() + 24 * 60 * 60);
    $errors = true;
} else {
    foreach ($_POST['languages'] as $lang) {
        if (!in_array($lang, $allowed_langs)) {
            setcookie('languages_error', '1', time() + 24 * 60 * 60);
            $errors = true;
            break;
        }
    }
}
// Сохраняем языки как строку через запятую
setcookie('languages_value', implode(',', $_POST['languages'] ?? []), time() + 30 * 24 * 60 * 60);

// 7. Биография (необязательное поле, но проверяем длину)
if (!empty($_POST['biography']) && strlen($_POST['biography']) > 5000) {
    setcookie('biography_error', '1', time() + 24 * 60 * 60);
    $errors = true;
}
setcookie('biography_value', $_POST['biography'] ?? '', time() + 30 * 24 * 60 * 60);

// 8. Согласие с контрактом
if (empty($_POST['agreed'])) {
    setcookie('agreed_error', '1', time() + 24 * 60 * 60);
    $errors = true;
}
setcookie('agreed_value', $_POST['agreed'] ?? '', time() + 30 * 24 * 60 * 60);

if ($errors) {
    header('Location: index.php');
    exit();
}

// Если ошибок нет - удаляем все куки с ошибками
$fields = ['full_name', 'phone', 'email', 'birth_date', 'gender', 'languages', 'biography', 'agreed'];
foreach ($fields as $field) {
    setcookie($field . '_error', '', 100000);
}

// Сохранение в БД (код из 3 лабораторной)
$user = 'u82669';
$pass = '9085380';
try {
    $db = new PDO('mysql:host=localhost;dbname=u82669', $user, $pass,
        [PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

    $stmt = $db->prepare("INSERT INTO users (full_name, phone, email, birth_date, gender, biography, agreed) 
                          VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([
        $_POST['full_name'],
        $_POST['phone'],
        $_POST['email'],
        $_POST['birth_date'],
        $_POST['gender'],
        $_POST['biography'] ?? '',
        isset($_POST['agreed']) ? 1 : 0
    ]);
    $user_id = $db->lastInsertId();

    $stmt_lang = $db->prepare("SELECT id FROM programming_languages WHERE name = ?");
    $stmt_insert = $db->prepare("INSERT INTO user_languages (user_id, language_id) VALUES (?, ?)");

    foreach ($_POST['languages'] as $lang_name) {
        $stmt_lang->execute([$lang_name]);
        $lang_id = $stmt_lang->fetchColumn();
        if ($lang_id) {
            $stmt_insert->execute([$user_id, $lang_id]);
        }
    }

} catch (PDOException $e) {
    die("Ошибка БД: " . $e->getMessage());
}

// Сохраняем куку с признаком успешного сохранения
setcookie('save', '1', time() + 24 * 60 * 60);
header('Location: index.php');
?>
