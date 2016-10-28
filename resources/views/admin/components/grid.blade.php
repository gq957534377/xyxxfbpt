@extends('admin.layouts.master')
@section('content')
@section('title', '网格')
<div class="wraper container-fluid">
    <div class="page-title">
        <h3 class="title">Grid System</h3>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Grid Options</h3>
                </div>
                <div class="panel-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th></th>
                            <th>
                                Extra small devices
                                <small>Phones (&lt;768px)</small>
                            </th>
                            <th>
                                Small devices
                                <small>Tablets (≥768px)</small>
                            </th>
                            <th>
                                Medium devices
                                <small>Desktops (≥992px)</small>
                            </th>
                            <th>
                                Large devices
                                <small>Desktops (≥1200px)</small>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <th>Grid behavior</th>
                            <td>Horizontal at all times</td>
                            <td colspan="3">Collapsed to start, horizontal above breakpoints</td>
                        </tr>
                        <tr>
                            <th>Max container width</th>
                            <td>None (auto)</td>
                            <td>750px</td>
                            <td>970px</td>
                            <td>1170px</td>
                        </tr>
                        <tr>
                            <th>Class prefix</th>
                            <td><code>.col-xs-</code></td>
                            <td><code>.col-sm-</code></td>
                            <td><code>.col-md-</code></td>
                            <td><code>.col-lg-</code></td>
                        </tr>
                        <tr>
                            <th># of columns</th>
                            <td colspan="4">12</td>
                        </tr>
                        <tr>
                            <th>Max column width</th>
                            <td class="text-muted">Auto</td>
                            <td>60px</td>
                            <td>78px</td>
                            <td>95px</td>
                        </tr>
                        <tr>
                            <th>Gutter width</th>
                            <td colspan="4">30px (15px on each side of a column)</td>
                        </tr>
                        <tr>
                            <th>Nestable</th>
                            <td colspan="4">Yes</td>
                        </tr>
                        <tr>
                            <th>Offsets</th>
                            <td colspan="1" class="text-muted">N/A</td>
                            <td colspan="3">Yes</td>
                        </tr>
                        <tr>
                            <th>Column ordering</th>
                            <td class="text-muted">N/A</td>
                            <td colspan="3">Yes</td>
                        </tr>
                        </tbody>
                    </table>
                </div> <!-- Panel-body -->

            </div> <!-- Panel -->
        </div> <!-- col-->

    </div> <!-- End row -->


    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Grid Example</h3>
                </div>
                <div class="panel-body">
                    <div class="grid-structure">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="grid-container">
                                    col-md-12
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-11">
                                <div class="grid-container">
                                    col-md-11
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="grid-container">
                                    col-md-1
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-10">
                                <div class="grid-container">
                                    col-md-10
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="grid-container">
                                    col-md-2
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-9">
                                <div class="grid-container">
                                    col-md-9
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="grid-container">
                                    col-md-3
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="grid-container">
                                    col-md-8
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="grid-container">
                                    col-md-4
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-7">
                                <div class="grid-container">
                                    col-md-7
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="grid-container">
                                    col-md-5
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="grid-container">
                                    col-md-6
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="grid-container">
                                    col-md-6
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-5">
                                <div class="grid-container">
                                    col-md-5
                                </div>
                            </div>
                            <div class="col-md-7">
                                <div class="grid-container">
                                    col-md-7
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="grid-container">
                                    col-md-4
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="grid-container">
                                    col-md-8
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="grid-container">
                                    col-md-3
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="grid-container">
                                    col-md-9
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <div class="grid-container">
                                    col-md-2
                                </div>
                            </div>
                            <div class="col-md-10">
                                <div class="grid-container">
                                    col-md-10
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-1">
                                <div class="grid-container">
                                    col-md-1
                                </div>
                            </div>
                            <div class="col-md-11">
                                <div class="grid-container">
                                    col-md-11
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <div class="grid-container">
                                    col-md-2
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="grid-container">
                                    col-md-3
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="grid-container">
                                    col-md-4
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="grid-container">
                                    col-md-2
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="grid-container">
                                    col-md-1
                                </div>
                            </div>
                        </div> <!-- end row -->
                    </div> <!-- grid-structure -->
                </div> <!-- Panel-body -->
            </div> <!-- panel -->
        </div> <!-- Col -->
    </div> <!-- End row -->

</div>
@endsection
@section('script')
@endsection