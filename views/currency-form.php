<div class="currency-widget">
    <div class="currency-general-container">
        <form id="currency-converter" method="POST">
            <h1 class="align-center currency-title">Currency Exchange</h1>
            <hr>
            <div class="currency-to-convert">
                <div class="radio-buttons">
                    <input type="radio" name="operation" class="operation" id="selling" value="selling" checked="checked">
                    <label for="selling">Buy Travel Money</label>
                </div>
                <div class="radio-buttons">
                    <input type="radio" name="operation" class="operation" id="buying" value="buying">
                    <label for="buying">Buy Back Currency</label>
                </div>
            </div>
            <div class="currency-to-convert">
                <label for="to">Currency</label>
                <select name="to" id="to" required>
                    <option value="">-- Select an option --</option>
                    <? foreach ($countries as $c) { ?>
                        <option value="<? echo $c['code']; ?>"
                            <? echo ($c['code'] === 'EUR') ? 'selected' : ''; ?>
                        ><? echo $c['country'] . " (" . $c['code'] . ")"; ?></option>
                    <? } ?>
                </select>
            </div>
            <div class="currency-container">
                <div class="currency-subcontainer">
                    <span class="phrase-selling-buying">Buy Travel Money</span><br>
                    <span class="big-font currency-code-text">GBP</span>
                </div>
                <div class="currency-subcontainer conversion-rate-value-one">

                </div>
                <div class="currency-subcontainer align-right">
                    <input class="form-inputs align-right" type="number" name="amount" id="amount" placeholder="Quantity" value = "1000" required>
                </div>
            </div>
            <div class="currency-container">
                <div class="currency-subcontainer">
                    You get<br>
                    <span class="big-font currency-selected">EUR</span>
                </div>
                <div class="currency-subcontainer conversion-rate-value-two">

                </div>
                <div class="currency-subcontainer with-border align-right">
                    <span class="currency-result"></span>
                </div>
            </div>
            <h3 class="align-center">Delivery Option</h3>
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
                <input type="hidden" name="currency-conversion-result" id="currency-conversion-result">
                <input type="hidden" value="" name="order-type" id="order-type" required>
                <button class="currency-button currency-show-form start-order" type="button">Start Order</button>
            </div>
            <div class="hide-show-form" id="client-data-form">
                <div class="currency-container">
                    <input type="text" class="form-inputs" name="name" id="name" placeholder="Name" minlength="2" required>
                </div>
                <div class="currency-container">
                    <input type="email" class="form-inputs" name="email" id="email" placeholder="Email" required>
                </div>
                <div class="currency-container">
                    <input type="tel" class="form-inputs" name="phone" id="phone" placeholder="Phone" required>
                </div>
                <div class="currency-container">
                    <input type="text" class="form-inputs" name="address" id="address" placeholder="Address" required minlength="6">
                </div>
                <hr>
                <button class="currency-submit currency-button submit-order" type="button">Order</button>
            </div>
        </form>
    </div>
</div>