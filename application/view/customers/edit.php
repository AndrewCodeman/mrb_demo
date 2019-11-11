<div class="container">
    <h2>Customer</h2>

    <div>
        <h3>Edit a customer</h3>
        <form action="<?php echo URL; ?>customers/updatecustomer" method="POST">
            <label>ID <?php echo htmlspecialchars($customer->id, ENT_QUOTES, 'UTF-8'); ?></label>
            <label>Name</label>
            <input autofocus type="text" name="name" value="<?php echo htmlspecialchars($customer->name, ENT_QUOTES, 'UTF-8'); ?>" required />
            <label>Address</label>
            <input type="text" name="address" value="<?php echo htmlspecialchars($customer->address, ENT_QUOTES, 'UTF-8'); ?>" />
            <label>Email</label>
            <input type="email" name="email" value="<?php echo htmlspecialchars($customer->email, ENT_QUOTES, 'UTF-8'); ?>" />
            <label>Phone</label>
            <input type="text" name="phone" value="<?php echo htmlspecialchars($customer->phone, ENT_QUOTES, 'UTF-8'); ?>" />
            <input type="hidden" name="customer_id" value="<?php echo htmlspecialchars($customer->id, ENT_QUOTES, 'UTF-8'); ?>" />
            <label>Respond Method</label>
            <input autofocus type="number" name="number" value="<?php echo htmlspecialchars($customer->respondMethod, ENT_QUOTES, 'UTF-8'); ?>" required />
            <input type="submit" name="submit_update_customer" value="Update" />
        </form>
    </div>
</div>

