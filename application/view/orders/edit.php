<div class="container">
    <h2>Order</h2>

    <div>
        <h3>Edit an order</h3>
        <form action="<?php echo URL; ?>orders/updateorder" method="POST">
            <input type="hidden" name="order_id" value="<?php echo htmlspecialchars($order->id, ENT_QUOTES, 'UTF-8'); ?>" />
            <input type="hidden" name="customerId" value="<?php echo htmlspecialchars($order->customerId, ENT_QUOTES, 'UTF-8'); ?>" />
            <label>ID <?php echo htmlspecialchars($order->id, ENT_QUOTES, 'UTF-8'); ?></label>
            <label>Customer <?php echo htmlspecialchars($order->customer, ENT_QUOTES, 'UTF-8'); ?></label>
            <label>Vennicle</label>
            <select name="vehicleId">
                <?php
                foreach ($vehicles as $ven) {
                    echo '<option value="'.$ven->id.'" '.(($order->vehicleId===$ven->id)?"selected":"").'>'.$ven->type.' '
                        .strtoupper($ven->plate).'</option>'.PHP_EOL;
                }
                ?>
            </select>
            <label>Created</label>
            <input autofocus type="datetime-local" name="created" value="<?php echo strftime('%Y-%m-%dT%H:%M:%S', strtotime(htmlspecialchars($order->created_at, ENT_QUOTES, 'UTF-8'))); ?>" required />
            <label>Completed</label>
            <input type="datetime-local" name="complected" value="<?php echo strftime('%Y-%m-%dT%H:%M:%S', strtotime(htmlspecialchars($order->completed_at, ENT_QUOTES, 'UTF-8'))); ?>" />
            <input type="submit" name="submit_update_order" value="Update" />
        </form>
    </div>
</div>

