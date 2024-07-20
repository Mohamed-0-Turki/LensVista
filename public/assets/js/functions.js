const breakpoints = ['sm', 'md', 'lg', 'xl', '2xl'];

function showPassword(buttons, inputs) {
    buttons.forEach(btnEye => {
        btnEye.addEventListener("click", () => {
            let index = buttons.indexOf(btnEye);
            if (inputs[index].type === "password") {
                inputs[index].type = "text";
            }
            else{
                inputs[index].type = "password";
            }
        });
    });
}

function toggleMenuOnClick(btn, menu) {

    btn.addEventListener("click", () => {
        breakpoints.forEach(breakpoint => {
            const maxClass = `max-${breakpoint}:hidden`;
            const regularClass = `${breakpoint}:hidden`;

            if (menu.classList.contains(maxClass) || menu.classList.contains(regularClass)) {
                menu.classList.remove(maxClass, regularClass);
            }
            else {
                menu.classList.toggle("hidden");
            }
        });
    });
}

function closeMenuOnClickOutside(btn, menu) {
    document.addEventListener('click', function(event) {
        if (!menu.contains(event.target) && !btn.contains(event.target)) {
            menu.classList.add('hidden');
        }
    });
}

function setImageOnClick(parentImage, images) {
    images.forEach(image => {
        image.addEventListener("click", () => {
        parentImage.src = image.src
        })
    });
}
function cycleImages(parentImage, images) {
    imageIndex = 0
    setInterval(() => {
        parentImage.src = images[imageIndex].src
        imageIndex++
        if (imageIndex == images.length) {
        imageIndex = 0;
        }
    }, 5000);
}

function initializeQuantityControls(minusBtn, plusBtn, quantityInput, quantityText) {
    function validateInput() {
        const value = quantityInput.value;
        const nonNumeric = /\D/.test(value);
        if (value <= 0 || nonNumeric) {
        quantityInput.value = 1;
        quantityText.innerHTML = quantityInput.value;
        } else {
        quantityText.innerHTML = quantityInput.value;
        }
    }
    quantityInput.addEventListener("input", validateInput);
    plusBtn.addEventListener("click", () => {
        quantityInput.value = +quantityInput.value + 1;
        validateInput();
    });
    minusBtn.addEventListener("click", () => {
        quantityInput.value = +quantityInput.value - 1;
        validateInput();
    });
}


function changeImageSrc(inputFile, image) {
    inputFile.addEventListener("change", () => {
        image.src = URL.createObjectURL(inputFile.files[0])
    })
}