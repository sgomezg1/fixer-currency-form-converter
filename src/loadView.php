<?php

class loadView
{
    public $defaultCurrency;
    public $dataForConversion;

    public function __construct()
    {
        header("Content-type", "application/json");
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
                '/latest/',
                array(
                    'methods' => 'GET',
                    'callback' => array($this, "api_get_latest_currency")
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

    private function getApiRequest($method, $endpoint)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => APIURL . $endpoint,
            CURLOPT_HTTPHEADER => array(
                "Content-Type: text/plain",
                "apikey: " . CREDENTIALS['api-key'] . ""
            ),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $method
        ));

        $response = curl_exec($curl);
        return json_decode($response);
    }

    private function getLatest($endpoint)
    {
        try {
            $api = $this->getApiRequest("GET", $endpoint);
            return $api->rates;
        } catch (Exception $e) {
            return json_encode(["success" => false, "error" => $e->getMessage()]);
        }
    }

    private function getConversion($endpoint)
    {
        try {
            $
            $api = $this->getApiRequest("GET", $endpoint);
            return $api->result;
        } catch (Exception $e) {
            return json_encode(["success" => false, "error" => $e->getMessage()]);
        }
    }

    public function getFormView()
    {
        $countries = $this->dataForConversion;
        $eurToGbr = $this->getLatest("/latest?symbols=EUR&base=" . $this->defaultCurrency);
        $eurToGbr = number_format((float)$eurToGbr->EUR, 3, '.', '');
        require_once(WP_PLUGIN_DIR . "/fixer-api-fx-converter/views/currency-form.php");
    }

    public function api_receive_conversion_from_to()
    {
        $to = $_REQUEST['to'];
        $amount = $_REQUEST['amount'];
        $conversion = $this->getConversion("/convert?to=" . $to . "&from=" . $this->defaultCurrency . "&amount=" . $amount);
        $latest = $this->getLatest("/latest?symbols=" . $to . "&base=" . $this->defaultCurrency);
        return json_encode(["conversion" => number_format((float)$conversion, 2, '.', ''), "latest" => $latest]);
    }

    public function api_get_latest_currency()
    {
        $to = $_REQUEST['to'];
        $latest = $this->getLatest("/latest?symbols=" . $to . "&base=" . $this->defaultCurrency);
        return $latest;
    }

    public function api_send_email_for_converter_request()
    {
        try {
            require_once(WP_PLUGIN_DIR . "/fixer-api-fx-converter/src/sendEmail.php");
            $htmlMessage = "
                <h2>Hello. You've received a request from buy currency form. This is the client data:</h2>
                <p>
                    <strong>Name:</strong> " . $_POST['name'] . "<br>
                    <strong>Email:</strong> " . $_POST['email'] . "<br>
                    <strong>Phone Number:</strong> " . $_POST['phone'] . "<br>
                    <strong>Address:</strong> " . $_POST['address'] . "
                </p>
                <h3>So. Here is the conversion request:</h3>
                <p>
                    <strong>Currency:</strong> " . $_POST['to'] . "<br>
                    <strong>Amount:</strong> " . $_POST['currency-conversion-result'] . "<br>
                    <strong>Delivery Method:</strong> " . $_POST['order-type'] . "<br><br>
                </p>
            ";
            $mail = new sendEmail(
                "Receiving currency (".$_POST["to"].") request",
               $htmlMessage,
            );
            $mail->send();
            return json_encode(["success" => true, "message" => "Email has been sent successfully. We'll be in touch wiht you as soon as possible."]);
        } catch (Exception $e) {
            // return json_encode(["success" => false, "message" => $e->getMessage(), "detail" => $this->mail->ErrorInfo]);
            return json_encode(["success" => false, "message" => $e->getMessage()]);
        }
    }
}
