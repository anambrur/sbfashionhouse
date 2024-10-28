<?php
/**
 * Created by PhpStorm.
 * User: mrksohag
 * Date: 1/3/18
 * Time: 6:20 PM
 */

if ($all_tax)
{
$edit_tax = SM::check_this_method_access('taxes', 'edit') ? 1 : 0;
$tax_status_update = SM::check_this_method_access('taxes', 'tax_status_update') ? 1 : 0;
$delete_tax = SM::check_this_method_access('taxes', 'destroy') ? 1 : 0;
$per = $edit_tax + $delete_tax;
$sl = 1;
foreach ($all_tax as $tax)
{
?>
<tr id="tr_{{$tax->id}}">
    <td><?php echo $sl; ?></td>
    <td><?php echo $tax->title; ?></td>
    <td>
		<?php echo $tax->country; ?>
    </td>
    <td>
		<?php echo ($tax->type == 1 ? "$" : "").$tax->tax.($tax->type == 2 ? "%" : ""); ?>
    </td>
	<?php if ($tax_status_update != 0): ?>
    <td class="text-center">
        <select class="form-control change_status" route="<?php echo config('constant.smAdminSlug'); ?>/taxes/tax_status_update" post_id="<?php echo $tax->id; ?>">
            <option value="1" <?php
				if ($tax->status == 1)
				{
					echo 'Selected="Selected"';
				}
				?>>Published</option>
            <option value="2" <?php
				if ($tax->status == 2)
				{
					echo 'Selected="Selected"';
				}
				?>>Pending</option>
            <option value="3" <?php
				if ($tax->status == 3)
				{
					echo 'Selected="Selected"';
				}
				?>>Canceled</option>
        </select>
    </td>
	<?php endif; ?>
	<?php if ($per != 0): ?>
    <td class="text-center">
		<?php if ($edit_tax != 0): ?>
        <a href="<?php echo url(config('constant.smAdminSlug') . '/taxes'); ?>/<?php echo $tax->id; ?>/edit" title="Edit" class="btn btn-xs btn-default" id="">
            <i class="fa fa-pencil"></i>
        </a>
		<?php endif; ?>
		<?php if ($delete_tax != 0): ?>
        <a href="<?php echo url(config('constant.smAdminSlug') . '/taxes/destroy'); ?>/<?php echo $tax->id; ?>"
           title="Delete" class="btn btn-xs btn-default delete_data_row"
           delete_message="Are you sure to delete this Tax?"
           delete_row="tr_{{$tax->id}}">
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
