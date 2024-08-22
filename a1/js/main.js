function navigate() {
    const menu = document.getElementById('menu');
    const selectedValue = menu.value;
    if (selectedValue) {
        window.location.href = selectedValue;
    }
}
