<div class="container">
    <h2>Order</h2>
    <!-- add order form -->
    <div class="box">
        <h3>Add a order</h3>
        <form action="<?php echo URL; ?>orders/addorder" method="POST">
            <label>Customer</label>
            <input type="text" name="customerId" value="" required />
            <label>Vehicle</label>
            <input type="text" name="vehicleId" value="" />

            <input type="submit" name="submit_add_order" value="Submit" />
        </form>
    </div>
    <!-- main content output -->
    <div class="box">
        <h3>Amount of orders</h3>
        <div>
            <?php echo $amount_of_orders; ?>
        </div>
        <h3>Amount of orders</h3>
        <div>
            <button id="javascript-ajax-button">Click here to get the amount of orders</button>
            <div id="javascript-ajax-result-box"></div>
        </div>
        <h3>List of orders</h3>
        <table>
            <thead style="background-color: #ddd; font-weight: bold;">
            <tr>
                <td>Id</td>
                <td>Customer</td>
                <td>Vehicle</td>
                <td>Created</td>
                <td>Complected</td>
                <td>DELETE</td>
                <td>EDIT</td>
                <td>Job ID</td>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($orders as $order) { ?>
                <tr>
                    <td><?php if (isset($order->id)) echo htmlspecialchars($order->id, ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php if (isset($order->customer)) echo htmlspecialchars($order->customer, ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php if (isset($order->vehicleId)) echo htmlspecialchars($order->vehicleType, ENT_QUOTES, 'UTF-8').' '.
                            htmlspecialchars($order->vehiclePlate, ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php if (isset($order->created_at)) echo htmlspecialchars($order->created_at, ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php if (isset($order->completed_at)) echo htmlspecialchars($order->completed_at, ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><a href="<?php echo URL . 'orders/deleteorder/' . htmlspecialchars($order->id, ENT_QUOTES, 'UTF-8'); ?>">delete</a></td>
                    <td><a href="<?php echo URL . 'orders/editorder/' . htmlspecialchars($order->id, ENT_QUOTES, 'UTF-8'); ?>">edit</a></td>
                    <td><?php if (isset($order->job)) {
                       if ($order->job==0) {
                           echo '<a href="'. URL . 'jobs/generate/'.$order->id.'" >Create job</a>';

                       } else {
                          echo '<a href="'. URL . 'jobs/editjob/'.$order->job.'" >'. htmlspecialchars($order->job, ENT_QUOTES, 'UTF-8').'</a>';
                        }
                    } ?>
                </td></tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>
