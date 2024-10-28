<?php
$edit_brand = SM::check_this_method_access('brands', 'edit') ? 1 : 0;
$brand_status_update = SM::check_this_method_access('brands', 'brand_status_update') ? 1 : 0;
$delete_brand = SM::check_this_method_access('brands', 'destroy') ? 1 : 0;
$per = $edit_brand + $delete_brand;
if ($all_brand)
{
$sl = 1;
foreach ($all_brand as $brand)
{
?>
<tr id="tr_{{$brand->id}}">
    <td><?php echo $sl; ?></td>
    <td><?php echo $brand->title; ?></td>
    <td><?php echo $brand->website; ?></td>
    <td>
        <img class="img-blog"
             src="<?php echo SM::sm_get_the_src($brand->image, 80, 80); ?>"
             width="40px" alt="<?php echo $brand->title; ?>"/>
    </td>
    <th><?php echo count($brand->products); ?></th>
    <?php if ($brand_status_update != 0): ?>
    <td class="text-center">
        <select class="form-control change_status"
                route="<?php echo config('constant.smAdminSlug'); ?>/brands/brand_status_update"
                post_id="<?php echo $brand->id; ?>">
            <option value="1" <?php
                if ($brand->status == 1) {
                    echo 'Selected="Selected"';
                }
                ?>>Published
            </option>
            <option value="2" <?php
                if ($brand->status == 2) {
                    echo 'Selected="Selected"';
                }
                ?>>Pending
            </option>
            <option value="3" <?php
                if ($brand->status == 3) {
                    echo 'Selected="Selected"';
                }
                ?>>Canceled
            </option>
        </select>
    </td>
    <?php endif; ?>
    <?php if ($per != 0): ?>
    <td class="text-center">
        <?php if ($edit_brand != 0): ?>
        <a href="<?php echo url(config('constant.smAdminSlug') . '/brands'); ?>/<?php echo $brand->id; ?>/edit"
           title="Edit" class="btn btn-xs btn-default" id="">
            <i class="fa fa-pencil"></i>
        </a>
        <?php endif; ?>
        <?php if ($delete_brand != 0): ?>
        <a href="<?php echo url(config('constant.smAdminSlug') . '/brands/destroy'); ?>/<?php echo $brand->id; ?>"
           title="Delete" class="btn btn-xs btn-default delete_data_row"
           delete_message="Are you sure to delete this Category?"
           delete_row="tr_{{$brand->id}}">
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
