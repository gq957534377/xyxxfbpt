@extends('admin.layouts.master')
@section('content')
@section('title', '功能测试')
<div class="wraper container-fluid">
    <div class="page-title">
        <h3 class="title">Bootstrap-Elements</h3>
    </div>

    <div class="row">

        <!-- Popovers -->
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Popovers</h3>
                </div>
                <div class="panel-body">
                    <ul class="list-inline m-b-10">

                        <li>
                            <button type="button" class="btn btn-default" data-container="body" title="" data-toggle="popover" data-placement="top" data-content="Vivamus sagittis lacus vel augue laoreet rutrum faucibus.">
                                Popover on top
                            </button>
                        </li>

                        <li>
                            <button type="button" class="btn btn-default" data-container="body" title="" data-toggle="popover" data-placement="bottom" data-content="Vivamus
                                        sagittis lacus vel augue laoreet rutrum faucibus.">
                                Popover on bottom
                            </button>
                        </li>

                        <li>
                            <button type="button" class="btn btn-default" data-container="body" title="" data-toggle="popover" data-placement="right" data-content="Vivamus sagittis lacus vel augue laoreet rutrum faucibus.">
                                Popover on right
                            </button>
                        </li>

                        <li>
                            <button type="button" class="btn btn-default" data-container="body" title="" data-toggle="popover" data-placement="left" data-content="Vivamus sagittis lacus vel augue laoreet rutrum faucibus." data-original-title="Popover title">
                                Popover on left
                            </button>
                        </li>

                    </ul>
                    <button tabindex="0" class="btn btn-default" role="button" data-toggle="popover" data-trigger="focus" title="" data-content="And here's some amazing content. It's very engaging. Right?" data-original-title="Dismissible popover">Dismissible popover
                    </button>
                </div>  <!-- end panel-body -->
            </div> <!-- panel -->
        </div>

        <!-- Tooltips -->
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Tooltips</h3>
                </div>
                <div class="panel-body">
                    <ul class="list-inline">
                        <li><button type="button" class="btn btn-default tooltip-btn" data-toggle="tooltip" data-placement="left" title="" data-original-title="Tooltip on left">Tooltip on left</button></li>

                        <li><button type="button" class="btn btn-default tooltip-btn" data-toggle="tooltip" data-placement="top" title="" data-original-title="Tooltip on top">Tooltip on top</button></li>

                        <li><button type="button" class="btn btn-default tooltip-btn" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Tooltip on bottom">Tooltip on bottom</button></li>

                        <li><button type="button" class="btn btn-default tooltip-btn" data-toggle="tooltip" data-placement="right" title="" data-original-title="Tooltip on right">Tooltip on right</button></li>
                    </ul>
                </div>
            </div>
        </div>
    </div> <!-- End row-->




    <div class="row">
        <!-- Labels -->
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Labels</h3>
                </div>
                <div class="panel-body">
                    <p>
                        <span class="label label-default">Default</span>
                        <span class="label label-primary">Primary</span>
                        <span class="label label-success">Success</span>
                        <span class="label label-info">Info</span>
                        <span class="label label-warning">Warning</span>
                        <span class="label label-danger">Danger</span>
                        <span class="label label-purple">Purple</span>
                        <span class="label label-inverse">Inverse</span>
                        <span class="label label-pink">Pink</span>
                    </p>
                </div>
            </div>
        </div>

        <!-- Badge -->
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Badge</h3>
                </div>
                <div class="panel-body">
                    <p>
                        <span class="badge bg-primary">15</span>
                        <span class="badge bg-success">0</span>
                        <span class="badge bg-info">21</span>
                        <span class="badge bg-inverse">3</span>
                        <span class="badge bg-warning">35</span>
                        <span class="badge bg-danger">32</span>
                        <span class="badge bg-purple">51</span>
                        <span class="badge bg-pink">77</span>
                        <span class="badge">9</span>
                    </p>
                </div>
            </div>
        </div>
    </div> <!-- End row -->



    <div class="row">

        <!-- Standard Alert -->
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Standard Alert</h3>
                </div>
                <div class="panel-body">

                    <div class="alert alert-success">
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. <a href="#" class="alert-link">Alert Link</a>.
                    </div>
                    <div class="alert alert-info">
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. <a href="#" class="alert-link">Alert Link</a>.
                    </div>
                    <div class="alert alert-warning">
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. <a href="#" class="alert-link">Alert Link</a>.
                    </div>
                    <div class="alert alert-danger">
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. <a href="#" class="alert-link">Alert Link</a>.
                    </div>

                    <div class="alert alert-success fade in">
                        <h4>Big one!</h4>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit. Cras mattis consectetur purus sit amet fermentum.</p>
                        <p>
                            <button type="button" class="btn btn-success">Wanna do this</button>
                            <button type="button" class="btn btn-default">Or do this</button>
                        </p>
                    </div>
                </div>  <!-- Panel-body -->
            </div> <!-- Panel-->
        </div>

        <div class="col-md-6">

            <!-- Dismissable Alert -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Dismissable Alert</h3>
                </div>
                <div class="panel-body">
                    <div class="alert alert-success alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. <a href="#" class="alert-link">Alert Link</a>.
                    </div>
                    <div class="alert alert-info alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. <a href="#" class="alert-link">Alert Link</a>.
                    </div>
                    <div class="alert alert-warning alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. <a href="#" class="alert-link">Alert Link</a>.
                    </div>
                    <div class="alert alert-danger alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. <a href="#" class="alert-link">Alert Link</a>.
                    </div>

                    <div class="alert alert-info fade in">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h4>Big one!</h4>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit. Cras mattis consectetur purus sit amet fermentum.</p>
                        <p>
                            <button type="button" class="btn btn-info">Wanna do this</button>
                            <button type="button" class="btn btn-default">Or do this</button>
                        </p>
                    </div>
                </div> <!-- Panel-body -->
            </div> <!-- panel -->
        </div> <!-- col -->
    </div> <!-- End row -->



    <div class="row">

        <!-- Pagination -->
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Pagination</h3>
                </div>
                <div class="panel-body">
                    <ul class="pagination m-b-5">
                        <li>
                            <a href="#" aria-label="Previous">
                                <i class="fa fa-angle-left"></i>
                            </a>
                        </li>
                        <li><a href="#">1</a></li>
                        <li class="active"><a href="#">2</a></li>
                        <li><a href="#">3</a></li>
                        <li class="disabled"><a href="#">4</a></li>
                        <li><a href="#">5</a></li>
                        <li>
                            <a href="#" aria-label="Next">
                                <i class="fa fa-angle-right"></i>
                            </a>
                        </li>
                    </ul>


                    <div class="clear"></div>

                    <ul class="pagination pagination-sm">
                        <li> <a href="#"> <i class="fa fa-angle-left"></i> </a> </li>
                        <li> <a href="#">1</a> </li>
                        <li class="active"> <a href="#">2</a> </li>
                        <li> <a href="#">3</a> </li>
                        <li class="disabled"> <a href="#">4</a> </li>
                        <li> <a href="#">5</a> </li>
                        <li> <a href="#">6</a> </li>
                        <li> <a href="#"> <i class="fa fa-angle-right"></i> </a> </li>
                    </ul>

                    <div class="clear"></div>

                    <ul class="pagination pagination-lg m-0">
                        <li> <a href="#"> <i class="fa fa-angle-left"></i> </a> </li>
                        <li> <a href="#">1</a> </li>
                        <li class="active"> <a href="#">2</a> </li>
                        <li> <a href="#">3</a> </li>
                        <li> <a href="#">4</a> </li>
                        <li> <a href="#"> <i class="fa fa-angle-right"></i> </a> </li>
                    </ul>

                </div> <!-- panel-body -->
            </div> <!-- panel -->
        </div>


        <!-- Pagers -->
        <div class="col-sm-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="panel-title">Pagers</div>
                </div>
                <div class="panel-body">
                    <ul class="pager">
                        <li>
                            <a href="#"> <i class="fa fa-angle-double-left"></i> Previous</a>
                        </li>
                        <li>
                            <a href="#">Next <i class="fa fa-angle-double-right"></i> </a>
                        </li>
                    </ul>
                    <ul class="pager">
                        <li class="previous">
                            <a href="#"> <i class="fa fa-long-arrow-left"></i> </a>
                        </li>
                        <li class="next">
                            <a href="#"> <i class="fa fa-long-arrow-right"></i> </a>
                        </li>
                    </ul>
                    <ul class="pager">
                        <li class="previous disabled">
                            <a href="#"><i class="fa fa-long-arrow-left"></i> Previous</a>
                        </li>
                        <li class="next">
                            <a href="#">Next <i class="fa fa-long-arrow-right"></i></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

    </div> <!-- End row -->


    <!-- List Groups -->
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">List Groups</h3>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h5>Simple List Group</h5>
                            <ul class="list-group">
                                <li class="list-group-item">
                                    <span class="badge bg-primary">14</span>
                                    Cras justo odio
                                </li>
                                <li class="list-group-item">
                                    <span class="badge bg-purple">2</span>
                                    Dapibus ac facilisis in
                                </li>
                                <li class="list-group-item">
                                    <span class="badge bg-pink">1</span>
                                    Morbi leo risus
                                </li>
                                <li class="list-group-item">
                                    <span class="badge bg-inverse">1</span>
                                    Morbi leo risus
                                </li>
                                <li class="list-group-item">
                                    <span class="badge bg-success">1</span>
                                    Morbi leo risus
                                </li>
                            </ul>
                        </div>

                        <div class="col-md-6">
                            <h5>List Group with Links</h5>
                            <div class="list-group">
                                <a href="#" class="list-group-item active">
                                    Cras justo odio
                                </a>
                                <a href="#" class="list-group-item">Dapibus ac facilisis in</a>
                                <a href="#" class="list-group-item">Morbi leo risus</a>
                                <a href="#" class="list-group-item disabled">Porta ac consectetur ac</a>
                                <a href="#" class="list-group-item">Vestibulum at eros</a>
                            </div> <!-- list-group -->
                        </div> <!-- col -->
                    </div> <!-- end row -->
                </div> <!-- panel-body -->
            </div> <!-- panel -->
        </div> <!-- col -->
    </div> <!-- End row -->



    <!-- List Group with Description -->
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">List Group with Description</h3>
                </div>
                <div class="panel-body">
                    <div class="list-group">
                        <a href="#" class="list-group-item active">
                            <h4 class="list-group-item-heading">Domestic confined any but son</h4>
                            <p class="list-group-item-text">Consider speaking me prospect whatever if. Ten nearer rather hunted six parish indeed number. Allowance repulsive sex may contained can set suspected abilities cordially. Do part am he high rest that. So fruit to ready it being views match. </p>
                        </a>
                        <a href="#" class="list-group-item disabled">
                            <h4 class="list-group-item-heading">Why painful the sixteen how minuter</h4>
                            <p class="list-group-item-text">Started his hearted any civilly. So me by marianne admitted speaking. Men bred fine call ask. Cease one miles truth day above seven. Suspicion sportsmen provision suffering mrs saw engrossed something. Snug soon he on plan in be dine some. </p>
                        </a>
                        <a href="#" class="list-group-item">
                            <h4 class="list-group-item-heading">Barton waited twenty always repair</h4>
                            <p class="list-group-item-text">Talking chamber as shewing an it minutes. Trees fully of blind do. Exquisite favourite at do extensive listening. Improve up musical welcome he. Gay attended vicinity prepared now diverted. Esteems it ye sending reached as. Longer lively her design settle tastes advice mrs off who. </p>
                        </a>
                    </div> <!-- list-group -->
                </div> <!-- Panel-body -->
            </div> <!-- panel -->
        </div> <!-- col -->
    </div> <!-- End row -->


</div>
@endsection
@section('script')

@endsection