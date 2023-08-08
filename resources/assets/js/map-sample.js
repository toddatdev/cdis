$("#addNaics").click(function (e) {
    e.preventDefault();
    naics = $(".naics:first").clone().appendTo("#naicsCodes");
    naics.children(".naicsCode").val("");
});
$("#addCoapplicant").click(function (e) {
    e.preventDefault();
    if ($(".coapplicant").is(":hidden")) {
        $(".coapplicant").show();
    } else {
        $(".coapplicant").clone().appendTo("#coapplicants").children("input").val("");
    }
});
$(".removecoapplicant").click(function (e) {
    e.preventDefault();
    $(this).parents(".coapplicant").not(":first").remove();
    if ($(".coapplicant").length == 1) {
        $(".coapplicant").hide();
    }
});
$(".addfee").click(function (e) {
    e.preventDefault();
    $("#feeform").show();
});
$(".addreview").click(function (e) {
    e.preventDefault();
    $("#reviewform").show();
})
$(".datepicker").daterangepicker({
    singleDatePicker: true,
    showDropdowns: true,
    autoApply: true,
    autoUpdateInput: false
});
$('.datepicker').on('apply.daterangepicker', function (ev, picker) {
    $(this).val(picker.startDate.format('MM/DD/YYYY'));
    id = $(this).attr("id") + "_formatted";
    $("#" + id).val(picker.startDate.format('YYYY-MM-DD'))
});
$("#final_inspection").data('daterangepicker').setStartDate("");
$("#final_inspection").val("");
$("#permit_received").data('daterangepicker').setStartDate("");
$("#permit_received").val("");
$("#permit_complete").data('daterangepicker').setStartDate("");
$("#permit_complete").val("");
$("#permit_issued").data('daterangepicker').setStartDate("");
$("#permit_issued").val("");
$("#permit_expiration_date").data('daterangepicker').setStartDate("");
$("#permit_expiration_date").val("");
$("#permit_received_formatted").val("");
$("#final_inspection_formatted").val("");
$("#permit_complete_formatted").val("(");
$("#permit_issued_formatted").val("(");
$("#permit_expiration_date_formatted").val("");

$(".generatemap").on("click", function (e) {
    e.preventDefault();
    $("#nomap").hide();
    latdeg = new Number($("#lat_degrees").val());
    lngdeg = new Number($("#lng_degrees").val());
    if (isNaN(latdeg) || isNaN(lngdeg)) {
        $("#nomap").show();
        return false;
    }
    latmin = new Number($("#lat_minutes").val());
    lngmin = new Number($("#lng_minutes").val());
    if (isNaN(latmin) || isNaN(lngmin)) {
        $("#nomap").show();
        return false;
    }
    latsec = new Number($("#lat_seconds").val());
    lngsec = new Number($("#lng_seconds").val());
    if (isNaN(latsec) || isNaN(lngsec)) {
        $("#nomap").show();
        return false;
    }
    coordinates = new Object();
    coordinates.latdeg = latdeg;
    coordinates.latmin = latmin;
    coordinates.latsec = latsec;
    coordinates.lngdeg = lngdeg;
    coordinates.lngmin = lngmin;
    coordinates.lngsec = lngsec;
    coordinates._token = "m8J1QI2VHpJFAg3EmM4RBkUNUmcrQKOtCqWyY7Xk"
    $.post("/coordinates", coordinates, function (data) {
        iframe = "<iframe width='1078' height='400' frameborder='0'";
        iframe += " src='https://www.google.com/maps/embed/v1/view?key=";
        iframe += "AIzaSyAg0Mz9gHy_14P5nhUO-1gIWa5CUC5aORA&zoom=18";
        iframe += "&center=" + data.latitude + "," + data.longitude + "' ";
        iframe += "allowfullscreen></iframe>";
        $("#map").html(iframe).show();
    });
});
$(".scroll").click(function () {
    var area = $(this).data("area");
    $([document.documentElement, document.body]).animate({
        scrollTop: $("#" + area).offset().top
    }, 2000);
});
CKEDITOR.replace('memo');
CKEDITOR.instances.memo.setData();
$("#feeform").submit(function (e) {
    e.preventDefault();
    data = new Object();
    data.admin = $("#fee_admin").val();
    data.nr = $("#new").is(":checked") ? "N" : $("#resubmit").is(":checked") ? "R" : "";
    data.review_number = $("#review_number").val();
    data.disturbed_acres = $("#rev_disturbed_acres").val();
    data.total_acres = $("#rev_total_acres").val();
    data.fee_type = $("#fee_type").val();
    data.fee_amount = $("#fee_amount").val();
    data.check_number = $("#check_number").val();
    data.payor_name = $("#payor_name").val();
    data.check_date = $("#check_date_formatted").val();
    data.project_id = $("#project_id").val();
    data._token = "m8J1QI2VHpJFAg3EmM4RBkUNUmcrQKOtCqWyY7Xk";
    $.post("http://conservationdistrict.us/fees/add", data, function (resp) {
        if (resp.success == 1) {

            $("#feesuccess, #feetable").show();
            $("#feetable").append('<tr id="fee_' + resp.data.fee_id + '"><td>' + resp.data.admin == "1" ? "Y" : "N" + '</td>\n' +
            '                                            <td>' + resp.data.admin_rev_date + '</td>\n' +
            '                                            <td>' + resp.data.admin_status + '</td>\n' +
            '                                            <td>' + resp.data.admin_initials + '</td>\n' +
            '                                            <td>' + resp.data.reviewed == "" ? "" : moment(resp.data.reviewed).format("MM/DD/YYYY") + '</td>\n' +
                '                                            <td>' + resp.data.tech_status + '</td>\n' +
                '                                            <td>' + resp.data.return_reason + '</td>\n' +
                '                                            <td>' + resp.data.date_wd + '</td>\n' +
                '                                        </tr>');
        }
    });
});

$("#reviewform").submit(function (e) {
    e.preventDefault();
    data = new Object();
    data.received = $("#review_received_formatted").val();
    data.admin = $("#review_admin").is(":checked") ? 1 : 0;
    data.admin_review_date = $("#review_admin_date_formatted").val();
    data.admin_status = $("#admin_status").val();
    data.admin_initials = $("#admin_initials").val();
    data.reviewed_date = $("#reviewed_date_formatted").val();
    data.tech_status = $("#tech_status").val();
    data.tech_init = $("#tech_initials").val();
    data.return_reason = $("#return_reason").val();
    data.date_wd = $("#date_wd_formatted").val();
    data.project_id = $("#project_id").val();
    data._token = "m8J1QI2VHpJFAg3EmM4RBkUNUmcrQKOtCqWyY7Xk";
    $.post("http://conservationdistrict.us/reviews/add", data, function (resp) {
        if (resp.success == 1) {
            $("#reviewsuccess, #reviewtable").show();
            $("#reviewtable").append('<tr id="review_' + resp.data.review_id + '">\n' +
            '                                            <td>' + resp.data.admin == 1 ? "Y" : "N" + '</td>\n' +
            '                                            <td>' + resp.data.admin_rev_date == "" ? "" : moment(resp.data.admin_rev_date).format("MM/DD/YYYY") + '</td>\n' +
            '                                            <td>' + resp.data.admin_status + '</td>\n' +
            '                                            <td>' + resp.data.admin_initials + '</td>\n' +
            '                                            <td>' + resp.data.reviewed == "" ? "" : moment(resp.data.reviewed).format("MM/DD/YYYY") + '</td>\n' +
            '                                            <td>' + resp.data.tech_initials + '</td>\n' +

            '                                            <td>' + resp.data.tech_status + '</td>\n' +
            '                                            <td>' + resp.data.return_reason + '</td>\n' +
            '                                            <td>' + resp.data.date_wd == "" ? "" : moment(resp.data.date_wd).format("MM/DD/YYYY") + '</td>\n' +
                '                                        </tr>');
        }
    });
});
$("#letter").change(function (e) {
    e.preventDefault();
    $(".letterForm, #lettertech, #letter_technician").hide();
    value = $(this).val();
    $("#" + value + "_form").show();
    if (value == "" || value == "es_permit_recommendation_for_permit_action" || value == "es_permit_technical_deficiency" || value == "npdes_permit") {
        $("#lettertech, #letter_technician").hide();
    } else {
        $("#lettertech, #letter_technician").css("display", "block");
    }
});
