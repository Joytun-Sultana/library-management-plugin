

/**
 * Version details
 *
 * @package    local_library/confirmdelete
 * @copyright  2024  joytun  (joytunsultana09171@gmail.com)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
 

define([
    'jquery',
    'core/ajax',
    'core/str',
    'core/modal_factory',
    'core/modal_events',
    'core/notification'
], function($,
             Ajax,
             str,
             ModalFactory,
             ModalEvents,
             Notification) {
    $('.delete-btn').on('click', function() {  // Class .delete-btn is button class defined in manage.php file.
        let elementId = $(this).attr('id');
        let arr = elementId.split("-");
        let bookId = arr[arr.length - 1];
        
        // eslint-disable-next-line promise/catch-or-return
        ModalFactory.create({
            type: ModalFactory.types.SAVE_CANCEL,
            title: str.get_string('deletetitle', 'local_library', '', ''),
            body: str.get_string('modalmessage', 'local_library', '', '')
            // eslint-disable-next-line promise/always-return
        }).then(function(modal) {
            modal.setSaveButtonText(str.get_string('delete', 'local_library', '', ''));
            let root = modal.getRoot();
            root.on(ModalEvents.save, function() {
                let wsfunction = 'local_library_delete_book';   // Defined in classes/external.php file.
                let params = { 'bookid': parseInt(bookId) };

                let request = {
                    methodname: wsfunction,
                    args: params
                };
                Ajax.call([request])[0].done(function() {
                    window.location.href = $(location).attr('href');
                }).fail(Notification.exception);
            });
            modal.show();
        });
    });
});

