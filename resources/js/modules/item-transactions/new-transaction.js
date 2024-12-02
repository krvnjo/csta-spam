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

    // ============ View a Item Transaction ============ //
    newTransactionDatatable.on('click', '.btnViewItem', function () {
        const transactionId = $(this).closest('tr').find('td[data-transaction-id]').data('transaction-id');

        $.ajax({
            url: '/item-transactions/new-transaction/view',
            method: 'GET',
            data: { id: transactionId },
            success: function (response) {
                $('#modalViewItemTransaction').modal('toggle');

                $('#lblViewTransaction').text(response.transaction);
                $('#lblViewRequester').text(response.requester);
                $('#lblViewReceived').text(response.received);
                $('#lblViewRemarks').text(response.remarks);
                let itemsHtml = response.items
                    .map(item => `${item.name} (Qty: ${item.quantity})`)
                    .join('<br>');
                $('#lblViewItems').html(itemsHtml);
                $('#lblViewDateCreated').text(response.dateCreated);


            },
            error: function (response) {
                showResponseAlert(response, 'error');
            },
        });
    });
    // ============ End View a Item Transaction ============ //
});
