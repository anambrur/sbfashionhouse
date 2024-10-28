<?php
/**
 * Created by PhpStorm.
 * User: mrksohag
 * Date: 1/3/18
 * Time: 6:30 PM
 */

$edit_payment_method = SM::check_this_method_access( 'payment_methods', 'edit' ) ? 1 : 0;
$payment_method_status_update = SM::check_this_method_access( 'payment_methods', 'payment_method_status_update' ) ? 1 : 0;
$delete_payment_method = SM::check_this_method_access( 'payment_methods', 'destroy' ) ? 1 : 0;
$per = $edit_payment_method + $delete_payment_method;
if ($all_payment_method)
{
$sl = 1;
foreach ($all_payment_method as $payment_method)
{
?>
<tr id="tr_{{$payment_method->id}}">
    <td><?php echo $sl; ?></td>
    <td><?php echo $payment_method->title; ?></td>
    <td><?php
		if ( $payment_method->type == 2 ) {
			echo "Online Without Card";
		} else if ( $payment_method->type == 3 ) {
			echo "Online With Card";
		} else {
			echo "Offline";
		}
		?></td>
	<?php if ($payment_method_status_update != 0): ?>
    <td class="text-center">
        <select class="form-control change_status"
                route="<?php echo config( 'constant.smAdminSlug' ); ?>/payment_methods/payment_method_status_update"
                post_id="<?php echo $payment_method->id; ?>">
            <option value="1" <?php
				if ( $payment_method->status == 1 ) {
					echo 'Selected="Selected"';
				}
				?>>Published
            </option>
            <option value="2" <?php
				if ( $payment_method->status == 2 ) {
					echo 'Selected="Selected"';
				}
				?>>Pending
            </option>
            <option value="3" <?php
				if ( $payment_method->status == 3 ) {
					echo 'Selected="Selected"';
				}
				?>>Canceled
            </option>
        </select>
    </td>
	<?php endif; ?>
	<?php if ($per != 0): ?>
    <td class="text-center">
		<?php if ($edit_payment_method != 0): ?>
        <a href="<?php echo url( config( 'constant.smAdminSlug' ) . '/payment_methods' ); ?>/<?php echo $payment_method->id; ?>/edit"
           title="Edit" class="btn btn-xs btn-default" id="">
            <i class="fa fa-pencil"></i>
        </a>
		<?php endif; ?>
		<?php if ($delete_payment_method != 0): ?>
        <a href="<?php echo url( config( 'constant.smAdminSlug' ) . '/payment_methods/destroy' ); ?>/<?php echo $payment_method->id; ?>"
           title="Delete" class="btn btn-xs btn-default delete_data_row"
           delete_message="Are you sure to delete this Payment method?"
           delete_row="tr_{{$payment_method->id}}">
            <i class="fa fa-times"></i>
        </a>
		<?php endif; ?>
    </td>
	<?php endif; ?>
</tr>
<?php
$sl ++;
}
}
?>
