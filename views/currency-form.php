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
        <h4>Select an operation:</h4>
        <div class="currency-to-convert">
            <div class="radio-buttons">
                <input type="radio" name="operation" class = "operation" id = "buying" value="buying" checked = "checked">
                <label for = "buying">Buying</label>
            </div>
            <div class="radio-buttons">
                <input type="radio" name="operation" class = "operation" id = "selling" value="selling">
                <label for = "selling">Selling</label>
            </div>
        </div>
        <div class="currency-to-convert">
            <label for="to">Currency</label>
            <select name="to" id="to" required>
                <option value="">-- Select an option --</option>
                <? foreach ($countries as $c) { ?>
                    <option value="<? echo $c['code']; ?>"><? echo $c['country'] . " (" . $c['code'] . ")"; ?></option>
                <? } ?>
            </select>
        </div>
        <div class="currency-container">
            <div class="currency-subcontainer">
                <span class = "phrase-selling-buying">You pay</span><br>
                <span class="big-font currency-code-text">GBP</span>
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