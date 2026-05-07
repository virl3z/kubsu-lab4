<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Регистрационная форма</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', 'Roboto', sans-serif;
            background: #f0f2f5;
            min-height: 100vh;
            padding: 2rem 1rem;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .header {
            background: #4a5568;
            color: white;
            padding: 1.5rem 2rem;
            text-align: center;
        }
        .header h1 { font-size: 1.5rem; margin-bottom: 0.25rem; font-weight: 500; }
        .header p { font-size: 0.85rem; opacity: 0.85; }
        .content { padding: 2rem; }
        .form-group { margin-bottom: 1.25rem; }
        label { display: block; font-weight: 500; margin-bottom: 0.5rem; color: #2d3748; font-size: 0.85rem; }
        .required::after { content: " *"; color: #e53e3e; }
        input, select, textarea {
            width: 100%;
            padding: 0.6rem 0.75rem;
            border: 1px solid #cbd5e0;
            border-radius: 4px;
            font-size: 0.9rem;
            font-family: inherit;
            transition: all 0.2s;
        }
        input:focus, select:focus, textarea:focus {
            outline: none;
            border-color: #4a5568;
            box-shadow: 0 0 0 2px rgba(74, 85, 104, 0.1);
        }
        /* Подсветка полей с ошибками */
        .error-input {
            border: 2px solid #e53e3e !important;
            background-color: #fff5f5;
        }
        .radio-group { display: flex; gap: 1.5rem; margin-top: 0.25rem; }
        .radio-group label { display: inline-flex; align-items: center; gap: 0.5rem; font-weight: normal; cursor: pointer; }
        .radio-group input[type="radio"] { width: 16px; height: 16px; }
        select[multiple] { min-height: 140px; background: #fafafa; }
        select[multiple] option { padding: 0.4rem; cursor: pointer; }
        .checkbox-group { margin: 1.25rem 0; }
        .checkbox-group label { display: inline-flex; align-items: center; gap: 0.5rem; font-weight: normal; cursor: pointer; }
        .checkbox-group input[type="checkbox"] { width: 16px; height: 16px; }
        button {
            background: #4a5568;
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            font-size: 0.9rem;
            font-weight: 500;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }
        button:hover { background: #2d3748; }
        small { display: block; color: #718096; font-size: 0.7rem; margin-top: 0.25rem; }
        .error-message {
            background: #fff5f5;
            color: #c53030;
            padding: 0.5rem 0.75rem;
            border-radius: 4px;
            margin-bottom: 0.5rem;
            border: 1px solid #feb2b2;
            font-size: 0.8rem;
        }
        .success-message {
            background: #f0fff4;
            color: #276749;
            padding: 0.75rem 1rem;
            border-radius: 4px;
            margin-bottom: 1.25rem;
            border: 1px solid #9ae6b4;
            font-size: 0.85rem;
        }
        #messages {
            margin-bottom: 1.25rem;
        }
        @media (max-width: 640px) {
            .content { padding: 1.25rem; }
            .radio-group { flex-direction: column; gap: 0.5rem; }
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>Регистрационная форма</h1>
        <p>Заполните все поля</p>
    </div>
    <div class="content">

        <?php if (!empty($messages)): ?>
            <div id="messages">
                <?php foreach ($messages as $message): ?>
                    <?= $message ?>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form action="" method="POST">
            <div class="form-group">
                <label class="required">ФИО</label>
                <input type="text" name="full_name" 
                       class="<?= $errors['full_name'] ? 'error-input' : '' ?>"
                       value="<?= htmlspecialchars($values['full_name'] ?? '') ?>"
                       placeholder="Иванов Иван Иванович">
                <small>Только буквы, пробелы и дефисы, не более 150 символов</small>
            </div>

            <div class="form-group">
                <label class="required">Телефон</label>
                <input type="text" name="phone" 
                       class="<?= $errors['phone'] ? 'error-input' : '' ?>"
                       value="<?= htmlspecialchars($values['phone'] ?? '') ?>"
                       placeholder="+7 (123) 456-78-90">
                <small>Пример: +7 (123) 456-78-90 (только цифры, пробелы, +, (, ), -)</small>
            </div>

            <div class="form-group">
                <label class="required">E-mail</label>
                <input type="text" name="email" 
                       class="<?= $errors['email'] ? 'error-input' : '' ?>"
                       value="<?= htmlspecialchars($values['email'] ?? '') ?>"
                       placeholder="example@mail.ru">
                <small>Должен содержать символ @</small>
            </div>

            <div class="form-group">
                <label class="required">Дата рождения</label>
                <input type="date" name="birth_date" 
                       class="<?= $errors['birth_date'] ? 'error-input' : '' ?>"
                       value="<?= htmlspecialchars($values['birth_date'] ?? '') ?>">
            </div>

            <div class="form-group">
                <label class="required">Пол</label>
                <div class="radio-group">
                    <label>
                        <input type="radio" name="gender" value="male"
                               <?= ($values['gender'] ?? '') == 'male' ? 'checked' : '' ?>> Мужской
                    </label>
                    <label>
                        <input type="radio" name="gender" value="female"
                               <?= ($values['gender'] ?? '') == 'female' ? 'checked' : '' ?>> Женский
                    </label>
                </div>
            </div>

            <div class="form-group">
                <label class="required">Любимый язык программирования</label>
                <select name="languages[]" multiple size="6"
                        class="<?= $errors['languages'] ? 'error-input' : '' ?>">
                    <?php
                    $langs = ['Pascal', 'C', 'C++', 'JavaScript', 'PHP', 'Python', 'Java', 'Haskell', 'Clojure', 'Prolog', 'Scala', 'Go'];
                    $selected_langs = explode(',', $values['languages'] ?? '');
                    foreach ($langs as $lang): ?>
                        <option value="<?= $lang ?>" <?= in_array($lang, $selected_langs) ? 'selected' : '' ?>>
                            <?= $lang ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <small>Удерживайте Ctrl для выбора нескольких языков</small>
            </div>

            <div class="form-group">
                <label>Биография</label>
                <textarea name="biography" rows="4" 
                          class="<?= $errors['biography'] ? 'error-input' : '' ?>"
                          placeholder="Расскажите немного о себе..."><?= htmlspecialchars($values['biography'] ?? '') ?></textarea>
            </div>

            <div class="checkbox-group">
                <label>
                    <input type="checkbox" name="agreed" value="1"
                           <?= !empty($values['agreed']) ? 'checked' : '' ?>> 
                    Я ознакомлен с контрактом
                </label>
            </div>

            <button type="submit">Сохранить</button>
        </form>
    </div>
</div>
</body>
</html>