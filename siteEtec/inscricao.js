/**
 * inscricao.js — Validação client-side otimizada, contador de caracteres,
 * máscara de telefone e loader no botão de envio.
 */

document.addEventListener('DOMContentLoaded', () => {

  /*Referências*/
  const form = document.getElementById('inscricaoForm');
  const submitBtn = document.getElementById('submitBtn');
  const telefone = document.getElementById('telefone');
  const motivacao = document.getElementById('motivacao');
  const charCount = document.getElementById('charCount');
  const datanascimento = document.getElementById('datanascimento');

  const MAX_CHARS = 500;

  /*Regras de validação*/
  const rules = {
    nome: v => !v.trim() ? 'Nome completo é obrigatório.'
            : v.trim().length < 3 ? 'Digite seu nome completo.' : '',

    email: v => !v.trim() ? 'E-mail é obrigatório.'
            : !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v.trim()) ? 'Informe um e-mail válido.' : '',

    telefone: v => !v.trim() ? 'Telefone é obrigatório.' : '',

    datanascimento: v => !v.trim() ? 'Data de nascimento é obrigatória.'
            : !/^\d{2}\/\d{2}\/\d{4}$/.test(v.trim()) ? 'Use o formato DD/MM/AAAA.' : '',

    endereco: v => !v.trim() ? 'Endereço completo é obrigatório.' : '',

    bairro: v => !v.trim() ? 'Bairro é obrigatório.' : '',

    municipio: v => !v.trim() ? 'Município é obrigatório.' : '',

    escolaridade: v => !v ? 'Selecione seu nível de escolaridade.' : '',

    curso: v => !v ? 'Selecione o curso que deseja se inscrever.' : '',

    motivacao: v => !v.trim() ? 'Conte-nos por que você se interessa por este curso.'
            : v.trim().length < 10 ? 'Mínimo de 10 caracteres.'
            : v.trim().length > MAX_CHARS ? `Máximo de ${MAX_CHARS} caracteres.` : '',

    aceite: c => !c ? 'Você precisa aceitar os termos e condições.' : '',
  };

  const camposObrigatorios = [
    'nome', 'email', 'telefone', 'datanascimento', 'endereco', 'bairro', 'municipio',
    'escolaridade', 'curso', 'motivacao', 'aceite'
  ];

  /*Aplica / limpa um campo*/
  function setFieldState(el, msg) {
    const errEl = document.getElementById(`erro-${el.id}`);
    el.classList.toggle('is-error', !!msg);
    el.classList.toggle('is-valid', !msg);
    if (errEl) errEl.textContent = msg;
    return !msg;
  }

  function valorDoCampo(el) {
    return el.type === 'checkbox' ? el.checked : el.value;
  }

  /*Contador de caracteres*/
  if (motivacao && charCount) {
    const updateCount = () => {
      let len = motivacao.value.length;
      if (len > MAX_CHARS) motivacao.value = motivacao.value.slice(0, MAX_CHARS);
      len = motivacao.value.length;
      charCount.textContent = `${len} / ${MAX_CHARS}`;
      charCount.classList.toggle('near-limit', len >= 400 && len < MAX_CHARS);
      charCount.classList.toggle('at-limit', len >= MAX_CHARS);
    };
    motivacao.addEventListener('input', updateCount);
    updateCount();
  }

  /*Máscara de data*/
  if (datanascimento) {
    datanascimento.addEventListener('input', () => {
      let v = datanascimento.value.replace(/\D/g, '');
      if (v.length > 8) v = v.slice(0, 8);
      if (v.length > 4)      v = v.replace(/^(\d{2})(\d{2})(\d{4})$/, '$1/$2/$3');
      else if (v.length > 2) v = v.replace(/^(\d{2})(\d+)$/,           '$1/$2');
      datanascimento.value = v;
    });
  }

  /*Máscara de telefone*/
  if (telefone) {
    telefone.addEventListener('input', () => {
      let v = telefone.value.replace(/\D/g, '');
      if (v.length > 11) v = v.slice(0, 11);
      if (v.length > 10)      v = v.replace(/^(\d{2})(\d{5})(\d{4})$/, '($1) $2-$3');
      else if (v.length > 6)  v = v.replace(/^(\d{2})(\d{4})(\d+)$/,   '($1) $2-$3');
      else if (v.length > 2)  v = v.replace(/^(\d{2})(\d+)$/,           '($1) $2');
      telefone.value = v;
    });
  }

  /*Valida ao sair do campo*/
  camposObrigatorios.forEach(id => {
    const el = document.getElementById(id);
    if (!el) return;

    // checkbox
    if (el.type === 'checkbox') {
      el.addEventListener('change', () => {
        const msg = rules[id] ? rules[id](valorDoCampo(el)) : '';
        const errEl = document.getElementById(`erro-${el.id}`);
        if (errEl) errEl.textContent = msg;
        el.classList.toggle('is-error', !!msg);
        el.classList.toggle('is-valid', !msg);
      });
      return;
    }

    el.addEventListener('blur', () => {
      const msg = rules[id] ? rules[id](valorDoCampo(el)) : '';
      setFieldState(el, msg);
    });
  });

  /*Valida os campos obrigatórios*/
  function validateAll() {
    let ok = true;
    camposObrigatorios.forEach(id => {
      const el = document.getElementById(id);
      if (!el) return;
      const val = valorDoCampo(el);
      const ruleFn = rules[id];
      const msg = ruleFn ? ruleFn(val) : '';

      if (el.type === 'checkbox') {
        const errEl = document.getElementById(`erro-${el.id}`);
        if (msg) {
          if (errEl) errEl.textContent = msg;
          el.classList.add('is-error');
          el.classList.remove('is-valid');
          ok = false;
        } else {
          if (errEl) errEl.textContent = '';
          el.classList.remove('is-error');
          el.classList.add('is-valid');
        }
      } else {
        if (!setFieldState(el, msg)) ok = false;
      }
    });
    return ok;
  }

  /*Submit*/
  if (form) {
    form.addEventListener('submit', e => {
      if (!validateAll()) {
        e.preventDefault();
        const firstError = form.querySelector('.is-error');
        if (firstError && typeof firstError.focus === 'function') firstError.focus();
        return;
      }

      if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.classList.add('loading');
      }
    });
  }

});