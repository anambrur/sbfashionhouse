<?php
/**
 * Created by PhpStorm.
 * User: mrksohag
 * Date: 1/3/18
 * Time: 6:13 PM
 */

$edit_slider = SM::check_this_method_access('sliders', 'edit_slider') ? 1 : 0;
$slider_status_update = SM::check_this_method_access('sliders', 'slider_status_update') ? 1 : 0;
$delete_slider = SM::check_this_method_access('sliders', 'delete_slider') ? 1 : 0;
$per = $edit_slider + $delete_slider;
if ($sliders)
{
$sl = 1;
foreach ($sliders as $slider)
{
?>
<tr id="tr_{{$slider->id}}">
    <td><?php echo $sl; ?></td>
    <td>
        {{$slider->title}}
    </td>
    <td>
        <img class="img-blog" src="<?php echo SM::sm_get_the_src($slider->image, 80, 80); ?>" width="80px" alt="slider" />
    </td>
	<?php if ($slider_status_update != 0): ?>
    <td class="text-center">
        <select class="form-control change_status" route="<?php echo config('constant.smAdminSlug'); ?>/sliders/slider_status_update" post_id="<?php echo $slider->id; ?>">
            <option value="1" <?php
				if ($slider->status == 1)
				{
					echo 'Selected="Selected"';
				}
				?>>Published</option>
            <option value="2" <?php
				if ($slider->status == 2)
				{
					echo 'Selected="Selected"';
				}
				?>>Pending</option>
            <option value="3" <?php
				if ($slider->status == 3)
				{
					echo 'Selected="Selected"';
				}
				?>>Canceled</option>
        </select>
    </td>
	<?php endif; ?>
	<?php if ($per != 0): ?>
    <td class="text-center">
		<?php if ($edit_slider != 0): ?>
        <a href="<?php echo url(config('constant.smAdminSlug') . '/sliders/edit_slider'); ?>/<?php echo $slider->id; ?>" title="Edit" class="btn btn-xs btn-default" id="">
            <i class="fa fa-pencil"></i>
        </a>
		<?php endif; ?>
		<?php if ($delete_slider != 0): ?>
        <a href="<?php echo url(config('constant.smAdminSlug') . '/sliders/delete_slider'); ?>/<?php echo $slider->id; ?>"
           title="Delete" class="btn btn-xs btn-default delete_data_row"
           delete_message="Are you sure to delete this Slider?"
           delete_row="tr_{{$slider->id}}">
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
