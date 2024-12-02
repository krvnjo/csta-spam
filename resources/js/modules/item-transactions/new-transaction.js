$(document).ready(function () {
    const newTransactionDatatable = $('#newTransactionDatatable').DataTable();

    // ============ Create a Transaction ============ //
    const transactionAddModal = $('#modalAddNewTransaction');
    const transactionAddForm = $('#frmAddNewTransaction');
    const transactionAddSaveBtn = $('#btnAddSaveNewTransaction');

    handleUnsavedChanges(transactionAddModal, transactionAddForm, transactionAddSaveBtn);

    transactionAddForm.on('submit', function (e) {
        e.preventDefault();
        toggleButtonState(transactionAddSaveBtn, true);

        const addFormData = new FormData(transactionAddForm[0]);

        $.ajax({
            url: '/item-transactions/new-transaction',
            method: 'POST',
            data: addFormData,
            processData: false,
            contentType: false,
            success: function (response) {
                if (response.success) {
                    toggleButtonState(transactionAddSaveBtn, false);
                    showResponseAlert(response, 'success', transactionAddModal, transactionAddForm);
                } else {
                    handleValidationErrors(response, 'Add');
                    toggleButtonState(transactionAddSaveBtn, false);
                }
            },
            error: function (response) {
                showResponseAlert(response, 'error', transactionAddModal, transactionAddForm);
            },
        });
    });

    // ============ End Create a Transaction ============ //
});
