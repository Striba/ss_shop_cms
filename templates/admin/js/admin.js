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


function newCategory(){
     console.log('upsaaa');
    var postData = getData('#blockNewCategory');
   console.log('ups'); 
    jQuery.ajax({
        type: 'POST',
        url: '/admin/addnewcat/',
        dataType: 'json',
        data: postData,
        success: function (data){
            if(data){
                alert(data['message']);
                jQuery('#newCategoryName').val();
            } else {
                alert(data['message']);
            }
        }
    });
}

/**
 * Обновленных данных категории
 * 
 * @param integer itemId ID категории
 * @returns {undefined}
 */
function updateCat(itemId){
    
    var parentId = jQuery('#parentId_' + itemId).val();
    var newName = jQuery('#itemName_' + itemId).val();
    var postData = { itemId: itemId,
                     parentId: parentId,
                     newName: newName };
    //console.log(postData);
    jQuery.ajax({
        type: 'POST',
        url: '/admin/updatecategory/',
        dataType: 'json',
        data: postData,
        success: function(data){
            alert(data['message']);
        }
    });
    
}

/**
 * Добавление нового продукта(товара)
 * 
 */
function addProduct(){
    var itemName = jQuery('#newItemName').val();
    var itemPrice = jQuery('#newItemPrice').val();
    var itemCatId = jQuery('#newItemCatId').val();
    var itemDesc = jQuery('#newItemDesc').val();
    
    //Формируем массив в формате JSON, для отправки в значения
    var postData = {itemName: itemName,
                    itemPrice: itemPrice,
                    itemCatId: itemCatId,
                    itemDesc: itemDesc};
    
    jQuery.ajax({
        type: 'POST',
        url: '/admin/addproduct/',
        data: postData,
        dataType: 'json',
        success: function(data){
            alert(data['message']);
            if(data['success']){
                //очищаем все поля для ввода новго продукта:
               jQuery('#newItemName').val(''); 
               jQuery('#newItemPrice').val('');
               jQuery('#newItemCatId').val('');
               jQuery('#newItemDesc').val('');
            } 
        }
    });
   
}

/**
 * Изменение данных продукта
 * 
 * @param {type} itemId
 */
function updateProduct(itemId){
    
    var itemName = jQuery('#itemName_' + itemId).val();
    var itemPrice = jQuery('#itemPrice_' + itemId).val();
    var itemCatId = jQuery('#itemCatId_' + itemId).val();
    var itemDesc = jQuery('#itemDesc_' + itemId).val();
    var itemStatus = jQuery('#itemStatus_' + itemId).prop('checked');
    
    if(! itemStatus){
        itemStatus = 1;
    } else {
        itemStatus = 0;
    }
    
    var postData = {
        itemId: itemId,
        itemName: itemName,
        itemPrice: itemPrice,
        itenCatId: itemCatId,
        itemDesc: itemDesc,
        itemStatus: itemStatus};
   
    jQuery.ajax({
        type: 'post',
        url: '/admin/updateproduct/',
        data: postData,
        dataType: 'json',
        success: function(data){
            alert(data['message']);
        }
    });
}


/**
 * Показать развернутую информацию товара заказа
 * 
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

/**
 * Изменение статуса заказа
 * 
 */
function updateOrderStatus(itemId){
    
  var status;
if($("#itemStatus_" + itemId).is(":not(:checked)")){
    status = 0;
}else{
    status = 1;
}
  
  var postData = {itemId: itemId, status: status};
  
  jQuery.ajax({
      type: 'post',
      url: '/admin/setorderstatus/',
      data: postData,
      dataType: 'json',
      success: function(data){
          if(! data['success']){
              alert(data['message']);
          }
      }
  });
  
}

/**
 * Изменение информации об оплате заказа
 * 
 */
function updateDatePayment(itemId){
    
  var datePayment = jQuery('#datePayment_' + itemId).val();
  var postData = {itemId: itemId, datePayment: datePayment};
  
    //console.log('NOOOSSS');//сюда доходит
  jQuery.ajax({
      type: 'post',
      url: '/admin/setorderdatepayment/',
      data: postData,
      dataType: 'json',
      success: function(data){
          if(! data['success']){
              alert(data['message']);
          } else {
              //console.log('YEEESSS');
          }
      }
  });
}
