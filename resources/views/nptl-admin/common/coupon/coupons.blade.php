<?php
/**
 * Created by PhpStorm.
 * User: mrksohag
 * Date: 1/3/18
 * Time: 5:59 PM
 */
?>

<?php
if ($all_coupon)
{
$edit_coupon = SM::check_this_method_access('coupons', 'edit') ? 1 : 0;
$coupon_status_update = SM::check_this_method_access('coupons', 'coupon_status_update') ? 1 : 0;
$delete_coupon = SM::check_this_method_access('coupons', 'destroy') ? 1 : 0;
$per = $edit_coupon + $delete_coupon;
$sl = 1;
foreach ($all_coupon as $coupon)
{
?>
<tr id="tr_{{$coupon->id}}">
    <td><?php echo $sl; ?></td>
    <td><?php echo $coupon->title; ?></td>
    <td>
        <?php echo $coupon->coupon_code; ?>

    </td>
    <td>
        <?php echo $coupon->qty; ?>
    </td>
    <td>
        <?php echo $coupon->balance_qty; ?></td>
    <td>
        <?php echo ($coupon->type == 1 ? SM::get_setting_value('currency') : "") . ' ' . $coupon->coupon_amount . ($coupon->type == 2 ? "%" : ""); ?>
    </td>
    <td>
        {{ SM::showDateTime($coupon->validity) }}
     </td>
    <?php if ($coupon_status_update != 0): ?>
    <td class="text-center">
        <select class="form-control change_status"
                route="<?php echo config('constant.smAdminSlug'); ?>/coupons/coupon_status_update"
                post_id="<?php echo $coupon->id; ?>">
            <option value="1" <?php
                if ($coupon->status == 1) {
                    echo 'Selected="Selected"';
                }
                ?>>Published
            </option>
            <option value="2" <?php
                if ($coupon->status == 2) {
                    echo 'Selected="Selected"';
                }
                ?>>Pending
            </option>
            <option value="3" <?php
                if ($coupon->status == 3) {
                    echo 'Selected="Selected"';
                }
                ?>>Canceled
            </option>
        </select>
    </td>
    <?php endif; ?>
    <?php if ($per != 0): ?>
    <td class="text-center">
        <?php if ($edit_coupon != 0): ?>
        <a href="<?php echo url(config('constant.smAdminSlug') . '/coupons'); ?>/<?php echo $coupon->id; ?>/edit"
           title="Edit" class="btn btn-xs btn-default" id="">
            <i class="fa fa-pencil"></i>
        </a>
        <?php endif; ?>
        <?php if ($delete_coupon != 0): ?>
        <a href="<?php echo url(config('constant.smAdminSlug') . '/coupons/destroy'); ?>/<?php echo $coupon->id; ?>"
           title="Delete" class="btn btn-xs btn-default delete_data_row"
           delete_message="Are you sure to delete this Coupon?"
           delete_row="tr_{{$coupon->id}}">
            <i class="fa fa-times"></i>
        </a>
        <?php endif; ?>
    </td>
    <?php endif; ?>
</tr>
<?php
$sl++;
}
}
?>
