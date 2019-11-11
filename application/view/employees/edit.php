<div class="container">
    <h2>Employee</h2>

    <div>
        <h3>Edit an employee</h3>
        <form action="<?php echo URL; ?>employees/updateemployee" method="POST">
            <label>ID <?php echo htmlspecialchars($employee->id, ENT_QUOTES, 'UTF-8'); ?></label>
            <label>Firstame</label>
            <input autofocus type="text" name="firstname" value="<?php echo htmlspecialchars($employee->firstname, ENT_QUOTES, 'UTF-8'); ?>" required />
            <label>Surname</label>
            <input type="text" name="surname" value="<?php echo htmlspecialchars($employee->surname, ENT_QUOTES, 'UTF-8'); ?>" />
            <label>Email</label>
            <input type="email" name="email" value="<?php echo htmlspecialchars($employee->email, ENT_QUOTES, 'UTF-8'); ?>" />
            <label>Phone</label>
            <input type="text" name="phone" value="<?php echo htmlspecialchars($employee->phone, ENT_QUOTES, 'UTF-8'); ?>" />
            <input type="hidden" name="employee_id" value="<?php echo htmlspecialchars($employee->id, ENT_QUOTES, 'UTF-8'); ?>" />
            <label>Category</label>
            <select name="category">
                <option value="ManagerA" <?=($employee->category==="ManagerA")?"selected":""?>>Manager A</option>
                <option value="ManagerB" <?=($employee->category==="ManagerB")?"selected":""?>>Manager B (only Cars and 4h)</option>
                <option value="MechanicA" <?=($employee->category==="MechanicA")?"selected":""?>>Mechanic A (only Cars and Motorbikes)</option>
                <option value="MechanicB" <?=($employee->category==="MechanicB")?"selected":""?>>Mechanic B</option>
            </select>
            <label>Started</label>
            <input type="datetime-local" name="started" value="<?php echo strftime('%Y-%m-%dT%H:%M:%S', strtotime(htmlspecialchars($employee->started_at, ENT_QUOTES, 'UTF-8'))); ?>" />
            <label>Left</label>
            <input type="datetime-local" name="left" value="<?php echo strftime('%Y-%m-%dT%H:%M:%S', strtotime(htmlspecialchars($employee->left_at, ENT_QUOTES, 'UTF-8'))); ?>" />
            <input type="submit" name="submit_update_employee" value="Update" />
        </form>
    </div>
</div>

