<div class="container">
    <h2><?=$customername?> jobs</h2>

    <!-- main content output -->
    <div class="box">

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
                <td>Customer</td>
                <td>Vehicle</td>
                <td>Created</td>
                <td>Complected</td>
                <td>DELETE</td>
                <td>EDIT</td>
                <td>Job</td>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($jobs as $job) { ?>
                <tr>
                    <td><?php if (isset($job->id)) echo htmlspecialchars($job->id, ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php if (isset($job->customer)) echo htmlspecialchars($job->customer, ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php if (isset($job->vehicleId)) echo htmlspecialchars($job->vehicleType, ENT_QUOTES, 'UTF-8').' '.
                            htmlspecialchars($job->vehiclePlate, ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php if (isset($job->created_at)) echo htmlspecialchars($job->created_at, ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php if (isset($job->completed_at)) echo htmlspecialchars($job->completed_at, ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><a href="<?php echo URL . 'jobs/deletejob/' . htmlspecialchars($job->id, ENT_QUOTES, 'UTF-8'); ?>">delete</a></td>
                    <td><a href="<?php echo URL . 'jobs/editjob/' . htmlspecialchars($job->id, ENT_QUOTES, 'UTF-8'); ?>">edit</a></td>
                    <td><?php if (isset($job->job)) {
                       if ($job->job===0) {
                           echo '<a href="'. URL . 'jobs/create?'.$job->id.'" >Create job</a>';

                       } else {
                          echo '<a href="'. URL . 'jobs/'.$job->id.'" >'. htmlspecialchars($job->job, ENT_QUOTES, 'UTF-8').'</a>';
                        }
                    } ?>
                </td></tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>
