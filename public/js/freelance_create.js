document.addEventListener('DOMContentLoaded', () => {
  const titleInput       = document.getElementById('id_title');
  const priceInput       = document.getElementById('id_price');
  const descriptionInput = document.getElementById('id_description');
  const submitBtn        = document.getElementById('submit_btn');

  let prevPrice = '';

  function validateForm() {
    const titleFilled = titleInput.value.trim() !== '';
    const priceFilled = priceInput.value.trim() !== '';
    const descText    = descriptionInput.value.trim();
    const descValid   = descText.length >= 200;

    submitBtn.disabled = !(titleFilled && priceFilled && descValid);
  }

  priceInput.addEventListener('beforeinput', e => {
    if (e.inputType === 'insertText' && /[^0-9.]/.test(e.data)) {
      e.preventDefault();
    }
  });

  priceInput.addEventListener('input', () => {
    const v = priceInput.value;
    if (/^\d*(\.\d{0,2})?$/.test(v)) {
      prevPrice = v;
    } else {
      priceInput.value = prevPrice;
    }
    validateForm();
  });

  titleInput.addEventListener('input', validateForm);
  descriptionInput.addEventListener('input', validateForm);

  validateForm();
});
