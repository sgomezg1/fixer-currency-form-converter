$(document).ready(function() {
    function doConversion() {
        $.ajax({
            url: `/wp-json/c/get?to=${$("#to").val()}&amount=${$("#amount").val()}&operation=${$("input[name='operation']:checked").val()}`,
            type: "GET",
            dataType: "json",
            success: function(response) {
                const resp = JSON.parse(response);
                $(".currency-result").empty();
                $(".currency-result").append(resp.conversion);

                $(".conversion-rate-value-one").empty();
                $(".conversion-rate-value-two").empty();
                if ($("input[name='operation']:checked").val() === "buying") {
                    $(".conversion-rate-value-one").append("X " + resp.rate);
                } else {
                    $(".conversion-rate-value-two").append("X " + resp.rate);
                }

                $("#currency-conversion-result").val(resp.conversion);
            },
            error: function(error) {
                console.log(error);
            },
        });
    }

    doConversion();

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

    $(".operation").change(function(e) {
        if (e.target.value === "selling") {
            $(".phrase-selling-buying").empty();
            $(".phrase-selling-buying").append("Buy Travel Money");
            $(".currency-selected").empty();
            $(".currency-selected").append("GBP");
            $(".currency-code-text").empty();
            $(".currency-code-text").append("EUR");
        } else {
            $(".phrase-selling-buying").empty();
            $(".phrase-selling-buying").append("Buy Back Currency");
            $(".currency-code-text").empty();
            $(".currency-code-text").append("GBP");
            $(".currency-selected").empty();
            $(".currency-selected").append("EUR");
        }
        $("#amount").val("1000");
        $(".currency-result").empty();
        $("#to").val("EUR");
        doConversion();
    });

    $("#to").change(function(e) {
        if ($("input[name='operation']:checked").val() === "selling") {
            $(".currency-code-text").empty();
            $(".currency-code-text").append(e.target.value);
        } else {
            $(".currency-selected").empty();
            $(".currency-selected").append(e.target.value);
        }
        doConversion()
    });

    $("#amount").keyup(
        $.debounce(1000, function(e) {
            if ($("#to").val() !== "") {
                doConversion();
            }
        })
    );

    $(".start-order").click(function() {
        $("#client-data-form").removeClass("hide-show-form");
        $("#client-data-form").addClass(".show-form");
    });

    $(".submit-order").click(function() {
        $("#currency-converter").validate();
        if ($("#currency-converter").valid()) {
            if ($("#order-type").val() !== "") {
                const formData = new FormData($("#currency-converter")[0]);
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
            } else {
                alert("You must select a delivery method to continue.");
            }
        } else {
            alert("You must fill all the fields of this form to start order.");
        }
    });
});