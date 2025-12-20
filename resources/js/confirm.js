import Swal from 'sweetalert2';

/**
 * Reusable delete confirmation
 *
 * @param {Object} options
 * @param {string} options.url        - delete endpoint
 * @param {string} options.formId     - hidden form id
 * @param {string} options.title      - modal title
 * @param {string} options.text       - modal text
 * @param {string} options.confirmText
 */
function confirmDelete({
    url,
    formId,
    title = 'Are you sure?',
    text = 'This action cannot be undone.',
    confirmText = 'Accept'
}) {
    Swal.fire({
        title,
        text,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: confirmText
    }).then((result) => {
        if (!result.isConfirmed) return;

        const form = document.getElementById(formId);

        if (!form) {
            console.error(`Form with id "${formId}" not found`);
            return;
        }

        form.action = url;
        form.submit();
    });
}


window.confirmDelete = confirmDelete;
