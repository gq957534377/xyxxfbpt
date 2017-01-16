@extends('home.layouts.master')

@section('menu')
    @parent
@endsection

@section('content')
<div class="container-fluid bgc-1">
    <div class="container mar-emt15 mar-b30">
        <div class="col-sm-offset-1 col-sm-10 pad-clr qili-about-us">
            <ul class="col-sm-2 pad-clr">
                <li class="mar-emt30">
                    <p>About</p>
                </li>
                @if(!empty($type))
                <li class="@if($type == 1)qili-about-us-active @endif">
                    <p>关于我们</p>
                </li>
                <li class="@if($type == 2)qili-about-us-active @endif">
                    <p>免责条款</p>
                </li>
                <li class="@if($type == 3)qili-about-us-active @endif">
                    <p>版权声明</p>
                </li>
                @else
                    <li class="qili-about-us-active">
                        <p>关于我们</p>
                    </li>
                    <li>
                        <p>免责条款</p>
                    </li>
                    <li>
                        <p>版权声明</p>
                    </li>
                @endif
            </ul>
            @if(!empty($type))
                <div class="bgc-0 col-sm-10 pad-clr @if($type != 1)hidden @endif">
                    <p>关于我们</p>
                    <img class="img-responsive" src="{{asset('home/img/about-us.jpg')}}">
                    <p class="indent">
                        奇立英雄会创业平台，是一个针对高成长创新企业的综合创业服务平台。平台于2017年1月正式上线，我们致力于打造一个集学习、推广、社交等为一体的O2O创业孵化加速器，涵盖创业教育和创业公关等创业服务。<br><br>
                        奇立英雄会创业平台精准定位不同人群的创业需求，展开多维度的创业人群服务，积极开展创新政策先行先试，激发各类主体的创新活力，通过构建愈发完整的“双创”政务服务体系，搭建对应的信息资源、公共技术服务平台，完善创业人才引进、创业辅导服务链条，打造一个多元创业人群的“强磁场”。<br><br>
                        创业者在“磁场”中释放巨大的创造力，也不断刷新着英雄会平台的自主创新能力。奇立英雄会正在完善创新创业政策体系，着力打造“国际创新创业中心”。<br><br>
                    </p>
                </div>
                <div class="bgc-0 col-sm-10 pad-clr @if($type != 2)hidden @endif ">
                    <p>免责声明</p>
                    <img class="img-responsive" src="{{asset('home/img/about-us.jpg')}}">
                    <p>
                        一、保护用户隐私是奇立英雄会网站的一项基本政策，奇立英雄会保证不对外公开或向第三方提供单个用户的注册资料及用户在使用网络服务时存储在奇立英雄会的非公开内容，但下列情况除外：<br>
                        （1）事先获得用户的明确授权；<br>
                        （2）根据有关的法律法规要求；<br>
                        （3）按照相关政府主管部门的要求；<br>
                        （4）为维护社会公众的利益；<br>
                        （5）为维护i黑马网站的合法权益。<br><br>

                        二、 奇立英雄会 可能会与第三方合作向用户提供相关的网络服务，在此情况下，如该第三方同意承担与 奇立英雄会 同等的保护用户隐私的责任，则 奇立英雄会 有权将用户的注册资料等提供给该第三方。<br><br>

                        三、在不透露单个用户隐私资料的前提下， 奇立英雄会 有权对整个用户数据库进行分析并对用户数据库进行商业上的利用。<br><br>

                        四、 奇立英雄会 制定了以下四项隐私权保护原则，指导我们如何来处理产品中涉及到用户隐私权和用户信息等方面的问题：<br>
                        （1） 利用我们收集的信息为用户提供有价值的产品和服务。<br>
                        （2） 开发符合隐私权标准和隐私权惯例的产品。<br>
                        （3） 将个人信息的收集透明化，并由权威第三方监督。<br>
                        （4） 尽最大的努力保护我们掌握的信息。<br><br>

                        五、Cookie的使用<br>
                        使用 Cookie 能帮助您实现您的联机体验的个性化，您可以接受或拒绝 Cookie ，大多数 Web 浏览器会自动接受Cookie，但您通常可根据自己的需要来修改浏览器的设置以拒绝Cookie。奇立英雄会有时会使用 Cookie 以便知道哪些网站受欢迎，使您在访问奇立英雄会时能得到更好的服务。Cookie不会跟踪个人信息。当您注册奇立英雄会时，奇立英雄会亦会使用Cookie。在这种情况下，奇立英雄会会收集并存储有用信息，当您再次访问奇立英雄会时，我们可辨认您的身份。来自奇立英雄会的 Cookie 只能被奇立英雄会读取。如果您的浏览器被设置为拒绝Cookie，您仍然能够访问奇立英雄会的大多数网页。<br><br>

                        六、免责说明<br>
                        就下列相关事宜的发生，奇立英雄会不承担任何法律责任：<br>
                        （1）由于您将用户密码告知他人或与他人共享注册帐户，由此导致的任何个人信息的泄露，或其他非因奇立英雄会原因导致的个人信息的泄露；<br>
                        （2）奇立英雄会网站根据法律规定或政府相关政策要求提供您的个人信息；<br>
                        （3）任何第三方根据奇立英雄会各服务条款及声明中所列明的情况使用您的个人信息，由此所产生的纠纷；<br>
                        （4）任何由于黑客攻击、电脑病毒侵入或政府管制而造成的暂时性网站关闭；<br>
                        （5）因不可抗力导致的任何后果；<br>
                        （6）奇立英雄会在各服务条款及声明中列明的使用方式或免责情形。<br><br>

                        七、联系我们<br>
                        如果有问题请 email或电话联系奇立英雄会 相关编辑，我们会在最短的时间内进行处理。<br><br>
                    </p>
                </div>
                <div class="bgc-0 col-sm-10 pad-clr @if($type != 3)hidden @endif">
                    <p>版权申明</p>
                    <img class="img-responsive" src="{{asset('home/img/about-us.jpg')}}">
                    <p>
                        1.本站版权属于  xxx有限公司所有，xxx有限公司书面授权，任何企业、网站、个人不得转载、摘编、镜像或利用其它方式使用本站内容。经xxx有限公司授权使用作品的，应在授权范围内使用，并注明“来源：www.xxx.cn ” ，同时不得将稿件提供给任何第三方，违者本网将保留依法处理的权利。有关作品内容、版权、合作和其它问题，请发信至xxx@xxx.cn。
                    </p>
                </div>
            @else
                <div class="bgc-0 col-sm-10 pad-clr ">
                    <p>关于我们</p>
                    <img class="img-responsive" src="{{asset('home/img/about-us.jpg')}}">
                    <p class="indent">
                        奇立英雄会创业平台，是一个针对高成长创新企业的综合创业服务平台。平台于2017年1月正式上线，我们致力于打造一个集学习、推广、社交等为一体的O2O创业孵化加速器，涵盖创业教育和创业公关等创业服务。<br><br>
                        奇立英雄会创业平台精准定位不同人群的创业需求，展开多维度的创业人群服务，积极开展创新政策先行先试，激发各类主体的创新活力，通过构建愈发完整的“双创”政务服务体系，搭建对应的信息资源、公共技术服务平台，完善创业人才引进、创业辅导服务链条，打造一个多元创业人群的“强磁场”。<br><br>
                        创业者在“磁场”中释放巨大的创造力，也不断刷新着英雄会平台的自主创新能力。奇立英雄会正在完善创新创业政策体系，着力打造“国际创新创业中心”。<br><br>
                    </p>
                </div>
                <div class="bgc-0 col-sm-10 pad-clr ">
                    <p>免责声明</p>
                    <img class="img-responsive" src="{{asset('home/img/about-us.jpg')}}">
                    <p>
                        一、保护用户隐私是奇立英雄会网站的一项基本政策，奇立英雄会保证不对外公开或向第三方提供单个用户的注册资料及用户在使用网络服务时存储在奇立英雄会的非公开内容，但下列情况除外：<br>
                        （1）事先获得用户的明确授权；<br>
                        （2）根据有关的法律法规要求；<br>
                        （3）按照相关政府主管部门的要求；<br>
                        （4）为维护社会公众的利益；<br>
                        （5）为维护i黑马网站的合法权益。<br><br>

                        二、 奇立英雄会 可能会与第三方合作向用户提供相关的网络服务，在此情况下，如该第三方同意承担与 奇立英雄会 同等的保护用户隐私的责任，则 奇立英雄会 有权将用户的注册资料等提供给该第三方。<br><br>

                        三、在不透露单个用户隐私资料的前提下， 奇立英雄会 有权对整个用户数据库进行分析并对用户数据库进行商业上的利用。<br><br>

                        四、 奇立英雄会 制定了以下四项隐私权保护原则，指导我们如何来处理产品中涉及到用户隐私权和用户信息等方面的问题：<br>
                        （1） 利用我们收集的信息为用户提供有价值的产品和服务。<br>
                        （2） 开发符合隐私权标准和隐私权惯例的产品。<br>
                        （3） 将个人信息的收集透明化，并由权威第三方监督。<br>
                        （4） 尽最大的努力保护我们掌握的信息。<br><br>

                        五、Cookie的使用<br>
                        使用 Cookie 能帮助您实现您的联机体验的个性化，您可以接受或拒绝 Cookie ，大多数 Web 浏览器会自动接受Cookie，但您通常可根据自己的需要来修改浏览器的设置以拒绝Cookie。奇立英雄会有时会使用 Cookie 以便知道哪些网站受欢迎，使您在访问奇立英雄会时能得到更好的服务。Cookie不会跟踪个人信息。当您注册奇立英雄会时，奇立英雄会亦会使用Cookie。在这种情况下，奇立英雄会会收集并存储有用信息，当您再次访问奇立英雄会时，我们可辨认您的身份。来自奇立英雄会的 Cookie 只能被奇立英雄会读取。如果您的浏览器被设置为拒绝Cookie，您仍然能够访问奇立英雄会的大多数网页。<br><br>

                        六、免责说明<br>
                        就下列相关事宜的发生，奇立英雄会不承担任何法律责任：<br>
                        （1）由于您将用户密码告知他人或与他人共享注册帐户，由此导致的任何个人信息的泄露，或其他非因奇立英雄会原因导致的个人信息的泄露；<br>
                        （2）奇立英雄会网站根据法律规定或政府相关政策要求提供您的个人信息；<br>
                        （3）任何第三方根据奇立英雄会各服务条款及声明中所列明的情况使用您的个人信息，由此所产生的纠纷；<br>
                        （4）任何由于黑客攻击、电脑病毒侵入或政府管制而造成的暂时性网站关闭；<br>
                        （5）因不可抗力导致的任何后果；<br>
                        （6）奇立英雄会在各服务条款及声明中列明的使用方式或免责情形。<br><br>

                        七、联系我们<br>
                        如果有问题请 email或电话联系奇立英雄会 相关编辑，我们会在最短的时间内进行处理。<br><br>
                    </p>
                </div>
                <div class="bgc-0 col-sm-10 pad-clr ">
                    <p>版权申明</p>
                    <img class="img-responsive" src="{{asset('home/img/about-us.jpg')}}">
                    <p>
                        1.本站版权属于  xxx有限公司所有，xxx有限公司书面授权，任何企业、网站、个人不得转载、摘编、镜像或利用其它方式使用本站内容。经xxx有限公司授权使用作品的，应在授权范围内使用，并注明“来源：www.xxx.cn ” ，同时不得将稿件提供给任何第三方，违者本网将保留依法处理的权利。有关作品内容、版权、合作和其它问题，请发信至xxx@xxx.cn。
                    </p>
                </div>
            @endif
        </div>
    </div>
</div>

@section('script')
    <script>
        $(function () {
            $('.qili-about-us ul li').on('click', function () {
                if($(this).index() > 0) {
                    if(! $(this).hasClass('qili-about-us-active')) {
                        $('.qili-about-us ul li').removeClass('qili-about-us-active');
                        $(this).addClass('qili-about-us-active');
                        $('.qili-about-us div').addClass('hidden').eq($(this).index() - 1).removeClass('hidden');
                    }
                }
            });

        });
    </script>
@endsection

@endsection
