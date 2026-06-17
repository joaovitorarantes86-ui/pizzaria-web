document.addEventListener('DOMContentLoaded', function() {

  // ---- Menu mobile ----
  var toggle = document.querySelector('.menu-toggle');
  var menu = document.querySelector('.nav-list');
  if (toggle && menu) {
    toggle.addEventListener('click', function() {
      this.classList.toggle('ativo');
      menu.classList.toggle('aberto');
    });
    menu.querySelectorAll('a').forEach(function(link) {
      link.addEventListener('click', function() {
        toggle.classList.remove('ativo');
        menu.classList.remove('aberto');
      });
    });
  }

  // ---- Validação de formulários ----
  function validar(campo) {
    var val = campo.value.trim();
    var tipo = campo.dataset.val;
    var erro = campo.parentElement.querySelector('.form-error');

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

  document.addEventListener('blur', function(e) {
    if (e.target.matches('input, select, textarea')) validar(e.target);
  }, true);

  document.addEventListener('submit', function(e) {
    var form = e.target;
    var campos = form.querySelectorAll('input, select, textarea');
    var ok = true;
    campos.forEach(function(c) { if (!validar(c)) ok = false; });
    if (!ok) e.preventDefault();
  });

  // ---- Admin sidebar toggle mobile ----
  var sidebarToggle = document.querySelector('.admin-sidebar .menu-toggle');
  var sidebarNav = document.querySelector('.admin-sidebar .sidebar-nav');
  if (sidebarToggle && sidebarNav) {
    sidebarToggle.addEventListener('click', function() {
      sidebarNav.classList.toggle('aberto');
    });
  }

  // ---- Animações ao scroll ----
  var animEls = document.querySelectorAll('[data-animar]');
  if (animEls.length) {
    var observer = new IntersectionObserver(function(entries) {
      entries.forEach(function(entry) {
        if (entry.isIntersecting) {
          entry.target.style.opacity = '1';
          entry.target.style.transform = 'translateY(0)';
        }
      });
    }, { threshold: 0.1 });

    animEls.forEach(function(el) {
      el.style.opacity = '0';
      el.style.transform = 'translateY(24px)';
      el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
      observer.observe(el);
    });
  }

});
