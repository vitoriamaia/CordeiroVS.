/**
 * @use jQuery('.element').exists(function(){})
 * @param callback
 * @returns {jQuery}
 */
jQuery.fn.exists = function(callback) {
    var args = [].slice.call(arguments, 1);

    if (this.length) {
        callback.call(this, args);
    }
    return this;
};