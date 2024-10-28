@extends('nptl-admin/master')
@section('title','Product Import')
@section('content')
    <section id="widget-grid" class="">
    <?php
    $edit_product = SM::check_this_method_access('products', 'edit') ? 1 : 0;
    $product_status_update = SM::check_this_method_access('products', 'product_status_update') ? 1 : 0;
    $delete_product = SM::check_this_method_access('products', 'delete') ? 1 : 0;
    $per = $edit_product + $delete_product;
    ?>
    <!-- row -->
        <div class="row">

            <!-- NEW WIDGET START -->
            <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

                <!-- Widget ID (each widget will need unique ID)-->
                <div class="jarviswidget" id="product_list_wid">
                    <header>
                        <span class="widget-icon"> <i class="fa fa-download"></i> </span>
                        <!--<h2>Product Import </h2>-->
                    </header>

                    <!-- widget div-->
                    <div>

                        <!-- widget edit box -->
                        <div class="jarviswidget-editbox">
                            <!-- This area used as dropdown edit box -->
                            <input class="form-control" type="text">
                        </div>
                        <!-- end widget edit box -->

                        <!-- widget content -->
                        <div class="widget-body table-responsive">
                            <!-- this is what the user will see -->
                            <div class="col-sm-12">
                                <div class="box">
                                    <div class="box-body">
                                        {!! Form::open(array('route'=>'import_csv','method'=>'POST', 'files'=>true)) !!}
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="col-sm-4">
                                                    <div class="sm-form form-group {{ $errors->has('import_file') ? ' has-error' : '' }}">
                                                        {{ Form::label('import_file', 'File To Import(CSV):', array('class' => 'requiredStar')) }}
                                                        {!! Form::file('import_file', null,['class'=>'form-control', 'required', 'accept'=>'.csv']) !!}
                                                        @if ($errors->has('import_file'))
                                                            <span class="help-block dark-red">
                                                              <strong>{{ $errors->first('import_file') }}</strong>
                                                           </span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <br>
                                                    <button type="submit" class="btn btn-primary">Submit</button>
                                                </div>
                                            </div>
                                        </div>
                                        {!! Form::close() !!}

                                        <br><br>
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <a href="{{ asset('uploads/files/import_products_csv_template.csv') }}"
                                                   class="btn btn-success" download=""><i class="fa fa-download"></i>
                                                    Download CSV file template</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="box box-solid">
                                    <div class="box-header">
                                        <h3 class="box-title">Instructions</h3>
                                    </div>
                                    <div class="box-body">
                                        <strong>Follow the instructions carefully before importing the
                                            file.</strong><br>
                                        The columns of the CSV file should be in the following order. <br><br>
                                        <table class="table table-striped">
                                            <tbody>
                                            <tr>
                                                <th>Column Number</th>
                                                <th>Column Name</th>
                                                <th>Instruction</th>
                                            </tr>
                                            <tr>
                                                <td>1</td>
                                                <td>Product Name
                                                    <small class="text-muted requiredStar">(Required)</small>
                                                </td>
                                                <td>Name of the product</td>
                                            </tr>
                                            <tr>
                                                <td>2</td>
                                                <td>Product Short Description
                                                    <small class="text-muted">(Optional)</small>
                                                </td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td>3</td>
                                                <td>Product Long Description
                                                    <small class="text-muted">(Optional)</small>
                                                </td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td>4</td>
                                                <td>Image
                                                    <small class="text-muted requiredStar">(Required)</small>
                                                </td>
                                                <td>Image name with extension.<br> (Image name must be uploaded to the
                                                    server img )
                                                </td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td>5</td>
                                                <td>Image Gallery
                                                    <small class="text-muted">(Optional)</small>
                                                </td>
                                                <td>Image name with extension.<br> (Ex: simple1.png,simple2.png)
                                                </td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td>6</td>
                                                <td>SKU
                                                    <small class="text-muted requiredStar">(Required) (Unique)</small>
                                                </td>
                                                <td>Product SKU Required and Unique.
                                                    {{--If blank an SKU will be automatically generated--}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>7</td>
                                                <td>Stock Status
                                                    <small class="text-muted">(Optional)</small>
                                                </td>
                                                <td>Product Stock Status
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>8</td>
                                                <td>Tax Class
                                                    <small class="text-muted">(Optional)</small>
                                                </td>
                                                <td>Product Tax Class
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>9</td>
                                                <td>Regular Price
                                                    <small class="text-muted requiredStar">(Required)</small>
                                                </td>
                                                <td>Regular Price (Only in numbers)<br>(Ex: 84|85|88)
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>10</td>
                                                <td>Sale Price <br>
                                                    <small class="text-muted">(Optional)
                                                    </small>
                                                </td>
                                                <td>Sale Price (Only in numbers)<br>(Ex: 84|85|88)
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>11</td>
                                                <td>Category
                                                    <small class="text-muted requiredStar">(Required)</small>
                                                </td>
                                                <td>Name of the Category <br>
                                                    <strong>Currently supported: Category1,Category2</strong>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>12</td>
                                                <td>Product Type
                                                    <small class="text-muted">(Required)</small>
                                                </td>
                                                <td>Product Type <br>
                                                    <strong>Available Options: Simple, Variable</strong>

                                                </td>
                                            </tr>
                                            <tr>
                                                <td>13</td>
                                                <td>IF Product type Variable
                                                    <small class="text-muted requiredStar">(Required if product type is variable)
                                                    </small>
                                                </td>
                                                <td>
                                                    <small>
                                                        (Ex: Color name:green,Size name:XL!Legnth_ 55& Front_ 75& Back_
                                                        88& Chest_ 36,Qty:5,Price:150,Image:example1.png|
                                                        Color name:green,Size name:XL!Legnth_ 22& Front_ 33& Back_ 44&
                                                        Chest_ 55,Qty:15,Price:250,Image:example2.png)
                                                        <br>
                                                        (Ex: green,S!Legnth_55& Front_ 75& Back_ 88& Chest_
                                                        36,11,111.00,example1.png|
                                                        Variable,M!Legnth_22& Front_ 33& Back_ 44& Chest_
                                                        55,22,222.00,example2.png)
                                                    </small>
                                                <td>
                                            </tr>
                                            <tr>
                                                <td>14</td>
                                                <td>Brand
                                                    <small class="text-muted requiredStar">(Required)</small>
                                                </td>
                                                <td>Name of the brand <br>
                                                    {{--<small class="text-muted">(If not found new brand with the given--}}
                                                    {{--name will be created)--}}
                                                    {{--</small>--}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>15</td>
                                                <td>Product Qty
                                                    <small class="text-muted">(Optional)</small>
                                                </td>
                                                <td>Product Qty (Only in numbers) <br>(Ex: 100|150|200)<br>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>16</td>
                                                <td>Alert quantity
                                                    <small class="text-muted">(Required if Manage Stock is 1)</small>
                                                </td>
                                                <td>Alert quantity</td>
                                            </tr>
                                            <tr>
                                                <td>17</td>
                                                <td>Weight
                                                    <small class="text-muted">(Optional)</small>
                                                </td>
                                                <td>Optional<br>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>18</td>
                                                <td>Product Model
                                                    <small class="text-muted">(Optional)</small>
                                                </td>
                                                <td>Optional<br>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>19</td>
                                                <td>Unit
                                                    <small class="text-muted requiredStar">(Required)</small>
                                                </td>
                                                <td>Name of the unit</td>
                                            </tr>
                                            <tr>
                                                <td>20</td>
                                                <td>Total views
                                                    <small class="text-muted">(Optional)</small>
                                                </td>
                                                <td>Optional<br>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>21</td>
                                                <td>Product tag
                                                    <small class="text-muted">(Optional)</small>
                                                </td>
                                                <td>Name of the Product tag <br>
                                                    <strong>Currently supported: Tag1,Tag2</strong>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>22</td>
                                                <td>Seo Title
                                                    <small class="text-muted">(Optional)</small>
                                                </td>
                                                <td>Optional<br>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>23</td>
                                                <td>Meta Key
                                                    <small class="text-muted">(Optional)</small>
                                                </td>
                                                <td>Optional<br>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>24</td>
                                                <td>Meta Description
                                                    <small class="text-muted">(Optional)</small>
                                                </td>
                                                <td>Optional<br>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>25</td>
                                                <td>Status
                                                    <small class="text-muted requiredStar">(Required)</small>
                                                </td>
                                                <td>Enable or disable Product<br>
                                                    <strong>Available Options: Published, Pending, Cancel</strong></td>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end widget content -->
                    </div>
                    <!-- end widget div -->

                </div>
                <!-- end widget -->

            </article>
            <!-- WIDGET END -->

        </div>

        <!-- end row -->

    </section>
@endsection
