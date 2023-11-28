function aceitarCookies() {
    var cookieKey = "aceitouCookies";
    var preferenciaAceite = "sim";
    localStorage.setItem(cookieKey, preferenciaAceite);
    document.getElementById("cookieConsentPopup").style.display = "none";
}

document.addEventListener("DOMContentLoaded", function () {
    var cookieKey = "aceitouCookies";
    if (localStorage.getItem(cookieKey) !== "sim") {
        document.getElementById("cookieConsentPopup").style.display = "block";
    }

    // Carregar o nome de usuário do armazenamento local, se disponível
    var usuarioKey = "usuario";
    var usuarioInput = document.getElementById("usuarioInput");
    var salvarUsuarioCheckbox = document.getElementById("salvarUsuarioCheckbox");
    if (localStorage.getItem(usuarioKey)) {
        usuarioInput.value = localStorage.getItem(usuarioKey);
        salvarUsuarioCheckbox.checked = true;
    }

    // Salvar o nome de usuário no armazenamento local quando o formulário é enviado
    document.querySelector("form").addEventListener("submit", function () {
        if (salvarUsuarioCheckbox.checked) {
            localStorage.setItem(usuarioKey, usuarioInput.value);
        } else {
            localStorage.removeItem(usuarioKey);
        }
    });
});

document.getElementById("acceptCookiesButton").addEventListener("click", aceitarCookies);
