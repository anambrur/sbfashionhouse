<?php
/**
 * Created by PhpStorm.
 * User: mrksohag
 * Date: 1/3/18
 * Time: 5:22 PM
 */
?>
<?php
if ($all_blog)
{
$edit_blog = SM::check_this_method_access( 'blogs', 'edit' ) ? 1 : 0;
$blog_status_update = SM::check_this_method_access( 'blogs', 'blog_status_update' ) ? 1 : 0;
$delete_blog = SM::check_this_method_access( 'blogs', 'delete' ) ? 1 : 0;
$per = $edit_blog + $delete_blog;
$sl = 1;
foreach ($all_blog as $blog)
{
?>
<tr id="tr_{{$blog->id}}">
    <td><?php echo $sl; ?></td>
    <td>
        @if(count($blog->categories)>0)
            @foreach($blog->categories as $cat)
                @if($loop->iteration>1)
                    {{", "}}
                @endif
                {{$cat->title}}
            @endforeach
        @endif
    </td>
    <td><?php echo $blog->title; ?></td>
    <td>
        <img class="img-blog"
             src="<?php echo SM::sm_get_the_src( $blog->image, 80, 80 ); ?>"
             width="80px"
             alt="<?php echo $blog->title; ?>"/>
    </td>
    <td><?php echo $blog->is_sticky == 1 ? "Yes" : "No"; ?></td>
    <td><?php echo isset( $blog->user->username ) ? $blog->user->username : ""; ?></td>
    <td><?php echo $blog->views; ?></td>
    <td><?php echo $blog->likes; ?></td>
    <td><?php echo $blog->comments; ?></td>
	<?php if ($blog_status_update != 0): ?>
    <td class="text-center">
        <select class="form-control change_status"
                route="<?php echo config( 'constant.smAdminSlug' ); ?>/blogs/blog_status_update"
                post_id="<?php echo $blog->id; ?>">
            <option value="1" <?php
				if ( $blog->status == 1 ) {
					echo 'Selected="Selected"';
				}
				?>>Published
            </option>
            <option value="2" <?php
				if ( $blog->status == 2 ) {
					echo 'Selected="Selected"';
				}
				?>>Pending
            </option>
            <option value="3" <?php
				if ( $blog->status == 3 ) {
					echo 'Selected="Selected"';
				}
				?>>Canceled
            </option>
        </select>
    </td>
	<?php endif; ?>
	<?php if ($per != 0): ?>
    <td class="text-center">
        <a target="_blank" href="<?php echo url( '/blog/' . $blog->slug ); ?>" title="View"
           class="btn btn-xs btn-success" id="">
            <i class="fa fa-eye"></i>
        </a>
		<?php if ($edit_blog != 0): ?>
        <a href="<?php echo url( config( 'constant.smAdminSlug' ) . '/blogs' ); ?>/<?php echo $blog->id; ?>/edit"
           title="Edit" class="btn btn-xs btn-default" id="">
            <i class="fa fa-pencil"></i>
        </a>
		<?php endif; ?>
		<?php if ($delete_blog != 0): ?>
        <a href="<?php echo url( config( 'constant.smAdminSlug' ) . '/blogs/delete' ); ?>/<?php echo $blog->id; ?>"
           title="Delete" class="btn btn-xs btn-default delete_data_row"
           delete_message="'Are you sure to delete this blog post?'"
           delete_row="tr_{{$blog->id}}"
        >
            <i class="fa fa-times"></i>
        </a>
		<?php endif; ?>
    </td>
	<?php endif; ?>
</tr>
<?php
$sl ++;
}
}
?>
