<div class="table-responsive">
    <table class="table">
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
                <td class="text-left"><?= $order->status; ?></td>
            </tr>
       <?php } ?>
        </tbody>
     </table>
            </div>