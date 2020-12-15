$(function() {

    'use strict';

    var needToLoad = false;
    document.addEventListener("visibilitychange", event => {
        if (document.visibilityState == "visible") {
            $('select[aria-controls="dtLinks"]').change();
        } else {
            needToLoad = true;
        }
    });
    if (needToLoad) {
        $('select[aria-controls="dtLinks"]').change();
    }
});