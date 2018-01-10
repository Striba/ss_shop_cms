<?php

/* 
 * Контроллер функций пользователя
 *
 */

//подключаем модели:
include_once 'models/CategoriesModel.php';
include_once 'models/UsersModel.php';




/**
 * AJAX регистрация пользователя.
 * Инициализаця сессионной переменной ($_SESSION['user'])
 * 
 * @return json массив данных нового пользователя
 */
function registerAction(){
    //echo 'Hallo';
    
    $email = isset($_REQUEST['email']) ? $_REQUEST['email'] : null;
    $email = trim($email);
    
    $pwd1 = isset($_REQUEST['pwd1']) ? $_REQUEST['pwd1'] : null;
    $pwd2 = isset($_REQUEST['pwd2']) ? $_REQUEST['pwd2'] : null;
    
    $phone = isset($_REQUEST['phone']) ? $_REQUEST['phone'] : null;
    $adress = isset($_REQUEST['adress']) ? $_REQUEST['adress'] : null;
    $name = isset($_REQUEST['name']) ? $_REQUEST['name'] : null;
    $name = trim($name);
    
    $resData = null;
    $resData = checkRegisterParam($email, $pwd1, $pwd2);
    
    if(! $resData && checkUserEmail($email)){

        $resData['success'] = 0;
        $resData['message'] = "Пользователь с таким email( '{$email}' ) уже зарегистрирован";
    }
    
    if(! $resData){
        $pwdMD5 = md5($pwd1);
        
        $userData = registerNewUser($email, $pwdMD5, $name, $phone, $adress);
        
        if($userData['success']){
            $resData['message'] = 'Пользователь успешно зарегистрирован';
            $resData['success'] = 1;
            
            $userData = $userData[0];
            $resData['userName'] = $userData['name'] ? $userData['name'] : $userData['email'];
            $resData['userEmail'] = $email;
            
            $_SESSION['user'] = $userData;
            $_SESSION['user']['displayName'] = $userData['name'] ? $userData['name'] : $userData['email'];
        } else {
           $resData['success'] = 0;
           $resData['message'] = 'Ошибка регистрации';
        }
        
    }
       echo json_encode($resData);
}

/**
 * Разлогинивание пользователя
 * 
 */
function logoutAction(){
    if(isset($_SESSION['user'])){
        unset($_SESSION['user']);
        unset($_SESSION['cart']);
    }
    
    redirect('/');
}

/**
 * AJAX авторизация пользователя
 * 
 * @return fson массив данных авторизированного пользователя
 */
function loginAction() {
    $email = isset($_REQUEST['email']) ? $_REQUEST['email'] : null;
    $email = trim($email);
    
    $pwd = isset($_REQUEST['pwd']) ? $_REQUEST['pwd'] : null;
    $pwd = trim($pwd);
    
    $userData = loginUser($email, $pwd);
    
    if($userData['success']){
        
        //Чтобы не обращаться за данными каждый раз в БД, заносим данные в сессию.
        $userData = $userData[0];
        
        $_SESSION['user'] = $userData;
        $_SESSION['user']['displayName'] = $userData['name'] ? $userData['name'] : $userData['email'];
        
        $resData = $_SESSION['user'];
        $resData['success'] = 1;
        
        //
        //

    } else {
        $resData['success'] = 0;
        $resData['message'] = 'Неверный логин или пароль';
    }
    
    echo json_encode($resData);
}

/**
 * Формирование главной страницы пользователя
 * 
 * @link /user/
 * @param object $smarty шаблонизатор
 */
function indexAction($smarty){
    
    //Если пользователь не залогинен, то редирект на главную страницу
    if(! isset($_SESSION['user'])){
        redirect('/');
    }
    
    //получаем список категорий для меню
    $rsCategories = getAllMainCatsWithChildren();
    
    $smarty->assign('PageTitle', 'Страница пльзователя');
    $smarty->assign('rsCategories', $rsCategories);
    
    loadTemplate($smarty, 'header');
    loadTemplate($smarty, 'user');
    loadTemplate($smarty, 'footer');
}

/**
 * Обновление данных пользователя
 * 
 * @return json результаты выполнения функции
 * 
 */
function updateAction(){
    //> если пользователь не залогинен,то выходим
    if(! isset($_SESSION['user'])){
        redirect('/');
    }
    //<
    
    //>инициализация переменных
    $resData = array();
    $phone = isset($_REQUEST['phone']) ? $_REQUEST['phone'] : null;
    $adress = isset($_REQUEST['adress']) ? $_REQUEST['adress'] : null;
    $name = isset($_REQUEST['name']) ? $_REQUEST['name'] : null;
    $pwd1 = isset($_REQUEST['pwd1']) ? $_REQUEST['pwd1'] : null;
    $pwd2 = isset($_REQUEST['pwd2']) ? $_REQUEST['pwd2'] : null;
    $curPwd = isset($_REQUEST['curPwd']) ? $_REQUEST['curPwd'] : null;
    
    //<
    //echo 'curPWD: '.$curPwd;
    //echo 'SESSION curPWD: '.$_SESSION['user']['pwd'];
    //echo 'SESSION phone: '.$_SESSION['user']['phone'];
    //echo 'SESSION adress: '.$_SESSION['user']['adress'];

    //проверка правильности пароля (введенный и тот под которым залогинились)
    $curPwdMD5 = md5($curPwd);
    //echo 'curPwdMD5: '.$curPwdMD5;
    if(! $curPwd || ($_SESSION['user']['pwd'] != $curPwdMD5)){
        $resData['success'] = 0;
        $resData['message'] = "Текущий пароль не верный";
        echo json_encode($resData);
        return false;
    }
    
    //обновление данных пользователя
    $res = updateUserData($name, $phone, $adress, $pwd1, $pwd2, $curPwdMD5);
    //echo ' adress: '.$adress;
    if($res){
        $resData['success'] = 1;
        $resData['message'] = 'Данные сохранены';
        $resData['userName'] = $name;
        
        $_SESSION['user']['name'] = $name;
        $_SESSION['user']['phone'] = $phone;
        $_SESSION['user']['adress'] = $adress;
        
            $newPwd = $_SESSION['user']['pwd'];
            if($pwd1 && $pwd1 == $pwd2){
                $newPwd = md5(trim($pwd1));
            }
            
        //$_SESSION['user']['pwd'] = $curPwdMD5;
        $_SESSION['user']['pwd'] = $newPwd;
        $_SESSION['user']['displayName'] = $name ? $name : $_SESSION['user']['email'];
        
    } else {
        $resData['success'] = 0;
        $resData['message'] = 'Ошибка сохранения данных';
    }
    
    echo json_encode($resData);
}