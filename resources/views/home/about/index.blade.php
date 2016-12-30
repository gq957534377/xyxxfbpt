@extends('home.layouts.master')

@section('menu')
    @parent
@endsection

@section('content')
<div class="container-fluid bgc-1">
    <div class="container mar-emt15 mar-b30">
        <div class="col-lg-offset-1 col-lg-10 b-all-1 pad-clr qili-about-us">
            <ul class="col-lg-2 pad-clr">
                <li class="mar-emt30"><p>About</p></li>
                <li>
                    <p>关于我们</p>
                </li>
                <li>
                    <p>免责条款</p>
                </li>
                <li>
                    <p>版权声明</p>
                </li>
            </ul>
            <div class="bgc-0 b-all-1 col-lg-10 pad-clr">
                <p>关于我们</p>
                <span>1111111111111111</span>
            </div>
            <div class="bgc-0 hidden col-lg-10 pad-clr">
                <p>免责条款</p>
                <span>2222222222222222</span>
            </div>
            <div class="bgc-0 hidden col-lg-10 pad-clr">
                <p>版权声明</p>
                <span>333333333333333333</span>
            </div>
        </div>
    </div>
</div>
@endsection
