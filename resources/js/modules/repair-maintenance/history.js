$(document).ready(function () {
  const historiesDatatable = $('#historiesDatatable').DataTable();

  // ============ View History Request ============ //
  historiesDatatable.on('click', '.btnViewHistory', function () {
    const historyId = $(this).closest('tr').find('td[data-history-id]').data('history-id');

    console.log(historyId);
    $.ajax({
      url: '/repair-maintenance/maintenance-history/view',
      method: 'GET',
      data: { id: historyId },
      success: function (response) {
        $('#modalViewHistory').modal('toggle');

        const historyConfig = {
          textFields: [
            { key: 'num', selector: '#lblViewNum' },
            { key: 'ticket', selector: '#lblViewTicket' },
            { key: 'description', selector: '#lblViewDescription' },
            { key: 'cost', selector: '#lblViewCost' },
            { key: 'remarks', selector: '#lblViewRemarks' },
            { key: 'created_by', selector: '#lblViewCreatedBy' },
            { key: 'updated_by', selector: '#lblViewUpdatedBy' },
            { key: 'created_at', selector: '#lblViewCreatedAt' },
            { key: 'updated_at', selector: '#lblViewUpdatedAt' },
          ],

          dropdownFields: [
            {
              key: 'items',
              container: '#dropdownMenuViewItems',
              countSelector: '#lblViewItems',
              label: 'items in this ticket',
            },
          ],

          progressFields: { key: 'progress', selector: '#lblViewProgress' },

          imageFields: [
            { key: 'image', selector: '#imgViewUser' },
            { key: 'created_img', selector: '#imgViewCreatedBy' },
            { key: 'updated_img', selector: '#imgViewUpdatedBy' },
          ],
        };

        displayViewResponseData(response, historyConfig);
      },
      error: function (response) {
        showResponseAlert(response, 'error');
      },
    });
  });
  // ============ End View Ticket Request ============ //
});
