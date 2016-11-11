@extends('admin.layouts.master')
@section('content')
@section('title', '功能测试')
<div class="wraper container-fluid">
    <div class="page-title">
        <h3 class="title">Buttons</h3>
    </div>

    <!-- Row start -->
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Default Buttons</h3>
                </div>
                <div class="panel-body">
                    <button type="button" class="btn btn-default m-b-5">.btn-default</button>
                    <button type="button" class="btn btn-primary m-b-5">.btn-primary</button>
                    <button type="button" class="btn btn-success m-b-5">.btn-success</button>
                    <button type="button" class="btn btn-info m-b-5">.btn-info</button>
                    <button type="button" class="btn btn-warning m-b-5">.btn-warning</button>
                    <button type="button" class="btn btn-danger m-b-5">.btn-danger</button>
                    <button type="button" class="btn btn-inverse m-b-5">.btn-inverse</button>
                    <button type="button" class="btn btn-purple m-b-5">.btn-purple</button>
                    <button type="button" class="btn btn-pink m-b-5">.btn-pink</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Row -->

    <!-- Row start -->
    <div class="row">

        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Button-Rounded</h3>
                </div>
                <div class="panel-body">
                    <button type="button" class="btn btn-default btn-rounded m-b-5">.btn-default</button>
                    <button type="button" class="btn btn-primary btn-rounded m-b-5">.btn-primary</button>
                    <button type="button" class="btn btn-success btn-rounded m-b-5">.btn-success</button>
                    <button type="button" class="btn btn-info btn-rounded m-b-5">.btn-info</button>
                    <button type="button" class="btn btn-warning btn-rounded m-b-5">.btn-warning</button>
                    <button type="button" class="btn btn-danger btn-rounded m-b-5">.btn-danger</button>
                    <button type="button" class="btn btn-inverse btn-rounded m-b-5">.btn-inverse</button>
                    <button type="button" class="btn btn-purple btn-rounded m-b-5">.btn-purple</button>
                    <button type="button" class="btn btn-pink btn-rounded m-b-5">.btn-pink</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End row -->

    <!-- Row start -->
    <div class="row">
        <div class="col-lg-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Button-Width</h3>
                </div>
                <div class="panel-body">
                    <button type="button" class="btn btn-primary w-xs m-b-5">Xs</button>
                    <button type="button" class="btn btn-purple w-sm m-b-5">Small</button>
                    <button type="button" class="btn btn-info w-md m-b-5">Middle</button>
                    <button type="button" class="btn btn-warning w-lg m-b-5">Large</button>

                </div>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Button-Sizes</h3>
                </div>
                <div class="panel-body">
                    <button class="btn btn-primary btn-lg m-b-5">Large button</button>
                    <button class="btn btn-danger m-b-5">Normal button</button>
                    <button class="btn btn-success btn-sm m-b-5">Small button</button>
                    <button class="btn btn-purple btn-xs m-b-5">Extra small button</button>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Button-Disabled</h3>
                </div>
                <div class="panel-body">
                    <button class="btn btn-info disabled m-b-5">Info</button>
                    <button class="btn btn-purple disabled m-b-5">Purple</button>
                    <button class="btn btn-pink disabled m-b-5">Pink</button>
                    <button class="btn btn-inverse disabled m-b-5">Inverse</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End row-->

    <!-- Row start -->
    <div class="row">
        <div class="col-lg-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Icon Button</h3>
                </div>
                <div class="panel-body">
                    <button class="btn btn-icon btn-default m-b-5"> <i class="fa fa-heart-o"></i> </button>
                    <button class="btn btn-icon btn-danger m-b-5"> <i class="fa fa-remove"></i> </button>
                    <button class="btn btn-icon btn-purple m-b-5"> <i class="fa fa-music"></i> </button>
                    <button class="btn btn-icon btn-primary m-b-5"> <i class="fa fa-star"></i> </button>
                    <button class="btn btn-icon btn-success m-b-5"> <i class="fa fa-thumbs-o-up"></i> </button>
                    <button class="btn btn-icon btn-info m-b-5"> <i class="fa fa-keyboard-o"></i> </button>
                    <button class="btn btn-icon btn-warning m-b-5"> <i class="fa fa-wrench"></i> </button>
                    <br>
                    <button class="btn btn-default m-b-5"> <i class="fa fa-heart"></i> <span>Like</span> </button>
                    <button class="btn btn-inverse m-b-5"> <i class="fa fa-envelope-o"></i> <span>Share</span> </button>
                    <button class="btn btn-warning m-b-5"> <i class="fa fa-rocket"></i> <span>Launch</span> </button>
                    <button class="btn btn-info m-b-5"> <i class="fa fa-cloud"></i> <span>Cloud Hosting</span> </button>
                    <button class="btn btn-pink m-b-5"> <span>Book Flight</span> <i class="fa fa-plane"></i> </button>
                    <button class="btn btn-purple m-b-5"> <span>Donate Money</span> <i class="fa fa-money"></i> </button>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Block Button</h3>
                </div>
                <div class="panel-body">
                    <button type="button" class="btn btn-block btn-lg btn-primary">Block Button</button>
                    <button type="button" class="btn btn-block btn--md btn-pink">Block Button</button>
                    <button type="button" class="btn btn-block btn-sm btn-success">Block Button</button>
                    <button type="button" class="btn btn-block btn-xs btn-purple">Block Button</button>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Button Group</h3>
                </div>
                <div class="panel-body">
                    <div class="btn-group m-b-10">
                        <button type="button" class="btn btn-default">Left</button>
                        <button type="button" class="btn btn-default">Middle</button>
                        <button type="button" class="btn btn-default">Right</button>
                    </div>
                    <br>
                    <div class="btn-group btn-group-justified m-b-10">
                        <a class="btn btn-primary" role="button">Left</a>
                        <a class="btn btn-warning" role="button">Middle</a>
                        <a class="btn btn-danger" role="button">Right</a>
                    </div>
                    <div class="btn-group m-b-10">
                        <button type="button" class="btn btn-default">1</button>
                        <button type="button" class="btn btn-default">2</button>
                        <button type="button" class="btn btn-inverse">3</button>
                        <button type="button" class="btn btn-default">4</button>
                    </div>
                    <div class="btn-group m-b-10">
                        <button type="button" class="btn btn-default">5</button>
                        <button type="button" class="btn btn-inverse">6</button>
                        <button type="button" class="btn btn-default">7</button>
                    </div>
                    <div class="btn-group m-b-10">
                        <button type="button" class="btn btn-default">8</button>
                    </div>
                    <br>
                    <div class="btn-group m-b-10">
                        <button type="button" class="btn btn-default">1</button>
                        <button type="button" class="btn btn-primary">2</button>
                        <button type="button" class="btn btn-default">3</button>
                        <div class="btn-group">
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false"> Dropdown <span class="caret"></span> </button>
                            <ul class="dropdown-menu">
                                <li><a href="#">Dropdown link 1</a></li>
                                <li><a href="#">Dropdown link 2</a></li>
                                <li><a href="#">Dropdown link 3</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="btn-group-vertical m-b-10">
                                <button type="button" class="btn btn-default">Top</button>
                                <button type="button" class="btn btn-default">Middle</button>
                                <button type="button" class="btn btn-default">Bottom</button>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="btn-group-vertical m-b-10">
                                <button type="button" class="btn btn-default">Button 1</button>
                                <button type="button" class="btn btn-default">Button 2</button>
                                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false"> Button 3 <span class="caret"></span> </button>
                                <ul class="dropdown-menu">
                                    <li><a href="#">Dropdown link 1</a></li>
                                    <li><a href="#">Dropdown link 2</a></li>
                                    <li><a href="#">Dropdown link 3</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End row -->

    <!-- Row start -->
    <div class="row">
        <div class="col-lg-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Dropdown</h3>
                </div>
                <div class="panel-body">
                    <div class="btn-group">
                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="true">Dropdown <span class="caret"></span></button>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="#">Action</a></li>
                            <li><a href="#">Another action</a></li>
                            <li><a href="#">Something else here</a></li>
                            <li class="divider"></li>
                            <li><a href="#">Separated link</a></li>
                        </ul>
                    </div>
                    <div class="btn-group">
                        <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-expanded="true">Dropdown <span class="caret"></span></button>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="#">Action</a></li>
                            <li><a href="#">Another action</a></li>
                            <li><a href="#">Something else here</a></li>
                            <li class="divider"></li>
                            <li><a href="#">Separated link</a></li>
                        </ul>
                    </div>
                    <div class="btn-group">
                        <button type="button" class="btn btn-pink dropdown-toggle" data-toggle="dropdown" aria-expanded="true">Dropdown <span class="caret"></span></button>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="#">Action</a></li>
                            <li><a href="#">Another action</a></li>
                            <li><a href="#">Something else here</a></li>
                            <li class="divider"></li>
                            <li><a href="#">Separated link</a></li>
                        </ul>
                    </div>
                    <div class="btn-group">
                        <button type="button" class="btn btn-purple dropdown-toggle" data-toggle="dropdown" aria-expanded="true">Dropdown <span class="caret"></span></button>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="#">Action</a></li>
                            <li><a href="#">Another action</a></li>
                            <li><a href="#">Something else here</a></li>
                            <li class="divider"></li>
                            <li><a href="#">Separated link</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Split button dropdown</h3>
                </div>
                <div class="panel-body">
                    <div class="btn-group dropdown">
                        <button type="button" class="btn btn-success">Dropddown</button>
                        <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="caret"></i></button>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="#">Action</a></li>
                            <li><a href="#">Another action</a></li>
                            <li><a href="#">Something else here</a></li>
                            <li class="divider"></li>
                            <li><a href="#">Separated link</a></li>
                        </ul>
                    </div>
                    <div class="btn-group dropdown">
                        <button type="button" class="btn btn-primary">Dropddown</button>
                        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="caret"></i></button>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="#">Action</a></li>
                            <li><a href="#">Another action</a></li>
                            <li><a href="#">Something else here</a></li>
                            <li class="divider"></li>
                            <li><a href="#">Separated link</a></li>
                        </ul>
                    </div>
                    <div class="btn-group dropdown">
                        <button type="button" class="btn btn-default">Dropddown</button>
                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="caret"></i></button>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="#">Action</a></li>
                            <li><a href="#">Another action</a></li>
                            <li><a href="#">Something else here</a></li>
                            <li class="divider"></li>
                            <li><a href="#">Separated link</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- End row-->

    <!-- Row start -->
    <div class="row">

        <div class="col-lg-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Dropup</h3>
                </div>
                <div class="panel-body">
                    <div class="btn-group dropup">
                        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Dropdup <span class="caret"></span></button>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="#">Action</a></li>
                            <li><a href="#">Another action</a></li>
                            <li><a href="#">Something else here</a></li>
                            <li class="divider"></li>
                            <li><a href="#">Separated link</a></li>
                        </ul>
                    </div>
                    <div class="btn-group dropup">
                        <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Dropdup <span class="caret"></span></button>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="#">Action</a></li>
                            <li><a href="#">Another action</a></li>
                            <li><a href="#">Something else here</a></li>
                            <li class="divider"></li>
                            <li><a href="#">Separated link</a></li>
                        </ul>
                    </div>
                    <div class="btn-group dropup">
                        <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Dropdup <span class="caret"></span></button>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="#">Action</a></li>
                            <li><a href="#">Another action</a></li>
                            <li><a href="#">Something else here</a></li>
                            <li class="divider"></li>
                            <li><a href="#">Separated link</a></li>
                        </ul>
                    </div>
                    <div class="btn-group dropup">
                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Dropdup <span class="caret"></span></button>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="#">Action</a></li>
                            <li><a href="#">Another action</a></li>
                            <li><a href="#">Something else here</a></li>
                            <li class="divider"></li>
                            <li><a href="#">Separated link</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Split button dropup</h3>
                </div>
                <div class="panel-body">
                    <div class="fileUpload btn btn-primary">
                        <span>Upload</span>
                        <input type="file" class="upload" />
                    </div>
                    <div class="fileUpload btn btn-purple">
                        <span><i class="ion-upload m-r-5"></i>Upload</span>
                        <input type="file" class="upload" />
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End row -->

</div>
@endsection
@section('script')
@endsection