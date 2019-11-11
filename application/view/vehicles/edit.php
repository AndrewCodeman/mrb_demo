<div class="container">
    <h2>Vehicle</h2>

    <div>
        <h3>Edit an vehicle</h3>
        <form action="<?php echo URL; ?>vehicles/updatevehicle" method="POST">
            <input type="hidden" name="vehicle_id" value="<?php echo htmlspecialchars($vehicle->id, ENT_QUOTES, 'UTF-8'); ?>" />
            <label>ID <?php echo htmlspecialchars($vehicle->id, ENT_QUOTES, 'UTF-8'); ?></label>
            <label>Plate</label>
            <input autofocus type="text" name="plate" value="<?php echo htmlspecialchars($vehicle->plate, ENT_QUOTES, 'UTF-8'); ?>" required />
            <label>Customer</label>
            <select name="customer" required>
                <?php
                foreach ($customers  as $c){
                    echo '<option value="'.$c->id.'" ';
                    echo ($c->id===$vehicle->customerId)?"selected":"";
                    echo '>'.$c->name.'</option>'.PHP_EOL;
                }
                ?>
            </select>
            <select name="type" required>
                <option value="Car" <?=($vehicle->type==="Car")?"selected":""?>>Car</option>
                <option value="Bus" <?=($vehicle->type==="Bus")?"selected":""?>>Bus</option>
                <option value="Motorbike" <?=($vehicle->type==="Motorbike")?"selected":""?>>Motorbike</option>
            </select>
            <input type="submit" name="submit_update_vehicle" value="Update" />
        </form>
    </div>
</div>

