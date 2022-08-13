<div class="currency-widget">
    <form class="currency-general-container" id="currency-converter" method="POST">
        <h1 class="align-center currency-title">Buy Currency Form</h1>
        <hr>
        <h4>User info:</h4>
        <div class="currency-container">
            <input type = "text" class = "form-inputs" name = "name" id = "name" placeholder="Name" required minlength="2">
        </div>
        <div class="currency-container">
            <input type = "email" class = "form-inputs" name = "email" id = "email" placeholder="Email" required>
        </div>
        <div class="currency-container">
            <input type = "tel" class = "form-inputs" name = "phone" id = "phone" placeholder="Phone" required>
        </div>
        <div class="currency-container">
            <input type = "text" class = "form-inputs" name = "address" id = "address" placeholder="Address" required minlength = "6">
        </div>
        <hr>
        <h4>Conversion info:</h4>
        <div class="currency-to-convert">
            <select name="to" id="to" required>
                <option value="">-- Select an option --</option>
                <? foreach ($countries as $code => $country) { ?>
                    <option value="<? echo $code; ?>">(<? echo $code; ?>) - <? echo $country; ?> </option>
                <? } ?>
            </select>
        </div>
        <div class="currency-container">
            <div class="currency-subcontainer">
                <h3 class="widget-header">Exchange Rate</h3>
            </div>
            <div class="currency-subcontainer align-right">
                <span class="big-font latest-rate"><? echo $eurToGbr; ?></span>Per 1 GBP
            </div>
        </div>
        <div class="currency-container">
            <div class="currency-subcontainer">
                You pay<br>
                <span class="big-font">GBR</span>
            </div>
            <div class="currency-subcontainer align-right">
                <input class="form-inputs align-right" type="number" name="amount" id = "amount" placeholder = "Quantity" required>
            </div>
        </div>
        <div class="currency-container">
            <div class="currency-subcontainer">
                You get<br>
                <span class="big-font currency-selected"></span>
            </div>
            <div class="currency-subcontainer with-border align-right">
                <span class="currency-result"></span>
            </div>
        </div>
        <h3 class = "align-center">Delivery Option</h3>
        <div class="currency-container">
            <div class="currency-subcontainer-buttons">
                <button type="button" class="currency-subcontainer select-delivery" data-request="collection">
                    <img class="clickable-image" src="<? echo PLUGINPATH . "/icons/collection.png"; ?>">
                    <br>
                    <br>
                    Collection
                </button>
            </div>
            <div class="container-button-divider"></div>
            <div class="currency-subcontainer-buttons">
                <button type="button" class="currency-subcontainer select-home" data-request="home">
                    <img class="clickable-image" src="<? echo PLUGINPATH . "/icons/delivered.png"; ?>">
                    <br>
                    <br>
                    Home Delivery
                </button>
            </div>
            <input type="hidden" name = "currency-conversion-result" id = "currency-conversion-result">
            <input type="hidden" value="" name = "order-type" id = "order-type" required>
        </div>
        <button class="currency-submit" type="button">Start Order</button>
    </form>
</div>