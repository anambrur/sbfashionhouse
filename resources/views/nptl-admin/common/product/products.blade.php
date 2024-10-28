<?php
/**
 * Created by PhpStorm.
 * User: mrksohag
 * Date: 1/3/18
 * Time: 5:22 PM
 */
?>
<?php
if ($all_product)
{
$edit_product = SM::check_this_method_access( 'products', 'edit' ) ? 1 : 0;
$product_status_update = SM::check_this_method_access( 'products', 'product_status_update' ) ? 1 : 0;
$delete_product = SM::check_this_method_access( 'products', 'delete' ) ? 1 : 0;
$per = $edit_product + $delete_product;
$sl = 1;
foreach ($all_product as $product)
{
?>
<tr id="tr_{{$product->id}}">
    <td><?php echo $sl; ?></td>
    <td><?php echo $product->title; ?></td>
    <td>
        @if(count($product->categories)>0)
            @foreach($product->categories as $cat)
                @if($loop->iteration>1)
                    {{", "}}
                @endif
                {{$cat->title}}
            @endforeach
        @endif
    </td>
    <td>
        @if(count($product->attributes)>0)
            @foreach($product->attributes as $cat1)
                @if($loop->iteration>1)
                    {{", "}}
                @endif
                {{$cat1->title}}
            @endforeach
        @endif
    </td>

    <td><?php echo $product->brand->title; ?></td>
    <td>
        <img class="img-product"
             src="<?php echo SM::sm_get_the_src( $product->image, 80, 80 ); ?>"
             width="80px"
             alt="<?php echo $product->title; ?>"/>
    </td>
     <td><?php echo $product->views; ?></td>
     <td><?php echo count($product->reviews); ?></td>
	<?php if ($product_status_update != 0): ?>
    <td class="text-center">
        <select class="form-control change_status"
                route="<?php echo config( 'constant.smAdminSlug' ); ?>/product_status_update"
                post_id="<?php echo $product->id; ?>">
            <option value="1" <?php
				if ( $product->status == 1 ) {
					echo 'Selected="Selected"';
				}
				?>>Published
            </option>
            <option value="2" <?php
				if ( $product->status == 2 ) {
					echo 'Selected="Selected"';
				}
				?>>Pending
            </option>
            <option value="3" <?php
				if ( $product->status == 3 ) {
					echo 'Selected="Selected"';
				}
				?>>Canceled
            </option>
        </select>
    </td>
	<?php endif; ?>
	<?php if ($per != 0): ?>
    <td class="text-center">
        <a target="_blank" href="<?php echo url( '/product/' . $product->slug ); ?>" title="View"
           class="btn btn-xs btn-success" id="">
            <i class="fa fa-eye"></i>
        </a>
		<?php if ($edit_product != 0): ?>
        <a href="<?php echo url( config( 'constant.smAdminSlug' ) . '/products' ); ?>/<?php echo $product->id; ?>/edit"
           title="Edit" class="btn btn-xs btn-default" id="">
            <i class="fa fa-pencil"></i>
        </a>
		<?php endif; ?>
		<?php if ($delete_product != 0): ?>
        <a href="<?php echo url( config( 'constant.smAdminSlug' ) . '/products/delete' ); ?>/<?php echo $product->id; ?>"
           title="Delete" class="btn btn-xs btn-default delete_data_row"
           delete_message="'Are you sure to delete this product post?'"
           delete_row="tr_{{$product->id}}"
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
