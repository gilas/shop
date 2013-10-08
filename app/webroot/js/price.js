jQuery(function() {
     $('input.price').keyup(function(){
        value = $(this).val()
        value = value.replace(/,/g,'')
        oldValue = ''
        for(i = value.length - 1; i >= 0 ; i--){
            oldValue += value[i]
        }
        value = oldValue;
        newValue = ''
        for(i = 0; i< value.length; i++){
            if(i%3 == 0 && i != 0){
                newValue += ','
            }
            newValue += value[i]
        }
        oldValue = ''
        for(i = newValue.length - 1; i >= 0 ; i--){
            oldValue += newValue[i]
        }
        newValue = oldValue;
        $(this).val(newValue)
    })
    $('input.price').change(function(){
        $('input.price').trigger('keyup');
    })
    $('input.price').trigger('keyup');
    $('form').submit(function(){
        $(this).find("input").each(function(){
            if($(this).hasClass('price')){
                value = $(this).val()
                value = value.replace(/,/g,'')
                $(this).val(value);
            }
        }).hasClass()
        return true;
    });
});