<?php
/**
 * Created by PhpStorm.
 * User: mrksohag
 * Date: 1/4/18
 * Time: 9:29 AM
 */
$edit_comment = SM::check_this_method_access( 'blogs', 'edit_comment' ) ? 1 : 0;
$comment_status_update = SM::check_this_method_access( 'blogs', 'comment_status_update' ) ? 1 : 0;
$delete_comment = SM::check_this_method_access( 'blogs', 'destroy' ) ? 1 : 0;
$per = $edit_comment + $delete_comment;
if ($comments)
{
$sl = 1;
foreach ($comments as $comment)
{
?>
<tr id="tr_{{$comment->id}}">
    <td><?php echo $sl; ?></td>
    <td><?php echo $comment->blog_title; ?></td>
    <td ><?php

		if ( strlen( $comment->comments ) > 500 ) {
			echo substr( strip_tags( $comment->comments ), 0, 500 ) . ".... ";
		} else {
			echo $comment->comments;
		}
		?>
    </td>
    <td><?php echo isset( $comment->user->username ) ? $comment->user->username : ""; ?></td>
    <td>
        <img class="img-blog"
             src="<?php echo SM::sm_get_the_src( isset( $comment->user->image ) ? $comment->user->image : "", 80, 80 ); ?>"
             width="80px"
             alt="author"/>
    </td>
	<?php if ($comment_status_update != 0): ?>
    <td class="text-center">
        <select class="form-control change_status"
                route="<?php echo config( 'constant.smAdminSlug' ); ?>/blogs/comment_status_update"
                post_id="<?php echo $comment->id; ?>">
            <option value="1" <?php
				if ( $comment->status == 1 ) {
					echo 'Selected="Selected"';
				}
				?>>Published
            </option>
            <option value="2" <?php
				if ( $comment->status == 2 ) {
					echo 'Selected="Selected"';
				}
				?>>Pending
            </option>
            <option value="3" <?php
				if ( $comment->status == 3 ) {
					echo 'Selected="Selected"';
				}
				?>>Canceled
            </option>
        </select>
    </td>
	<?php endif; ?>
	<?php if ($per != 0): ?>
    <td class="text-center">
        <a href="<?php echo url( config( 'constant.smAdminSlug' ) .
		                         '/blogs/reply_comment' ); ?>/<?php echo $comment->id; ?>"
           title="Edit" class="btn btn-xs btn-default" id="">
            <i class="fa fa-reply"></i>
        </a>
		<?php if ($edit_comment != 0): ?>
        <a href="<?php echo url( config( 'constant.smAdminSlug' ) . '/blogs/edit_comment' ); ?>/<?php echo $comment->id; ?>"
           title="Edit" class="btn btn-xs btn-default" id="">
            <i class="fa fa-pencil"></i>
        </a>
		<?php endif; ?>
		<?php if ($delete_comment != 0): ?>
        <a href="<?php echo url( config( 'constant.smAdminSlug' ) . '/blogs/delete_comment' ); ?>/<?php echo $comment->id; ?>"
           title="Delete" class="btn btn-xs btn-default delete_data_row"
           delete_message="Are you sure to delete this blog comment?"
           delete_row="tr_{{$comment->id}}">
            <i class="fa fa-times"></i>
        </a>
		<?php endif; ?>
    </td>
	<?php endif; ?>
</tr>
<?php
SM::getChildrenTableComment( $comment->commentable_id, $comment->id );

$sl ++;
}
}
?>
