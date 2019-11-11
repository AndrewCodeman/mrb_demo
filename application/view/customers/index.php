<div class="container">
    <h2>Customer</h2>
    <!-- add customer form -->
    <div class="box">
        <h3>Add a customer</h3>
        <form action="<?php echo URL; ?>customers/addcustomer" method="POST">
            <label>Name</label>
            <input type="text" name="name" value="" required />
            <label>Address</label>
            <input type="text" name="address" value="" />
            <label>Email</label>
            <input type="email" name="email" value="" />
            <label>Phone</label>
            <input type="text" name="phone" value="" />
            <label>Respond Method</label>
            <input type="number" name="respondMethod" value="" required />
            <input type="submit" name="submit_add_customer" value="Submit" />
        </form>
    </div>
    <!-- main content output -->
    <div class="box">
        <h3>Amount of customers</h3>
        <div>
            <?php echo $amount_of_customers; ?>
        </div>
        <h3>Amount of customers</h3>
        <div>
            <button id="javascript-ajax-button">Click here to get the amount of customers</button>
            <div id="javascript-ajax-result-box"></div>
        </div>
        <h3>List of customers</h3>
        <table>
            <thead style="background-color: #ddd; font-weight: bold;">
            <tr>
                <td>Id</td>
                <td>Name</td>
                <td>Address</td>
                <td>Email</td>
                <td>Phone</td>
                <td>Respond</td>
                <td>Created</td>
                <td>DELETE</td>
                <td>EDIT</td>
                <td>Vehicles</td>
                <td>Open/Closed Orders</td>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($customers as $customer) { ?>
                <tr>
                    <td><?php if (isset($customer->id)) echo htmlspecialchars($customer->id, ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php if (isset($customer->name)) echo htmlspecialchars($customer->name, ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php if (isset($customer->address)) echo htmlspecialchars($customer->address, ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php if (isset($customer->email)) echo htmlspecialchars($customer->email, ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php if (isset($customer->phone)) echo htmlspecialchars($customer->phone, ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php if (isset($customer->respondMethod)) echo htmlspecialchars($customer->respondMethod, ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php if (isset($customer->created_at)) echo htmlspecialchars($customer->created_at, ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><a href="<?php echo URL . 'customers/deletecustomer/' . htmlspecialchars($customer->id, ENT_QUOTES, 'UTF-8'); ?>">delete</a></td>
                    <td><a href="<?php echo URL . 'customers/editcustomer/' . htmlspecialchars($customer->id, ENT_QUOTES, 'UTF-8'); ?>">edit</a></td>
                    <td><a href="<?php echo URL . 'vehicles/customer/'.$customer->id; ?>"
                        ><?=htmlspecialchars($customer->vehicles, ENT_QUOTES, 'UTF-8');?></a></td>
                    <td><a href="<?php echo URL . 'orders/customer/'.$customer->id; ?>"
                        ><?=htmlspecialchars($customer->OpenOrders." / ".$customer->ClosedOrders, ENT_QUOTES, 'UTF-8');?></a></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>
