<?php

function make_checkoutprogress($number) { ?>

<style>
    .steps .row .col:nth-child(<?php echo $number ?>) p:nth-child(1) {
    background-color: var(--lighter-gray);
}
</style>

<div class="steps">
    <div class="row">
        <div class="col">
            <div class="row">
                <p> 1 </p>
                <p> Order Details </p>
                <hr width="25%">
            </div>
        </div>
        <div class="col">
            <div class="row">
                <p> 2</p>
                <p> Payment Details</p>
                <hr width="15%">
            </div>
        </div>

        <div class="col">
            <div class="row">
                <p> 3</p>
                <p> Resume</p>
            </div>
        </div>

    </div>
</div>

<?php } ?>