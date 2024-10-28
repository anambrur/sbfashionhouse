<?php
/**
 * Created by PhpStorm.
 * User: mrksohag
 * Date: 1/3/18
 * Time: 6:23 PM
 */

$edit = SM::check_this_method_access( 'users', 'edit_user' ) ? 1 : 0;
$status_update = SM::check_this_method_access( 'users', 'user_status_update' ) ? 1 : 0;
$delete = SM::check_this_method_access( 'users', 'delete_user' ) ? 1 : 0;
$per = $edit + $delete;
if ($users)
{
$sl = 1;
foreach ($users as $user)
{
?>
<tr id="tr_{{$user->id}}">
    <td><?php echo $sl; ?></td>
    <td><?= $user->role->name; ?></td>
    <td>
        <img class="img-blog"
             src="<?php echo SM::sm_get_the_src( $user->image, 80, 80 ); ?>"
             width="80px" alt="<?php echo $user->title; ?>"/>
    </td>
    <td>
		<?php
		echo $user->firstname . ' ' . $user->lastname;
		?>
    </td>
    <td><?php echo $user->username; ?></td>
    <td><?php echo $user->email; ?></td>
	<?php if ($status_update != 0): ?>
    <td class="text-center">
        @if($user->id!=1)
            <select class="form-control change_status"
                    route="<?php echo config( 'constant.smAdminSlug' ); ?>/users/user_status_update"
                    post_id="<?php echo $user->id; ?>">
                <option value="1" <?php
					if ( $user->status == 1 ) {
						echo 'Selected="Selected"';
					}
					?>>Approved
                </option>
                <option value="2" <?php
					if ( $user->status == 2 ) {
						echo 'Selected="Selected"';
					}
					?>>Pending
                </option>
                <option value="3" <?php
					if ( $user->status == 3 ) {
						echo 'Selected="Selected"';
					}
					?>>Canceled
                </option>
            </select>
        @else
            Approved
        @endif
    </td>
	<?php endif; ?>
	<?php if ($per != 0): ?>
    <td class="text-center">

		<?php if ($edit != 0): ?>
        <a href="<?php echo url( config( 'constant.smAdminSlug' ) . '/users/edit_user' ); ?>/<?php echo $user->id; ?>"
           title="Edit" class="btn btn-xs btn-default" id="">
            <i class="fa fa-pencil"></i>
        </a>
		<?php endif; ?>
        @if($user->id!=1)
			<?php if ($delete != 0): ?>
            <a href="<?php echo url( config( 'constant.smAdminSlug' ) . '/users/delete_user' ); ?>/<?php echo $user->id; ?>"
               title="Delete" class="btn btn-xs btn-default delete_data_row"
               delete_message="Are you sure to delete this User? This User all data will be delete."
               delete_row="tr_{{$user->id}}">
                <i class="fa fa-times"></i>
            </a>
			<?php endif; ?>
        @endif
    </td>
	<?php endif; ?>
</tr>
<?php
$sl ++;
}
}
?>
