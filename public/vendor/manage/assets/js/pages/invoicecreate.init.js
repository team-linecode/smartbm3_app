var paymentSign = "$";
function otherPayment() {
    var e = document.getElementById("choices-payment-currency").value;
    (paymentSign = e),
        document
            .getElementsByClassName("product-line-price")
            .forEach(function (e) {
                (isUpdate = e.value.slice(1)),
                    (e.value = paymentSign + isUpdate);
            }),
        recalculateCart();
}

function isData() {
    var e = document.getElementsByClassName("plus"),
        t = document.getElementsByClassName("minus");
    e &&
        e.forEach(function (n) {
            n.onclick = function (e) {
                var t;
                parseInt(n.previousElementSibling.value) < 10 &&
                    (e.target.previousElementSibling.value++,
                    (t =
                        n.parentElement.parentElement.previousElementSibling.querySelector(
                            ".product-price"
                        ).value),
                    (e =
                        n.parentElement.parentElement.nextElementSibling.querySelector(
                            ".product-line-price"
                        )),
                    updateQuantity(
                        n.parentElement.querySelector(".product-quantity")
                            .value,
                        t,
                        e
                    ));
            };
        }),
        t &&
            t.forEach(function (n) {
                n.onclick = function (e) {
                    var t;
                    1 < parseInt(n.nextElementSibling.value) &&
                        (e.target.nextElementSibling.value--,
                        (t =
                            n.parentElement.parentElement.previousElementSibling.querySelector(
                                ".product-price"
                            ).value),
                        (e =
                            n.parentElement.parentElement.nextElementSibling.querySelector(
                                ".product-line-price"
                            )),
                        updateQuantity(
                            n.parentElement.querySelector(".product-quantity")
                                .value,
                            t,
                            e
                        ));
                };
            });
}
flatpickr("#date-field", { enableTime: !0, dateFormat: "d M, Y, h:i K" }),
    isData();
var count = 1;
function new_link() {
    count++;
    var e = document.createElement("tr");
    (e.id = count), (e.className = "product");
    var t =
        '<tr><th scope="row" class="product-id">' +
        count +
        '</th><td class="text-start"><div class="mb-2"><input class="form-control bg-light border-0" type="text" id="productName-' +
        count +
        '" placeholder="Product Name"></div><textarea class="form-control bg-light border-0" id="productDetails-' +
        count +
        '" rows="2" placeholder="Product Details"></textarea></div></td><td><input class="form-control bg-light border-0 product-price" type="number" id="productRate-' +
        count +
        '" step="0.01" placeholder="$0.00"></td><td><div class="input-step"><button type="button" class="minus">–</button><input type="number" class="product-quantity" id="product-qty-' +
        count +
        '" value="0" readonly><button type="button" class="plus">+</button></div></td><td class="text-end"><div><input type="text" class="form-control bg-light border-0 product-line-price" id="productPrice-' +
        count +
        '" placeholder="$0.00" /></div></td><td class="product-removal"><a class="btn btn-success">Delete</a></td></tr';
    (e.innerHTML = document.getElementById("newForm").innerHTML + t),
        document.getElementById("newlink").appendChild(e);
    var n = document.querySelectorAll("[data-trigger]");
    for (i = 0; i < n.length; ++i) {
        var o = n[i];
        new Choices(o, {
            placeholderValue: "This is a placeholder set in the config",
            searchPlaceholderValue: "This is a search placeholder",
        });
    }
    isData(), remove(), amountKeyup(), resetRow();
}
remove();
var taxRate = 0.125,
    shippingRate = 65,
    discountRate = 0.15;
function remove() {
    document.querySelectorAll(".product-removal a").forEach(function (e) {
        e.addEventListener("click", function (e) {
            removeItem(e), resetRow();
        });
    });
}
function resetRow() {
    document
        .getElementById("newlink")
        .querySelectorAll("tr")
        .forEach(function (e, t) {
            t += 1;
            e.querySelector(".product-id").innerHTML = t;
        });
}
function recalculateCart() {
    var t = 0;
    document.getElementsByClassName("product").forEach(function (e) {
        e.getElementsByClassName("product-line-price").forEach(function (e) {
            e.value && (t += parseFloat(e.value.slice(1)));
        });
    });
    var e = t * taxRate,
        n = t * discountRate,
        o = 0 < t ? shippingRate : 0,
        a = t + e + o - n;
    (document.getElementById("cart-subtotal").value =
        paymentSign + t.toFixed(2)),
        (document.getElementById("cart-tax").value =
            paymentSign + e.toFixed(2)),
        (document.getElementById("cart-shipping").value =
            paymentSign + o.toFixed(2)),
        (document.getElementById("cart-total").value =
            paymentSign + a.toFixed(2)),
        (document.getElementById("cart-discount").value =
            paymentSign + n.toFixed(2)),
        (document.getElementById("totalamountInput").value =
            paymentSign + a.toFixed(2)),
        (document.getElementById("amountTotalPay").value =
            paymentSign + a.toFixed(2));
}
function amountKeyup() {
    document.getElementsByClassName("product-price").forEach(function (n) {
        n.addEventListener("keyup", function (e) {
            var t =
                n.parentElement.nextElementSibling.nextElementSibling.querySelector(
                    ".product-line-price"
                );
            updateQuantity(
                e.target.value,
                n.parentElement.nextElementSibling.querySelector(
                    ".product-quantity"
                ).value,
                t
            );
        });
    });
}
function updateQuantity(e, t, n) {
    t = (t = e * t).toFixed(2);
    (n.value = paymentSign + t), recalculateCart();
}
function removeItem(e) {
    e.target.closest("tr").remove(), recalculateCart();
}
amountKeyup();
var genericExamples = document.querySelectorAll("[data-trigger]");
for (i = 0; i < genericExamples.length; ++i) {
    var element = genericExamples[i];
    new Choices(element, {
        placeholderValue: "This is a placeholder set in the config",
        searchPlaceholderValue: "This is a search placeholder",
    });
}
function billingFunction() {
    document.getElementById("same").checked
        ? ((document.getElementById("shippingName").value =
              document.getElementById("billingName").value),
          (document.getElementById("shippingAddress").value =
              document.getElementById("billingAddress").value),
          (document.getElementById("shippingPhoneno").value =
              document.getElementById("billingPhoneno").value),
          (document.getElementById("shippingTaxno").value =
              document.getElementById("billingTaxno").value))
        : ((document.getElementById("shippingName").value = ""),
          (document.getElementById("shippingAddress").value = ""),
          (document.getElementById("shippingPhoneno").value = ""),
          (document.getElementById("shippingTaxno").value = ""));
}
var cleaveBlocks = new Cleave("#cardNumber", {
        blocks: [4, 4, 4, 4],
        uppercase: !0,
    }),
    genericExamples = document.querySelectorAll('[data-plugin="cleave-phone"]');
for (i = 0; i < genericExamples.length; ++i) {
    element = genericExamples[i];
    new Cleave(element, { delimiters: ["(", ")", "-"], blocks: [0, 3, 3, 4] });
}
document.addEventListener("DOMContentLoaded", function () {
    var P = document.getElementById("invoice_form");
    document.getElementsByClassName("needs-validation");
    P.addEventListener("submit", function (e) {
        e.preventDefault();
        var t = document.getElementById("invoicenoInput").value.slice(4),
            n = document.getElementById("companyEmail").value,
            o = document.getElementById("date-field").value,
            a = document.getElementById("totalamountInput").value.slice(1),
            l = document.getElementById("choices-payment-status").value,
            i = document.getElementById("billingName").value,
            c = document.getElementById("billingAddress").value,
            d = document
                .getElementById("billingPhoneno")
                .value.replace(/[^0-9]/g, ""),
            u = document.getElementById("billingTaxno").value,
            r = document.getElementById("shippingName").value,
            m = document.getElementById("shippingAddress").value,
            s = document
                .getElementById("shippingPhoneno")
                .value.replace(/[^0-9]/g, ""),
            p = document.getElementById("shippingTaxno").value,
            v = document.getElementById("choices-payment-type").value,
            g = document.getElementById("cardholderName").value,
            y = document
                .getElementById("cardNumber")
                .value.replace(/[^0-9]/g, ""),
            E = document.getElementById("amountTotalPay").value.slice(1),
            b = document
                .getElementById("registrationNumber")
                .value.replace(/[^0-9]/g, ""),
            I = document.getElementById("companyEmail").value,
            h = document.getElementById("companyWebsite").value,
            _ = document
                .getElementById("compnayContactno")
                .value.replace(/[^0-9]/g, ""),
            B = document.getElementById("companyAddress").value,
            f = document.getElementById("companyaddpostalcode").value,
            x = document.getElementById("cart-subtotal").value.slice(1),
            w = document.getElementById("cart-tax").value.slice(1),
            S = document.getElementById("cart-discount").value.slice(1),
            j = document.getElementById("cart-shipping").value.slice(1),
            q = document.getElementById("cart-total").value.slice(1),
            N = document.getElementById("exampleFormControlTextarea1").value,
            e = document.getElementsByClassName("product"),
            C = 1,
            T = [];
        e.forEach((e) => {
            var t = e.querySelector("#productName-" + C).value,
                n = e.querySelector("#productDetails-" + C).value,
                o = parseInt(e.querySelector("#productRate-" + C).value),
                a = parseInt(e.querySelector("#product-qty-" + C).value),
                e = e.querySelector("#productPrice-" + C).value.split("$"),
                e = {
                    product_name: t,
                    product_details: n,
                    rates: (rates = o),
                    quantity: (quantity = a),
                    amount: (amount = parseInt(e[1])),
                };
            T.push(e), C++;
        }),
            !1 === P.checkValidity()
                ? P.classList.add("was-validated")
                : ("edit-invoice" == options && invoice_no == t
                      ? ((objIndex = invoices.findIndex(
                            (e) => e.invoice_no == t
                        )),
                        (invoices[objIndex].invoice_no = t),
                        (invoices[objIndex].customer = i),
                        (invoices[objIndex].img = ""),
                        (invoices[objIndex].email = n),
                        (invoices[objIndex].date = o),
                        (invoices[objIndex].invoice_amount = a),
                        (invoices[objIndex].status = l),
                        (invoices[objIndex].billing_address = {
                            full_name: i,
                            address: c,
                            phone: d,
                            tax: u,
                        }),
                        (invoices[objIndex].shipping_address = {
                            full_name: r,
                            address: m,
                            phone: s,
                            tax: p,
                        }),
                        (invoices[objIndex].payment_details = {
                            payment_method: v,
                            card_holder_name: g,
                            card_number: y,
                            total_amount: E,
                        }),
                        (invoices[objIndex].company_details = {
                            legal_registration_no: b,
                            email: I,
                            website: h,
                            contact_no: _,
                            address: B,
                            zip_code: f,
                        }),
                        (invoices[objIndex].order_summary = {
                            sub_total: x,
                            estimated_tex: w,
                            discount: S,
                            shipping_charge: j,
                            total_amount: q,
                        }),
                        (invoices[objIndex].prducts = T),
                        (invoices[objIndex].notes = N),
                        localStorage.removeItem("invoices-list"),
                        localStorage.removeItem("option"),
                        localStorage.removeItem("invoice_no"),
                        localStorage.setItem(
                            "invoices-list",
                            JSON.stringify(invoices)
                        ))
                      : localStorage.setItem(
                            "new_data_object",
                            JSON.stringify({
                                invoice_no: t,
                                customer: i,
                                img: "",
                                email: n,
                                date: o,
                                invoice_amount: a,
                                status: l,
                                billing_address: {
                                    full_name: i,
                                    address: c,
                                    phone: d,
                                    tax: u,
                                },
                                shipping_address: {
                                    full_name: r,
                                    address: m,
                                    phone: s,
                                    tax: p,
                                },
                                payment_details: {
                                    payment_method: v,
                                    card_holder_name: g,
                                    card_number: y,
                                    total_amount: E,
                                },
                                company_details: {
                                    legal_registration_no: b,
                                    email: I,
                                    website: h,
                                    contact_no: _,
                                    address: B,
                                    zip_code: f,
                                },
                                order_summary: {
                                    sub_total: x,
                                    estimated_tex: w,
                                    discount: S,
                                    shipping_charge: j,
                                    total_amount: q,
                                },
                                prducts: T,
                                notes: N,
                            })
                        ),
                  (window.location.href = "apps-invoices-list.html"));
    });
});
