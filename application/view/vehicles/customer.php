<div class="container">
    <h2><?=$customername?> orders</h2>
    <!-- add vehicle form -->
    <div class="box">
        <h3>Add a vehicle</h3>
        <form action="<?php echo URL; ?>vehicles/addvehicle" method="POST">
            <label>Plate</label>
            <input type="text" name="plate" value="" required />
            <input type="hidden" name="customer" value="<?=$customer_id?>">

            <label>Type</label>
            <select name="type">
                <option value="Car" >Car</option>
                <option value="Bus" >Bus</option>
                <option value="Bike" >Motorbike</option>
            </select>
            <input type="submit" name="submit_add_vehicle" value="Submit" />
        </form>
    </div>
    <!-- main content output -->
    <div class="box">
        <h3>Amount of vehicles</h3>
        <div>
            <?php echo $amount_of_vehicles; ?>
        </div>
        <h3>Amount of vehicles</h3>
        <div>
            <button id="javascript-ajax-button">Click here to get the amount of vehicles</button>
            <div id="javascript-ajax-result-box"></div>
        </div>
        <h3>List of vehicles</h3>
        <table>
            <thead style="background-color: #ddd; font-weight: bold;">
            <tr>
                <td>Id</td>
                <td>Plate</td>
                <td>Customer</td>
                <td>Type</td>
                <td>DELETE</td>
                <td>EDIT</td>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($vehicles as $vehicle) { ?>
                <tr>
                    <td><?php if (isset($vehicle->id)) echo htmlspecialchars($vehicle->id, ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php if (isset($vehicle->plate)) echo htmlspecialchars($vehicle->plate, ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php if (isset($vehicle->customer)) echo htmlspecialchars($vehicle->customer, ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php if (isset($vehicle->type)) echo htmlspecialchars($vehicle->type, ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><a href="<?php echo URL . 'vehicles/deletevehicle/' . htmlspecialchars($vehicle->id, ENT_QUOTES, 'UTF-8'); ?>">delete</a></td>
                    <td><a href="<?php echo URL . 'vehicles/editvehicle/' . htmlspecialchars($vehicle->id, ENT_QUOTES, 'UTF-8'); ?>">edit</a></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>
