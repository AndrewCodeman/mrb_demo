<div class="container">
    <h2>Job</h2>
    <?php /*
    <!-- add job form -->
    <div class="box">
        <h3>Add a job</h3>
        <form action="<?php echo URL; ?>jobs/addjob" method="POST">
            <label>Customer</label>
            <input type="text" name="customerId" value="" required />
            <label>Vehicle</label>
            <input type="text" name="vehicleId" value="" />

            <input type="submit" name="submit_add_job" value="Submit" />
        </form>
    </div>
 */ ?>
    <!-- main content output -->
    <div class="box">
        <h3>Amount of jobs</h3>
        <div>
            <?php echo $amount_of_jobs; ?>
        </div>
        <h3>Amount of jobs</h3>
        <div>
            <button id="javascript-ajax-button">Click here to get the amount of jobs</button>
            <div id="javascript-ajax-result-box"></div>
        </div>
        <h3>List of jobs</h3>
        <table>
            <thead style="background-color: #ddd; font-weight: bold;">
            <tr>
                <td>Id</td>
                <td>Employee</td>
                <td>Category</td>
                <td>Order</td>
                <td>Customer</td>
                <td>Vehicle</td>
                <td>Start</td>
                <td>Duration</td>
                <td>Complected</td>
                <td>DELETE</td>
                <td>EDIT</td>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($jobs as $job) { ?>
                <tr>
                    <td><?php if (isset($job->id)) echo htmlspecialchars($job->id, ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php if (isset($job->employeeId)) echo htmlspecialchars($job->firstname." ".$job->surname, ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php if (isset($job->category)) echo htmlspecialchars($job->category, ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php if (isset($job->orderId)) echo htmlspecialchars($job->orderId, ENT_QUOTES, 'UTF-8');?></td>
                    <td><?php if (isset($job->customer)) echo htmlspecialchars($job->customer, ENT_QUOTES, 'UTF-8');?></td>
                    <td><?php if (isset($job->vehicleId)) echo htmlspecialchars($job->type." ".$job->plate, ENT_QUOTES, 'UTF-8');?></td>
                    <td><?php if (isset($job->start_at)) echo htmlspecialchars($job->start_at, ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php if (isset($job->duration)) echo htmlspecialchars($job->duration, ENT_QUOTES, 'UTF-8'); ?> min</td>
                    <td><?php if (isset($job->completed_at)){
                        echo htmlspecialchars($job->completed_at, ENT_QUOTES, 'UTF-8');
                        } else {
                            echo '<a href="'. URL . 'jobs/completed/'.$job->id.'" >Set completed</a>';
                        } ?></td>
                    <td><a href="<?php echo URL . 'jobs/deletejob/' . htmlspecialchars($job->id, ENT_QUOTES, 'UTF-8'); ?>">delete</a></td>
                    <td><a href="<?php echo URL . 'jobs/editjob/' . htmlspecialchars($job->id, ENT_QUOTES, 'UTF-8'); ?>">edit</a></td>
</tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>
