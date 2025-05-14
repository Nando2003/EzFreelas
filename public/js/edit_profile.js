document.addEventListener('DOMContentLoaded', () => {
    const deleteBtn = document.getElementById('delete_btn');
    const editBtn = document.getElementById('edit_btn');
    const cancelBtn = document.getElementById('cancel_btn');
    const nameInput = document.getElementById('id_name');
    const usernameInput = document.getElementById('id_username');
    const emailInput = document.getElementById('id_email');
    const buttonGroup = document.getElementById('button-group');
    const editActions = document.getElementById('edit-actions');

    const initialValues = {
        name: nameInput.value,
        username: usernameInput.value,
        email: emailInput.value
    };

    deleteBtn.addEventListener('click', (event) => {
        const confirmAlert = confirm("Tem certeza que deseja deletar sua conta?");
        
        if (!confirmAlert) {
            event.preventDefault();
        }
    });

    editBtn.addEventListener('click', () => {
        nameInput.disabled = false;
        usernameInput.disabled = false;
        emailInput.disabled = false;

        buttonGroup.classList.add('d-none');
        editActions.classList.remove('d-none');
    });

    cancelBtn.addEventListener('click', () => {
        nameInput.value = initialValues.name;
        usernameInput.value = initialValues.username;
        emailInput.value = initialValues.email;

        nameInput.disabled = true;
        usernameInput.disabled = true;
        emailInput.disabled = true;

        editActions.classList.add('d-none');
        buttonGroup.classList.remove('d-none');
    });
});
