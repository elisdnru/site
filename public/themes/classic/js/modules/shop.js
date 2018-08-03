
var currentProductX = 0;
var currentProductY = 0;

function getPageEventCoords(e){
    var evt = e || window.event;
    var coords = {left:0, top:0};
    if (evt.pageX){
        coords.left = evt.pageX;
        coords.top = evt.pageY;
    } else if (evt.clientX) {
        coords.left = evt.clientX + document.body.scrollLeft - document.body.clientLeft;
        coords.top = evt.clientY + document.body.scrollTop - document.body.clientTop;
        if (document.body.parentElement && document.body.parentElement.clientLeft){
            var bodParent = document.body.parentElement;
            coords.left += bodParent.scrollLeft - bodParent.clientLeft;
            coords.top += bodParent.scrollTop - bodParent.clientTop;
        }
    }
    return coords;
}

function toCartClick(e, id){
    var pos = getPageEventCoords(e);
    currentProductX = pos.left;
    currentProductY = pos.top;
    jQuery('#link' + id).click();
    return false;
}

function getElementPosition(elemId){
    var elem = typeof elemId == 'object' ? elemId : document.getElementById(elemId);
    var l = 0;
    var t = 0;
    while (elem)
    {
        l += elem.offsetLeft;
        t += elem.offsetTop;
        elem = elem.offsetParent;
    }
    return {"left":l, "top":t};
}

function showCartProcess(){

    var div = jQuery('<div>');
    div.css({
        width: 100,
        height: 30,
        position: 'absolute',
        left: currentProductX,
        top: currentProductY - 75,
        background: '#333',
        opacity: 0.5
    });
    jQuery('body').append(div);

    var cartPos = getElementPosition('miniCartWidget');

    div.animate({
        left: cartPos.left + 100,
        top: cartPos.top + 70,
        width: 50,
        height: 20,
        opacity:0
    }, 600);
}

function updateCart(token){
    jQuery.ajax({
        type: 'POST',
        url: '/shop/cart/minicart',
        data: {
            'YII_CSRF_TOKEN': token
        },
        success: function(data){
            jQuery('#miniCartWidget').html(data);
        },
        error:function(XHR) {
            alert(XHR.responseText);
        }
}   );
}