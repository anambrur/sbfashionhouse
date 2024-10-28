<?php
/**
 * Created by PhpStorm.
 * User: mrksohag
 * Date: 1/3/18
 * Time: 6:17 PM
 */
if ($all_tag)
{
$edit_tag = SM::check_this_method_access('tags', 'edit') ? 1 : 0;
$tag_status_update = SM::check_this_method_access('tags', 'tag_status_update') ? 1 : 0;
$delete_tag = SM::check_this_method_access('tags', 'destroy') ? 1 : 0;
$per = $edit_tag + $delete_tag;
$sl = 1;
foreach ($all_tag as $tag)
{
?>
<tr id="tr_{{$tag->id}}">
    <td><?php echo $sl; ?></td>
    <td><?php echo $tag->title; ?></td>
    <td>
        <img class="img-blog" src="<?php echo SM::sm_get_the_src($tag->image, 80, 80); ?>" width="80px" alt="<?php echo $tag->title; ?>" />
    </td>
    <td><?php echo $tag->total_products; ?></td>
	<?php if ($tag_status_update != 0): ?>
    <td class="text-center">
        <select class="form-control change_status" route="<?php echo config('constant.smAdminSlug'); ?>/tags/tag_status_update" post_id="<?php echo $tag->id; ?>">
            <option value="1" <?php
				if ($tag->status == 1)
				{
					echo 'Selected="Selected"';
				}
				?>>Published</option>
            <option value="2" <?php
				if ($tag->status == 2)
				{
					echo 'Selected="Selected"';
				}
				?>>Pending</option>
            <option value="3" <?php
				if ($tag->status == 3)
				{
					echo 'Selected="Selected"';
				}
				?>>Canceled</option>
        </select>
    </td>
	<?php endif; ?>
	<?php if ($per != 0): ?>
    <td class="text-center">
		<?php if ($edit_tag != 0): ?>
        <a href="<?php echo url(config('constant.smAdminSlug') . '/tags'); ?>/<?php echo $tag->id; ?>/edit" title="Edit" class="btn btn-xs btn-default" id="">
            <i class="fa fa-pencil"></i>
        </a>
		<?php endif; ?>
		<?php if ($delete_tag != 0): ?>
        <a href="<?php echo url(config('constant.smAdminSlug') . '/tags/destroy'); ?>/<?php echo $tag->id; ?>"
           title="Delete" class="btn btn-xs btn-default delete_data_row"
           delete_message="Are you sure to delete this Tag?"
           delete_row="tr_{{$tag->id}}">
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

