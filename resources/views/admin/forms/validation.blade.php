@extends('admin.layouts.master')
@section('content')
@section('title', '功能测试')
<div class="wraper container-fluid">
    <div class="page-title">
        <h3 class="title">Form Validation</h3>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading"><h3 class="panel-title">Form validations</h3></div>
                <div class="panel-body">
                    <div class=" form p-20">
                        <form class="cmxform form-horizontal tasi-form" id="commentForm" method="get" action="#" novalidate="novalidate">
                            <div class="form-group ">
                                <label for="cname" class="control-label col-lg-2">Name (required)</label>
                                <div class="col-lg-10">
                                    <input class=" form-control" id="cname" name="name" type="text" required="" aria-required="true">
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="cemail" class="control-label col-lg-2">E-Mail (required)</label>
                                <div class="col-lg-10">
                                    <input class="form-control " id="cemail" type="email" name="email" required="" aria-required="true">
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="curl" class="control-label col-lg-2">URL (optional)</label>
                                <div class="col-lg-10">
                                    <input class="form-control " id="curl" type="url" name="url">
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="ccomment" class="control-label col-lg-2">Your Comment (required)</label>
                                <div class="col-lg-10">
                                    <textarea class="form-control " id="ccomment" name="comment" required="" aria-required="true"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-offset-2 col-lg-10">
                                    <button class="btn btn-success" type="submit">Save</button>
                                    <button class="btn btn-default" type="button">Cancel</button>
                                </div>
                            </div>
                        </form>
                    </div> <!-- .form -->
                </div> <!-- panel-body -->
            </div> <!-- panel -->
        </div> <!-- col -->

    </div> <!-- End row -->


    <!-- Form-validation -->
    <div class="row">

        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading"><h3 class="panel-title">Form validations</h3></div>
                <div class="panel-body">
                    <div class=" form">
                        <form class="cmxform form-horizontal tasi-form" id="signupForm" method="get" action="#" novalidate="novalidate">
                            <div class="form-group ">
                                <label for="firstname" class="control-label col-lg-2">Firstname *</label>
                                <div class="col-lg-10">
                                    <input class=" form-control" id="firstname" name="firstname" type="text">
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="lastname" class="control-label col-lg-2">Lastname  *</label>
                                <div class="col-lg-10">
                                    <input class=" form-control" id="lastname" name="lastname" type="text">
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="username" class="control-label col-lg-2">Username *</label>
                                <div class="col-lg-10">
                                    <input class="form-control " id="username" name="username" type="text">
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="password" class="control-label col-lg-2">Password *</label>
                                <div class="col-lg-10">
                                    <input class="form-control " id="password" name="password" type="password">
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="confirm_password" class="control-label col-lg-2">Confirm Password *</label>
                                <div class="col-lg-10">
                                    <input class="form-control " id="confirm_password" name="confirm_password" type="password">
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="email" class="control-label col-lg-2">Email *</label>
                                <div class="col-lg-10">
                                    <input class="form-control " id="email" name="email" type="email">
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="agree" class="control-label col-lg-2 col-sm-3">Agree to Our Policy *</label>
                                <div class="col-lg-10 col-sm-9">
                                    <input type="checkbox" style="width: 16px" class="checkbox form-control" id="agree" name="agree">
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="newsletter" class="control-label col-lg-2 col-sm-3">Receive the Newsletter</label>
                                <div class="col-lg-10 col-sm-9">
                                    <input type="checkbox" style="width: 16px" class="checkbox form-control" id="newsletter" name="newsletter">
                                </div>
                            </div>


                            <div class="form-group">
                                <div class="col-lg-offset-2 col-lg-10">
                                    <button class="btn btn-success" type="submit">Save</button>
                                    <button class="btn btn-default" type="button">Cancel</button>
                                </div>
                            </div>
                        </form>
                    </div> <!-- .form -->

                </div> <!-- panel-body -->
            </div> <!-- panel -->
        </div> <!-- col -->

    </div> <!-- End row -->


</div>
@endsection
@section('script')
    <!--form validation-->
    <script type="text/javascript" src="http://cdn.rooyun.com/js/jquery.validate.min.js"></script>

    <!--form validation init-->
    <script src="http://cdn.rooyun.com/js/form-validation-init.js"></script>
@endsection