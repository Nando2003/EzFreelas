document.addEventListener('DOMContentLoaded', () => {
  const priceInput    = document.getElementById('id_price');
  const messageInput  = document.getElementById('id_message');
  const submitBtn     = document.getElementById('submit_btn');

  let prevPrice = '';

  function validateForm() {
    const priceFilled   = priceInput.value.trim() !== '';
    const messageText   = messageInput.value.trim();
    const messageValid  = messageText.length >= 100;

    submitBtn.disabled = !(priceFilled && messageValid);
  }

  // Bloqueia caracteres não numéricos ou ponto
  priceInput.addEventListener('beforeinput', e => {
    if (e.inputType === 'insertText' && /[^0-9.]/.test(e.data)) {
      e.preventDefault();
    }
  });

  // Valida formato decimal (2 casas)
  priceInput.addEventListener('input', () => {
    const v = priceInput.value;
    if (/^\d*(\.\d{0,2})?$/.test(v)) {
      prevPrice = v;
    } else {
      priceInput.value = prevPrice;
    }
    validateForm();
  });

  // Listener para mensagem
  messageInput.addEventListener('input', validateForm);

  // Validação inicial
  validateForm();
});