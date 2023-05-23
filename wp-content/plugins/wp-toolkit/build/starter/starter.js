/**
 * @returns {boolean}
 */
function is_Mobile() {
    try {
        if(/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini|Opera Mobile|Kindle|Windows Phone|PSP|AvantGo|Atomic Web Browser|Blazer|Chrome Mobile|Dolphin|Dolfin|Doris|GO Browser|Jasmine|MicroB|Mobile Firefox|Mobile Safari|Mobile Silk|Motorola Internet Browser|NetFront|NineSky|Nokia Web Browser|Obigo|Openwave Mobile Browser|Palm Pre web browser|Polaris|PS Vita browser|Puffin|QQbrowser|SEMC Browser|Skyfire|Tear|TeaShark|UC Browser|uZard Web|wOSBrowser|Yandex.Browser mobile/i.test(navigator.userAgent)) {
            return true;
        };
        return false;
    } catch(e){ console.log("Erro na verificação móvel"); return false; }
}

/**
 * @param f (function)
 */
function addLoadEvent(f) {
    var o = window.onload;
    window.onload = typeof window.onload != 'function' ? f : function() { if (o) { o(); } f(); }
}

/**
 * @param f (function)
 */
function addResizeEvent(f) {
    var o = window.onresize;
    window.onresize = typeof window.onresize != 'function' ? f : function() { if (o) { o(); } f(); }
}

/**
 * @param f (function)
 */
function addScrollEvent(f) {
    var o = window.onscroll;
    window.onscroll = typeof window.onscroll != 'function' ? f : function() { if (o) { o(); } f(); }
}