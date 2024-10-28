<?php
/**
 * Created by PhpStorm.
 * User: mrksohag
 * Date: 1/3/18
 * Time: 6:26 PM
 */

$edit = SM::check_this_method_access( 'users', 'edit_role' ) ? 1 : 0;
$delete = SM::check_this_method_access( 'users', 'delete_role' ) ? 1 : 0;
$per = $edit + $delete;
if ($roles)
{
$sl = 1;
foreach ($roles as $role)
{
?>
<tr id="tr_{{$role->id}}">
    <td><?php echo $sl; ?></td>
    <td><?php echo $role->name; ?></td>


    <td>
		<?php
		if ( isset( $role->created_at ) && SM::sm_string( $role->created_at ) ) {
			echo date( 'd F, Y', strtotime( $role->created_at ) );
		}
		?>
    </td>

	<?php if ($per != 0): ?>
    <td class="text-center">
        @if($role->id!=1)
			<?php if ($edit != 0): ?>
            <a href="<?php echo url( config( 'constant.smAdminSlug' ) . '/users/edit_role' ); ?>/<?php echo $role->id; ?>"
               title="Edit" class="btn btn-xs btn-default" id="">
                <i class="fa fa-pencil"></i>
            </a>
			<?php endif; ?>
        @endif
        @if($role->id!=1)
			<?php if ($delete != 0): ?>
            <a href="<?php echo url( config( 'constant.smAdminSlug' ) . '/users/delete_role' ); ?>/<?php echo $role->id; ?>"
               title="Delete" class="btn btn-xs btn-default delete_data_row"
               delete_message="Are you sure to delete this user role?
If you delete this role then all rolled user account will be pending! You will need to assign this rolled user to other role."
               delete_row="tr_{{$role->id}}">
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
