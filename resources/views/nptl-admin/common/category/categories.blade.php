<?php
/**
 * Created by PhpStorm.
 * User: mrksohag
 * Date: 1/3/18
 * Time: 5:55 PM
 */
?>
<?php
$edit_category = SM::check_this_method_access('categories', 'edit') ? 1 : 0;
$category_status_update = SM::check_this_method_access('categories', 'category_status_update') ? 1 : 0;
$delete_category = SM::check_this_method_access('categories', 'destroy') ? 1 : 0;
$per = $edit_category + $delete_category;
if ($all_category)
{
$sl = 1;
foreach ($all_category as $category)
{
?>
<tr id="tr_{{$category->id}}">
    <td><?php echo $sl; ?></td>
    <td><?php echo $category->title; ?></td>
    <td>
        <div style="background-color: {{ $category->color_code }}; width: 25px; height: 25px;">
        </div>
    </td>
    <td><?php echo $category->priority; ?></td>
    <td>
        <img class="img-product"
             src="<?php echo SM::sm_get_the_src($category->image, 30, 30); ?>"
             width="40px" alt="<?php echo $category->title; ?>"/>
    </td>
    <td>
        <img class="img-product"
             src="<?php echo SM::sm_get_the_src($category->fav_icon, 30, 30); ?>"
             width="40px" alt="<?php echo $category->title; ?>"/>
    </td>
    <th><?php echo $category->total_products; ?></th>
    <?php if ($category_status_update != 0): ?>
    <td class="text-center">
        <select class="form-control change_status"
                route="<?php echo config('constant.smAdminSlug'); ?>/categories/category_status_update"
                post_id="<?php echo $category->id; ?>">
            <option value="1" <?php
                if ($category->status == 1) {
                    echo 'Selected="Selected"';
                }
                ?>>Published
            </option>
            <option value="2" <?php
                if ($category->status == 2) {
                    echo 'Selected="Selected"';
                }
                ?>>Pending
            </option>
            <option value="3" <?php
                if ($category->status == 3) {
                    echo 'Selected="Selected"';
                }
                ?>>Canceled
            </option>
        </select>
    </td>
    <?php endif; ?>
    <?php if ($per != 0): ?>
    <td class="text-center">
        <?php if ($edit_category != 0): ?>
        <a href="<?php echo url(config('constant.smAdminSlug') . '/categories'); ?>/<?php echo $category->id; ?>/edit"
           title="Edit" class="btn btn-xs btn-default" id="">
            <i class="fa fa-pencil"></i>
        </a>
        <?php endif; ?>
        <?php if ($delete_category != 0): ?>
        <a href="<?php echo url(config('constant.smAdminSlug') . '/categories/destroy'); ?>/<?php echo $category->id; ?>"
           title="Delete" class="btn btn-xs btn-default delete_data_row"
           delete_message="Are you sure to delete this Category?"
           delete_row="tr_{{$category->id}}">
            <i class="fa fa-times"></i>
        </a>
        <?php endif; ?>
    </td>
    <?php endif; ?>
</tr>
<?php
$sl++;
SM::category_tree_for_category_table($category->id);
}
}
?>
