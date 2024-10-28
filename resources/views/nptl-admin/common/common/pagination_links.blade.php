<?php
/**
 * Created by PhpStorm.
 * User: mrksohag
 * Date: 1/3/18
 * Time: 5:09 PM
 */
?>
<div id="smpagination_links">
    <div class="text-center">

        {!! $smPagination->appends(request()->input())->links() !!}
    </div>
</div>
