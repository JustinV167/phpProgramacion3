function maxValue(e){
    const max = parseInt(e.max);
    const min=parseInt(e.min) 
    const value=parseInt(e.value)
    if(value<min || isNaN(value) )   {
        e.value=min
    } 
    if ( value> max) {
        e.value = max; // Establece el valor al máximo permitido
    }
    totalPriceProducts(e,e.value)
    
}
function prevButtonNumber(e){
    const input=e.nextElementSibling
    const value=parseInt(input.value)
    if(isNaN(value)){
        input.value=0
    }
    if(value>parseInt(input.min)){
        input.value=value-1
    }
    totalPriceProducts(e,input.value)
}
function nextButtonNumber(e){
    const input=e.previousElementSibling
    const value=parseInt(input.value)
    if(isNaN(value)){
        input.value=0
    }
    if(value<parseInt(input.max)){
        input.value=value+1
    }
    totalPriceProducts(e,input.value)
}
function totalPriceProducts(e,value){
    const parent=e.parentNode.nextElementSibling;
    const totalPriceTarget=parent.querySelector('.total_price')
    const priceTarget=parent.querySelector('.price')
    totalPriceTarget.innerText=value*parseInt(priceTarget.innerText)
}