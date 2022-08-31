<?php

class loadView
{
    public $defaultCurrency;
    public $dataForConversion;
    public $arrCountries;

    public function __construct()
    {
        header("Content-type", "application/json");
        $this->arrCountries = array(
            [
                "code" => "EUR",
                "country" => "Euro"
            ],
            [
                "code" => "USD",
                "country" => "USA"
            ],
            [
                "code" => "AED",
                "country" => "Dubai"
            ],
            [
                "code" => "TRY",
                "country" => "Turkey"
            ],
            [
                "code" => "HRK",
                "country" => "Croatia"
            ],
            [
                "code" => "HUF",
                "country" => "Hungary"
            ],
            [
                "code" => "CAD",
                "country" => "Canada"
            ],
            [
                "code" => "THB",
                "country" => "Thailand"
            ],
            [
                "code" => "PLN",
                "country" => "Poland"
            ],
            [
                "code" => "NOK",
                "country" => "Norway"
            ],
            [
                "code" => "INR",
                "country" => "India"
            ],
            [
                "code" => "CZK",
                "country" => "Czech"
            ],
            [
                "code" => "HKD",
                "country" => "Hong Kong"
            ]
        );

        $this->dataForConversion = json_decode(file_get_contents(WP_PLUGIN_DIR . "/fixer-api-fx-converter/js/sample-data.json"));
        $this->defaultCurrency = "GBP";
        add_shortcode('fixer-converter-form', array($this, "getFormView"));
        add_action('rest_api_init', function () {
            register_rest_route(
                'c',
                '/get/',
                array(
                    'methods' => 'GET',
                    'callback' => array($this, "api_receive_conversion_from_to")
                )
            );
            register_rest_route(
                'c',
                '/send-request/',
                array(
                    'methods' => 'GET',
                    'callback' => array($this, "api_send_email_for_converter_request")
                )
            );
            register_rest_route(
                'c',
                '/mail/',
                array(
                    'methods' => 'POST',
                    'callback' => array($this, "api_send_email_for_converter_request")
                )
            );
        });
    }


    private function getConversion($to, $amount, $operation)
    {
        $mappedArray = array_values(
            array_filter($this->dataForConversion, function ($e) use ($to) {
                return $e->code === $to;
            })
        );
        $total = round($mappedArray[0]->buy, 2) * $amount;
        if ($operation === 'selling') {
            $rate = 1 / round($mappedArray[0]->sell, 2);
            $total = $rate * $amount;
            return array(number_format((float)$total, 2, '.', ''), round($mappedArray[0]->sell, 2));
        } else {
            return array(number_format((float)$total, 2, '.', ''), round($mappedArray[0]->buy, 2));
        }
    }

    public function getFormView()
    {
        $countries = $this->arrCountries;
        require_once(WP_PLUGIN_DIR . "/fixer-api-fx-converter/views/currency-form.php");
    }

    public function api_receive_conversion_from_to()
    {
        $to = $_REQUEST['to'];
        $amount = $_REQUEST['amount'];
        $operation = $_REQUEST['operation'];
        $conversion = $this->getConversion($to, $amount, $operation);
        return json_encode(["conversion" => $conversion[0], "rate" => $conversion[1]]);
    }

    public function api_send_email_for_converter_request()
    {
        try {
            require_once(WP_PLUGIN_DIR . "/fixer-api-fx-converter/src/sendEmail.php");
            $htmlMessage = "
                <h2>Hello. You've received a request from buy currency form. This is the client data:</h2>
                <p>
                    <strong>Name:</strong> " . htmlspecialchars($_POST['name']) . "<br>
                    <strong>Email:</strong> " . htmlspecialchars($_POST['email']) . "<br>
                    <strong>Phone Number:</strong> " . htmlspecialchars($_POST['phone']) . "<br>
                    <strong>Address:</strong> " . htmlspecialchars($_POST['address']) . "
                </p>
                <h3>So. Here is the conversion request:</h3>
                <p>
                    <strong>Currency:</strong> " . htmlspecialchars($_POST['to']) . "<br>
                    <strong>Amount:</strong> " . htmlspecialchars($_POST['currency-conversion-result']) . "<br>
                    <strong>Delivery Method:</strong> " . htmlspecialchars($_POST['order-type']) . "<br><br>
                </p>
            ";
            $mail = new sendEmail(
                "Receiving currency (" . htmlspecialchars($_POST["to"]) . ") request",
                $htmlMessage,
            );
            $mail->send();
            return json_encode(["success" => true, "message" => "Email has been sent successfully. We'll be in touch wiht you as soon as possible."]);
        } catch (Exception $e) {
            return json_encode(["success" => false, "message" => $e->getMessage()]);
        }
    }
}
