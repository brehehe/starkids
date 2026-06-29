<!DOCTYPE html>
<html lang="id">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Invoice 80mm</title>
    </head>

    <body>
        <div class="invoice-container">
            <?php echo $__env->yieldContent('content'); ?>
        </div>
        <div class="print">
            <button onclick="window.print()"
                style="margin-top:10px;padding:5px 10px;background:#000;color:#fff;border:none;">Print</button>
        </div>
    </body>

</html>
<?php /**PATH /Users/macbookair/Documents/mediction/mediction.id/resources/views/layout/receipt/invoice.blade.php ENDPATH**/ ?>