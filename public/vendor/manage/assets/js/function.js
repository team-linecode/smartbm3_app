function getDetailUser(url, data) {
    $.ajax({
        url: url,
        data: data,
        type: "POST",
        dataType: "json",
        beforeSend: () => {
            $("#btnNext").addClass("disabled");
            showLoading();
        },
        success: (res) => {
            stopLoading();

            $("#displayName").html(res.name);
            res.nisn != null
                ? $("#displayNis").html(res.nisn)
                : $("#displayNis").html("___");
            $("#displayClass").html(res.classroom.alias);
            $("#displayExpertise").html(res.expertise.alias);
            $("#displaySchoolyear").html(res.schoolyear.name);
            $("#btnNext").removeClass("disabled");
        },
    });
}

function getCostDetail(url, data) {
    $.ajax({
        url: url,
        data: data,
        type: "POST",
        dataType: "json",
        beforeSend: () => {
            showLoading();
            $('#selectCostDetail').html('');
            $("#amount").val('');
        },
        success: (res) => {
            stopLoading();

            $("#selectCostDetail").removeAttr("disabled");

            if (res.cost_category == "gedung" || res.cost_category == "ujian") {
                $("input[name=date]").attr("disabled", "disabled").val('');
            }

            if (res.cost_category == "lain-lain" || res.cost_category == "gedung") {
                $('#selectCostDetail').attr("disabled", "disabled");
                $('#amount').removeAttr("disabled");
            } else {
                $("#selectCostDetail").html(res.el);
            }
        },
    });
}

function getCostAmount(url, data) {
    $.ajax({
        url: url,
        data: data,
        type: "POST",
        dataType: "json",
        beforeSend: () => {
            showLoading();
        },
        success: (res) => {
            stopLoading();

            $("#amount").removeAttr("disabled");
            $("#amount").val(res.amount);
        },
    });
}

function getAccountNumber(url, data) {
    $.ajax({
        url: url,
        data: data,
        type: "POST",
        dataType: "json",
        beforeSend: () => {
            showLoading();
        },
        success: (res) => {
            stopLoading();

            $("#cardNumber").val(res.account_number);
        },
    });
}
