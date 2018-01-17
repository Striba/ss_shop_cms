/**
 * Добавлене товара корзину
 * 
 * @param integer itemId - ID добавляемого продукта
 * @return в случае успеха обновляются данные корзины на странице
 */
function addToCart(itemId){
    console.log("js - addToCart()");
    $.ajax({
        type: 'POST',
        async: false,
       /* async: true,*/
        url: "/cart/addtocart/" + itemId + '/',
        dataType: 'json',
        success: function (data){//получаем данные джейсон которые к нам пришли
            if(data['success']){
                $('#cartCntItems').html(data['cntItems']);//меянем хтмл запись 
                //на то количесво оторое у нас прило в массиве джейсон
                //$('cartCntItems').append(data['cntItems']);// тот же результат
                //$('cartCntItems').append(data.cntItems);// тот же результат
                
                $('#addCart_' + itemId).hide();//прячем соотв. элемент
                $('#removeCart_' + itemId).show();//показываем соотв. элемент
            }
        }
    });
}

/**
 * Удаление товара из корзины
 * 
 * @param integer itemId - ID удаляемого продукта
 * @return в случае успеха обновляются данные корзины на странице
 */
function removeFromCart(itemId){
    console.log("js - removeFromCart("+itemId+")");
    $.ajax({
        type: 'POST',
        async: false,
        /*async: true,*/
        url: "/cart/removefromcart/" + itemId + '/',
        dataType: 'json',
        success: function (data){
            if(data['success']){
                $('#cartCntItems').html(data['cntItems']);
                
                $('#addCart_' + itemId).show();
                $('#removeCart_' + itemId).hide();
            }
        }
    });
}

/**
 * Подсчет стоимости купленного товара
 * 
 * @param integer itemId - ID продукта
 */
function conversionPrice(itemId){
    var newCnt = $('#itemCnt_' + itemId).val();//val() берем значение поля value
    // для переменной '#itemCnt_' + itemId
    var itemPrice = $('#itemPrice_' + itemId).attr('value');//attr('value')
    // берем аттрибут value для элемента с идентификатором '#itemPrice_' + itemId
    var itemRealPrice = newCnt * itemPrice;
    
    $('#itemRealPrice_' + itemId).html(itemRealPrice)
    
}

/**
 * Получение данных из формы
 * 
 * @param {object} obj_form идентификатор объекта
 * @returns array
 */
function getData(obj_form){
        console.log("Прибыли данные222: " + obj_form );

    var hData = {};/*инициализируем пустой массив, т.е. объект jQuery*/
    jQuery('input, textarea, select', obj_form).each(function(){/*применяем 
        функцию к каждому элементу массива*/
       if(this.name && this.name!=''){/*Если существует названиее текущего 
           элемента, и оно не пустое*/
           hData[this.name] = this.value;
           console.log('hData[' + this.name + '] = ' + hData[this.name]);
       } 
    });
    return hData;
};
/**
 * Регистрация нового пользователя
 * 
 * @returns {undefined}
 */
function registerNewUser(){
    var postData = getData('#registerBox');
    //console.log("Прибыли данные111: " );
    jQuery.ajax({
        type: 'POST',
        /* async: false,*/
        //async: false,
        url: "/user/register/",/*controller:user action:register*/
        data: postData,
        dataType: 'json',
        success: function(data){
             //console.log("Прибыли данные: " + data);
            if(data['success']){
                alert('Регистрация прошла успешно');
                
                //>блок в левом столбце
                jQuery('#registerBox').hide();
                //console.log("Прибыли данные888: " + data);
                jQuery('#userLink').attr('href', '/user/');
                jQuery('#userLink').html(data['userName']);
                jQuery('#userBox').show();
                //<
                
                //>Страница заказа
                jQuery('#loginBox').hide();
                jQuery('#btnSaveOrder').show();
                //<
            } else {
                alert(data['message']);
            }
        }
    });
    
}

/**
 *Авторизация пользователя
 * 
 * @returns {undefined}
 */
function login(){
    var email = jQuery('#loginEmail').val();
    var pwd = jQuery('#loginPwd').val();
    
    var postData = "email=" + email + "&pwd=" + pwd;// формируем строку запроса
    
    jQuery.ajax({
        type: 'POST',
        url: "/user/login/",
        data: postData,
        dataType: 'json',
        success: function(data){
            if(data['success']){
                jQuery('#registerBox').hide();
                jQuery('#loginBox').hide();
                
                jQuery('#userLink').attr('href','/user/');
                jQuery('#userLink').html(data['displayName']);
                jQuery('#userBox').show();
                
                //>заполняем поля на странице заказа:
                jQuery('#name').val(data['name']);
                jQuery('#adress').val(data['adress']);
                jQuery('#phone').val(data['phone']);
                //<
                jQuery('#btnSaveOrder').show();
            } else {
                alert(data['message']);
            }
        }
    });
    
}

/**
 * 
 * 
 * @returns {undefined}
 * 
 */

function showRegisterBox(){

    if (jQuery('#registerBoxHidden').hasClass('hideme')){
        jQuery('#registerBoxHidden').removeClass('hideme');
    } else {
        jQuery('#registerBoxHidden').addClass('hideme');
    }
    
//    if (jQuery('#registerBoxHidden').css('display') != 'block'){
//        jQuery('#registerBoxHidden').show();
//    } else {
//        jQuery('#registerBoxHidden').hide();
//    }
  
}

/**
 *Разлогинивание пользователя
 * 
 * @returns {undefined}
 */
function logout(){
    
    
}

/**
 * Обновление данных пользователя
 * 
 * 
 */

function updateUserData(){
    console.log('js - updateUserData()');
    var phone = jQuery('#newPhone').val();
    var adress = jQuery('#newAdress').val();
    var pwd1 = jQuery('#newPwd1').val();
    var pwd2 = jQuery('#newPwd2').val();
    var curPwd = jQuery('#curPwd').val();
    var name = jQuery('#newName').val();
    
    var postData = {phone: phone,
                    adress: adress,
                    pwd1: pwd1,
                    pwd2: pwd2,
                    curPwd: curPwd,
                    name: name};
    jQuery.ajax({
        type: 'POST',
        url: "/user/update/",
        data: postData,
        dataType: 'json',
        success: function(data){
            if(data['success']){
                jQuery('#userLink').html(data['userName']);
                alert(data['message']);
            } else {
                alert(data['message']);
            }
        }
    });
    
}

/**
 * Сохранение заказа
 * 
 */
function saveOrder(){
    var postData = getData('form');//применили, т.к. он здесь единственный 
    //и проходимся по его внутренним элементам
    jQuery.ajax({
        type: 'POST',
        //async: false,
        url: '/cart/saveorder/',
        data: postData,
        dataType:'json',
        success: function(data){
            if(data['success']){
                alert(data['message']);
                document.location = '/';
            } else {
                alert(data['message']);
            }
            
            
        }
    });
}

/**
 * Показывать или прятать данные об заказе
 * 
 */
function showProducts(id){
    //console.log('js-id: ' + id);
    var objName = '#purchasesForOrderId_' + id;
    if( jQuery(objName).css('display') != 'table-row'){
        //console.log('jaaaa '+objName);
        jQuery(objName).show();
    } else {
        //console.log('js-id: ' + jQuery(objName).css('display'))
        jQuery(objName).hide();
    }
    
}