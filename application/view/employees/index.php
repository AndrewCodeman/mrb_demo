<div class="container">
    <h2>Employees</h2>
    <!-- add employee form -->
    <div class="box">
        <h3>Add a employee</h3>
        <form action="<?php echo URL; ?>employees/addemployee" method="POST">
            <label>Firstname</label>
            <input type="text" name="firstname" value="" required />
            <label>Surname</label>
            <input type="text" name="surname" value="" />
            <label>Email</label>
            <input type="email" name="email" value="" />
            <label>Phone</label>
            <input type="text" name="phone" value="" />
            <label>Category</label>
            <select name="category" required>
                <option value="ManagerA" >Manager A </option>
                <option value="ManagerB" >Manager B (only Cars and 4h)</option>
                <option value="MechanicA" >Mechanic A (only Cars and Motorbikes)</option>
                <option value="MechanicB" >Mechanic B</option>
            </select>
            <label>Started</label>
            <input type="datetime-local" name="started" value="" />
            <input type="submit" name="submit_add_employee" value="Submit" />
        </form>
    </div>
    <!-- main content output -->
    <div class="box">
        <h3>Amount of employees</h3>
        <div>
            <?php echo $amount_of_employees; ?>
        </div>
        <h3>Amount of employees</h3>
        <div>
            <button id="javascript-ajax-button">Click here to get the amount of employees</button>
            <div id="javascript-ajax-result-box"></div>
        </div>
        <h3>List of employees</h3>
        <table>
            <thead style="background-color: #ddd; font-weight: bold;">
            <tr>
                <td>Id</td>
                <td>Name</td>
                <td>Email</td>
                <td>Phone</td>
                <td>Respond</td>
                <td>Started</td>
                <td>Left</td>
                <td>DELETE</td>
                <td>EDIT</td>
                <td>Open/Closed Jobs</td>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($employees as $employee) { ?>
                <tr>
                    <td><?php if (isset($employee->id)) echo htmlspecialchars($employee->id, ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php if (isset($employee->firstname)) echo htmlspecialchars($employee->firstname, ENT_QUOTES, 'UTF-8')." "
                        .htmlspecialchars($employee->surname, ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php if (isset($employee->email)) echo htmlspecialchars($employee->email, ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php if (isset($employee->phone)) echo htmlspecialchars($employee->phone, ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php if (isset($employee->category)) echo htmlspecialchars($employee->category, ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php if (isset($employee->started_at)) echo htmlspecialchars($employee->started_at, ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php if (isset($employee->left_at)) echo htmlspecialchars($employee->left_at, ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><a href="<?php echo URL . 'employees/deleteemployee/' . htmlspecialchars($employee->id, ENT_QUOTES, 'UTF-8'); ?>">delete</a></td>
                    <td><a href="<?php echo URL . 'employees/editemployee/' . htmlspecialchars($employee->id, ENT_QUOTES, 'UTF-8'); ?>">edit</a></td>
                    <td><a href="<?php echo URL . 'jobs/employee/'.$employee->id; ?>"
                        ><?=htmlspecialchars($employee->OpenJobs." / ".$employee->ClosedJobs, ENT_QUOTES, 'UTF-8');?></a></td>

                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>
