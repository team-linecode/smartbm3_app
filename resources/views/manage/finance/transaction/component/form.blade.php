<script>
    const formGroup = document.getElementById('form-group');
    const btnAdd = document.getElementById('btn-add');

    // Function to add event listeners to new input groups
    function addEventListeners(inputGroup) {
        const btnRemove = inputGroup.querySelector('.btn-remove');
        const btnMoveUp = inputGroup.querySelector('.btn-move-up');
        const btnMoveDown = inputGroup.querySelector('.btn-move-down');

        btnRemove.addEventListener('click', () => {
            if (formGroup.childElementCount > 2) {
                formGroup.removeChild(inputGroup);
            }
        });

        btnMoveUp.addEventListener('click', () => {
            const prevInputGroup = inputGroup.previousElementSibling;
            if (prevInputGroup && prevInputGroup.classList.contains('form-input')) {
                formGroup.insertBefore(inputGroup, prevInputGroup);
            }
        });

        btnMoveDown.addEventListener('click', () => {
            const nextInputGroup = inputGroup.nextElementSibling;
            if (nextInputGroup && nextInputGroup.classList.contains('form-input')) {
                formGroup.insertBefore(nextInputGroup, inputGroup);
            }
        });
    }

    btnAdd.addEventListener('click', () => {
        const lastInputGroup = formGroup.querySelector('.form-input:last-of-type');
        const clonedInputGroup = lastInputGroup.cloneNode(true);
        formGroup.insertBefore(clonedInputGroup, btnAdd);
        addEventListeners(clonedInputGroup);
    });

    formGroup.addEventListener('click', (event) => {
        if (event.target.classList.contains('btn-remove')) {
            const inputGroup = event.target.closest('.form-input');
            if (formGroup.childElementCount > 2) {
                formGroup.removeChild(inputGroup);
            }
        }

        // if (event.target.classList.contains('btn-move-up')) {
        //     const inputGroup = event.target.closest('.form-input');
        //     const prevInputGroup = inputGroup.previousElementSibling;
        //     if (prevInputGroup && prevInputGroup.classList.contains('form-input')) {
        //         formGroup.insertBefore(inputGroup, prevInputGroup);
        //     }
        // }

        // if (event.target.classList.contains('btn-move-down')) {
        //     const inputGroup = event.target.closest('.form-input');
        //     const nextInputGroup = inputGroup.nextElementSibling;
        //     if (nextInputGroup && nextInputGroup.classList.contains('form-input')) {
        //         formGroup.insertBefore(nextInputGroup, inputGroup);
        //     }
        // }
    });

    // Add event listeners to initial input groups
    const initialInputGroups = document.querySelectorAll('.form-input');
    initialInputGroups.forEach((inputGroup) => {
        addEventListeners(inputGroup);
    });
</script>
