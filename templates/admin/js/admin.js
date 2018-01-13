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

