<div class="container">
    <h2>Job</h2>
    <div>
        <h3>Edit an job</h3>
        <form action="<?php echo URL; ?>jobs/updatejob" method="POST">
            <input type="hidden" name="job_id" value="<?php echo htmlspecialchars($job->id, ENT_QUOTES, 'UTF-8'); ?>" />
            <input type="hidden" name="orderId" value="<?php echo htmlspecialchars($job->orderId, ENT_QUOTES, 'UTF-8'); ?>" />
            <label>ID <?php echo htmlspecialchars($job->id, ENT_QUOTES, 'UTF-8'); ?></label>
            <label>Order ID <?php echo htmlspecialchars($job->orderId, ENT_QUOTES, 'UTF-8'); ?></label>
            <label>Employee</label>
            <select name="employeeId">
                <?php
                foreach ($employees as $ven) {
                    echo '<option value="'.$ven->id.'" '.(($job->employeeId===$ven->id)?"selected":"").'>'.$ven->firstname.' '
                        .strtoupper($ven->surname).'</option>'.PHP_EOL;
                }
                ?>
            </select>
            <label>Start</label>
            <input  type="datetime-local" name="start" value="<?php echo date('%Y-%m-%dT%H:%M:%S', $job->start_at); ?>" required />
            <label>Completed</label>
            <input type="datetime-local" name="completed" value="<?php echo strftime('%Y-%m-%dT%H:%M:%S',htmlspecialchars($job->completed_at, ENT_QUOTES, 'UTF-8')); ?>" />
            <input type="submit" name="submit_update_job" value="Update" />
        </form>
    </div>
</div>

