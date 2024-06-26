document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('input[type="password"][data-mask]').forEach(input => {
      const mask = input.dataset.mask;
      const maskedInput = document.createElement('input');
      maskedInput.type = 'text';

      const inputStyles = window.getComputedStyle(input);
      for (let i = 0; i < inputStyles.length; i++) {
        const styleName = inputStyles[i];
        maskedInput.style[styleName] = inputStyles[styleName];
      }

      maskedInput.setAttribute('readonly', '');
      maskedInput.style.pointerEvents = 'none';
      maskedInput.style.top = 0;
      maskedInput.style.left = 0;
      maskedInput.style.width = '100%';
      maskedInput.style.height = '100%';

      input.style.position = 'absolute';
      input.style.opacity = 0;

      input.parentNode.insertBefore(maskedInput, input.nextSibling);

      input.addEventListener('input', () => {
        maskedInput.value = input.value.replace(/./g, mask);
      });

      input.dispatchEvent(new Event('input'));
    });
});