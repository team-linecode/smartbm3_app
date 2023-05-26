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

            $("#displayName").html(res.user.name);
            res.user.nisn != null
                ? $("#displayNis").html(res.user.nisn)
                : $("#displayNis").html("___");
            $("#displayClass").html(res.user.classroom.alias);
            $("#displayExpertise").html(res.user.expertise.alias);
            $("#displaySchoolyear").html(res.user.schoolyear.name);
            $("#btnNext").removeClass("disabled");

            $("#selectCost").html(res.costs)
        },
    });
}

function getCostDetail(obj, url, data) {
    let costDetail = obj.parent().parent().next().find('.selectCostDetail');
    let date = obj.parent().parent().next().next().find('.amount');
    let amount = obj.parent().parent().next().next().next().find('.amount');

    $.ajax({
        url: url,
        data: data,
        type: "POST",
        dataType: "json",
        beforeSend: () => {
            showLoading();
            costDetail.html('');
            amount.val('');
        },
        success: (res) => {
            stopLoading();

            costDetail.removeAttr("disabled");

            if (res.cost_category == "gedung" || res.cost_category == "ujian") {
                date.attr("disabled", "disabled").val('');
            }

            if (res.cost_category == "lain-lain" || res.cost_category == "gedung") {
                costDetail.attr("disabled", "disabled");
                amount.removeAttr("disabled");
            } else {
                costDetail.html(res.el);
            }
        },
    });
}

function getCostAmount(obj, url, data) {
    let sibling = obj.parent().parent().next().next().find('.amount')

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

            sibling.removeAttr("disabled");
            sibling.val(res.amount);
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
