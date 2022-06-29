$(function() {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        }
    });
    // $(".alert").alert();
    // window.setTimeout(function() {
    //     $(".alert").alert("close");
    // }, 9e3);
    // initSelect2(['#month', '#year', '#class_id', '#section_id']);
    $('.select-2').select2();
    $('#dataTable').dataTable();

    $(document).on('click', '._delete', function(e) {
        e.preventDefault();
        let url = $(this).data('route');
        let title = $(this).data('title');
        $('#_delete').modal('show');
        $('#_deleteTitle').html(title);
        $('#_deleteForm').attr('action', url);
    });
    $(document).on('click', '#checkAll', function() {
        const chk = $('.check');
        if ($(this).is(':checked')) {
            chk.prop('checked', true);
        } else {
            chk.prop('checked', false);
        }
    });
    $(".hasChildOptions").on('change', function() {
        if ($(this).prop("checked") == true) {
            if ($(this).data('show_child')) {
                if ($(this).data('show_child') == 1) {
                    $('#' + $(this).data('child_id')).show();
                } else {
                    $('#' + $(this).data('child_id')).hide();
                }
            } else $('#' + $(this).data('child_id')).show();
        } else {
            $('#' + $(this).data('child_id')).find('input').prop('checked', false);
            $('#' + $(this).data('child_id')).hide();
        }
    });
});
// Checkbox checked
function checkcheckbox() {
    // Total checkboxes
    var length = $('.check').length;
    // Total checked checkboxes
    var totalchecked = 0;
    $('.check').each(function() {
        if ($(this).is(':checked')) {
            totalchecked += 1;
        }
    });

    // Checked unchecked checkbox
    if (totalchecked == length) {
        $("#checkAll").prop('checked', true);
    } else {
        $('#checkAll').prop('checked', false);
    }
}

function changeStatus(arg) {
    let status = $(arg);
    swal({
            title: "Are you sure?",
            text: "This change will affect all records!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    url: status.data('route'),
                    type: 'post',
                    data: {
                        status: status.data('value'),
                    },
                    success: res => {
                        swal({
                            icon: 'success',
                            title: 'Success',
                            text: res.message
                        });
                        $('.table').DataTable().ajax.reload();
                    },
                    error: err => {
                        swal({
                            icon: 'error',
                            title: 'Oops...',
                            text: err.responseJSON.message
                        });
                    }
                });
            }
        });
}


function ajaxDelete(arg, type) {
    let args = $(arg);
    swal({
            title: "Are you sure?",
            text: "This action will delete this record and cannot be undone!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    url: args.data('route'),
                    type: 'delete',
                    data: {
                        id: args.data('value'),
                    },
                    success: res => {
                        swal({
                            icon: 'success',
                            title: 'Success',
                            text: res.message
                        }).then((confirm) => {
                            if (confirm) {
                                if (type == 'dt') {
                                    $('.table').DataTable().ajax.reload();
                                } else {
                                    window.location.reload();
                                }
                            }
                        });
                    },
                    error: err => {
                        swal({
                            icon: 'error',
                            title: 'Oops...',
                            text: err.responseJSON.message
                        });
                    }
                });
            }
        });
}

function ajaxAllDelete(arg, type) {
    let args = $(arg);
    var del_ids = [];
    // Read all checked checkboxes
    $("input:checkbox[class=check]:checked").each(function() {
        del_ids.push($(this).val());
    });
    // Check checkbox checked or not
    if (del_ids.length > 0) {
        swal({
                title: "Are you sure?",
                text: "This action will delete all records and cannot be undone!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        url: args.data('route'),
                        type: 'delete',
                        data: {
                            ids: del_ids,
                        },
                        success: res => {
                            swal({
                                icon: 'success',
                                title: 'Success',
                                text: res.message
                            }).then((confirm) => {
                                if (confirm) {
                                    if (type == 'dt') {
                                        $('.table').DataTable().ajax.reload();
                                    } else {
                                        window.location.reload();
                                    }
                                }
                            });
                        },
                        error: err => {
                            swal({
                                icon: 'error',
                                title: 'Oops...',
                                text: err.responseJSON.message
                            });
                        }
                    });
                }
            });
    }
}


function ajaxEdit(arg, type) {
    let args = $(arg);
    $.ajax({
        url: args.data('route'),
        type: 'get',
        data: {
            id: args.data('value'),
        },
        success: res => {
            $("#ajax_modal_container").html(res.modal);
            $("#editModal").modal('show');
        },
        error: err => {
            swal({
                icon: 'error',
                title: 'Oops...',
                text: err.responseJSON.message
            });
        }
    });
};

function ajaxStore(e, form, method, modal) {
    e.preventDefault();
    $.ajax({
        url: $(form).attr('action'),
        type: method,
        data: new FormData(form),
        processData: false,
        contentType: false,
        success: res => {
            swal({
                icon: 'success',
                title: 'Success',
                text: res.message
            }).then((confirm) => {
                if (confirm) {
                    $('.table').DataTable().ajax.reload();
                    $("#" + modal).modal('hide');
                    $(form).trigger("reset");
                }
            });
        },
        error: err => {
            swal({
                icon: 'error',
                title: 'Oops...',
                text: err.responseJSON.message
            });
        }
    });
}

// function ajaxStore(e, form, method, modal) {
//     e.preventDefault();
//     $.ajax({
//         url: $(form).attr('action'),
//         type: method,
//         data: $(form).serialize(),
//         success: res => {
//             swal({
//                 icon: 'success',
//                 title: 'Success',
//                 text: res.message
//             }).then((confirm) => {
//                 if (confirm) {
//                     $('.table').DataTable().ajax.reload();
//                     $("#" + modal).modal('hide');
//                     $(form).trigger("reset");
//                 }
//             });
//         },
//         error: err => {
//             swal({
//                 icon: 'error',
//                 title: 'Oops...',
//                 text: err.responseJSON.message
//             });
//         }
//     });
// }

function select2Ajax(id, placeholder, route, dropdown = 'body') {
    $('#' + id).select2({
        placeholder: placeholder,
        minimumInputLength: 2,
        dropdownParent: $(dropdown),
        ajax: {
            url: route,
            dataType: 'json',
            delay: 250,
            cache: true,
            data: function(params) {
                return {
                    q: $.trim(params.term)
                };
            },
            processResults: function(data) {
                return {
                    results: data
                };
            }
        }
    });
}
