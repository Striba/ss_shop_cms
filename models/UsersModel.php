<?php

/* 
 * Модель для теблицы пользователей (users)
 *
 */

/**
 * Регистрация нового пользователя
 * 
 * @param string $email почта
 * @param string $pwdMD5 пароль зашифрованный в MD5
 * @param string $name имя пользователя
 * @param string $phone телефон
 * @param string $adress адрес пользователя
 * @return array массив данных нового пользователя
 */
function registerNewUser($email, $pwdMD5, $name, $phone, $adress){
    //Делаем проверку каждой вводимой переменной на надежность:
    //htmlspecialchars - преобразует специальные символы в HTML сущности
    //mysql_real_escape_string экранирует специальные символы в строках
    // для испльзования в выражениях SQL (она устаревшая, но пока будет так)
    $email = htmlspecialchars(mysql_real_escape_string($email));
    $name = htmlspecialchars(mysql_real_escape_string($name));
    $phone = htmlspecialchars(mysql_real_escape_string($phone));
    $adress = htmlspecialchars(mysql_real_escape_string($adress));
    
    $sql = "INSERT INTO users (`email`, `pwd`, `name`, `phone`, `adress`) "
            . "VALUES "
            . "('{$email}', '{$pwdMD5}', '{$name}', '{$phone}', '{$adress}')";
            
    $rs = mysql_query($sql);
    
    //Проверка успешности запроса:
    if($rs){
        $sql = "SELECT * FROM users "
                . "WHERE "
                . "(`email` = '{$email}' and `pwd` = '{$pwdMD5}') LIMIT 1";
                
        $rs = mysql_query($sql);
        $rs = createSmartyRsArray($rs);
        
        //Проверяем нашли этого пользователя или нет:
        if(isset($rs[0])){
            $rs['success'] = 1;
        } else {
            $rs['success'] = 0;
        }
    } else {
        $rs['success'] = 0;
    }
    
    return $rs;
}

/**
 * Проверка параметров для регистрации пользователя.
 * 
 * @param string $email email
 * @param string $pwd1 пароль
 * @param string $pwd2 повтор пароля
 * @return array результат
 */
function checkRegisterParam($email, $pwd1, $pwd2){
    
    $res = null;// либо array() 
    
    if(! $email){
        $res['success'] = FALSE;
        $res['message'] = 'Введите email';
    }
    
    if(! $pwd1){
        $res['success'] = FALSE;
        $res['message'] = 'Введите пароль';
    }
    
    if(! $pwd2){
        $res['success'] = FALSE;
        $res['message'] = 'Введите повтор пароля';
    }
    
    if($pwd1 != $pwd2){
        $res['success'] = FALSE;
        $res['message'] = 'Пароли не совпадают';
    }
    
    return $res;
}

/**
 * Проверка почты. Есть ли емейл адрес в БД.
 * 
 * @param string $email
 * @return array массив - строка из таблицы  users, либо пустой массив
 */
function checkUserEmail($email){
    
    $email = mysql_real_escape_string($email);
    $sql = "SELECT id FROM users WHERE email = '{$email}'";
    
    $rs = mysql_query($sql);
    $rs = createSmartyRsArray($rs);
    
    return $rs;
}

/**
 * Авторизация пользователя
 * 
 * @param string $email почта
 * @param string $pwd пароль
 * @return array массив данных пользователя
 */
function loginUser($email, $pwd){
    
    $email = htmlspecialchars(mysql_real_escape_string($email));
    $pwd = md5($pwd);
    
    $sql = "SELECT * FROM users "
            . "WHERE "
            . "(email = '{$email}' and pwd = '{$pwd}') LIMIT 1";
    
    $rs = mysql_query($sql);
    $rs = createSmartyRsArray($rs);
    
    if (isset($rs[0])){
        $rs['success'] = 1; 
    } else {
        $rs['success'] = 0;
    }
    
    return $rs;
}

/**
 * Изменение данных пользователя
 * 
 * @param type $name имя пользователя
 * @param type $phone телефон
 * @param type $adress адрес
 * @param type $pwd1 новый пароль
 * @param type $pwd2 повтор нового пароля
 * @param type $curPwd текущий пароль
 * @return boolean TRUE в случае успеха
 */
function updateUserData($name, $phone, $adress, $pwd1, $pwd2, $curPwd){
    
    $email = htmlspecialchars(mysql_real_escape_string($_SESSION['user']['email']));
    $name = htmlspecialchars(mysql_real_escape_string($name));
    $phone = htmlspecialchars(mysql_real_escape_string($phone));
    $adress = htmlspecialchars(mysql_real_escape_string($adress));
    $pwd1 = trim($pwd1);
    $pwd2 = trim($pwd2);
    
    $newPwd = null;
    if($pwd1 && $pwd1 == $pwd2){
        $newPwd = md5($pwd1);
    }
    
    $sql = "UPDATE users SET";
    
    if($newPwd){
        $sql .= " `pwd` = '{$newPwd}', ";
    }
    
    $sql .= " `name` = '{$name}',"
    . " `phone` = '{$phone}',"
    . " `adress` = '{$adress}'"
    . " WHERE "
            . "`email` = '{$email}' and `pwd` = '{$curPwd}'"
            . " LIMIT 1";
            
    $rs = mysql_query($sql);
    
    return $rs;
}

/**
 * Получить данные заказа текущего пользователя
 * 
 * @return array массив заказов с привязкой к продуктам
 */

function getCurUserOrders(){
    
    $userId = isset($_SESSION['user']['id']) ? $_SESSION['user']['id'] : 0;
    $rs = getOrdersWithProductsByUser($userId);
    
    return $rs;
}