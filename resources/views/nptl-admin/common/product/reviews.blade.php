<?php
$edit_review = SM::check_this_method_access('products', 'edit_review') ? 1 : 0;
$review_status_update = SM::check_this_method_access('products', 'review_status_update') ? 1 : 0;
$delete_review = SM::check_this_method_access('products', 'destroy') ? 1 : 0;
$per = $edit_review + $delete_review;
if ($reviews)
{
$sl = 1;
foreach ($reviews as $review)
{
?>
<tr id="tr_{{$review->id}}">
    <td><?php echo $sl; ?></td>
    <td><?php echo $review->product->title; ?></td>

    <td>
        <?php echo $review->rating; ?>
    </td>
    <td><?php

        if (strlen($review->description) > 500) {
            echo substr(strip_tags($review->description), 0, 500) . ".... ";
        } else {
            echo $review->description;
        }
        ?>
    </td>
    <td><?php echo isset($review->user->username) ? $review->user->username : ""; ?></td>

    <?php if ($review_status_update != 0): ?>
    <td class="text-center">
        <select class="form-control change_status"
                route="<?php echo config('constant.smAdminSlug'); ?>/products/review_status_update"
                post_id="<?php echo $review->id; ?>">
            <option value="1" <?php
                if ($review->status == 1) {
                    echo 'Selected="Selected"';
                }
                ?>>Published
            </option>
            <option value="2" <?php
                if ($review->status == 2) {
                    echo 'Selected="Selected"';
                }
                ?>>Pending
            </option>
            <option value="3" <?php
                if ($review->status == 3) {
                    echo 'Selected="Selected"';
                }
                ?>>Canceled
            </option>
        </select>
    </td>
    <?php endif; ?>
    <?php if ($per != 0): ?>
    <td class="text-center">
        <a style="display: none;" href="<?php echo url(config('constant.smAdminSlug') .
            '/products/reply_review'); ?>/<?php echo $review->id; ?>"
           title="Edit" class="btn btn-xs btn-default" id="">
            <i class="fa fa-reply"></i>
        </a>
        <?php if ($edit_review != 0): ?>
        <a style="display: none;"
           href="<?php echo url(config('constant.smAdminSlug') . '/products/edit_review'); ?>/<?php echo $review->id; ?>"
           title="Edit" class="btn btn-xs btn-default" id="">
            <i class="fa fa-pencil"></i>
        </a>
        <?php endif; ?>
        <?php if ($delete_review != 0): ?>
        <a href="<?php echo url(config('constant.smAdminSlug') . '/products/delete_review'); ?>/<?php echo $review->id; ?>"
           title="Delete" class="btn btn-xs btn-default delete_data_row"
           delete_message="Are you sure to delete this blog review?"
           delete_row="tr_{{$review->id}}">
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
