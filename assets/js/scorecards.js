// Init single scorecard
function init_scorecard(id) {
    load_small_table_item(id, '#scorecard', 'scorecardid', 'scorecards/get_scorecard_data_ajax', '.table-scorecards');
}


// Validates scorecard add/edit form
function validate_scorecard_form(selector) {

    selector = typeof (selector) == 'undefined' ? '#scorecard-form' : selector;

    appValidateForm($(selector), {
        clientid: {
            required: {
                depends: function () {
                    var customerRemoved = $('select#clientid').hasClass('customer-removed');
                    return !customerRemoved;
                }
            }
        },
        date: 'required',
        tag: 'required',
        equipment_category: 'required',
        tags: 'required',
        assigned: 'required',
        scorecard_members: 'required',
        number: {
            required: true
        }
    });

    $("body").find('input[name="number"]').rules('add', {
        remote: {
            url: admin_url + "scorecards/validate_scorecard_number",
            type: 'post',
            data: {
                number: function () {
                    return $('input[name="number"]').val();
                },
                isedit: function () {
                    return $('input[name="number"]').data('isedit');
                },
                original_number: function () {
                    return $('input[name="number"]').data('original-number');
                },
                date: function () {
                    return $('body').find('.scorecard input[name="date"]').val();
                },
            }
        },
        messages: {
            remote: app.lang.scorecard_number_exists,
        }
    });

}


// Get the preview main values
function get_scorecard_item_preview_values() {
    var response = {};
    response.description = $('.main textarea[name="description"]').val();
    response.long_description = $('.main textarea[name="long_description"]').val();
    response.qty = $('.main input[name="quantity"]').val();
    return response;
}


// From scorecard table mark as
function scorecard_mark_as(status_id, scorecard_id) {
    var data = {};
    data.status = status_id;
    data.scorecardid = scorecard_id;
    $.post(admin_url + 'scorecards/update_scorecard_status', data).done(function (response) {
        table_scorecards.DataTable().ajax.reload(null, false);
    });
}
