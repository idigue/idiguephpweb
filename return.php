<!doctype html>
<html lang="en">
<?php include 'components/head.php'; ?>
<?php include 'components/breadcrumb.php'; ?>

<body>
    <?php
    ?>
    <h2 class="text-primary">Return Policies</h2>

    <div class="text-center">
        <div id="accordion">
            <p class="card" style="background-color: #333;">
            <div class="card-header" id=<?php echo 'heading' ?>>

                <button class="btn btn-link" data-toggle="collapse" data-target=<?php echo '#collapse' . $user['id']; ?> aria-expanded="true" aria-controls=<?php echo 'collapse' . $user['id']; ?>>
                    <h3>Non-Returnable Items</h3>
                </button>

            </div>
            <div id=<?php echo 'collapse' . $user['id']; ?> class="collapse show" aria-labelledby=<?php echo 'heading' . $user['id']; ?> data-parent="#accordion">
                <div class="card-body">
                    Personal care products
                </div>
            </div>
            <div class="card" style="background-color: #333;">
                <div class="card-header" id=<?php echo 'heading3' ?>>

                    <button class="btn btn-link" data-toggle="collapse" data-target=<?php echo '#collapse3'  ?> aria-expanded="true" aria-controls=<?php echo 'collapse3' ?>>
                        <h3>Return Requirements for Return-Eligible Items</h3>
                    </button>

                </div>
                <div id=<?php echo 'collapse3' ?> class="collapse show" aria-labelledby=<?php echo 'heading3'  ?> data-parent="#accordion">
                    <div class="card-body">
                        Items must be returned in new, unworn, undamaged condition with the original branded boxes and all accessories
                    </div>
                </div>

            </div>

            <p class="card" style="background-color: #333;">
            <div class="card-header" id=<?php echo 'heading2' ?>>

                <button class="btn btn-link" data-toggle="collapse" data-target=<?php echo '#collapse2'  ?> aria-expanded="true" aria-controls=<?php echo 'collapse2' ?>>
                    <h3>Quality Check for Returns</h3>
                </button>

            </div>
            <div id=<?php echo 'collapse2' ?> class="collapse show" aria-labelledby=<?php echo 'heading2'  ?> data-parent="#accordion">
                <div class="card-body">
                    <p>1. If you receive a damaged/defective item, please contact iDigue Customer Service within 24 hours of receipt.</p>
                    <p>2. When a returned item arrives at our warehouse, we will inspect and/or test it to ensure it is return- eligible and meets the applicable return requirements listed above. If the item passes our quality check, we will issue a refund. If our inspection finds that the returned item is not return-eligible or does not meet the return requirements listed above, we will reject the return and refuse to issue a refund or credit.</p>
                    <p>3. If an item’s return is rejected, we will send the item back to you at the same address that was specified in the original order and will deduct its return shipping fee from the amount of refund of other item(s) returned in the same order, if any. Currently, the return shipping fee for sending the rejected-return item to you is $7.99, and we reserve the right to adjust this fee.</p>
                    <p>4. In certain cases, we reserve the right, at our sole discretion, to offer a refund on the rejected-return item, instead of sending it back to you.</p>
                </div>
            </div>

        </div>

    </div>
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/site.js" asp-append-version="true"></script>

</html>