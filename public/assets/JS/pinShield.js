document.addEventListener("DOMContentLoaded", () => {
    const pinInput = document.querySelector('input[name="secure_pin"]');
    const keys = document.querySelectorAll('.pin_key');
    keys.forEach(key => {
        key.addEventListener('click', () => {
            if (pinInput.value.length < 8) {
                pinInput.value += key.value;
            }
        });
    });
});