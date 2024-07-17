document.addEventListener('DOMContentLoaded', function () {
    const checkboxes = document.querySelectorAll('input[type="checkbox"]');
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function () {
            const quantityInput = querySelectorAll('input[type="number"]');
            if (this.checked) {
                quantityInput.disabled = false;
            } else {
                quantityInput.disabled = true;
                // quantityInput.value = 1;
            }
        });
    });
});