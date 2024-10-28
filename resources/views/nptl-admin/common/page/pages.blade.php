<?php
/**
 * Created by PhpStorm.
 * User: mrksohag
 * Date: 1/3/18
 * Time: 6:07 PM
 */

$edit_page = SM::check_this_method_access('page', 'edit_page') ? 1 : 0;
$page_status_update = SM::check_this_method_access('page', 'page_status_update') ? 1 : 0;
$delete_page = SM::check_this_method_access('page', 'delete_page') ? 1 : 0;
$per = $edit_page + $delete_page;
if ($pages)
{
$sl = 1;
foreach ($pages as $page)
{
?>
<tr id="tr_{{$page->id}}">
    <td><?php echo $sl; ?></td>
    <td><?php echo $page->menu_title; ?></td>
    <td><?php echo $page->page_title; ?></td>
	<?php if ($page_status_update != 0): ?>
    <td class="text-center">
        <select class="form-control change_status" route="<?php echo config('constant.smAdminSlug'); ?>/pages/page_status_update" post_id="<?php echo $page->id; ?>">
            <option value="1" <?php
				if ($page->status == 1)
				{
					echo 'Selected="Selected"';
				}
				?>>Published</option>
            <option value="2" <?php
				if ($page->status == 2)
				{
					echo 'Selected="Selected"';
				}
				?>>Pending</option>
            <option value="3" <?php
				if ($page->status == 3)
				{
					echo 'Selected="Selected"';
				}
				?>>Canceled</option>
        </select>
    </td>
	<?php endif; ?>
	<?php if ($per != 0): ?>
    <td class="text-center">
		<?php if ($edit_page != 0): ?>
        <a href="<?php echo url(config('constant.smAdminSlug') . '/pages/edit_page'); ?>/<?php echo $page->id; ?>" title="Edit" class="btn btn-xs btn-default" id="">
            <i class="fa fa-pencil"></i>
        </a>
		<?php endif; ?>
		<?php if ($delete_page != 0): ?>
        <a href="<?php echo url(config('constant.smAdminSlug') . '/pages/delete_page'); ?>/<?php echo $page->id; ?>"
           title="Delete" class="btn btn-xs btn-default delete_data_row"
           delete_message="Are you sure to delete this Page?"
           delete_row="tr_{{$page->id}}">
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
