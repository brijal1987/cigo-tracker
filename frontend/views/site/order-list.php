<div class="table-responsive">
    <table class="table listing">
        <thead>
            <tr>
                <th class="text-left">First Name</th>
                <th class="text-left">Last Name</th>
                <th class="text-left">Date</th>
                <th class="text-left"></th>
            </tr>
        </thead>
    <tbody>
       <?php 
        foreach($orders as $order){ ?>
           <tr>
                <td class="text-left"><?= $order->first_name; ?></td>
                <td class="text-left"><?= $order->last_name; ?></td>
                <td class="text-left"><?= $order->schedule_date; ?></td>
                <td class="text-left">
                    <?php 
                    $statusText = "Pending";
                    $statusColor = " btn-default";
                    $closedisabled = " disabled";
                    if($order->status == 1){
                        $statusText = "Pending";
                        $statusColor = " btn-default";
                        $closedisabled = "";
                    }
                    else if($order->status == 2){
                        $statusText = "Assigned";
                        $statusColor = " btn-primary";
                        $closedisabled = "";
                    }
                    else if($order->status == 3){
                        $statusText = "On Route";
                        $statusColor = " btn-warning";
                    }
                    else if($order->status == 4){
                        $statusText = "Done";
                        $statusColor = " btn-success";
                    }
                    else if($order->status == 5){
                        $statusText = "Cancelled";
                        $statusColor = " btn-danger";
                    }
                    ?>
                    <span class="listing-close"><i class="fas fa-times-circle <?= $closedisabled?>"></i></span>
                    <div class="dropdown">
                        <button class="btn <?= $statusColor?> dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <?= $statusText; ?>
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a onclick="changeStatus('<?= $order->id;?>', 1)" href="javascript:void(0)">Pending</a></li>
                            <li><a onclick="changeStatus('<?= $order->id;?>', 2)" href="javascript:void(0)">Assigned</a></li>
                            <li><a onclick="changeStatus('<?= $order->id;?>', 3)" href="javascript:void(0)">On Route</a></li>
                            <li><a onclick="changeStatus('<?= $order->id;?>', 4)" href="javascript:void(0)">Done</a></li>
                            <li><a onclick="changeStatus('<?= $order->id;?>', 5)" href="javascript:void(0)">Cancelled</a></li>
                        </ul>
                    </div>

                </td>
            </tr>
       <?php } ?>
        </tbody>
     </table>
</div>
