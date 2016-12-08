@extends('admin.layouts.master')

<link href="http://cdn.rooyun.com/css/jquery.nestable.css" rel="stylesheet" />

@section('content')
@section('title', '可折叠列表')
<div class="wraper container-fluid">
    <div class="page-title">
        <h3 class="title">Nestable Lists</h3>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="text-center" id="nestable_list_menu">
                <button type="button" class="btn btn-pink" data-action="expand-all">Expand All</button>
                <button type="button" class="btn btn-purple" data-action="collapse-all">Collapse All</button>
            </div>
        </div>
    </div>
    <!-- End row -->

    <div class="row">
        <div class="col-lg-12">
            <div>
                <h4 class="text-muted">Serialised Output (per list)</h4>
            </div>

            <div class="row">
                <div class="col-lg-6">
                    <textarea id="nestable_list_1_output" class=" col-lg-12 form-control"></textarea>
                </div>
                <div class="col-lg-6">
                    <textarea id="nestable_list_2_output" class=" col-lg-12 form-control"></textarea>
                </div>
            </div>
        </div>
    </div><!-- end row -->

    <br>

    <div class="row">
        <div class="col-sm-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Nestable Lists 1</h3>
                </div>
                <div class="panel-body">
                    <div class="dd custom-dd" id="nestable_list_1">
                        <ol class="dd-list">
                            <li class="dd-item" data-id="1">
                                <div class="dd-handle">Item 1</div>
                            </li>
                            <li class="dd-item" data-id="2">
                                <div class="dd-handle">Item 2</div>
                                <ol class="dd-list">
                                    <li class="dd-item" data-id="3">
                                        <div class="dd-handle">Item 3</div>
                                    </li>
                                    <li class="dd-item" data-id="4">
                                        <div class="dd-handle">Item 4</div>
                                    </li>
                                    <li class="dd-item" data-id="5">
                                        <div class="dd-handle">Item 5</div>
                                        <ol class="dd-list">
                                            <li class="dd-item" data-id="6">
                                                <div class="dd-handle">Item 6</div>
                                            </li>
                                            <li class="dd-item" data-id="7">
                                                <div class="dd-handle">Item 7</div>
                                            </li>
                                            <li class="dd-item" data-id="8">
                                                <div class="dd-handle">Item 8</div>
                                            </li>
                                        </ol>
                                    </li>
                                    <li class="dd-item" data-id="9">
                                        <div class="dd-handle">Item 9</div>
                                    </li>
                                    <li class="dd-item" data-id="10">
                                        <div class="dd-handle">Item 10</div>
                                    </li>
                                </ol>
                            </li>
                            <li class="dd-item" data-id="11">
                                <div class="dd-handle">Item 11</div>
                            </li>
                            <li class="dd-item" data-id="12">
                                <div class="dd-handle">Item 12</div>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Nestable Lists 2</h3>
                </div>
                <div class="panel-body">
                    <div class="dd custom-dd" id="nestable_list_2">
                        <ol class="dd-list">
                            <li class="dd-item" data-id="13">
                                <div class="dd-handle">Item 13</div>
                            </li>
                            <li class="dd-item" data-id="14">
                                <div class="dd-handle">Item 14</div>
                            </li>
                            <li class="dd-item" data-id="15">
                                <div class="dd-handle">Item 15</div>
                                <ol class="dd-list">
                                    <li class="dd-item" data-id="16">
                                        <div class="dd-handle">Item 16</div>
                                    </li>
                                    <li class="dd-item" data-id="17">
                                        <div class="dd-handle">Item 17</div>
                                    </li>
                                    <li class="dd-item" data-id="18">
                                        <div class="dd-handle">Item 18</div>
                                    </li>
                                </ol>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End of row -->



    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Nestable Lists 3</h3>
                </div>
                <div class="panel-body">
                    <div class="dd custom-dd-empty" id="nestable_list_3">
                        <ol class="dd-list">
                            <li class="dd-item dd3-item" data-id="13">
                                <div class="dd-handle dd3-handle"></div>
                                <div class="dd3-content">Item 13</div>
                            </li>
                            <li class="dd-item dd3-item" data-id="14">
                                <div class="dd-handle dd3-handle"></div>
                                <div class="dd3-content">Item 14</div>
                            </li>
                            <li class="dd-item dd3-item" data-id="15">
                                <div class="dd-handle dd3-handle"></div>
                                <div class="dd3-content">Item 15</div>
                                <ol class="dd-list">
                                    <li class="dd-item dd3-item" data-id="16">
                                        <div class="dd-handle dd3-handle"></div>
                                        <div class="dd3-content">Item 16</div>
                                    </li>
                                    <li class="dd-item dd3-item" data-id="17">
                                        <div class="dd-handle dd3-handle"></div>
                                        <div class="dd3-content">Item 17</div>
                                    </li>
                                    <li class="dd-item dd3-item" data-id="18">
                                        <div class="dd-handle dd3-handle"></div>
                                        <div class="dd3-content">Item 18</div>
                                    </li>
                                </ol>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- End row -->

</div>
@endsection
@section('script')
    <script src="http://cdn.rooyun.com/js/jquery.nestable.js"></script>
    <script src="http://cdn.rooyun.com/js/nestable.js"></script>
@endsection