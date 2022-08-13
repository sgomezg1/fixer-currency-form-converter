$(document).ready(function() {
    $(".select-home").click(function(e) {
        $(this).addClass("active-deliver");
        $(".select-delivery").removeClass("active-deliver");
        $("#order-type").val("home");
    });

    $(".select-delivery").click(function(e) {
        $(this).addClass("active-deliver");
        $(".select-home").removeClass("active-deliver");
        $("#order-type").val("collection");
    });

    $("#to").change(function(e) {
        $(".currency-selected").empty();
        $(".currency-selected").append($(this).val());
        $("#amount").val("");
        $(".currency-result").empty();
        $.ajax({
            url: `/wp-json/c/latest?to=${$(this).val()}`,
            type: "GET",
            dataType: "json",
            success: function(response) {
                $(".latest-rate").empty();
                $(".latest-rate").append(
                    parseFloat(response[$("#to").val()]).toFixed(3)
                );
            },
            error: function(error) {
                console.log(error);
            },
        });
    });

    $("#amount").keyup(
        $.debounce(250, function(e) {
            if ($("#to").val() !== "") {
                $.ajax({
                    url: `/wp-json/c/get?to=${$("#to").val()}&amount=${$(this).val()}`,
                    type: "GET",
                    dataType: "json",
                    success: function(response) {
                        const resp = JSON.parse(response);
                        $(".latest-rate").empty();
                        $(".latest-rate").append(
                            parseFloat(resp.latest[$("#to").val()]).toFixed(3)
                        );
                        $(".currency-result").empty();
                        $(".currency-result").append(resp.conversion);

                        $("#currency-conversion-result").val(resp.conversion);
                    },
                    error: function(error) {
                        console.log(error);
                    },
                });
            }
        })
    );

    $(".currency-submit").click(function() {
        $("#currency-converter").validate();
        if ($("#currency-converter").valid()) {
            if ($("#order-type").val() !== "") {
                $("#currency-converter").submit();
            } else {
                alert("You must select a delivery method for submit your request.");
            }
        } else {
            alert("You must fill all the fields of this form to start order.");
        }
    });

    $("#currency-converter").submit(function(e) {
        e.preventDefault();
        const formData = new FormData($(this)[0]);
        $.ajax({
            url: `/wp-json/c/mail`,
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                const resp = JSON.parse(response);
                if (!resp.success) {
                    alert("Error with email sending, please contact administrator.");
                    return;
                }
                alert(resp.message);
            },
            error: function(error) {
                const resp = JSON.parse(error);
                alert(
                    "We are havin trouble with website. This is the error: " +
                    resp.message
                );
            },
        });
    });
});