// scripts.js
function aceitarCookies() {
    var cookieKey = "aceitouCookies";
    var preferenciaAceite = "sim";
    localStorage.setItem(cookieKey, preferenciaAceite);
    document.getElementById("cookieConsentPopup").style.display = "none";
}

document.addEventListener("DOMContentLoaded", function() {
    var cookieKey = "aceitouCookies";
    if (localStorage.getItem(cookieKey) !== "sim") {
        document.getElementById("cookieConsentPopup").style.display = "block";
    }
});
