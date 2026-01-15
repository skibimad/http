alert('fsx');
FSXA = {
    confirmDialog : function(message) {
        let confirmDialogTemplate = document.getElementById('fsx_confirm_dialog');

        let tempDiv = document.createElement('div');
        tempDiv.innerHTML = confirmDialogTemplate;
        document.body.appendChild(tempDiv.firstElementChild);

        return new Promise((resolve) => {
            const dialog = document.querySelector('.fsxa-confirm-dialog-overlay');
            const confirmButton = dialog.querySelector('.fsxa-confirm-dialog-confirm');
            const cancelButton = dialog.querySelector('.fsxa-confirm-dialog-cancel');

            confirmButton.addEventListener('click', () => {
                document.body.removeChild(dialog);
                resolve(true);
            });

            cancelButton.addEventListener('click', () => {
                document.body.removeChild(dialog);
                resolve(false);
            });
        });
    }
};