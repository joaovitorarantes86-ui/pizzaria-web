// menu hamburguer
function toggleMenu() {
    var menu = document.getElementById('menu');
    var img = document.getElementById('menu-img');
    menu.classList.toggle('aberto');
    img.src = menu.classList.contains('aberto') ? 'IMG/close.png' : 'IMG/menu.png';
}

// fecha menu ao clicar em link
document.querySelectorAll('#menu a').forEach(function(link) {
    link.addEventListener('click', function() {
        document.getElementById('menu').classList.remove('aberto');
        document.getElementById('menu-img').src = 'IMG/menu.png';
    });
});

// validação dos formulários
function validar(campo) {
    var val = campo.value.trim();
    var tipo = campo.dataset.val;
    var erro = campo.parentElement.querySelector('.msg-erro');

    campo.classList.remove('erro');
    if (erro) erro.classList.remove('show');

    if (campo.required && !val) {
        return marcarErro(campo, erro, 'Campo obrigatório.');
    }
    if (tipo === 'email' && val && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(val)) {
        return marcarErro(campo, erro, 'E-mail inválido.');
    }
    if (tipo === 'tel' && val && !/^\(?\d{2}\)?\s?\d{4,5}-?\d{4}$/.test(val)) {
        return marcarErro(campo, erro, 'Telefone inválido. Ex: (67) 99999-9999');
    }
    if (tipo === 'cep' && val && !/^\d{5}-?\d{3}$/.test(val)) {
        return marcarErro(campo, erro, 'CEP inválido. Ex: 79000-000');
    }
    if (tipo === 'senha' && val && val.length < 6) {
        return marcarErro(campo, erro, 'Mínimo 6 caracteres.');
    }
    return true;
}

function marcarErro(campo, erro, msg) {
    campo.classList.add('erro');
    if (erro) { erro.textContent = msg; erro.classList.add('show'); }
    return false;
}

// valida ao sair do campo
document.addEventListener('blur', function(e) {
    if (e.target.matches('input, select, textarea')) validar(e.target);
}, true);

// valida ao enviar
document.addEventListener('submit', function(e) {
    var form = e.target;
    var campos = form.querySelectorAll('input, select, textarea');
    var ok = true;
    campos.forEach(function(c) { if (!validar(c)) ok = false; });
    if (!ok) e.preventDefault();
});