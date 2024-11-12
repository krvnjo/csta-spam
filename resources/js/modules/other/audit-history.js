$(document).ready(function () {
  const auditsDatatable = $('#auditsDatatable').DataTable();
  // ============ View a Audit ============ //
  auditsDatatable.on('click', '.btnViewAudit', function () {
    const auditId = $(this).closest('tr').find('td[data-audit-id]').data('audit-id');
    console.log(auditId);

    $.ajax({
      url: '/audit-history/show',
      method: 'GET',
      data: { id: auditId },
      success: function (response) {
        $('#modalViewAudit').modal('toggle');

        const auditConfig = {
          textFields: [
            { key: 'audit', selector: '#lblViewAudit' },
            { key: 'description', selector: '#lblViewDescription' },
            { key: 'properties', selector: '#lblViewProperties' },
            { key: 'created_by', selector: '#lblViewCreatedBy' },
            { key: 'created_at', selector: '#lblViewCreatedAt' },
          ],

          eventFields: { key: 'event', selector: '#lblViewEvent' },

          imageFields: [{ key: 'created_img', selector: '#imgViewCreatedBy' }],
        };

        displayViewResponseData(response, auditConfig);
      },
      error: function (response) {
        showResponseAlert(response, 'error');
      },
    });
  });
  // ============ End View a Audit ============ //
});
