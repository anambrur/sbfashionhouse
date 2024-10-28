<?php
/**
 * Created by PhpStorm.
 * User: mrksohag
 * Date: 1/3/18
 * Time: 6:17 PM
 */
if ($all_subscriber)
{
$edit_subscriber = SM::check_this_method_access( 'subscribers', 'edit' ) ? 1 : 0;
$subscriber_status_update = SM::check_this_method_access( 'subscribers', 'subscriber_status_update' ) ? 1 : 0;
$delete_subscriber = SM::check_this_method_access( 'subscribers', 'destroy' ) ? 1 : 0;
$per = $edit_subscriber + $delete_subscriber;
$sl = 1;
foreach ($all_subscriber as $subscriber)
{
?>
<tr id="tr_{{$subscriber->id}}">
    <td><label><input type="checkbox" class="smCheckbox subscriber subscriber{{$subscriber->id}}" value="{{$subscriber->id}}"></label></td>
    <td class="subscriberemail{{$subscriber->id}}"><?php echo $subscriber->email; ?></td>

    <td><?php echo $subscriber->firstname . " " . $subscriber->lastname; ?></td>
    <td><?php echo $subscriber->country; ?></td>
    <td><?php echo $subscriber->state; ?></td>
	<?php if ($subscriber_status_update != 0): ?>
    <td class="text-center">
        <select class="form-control change_status"
                route="<?php echo config( 'constant.smAdminSlug' ); ?>/subscribers/subscriber_status_update"
                post_id="<?php echo $subscriber->id; ?>">
            <option value="1" <?php
				if ( $subscriber->status == 1 ) {
					echo 'Selected="Selected"';
				}
				?>>Subscribed
            </option>
            <option value="0" <?php
				if ( $subscriber->status == 0 ) {
					echo 'Selected="Selected"';
				}
				?>>Unsubscribed
            </option>
        </select>
    </td>
	<?php endif; ?>
	<?php if ($per != 0): ?>
    <td class="text-center">
        <a href="javascript:void(0)" row="{{$subscriber->id}}"
           title="Send Offer Mail" class="btn btn-xs btn-success showOfferMailPopUpForSingleSubscriber">
            <i class="fa fa-envelope"></i>
        </a>
		<?php if ($edit_subscriber != 0): ?>
        <a href="<?php echo url( config( 'constant.smAdminSlug' ) . '/subscribers' ); ?>/<?php echo $subscriber->id; ?>/edit"
           title="Edit" class="btn btn-xs btn-default" id="">
            <i class="fa fa-pencil"></i>
        </a>
		<?php endif; ?>
		<?php if ($delete_subscriber != 0): ?>
        <a href="<?php echo url( config( 'constant.smAdminSlug' ) . '/subscribers/destroy' ); ?>/<?php echo $subscriber->id; ?>"
           title="Delete" class="btn btn-xs btn-default delete_data_row"
           delete_message="Are you sure to delete this Tag?"
           delete_row="tr_{{$subscriber->id}}">
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

