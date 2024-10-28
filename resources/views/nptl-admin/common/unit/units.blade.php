<?php
/**
 * Created by PhpStorm.
 * User: mrksohag
 * Date: 1/3/18
 * Time: 5:55 PM
 */
?>
<?php
$edit_unit = SM::check_this_method_access('units', 'edit') ? 1 : 0;
$unit_status_update = SM::check_this_method_access('units', 'unit_status_update') ? 1 : 0;
$delete_unit = SM::check_this_method_access('units', 'destroy') ? 1 : 0;
$per = $edit_unit + $delete_unit;
if ($all_unit)
{
$sl = 1;
foreach ($all_unit as $unit)
{
?>
<tr id="tr_{{$unit->id}}">
    <td><?php echo $sl; ?></td>
    <td><?php echo $unit->title; ?></td>
    <td><?php echo $unit->actual_name; ?></td>
    <?php if ($unit_status_update != 0): ?>
    <td class="text-center">
        <select class="form-control change_status"
                route="<?php echo config('constant.smAdminSlug'); ?>/units/unit_status_update"
                post_id="<?php echo $unit->id; ?>">
            <option value="1" <?php
                if ($unit->status == 1) {
                    echo 'Selected="Selected"';
                }
                ?>>Published
            </option>
            <option value="2" <?php
                if ($unit->status == 2) {
                    echo 'Selected="Selected"';
                }
                ?>>Pending
            </option>
            <option value="3" <?php
                if ($unit->status == 3) {
                    echo 'Selected="Selected"';
                }
                ?>>Canceled
            </option>
        </select>
    </td>
    <?php endif; ?>
    <?php if ($per != 0): ?>
    <td class="text-center">
        <?php if ($edit_unit != 0): ?>
        <a href="<?php echo url(config('constant.smAdminSlug') . '/units'); ?>/<?php echo $unit->id; ?>/edit"
           title="Edit" class="btn btn-xs btn-default" id="">
            <i class="fa fa-pencil"></i>
        </a>
        <?php endif; ?>
        <?php if ($delete_unit != 0): ?>
        <a href="<?php echo url(config('constant.smAdminSlug') . '/units/destroy'); ?>/<?php echo $unit->id; ?>"
           title="Delete" class="btn btn-xs btn-default delete_data_row"
           delete_message="Are you sure to delete this Category?"
           delete_row="tr_{{$unit->id}}">
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
