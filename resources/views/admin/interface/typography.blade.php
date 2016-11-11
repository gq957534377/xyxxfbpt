@extends('admin.layouts.master')
@section('content')
@section('title', '功能测试')
<div class="wraper container-fluid">
    <div class="page-title">
        <h3 class="title">Typography</h3>
    </div>

    <!-- Row start -->
    <div class="row">
        <div class="col-md-5">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Headings</h3>
                </div>
                <div class="panel-body">
                    <h1>Heading 1
                        <small>Secondary Text</small>
                    </h1>
                    <h2>Heading 2
                        <small>Secondary Text</small>
                    </h2>
                    <h3>Heading 3
                        <small>Secondary Text</small>
                    </h3>
                    <h4>Heading 4
                        <small>Secondary Text</small>
                    </h4>
                    <h5>Heading 5
                        <small>Secondary Text</small>
                    </h5>
                    <h6>Heading 6
                        <small>Secondary Text</small>
                    </h6>
                </div>
            </div>
        </div>
        <div class="col-md-7">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Paragraphs</h3>
                </div>
                <div class="panel-body">
                    <p class="lead">This is a lead parapraph.</p>
                    <p>Neglected <strong>principle ask rapturous</strong> consulted. Lorem lively all did feebly excuse
                        our wooded. Old her object
                        <del>chatty regard vulgar</del>
                        missed.
                    </p>
                    <p>Believing neglected so so allowance existence departure in. In <span class="label label-info"
                                                                                            data-toggle="tooltip"
                                                                                            data-placement="left"
                                                                                            title="This is Design">design</span>
                        active temper be uneasy. Thirty for remove plenty regard you summer though. He preference
                        <ins>connection astonished</ins>
                        on of ye.
                    </p>
                    <p>As am hastily
                        <mark>invited settled at limited</mark>
                        civilly fortune me. Really spring in extent an by. Judge but built gay party world. Of so am he
                        remember although required. Bachelor unpacked be advanced at. Confined in declared marianne is
                        vicinity.
                    </p>
                    <p>Last paragraph has no bottom margin always.</p>
                    <p>Nullam quis risus eget urna mollis ornare vel eu leo.<a href="#">this is link</a> Cum sociis
                        natoque penatibus et magnis dis parturient montes...</p>
                </div>
            </div>
        </div>
    </div>
    <!-- End of Row -->

    <!-- Row start -->
    <div class="row">
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Inline text elements</h3>
                </div>
                <div class="panel-body">
                    <p>You can use the mark tag to
                        <mark>highlight</mark>
                        text.
                    </p>
                    <p>
                        <del>This line of text is meant to be treated as deleted text.</del>
                    </p>
                    <p>
                        <ins>This line of text is meant to be treated as an addition to the document.</ins>
                    </p>
                    <p>
                        <small>This line of text is meant to be treated as fine print.</small>
                    </p>
                    <p><strong>rendered as bold text</strong></p>
                    <p><em>rendered as italicized text</em></p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Example Address</h3>
                </div>
                <div class="panel-body">
                    <address class="ng-scope">
                        <strong>Twitter, Inc.</strong><br>
                        795 Folsom Ave, Suite 600<br>
                        San Francisco, CA 94107<br>
                        <abbr title="Phone">P:</abbr> (123) 456-7890
                    </address>
                    <strong>Full Name</strong><br>
                    <a href="mailto:#">first.last@example.com</a>

                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Contextual Text Colors</h3>
                </div>
                <div class="panel-body">
                    <p class="text-muted">Fusce dapibus, tellus ac cursus commodo, tortor mauris nibh.</p>
                    <p class="text-primary">Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
                    <p class="text-success">Duis mollis, est non commodo luctus, nisi erat porttitor ligula.</p>
                    <p class="text-info">Maecenas sed diam eget risus varius blandit sit amet non magna.</p>
                    <p class="text-warning">Etiam porta sem malesuada magna mollis euismod.</p>
                    <p class="text-danger">Donec ullamcorper nulla non metus auctor fringilla.</p>
                </div>
            </div>
        </div>
    </div>
    <!-- End of Row -->

    <!-- Row start -->
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Blockquotes</h3>
                </div>
                <div class="panel-body">
                    <blockquote><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a
                            ante.</p></blockquote>
                    <blockquote><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a
                            ante.</p>
                        <footer>Someone famous in<cite title="Source Title">Source Title</cite></footer>
                    </blockquote>
                    <blockquote class="blockquote-reverse"><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                            Integer posuere erat a ante.</p>
                        <footer>Someone famous in<cite title="Source Title">Source Title</cite></footer>
                    </blockquote>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Alignments</h3>
                </div>
                <div class="panel-body">
                    <p class="text-left">Left aligned text.</p>
                    <p class="text-center">Center aligned text.</p>
                    <p class="text-right">Right aligned text.</p>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Block</h3>
                </div>
                <div class="panel-body">
                    <pre>&lt;p&gt;Sample text here...&lt;/p&gt;</pre>
                </div>
            </div>
        </div>
    </div>
    <!-- End of Row -->

    <!-- Row start -->
    <div class="row">
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Ordered Lists</h3>
                </div>
                <div class="panel-body">
                    <ol>
                        <li>Lorem ipsum dolor sit amet</li>
                        <li>Consectetur adipiscing elit</li>
                        <li>Integer molestie lorem at massa</li>
                        <li>Facilisis in pretium nisl aliquet</li>
                        <li>Nulla volutpat aliquam velit</li>
                        <li>Faucibus porta lacus fringilla vel</li>
                        <li>Lorem ipsum dolor sit amet</li>
                        <li>Consectetur adipiscing elit</li>
                        <li>Integer molestie lorem at massa</li>
                        <li>Lorem ipsum dolor sit amet</li>
                        <li>Integer molestie lorem at massa</li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Unordered Lists</h3>
                </div>
                <div class="panel-body">
                    <ul>
                        <li>Lorem ipsum dolor sit amet</li>
                        <li>Consectetur adipiscing elit</li>
                        <li>Nulla volutpat aliquam velit
                            <ul>
                                <li>Phasellus iaculis neque</li>
                                <li>Purus sodales ultricies</li>
                                <li>Lorem ipsum dolor sit amet</li>
                                <li>Consectetur adipiscing elit</li>
                            </ul>
                        </li>
                        <li>Faucibus porta lacus fringilla vel</li>
                        <li>Eget porttitor lorem</li>
                        <li>Consectetur adipiscing elit</li>
                        <li>Integer molestie lorem at massa</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">List-Unstyled</h3>
                </div>
                <div class="panel-body">
                    <ul class="list-unstyled">
                        <li>Lorem ipsum dolor sit amet</li>
                        <li>Consectetur adipiscing elit</li>
                        <li>Integer molestie lorem at massa</li>
                    </ul>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">List-Inline</h3>
                </div>
                <div class="panel-body">
                    <ol class="list-inline">
                        <li>1.Lorem ipsum</li>
                        <li>2.Consectetur</li>
                        <li>3.Integer</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- End of Row -->

    <!-- Row start -->
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Dropcap</h3>
                </div>
                <div class="panel-body">
                    <p><span class="dropcap text-primary">D</span>orem ipsum dolor sit amet, consectetur adipisicing
                        elit. Voluptates, illo, iste itaque voluptas corrupti ratione reprehenderit magni similique?
                        Tempore, quos delectus asperiores libero voluptas quod perferendis! Voluptate, quod illo rerum?
                        Lorem ipsum dolor sit amet. Ea, ipsa, in, laboriosam, dignissimos nobis quaerat vitae a facere
                        esse neque laudantium nisi atque quos assumenda magni quae architecto fugiat libero.</p>
                    <p><span class="dropcap text-purple">D</span>orem ipsum dolor sit amet, consectetur adipisicing
                        elit. Voluptates, illo, iste itaque voluptas corrupti ratione reprehenderit magni similique?
                        Tempore, quos delectus asperiores libero voluptas quod perferendis! Voluptate, quod illo rerum?
                        Lorem ipsum dolor sit amet. Ea, ipsa, in, laboriosam, dignissimos nobis quaerat vitae a facere
                        esse neque laudantium nisi atque quos assumenda magni quae architecto fugiat libero.</p>
                </div>
            </div>
        </div>
    </div>
    <!-- End of Row -->

</div>
@endsection
@section('script')
@endsection