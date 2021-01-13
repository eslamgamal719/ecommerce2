function check_all() {

    $('input[class="item_checkbox"]:checkbox').each(function () {

        if ($('input[class="check_all"]:checkbox:checked').length == 0) {

            $(this).prop('checked', false);

        } else {

            $(this).prop('checked', true);
        }
    });
}


function delete_all() {

    $(document).on('click', '.del_all', function () {
        $('#form_data').submit();
    });

    $(document).on('click', '.delBtn', function () {

        var item_checked = $('input[class="item_checkbox"]:checkbox:checked').length;

        if (item_checked > 0) {

            $('.not_empty_record').removeClass('hidden');
            $('.empty_record').addClass('hidden');
            $('.record_count').text(item_checked);

        } else {

            $('.empty_record').removeClass('hidden');
            $('.not_empty_record').addClass('hidden');

        }
        $(".alert-modal").css('display', 'block');
    });
}


function delete_admin() {

    $(document).on('click', '.custom_delete', function () {

        var admin_id = $(this).attr('data-item-id');

        $('#del_admin' + admin_id).css('display', 'block');
    });
}



function delete_department() {

    $(document).on('click', '.delete-dep', function () {

        $('#delete_bootstrap_Modal').css('display', 'block');

    });
}



function close_window() {

    $(document).on('click', '#close', function () {

        $('.close-window').css('display', 'none');
    });
}





