<!DOCTYPE html>
<html>
    <head>
        <title>Laravel</title>

        <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">
        <script src="http://cdn.rooyun.com/js/jquery.js"></script>

        <style>
            html, body {
                height: 100%;
            }

            body {
                margin: 0;
                padding: 0;
                width: 100%;
                display: table;
                font-weight: 100;
                font-family: 'Lato';
            }

            .container {
                text-align: center;
                display: table-cell;
                vertical-align: middle;
            }

            .content {
                text-align: center;
                display: inline-block;
            }

            .title {
                font-size: 96px;
            }
        </style>
        <script>
            //index
            function showIndex() {
                //var token = $('input[name=_token]').val();
                //alert(token);
                $.ajax({
                    url: '/test',
                    type: 'get',    //请求方式
                    //data: {_token: token},
                    success: function(msg) {
                        //...
                        $('#qq').html(msg);
                    }
                });
            }
            //show
            function show() {
                //var token = $('input[name=_token]').val();
                //alert(token);
                $.ajax({
                    url: '/test/1',
                    type: 'get',    //请求方式
                    //data: {_token: token},
                    success: function(msg) {
                        //...
                        $('#qq').html(msg);
                    }
                });
            }

            //create
            function showCreate() {
                //var token = $('input[name=_token]').val();
                //alert(token);
                $.ajax({
                    url: '/test/create',
                    type: 'get',    //请求方式
                    //data: {_token: token},
                    success: function(msg) {
                        //...
                        $('#qq').html(msg);
                    }
                });
            }

            //post
            function showPost() {
                var token = $('input[name=_token]').val();
                //alert(token);
                $.ajax({
                    url: '/test',
                    type: 'post',    //请求方式
                    data: {_token: token},
                    success: function(msg) {
                        //...
                        $('#qq').html(msg);
                    }
                });
            }

            //edit
            function showEdit() {
                //var token = $('input[name=_token]').val();
                //alert(token);
                $.ajax({
                    url: '/test/1/edit',
                    type: 'get',    //请求方式
                    //data: {_token: token},
                    success: function(msg) {
                        //...
                        $('#qq').html(msg);
                    }
                });
            }

            //update
            function showPut() {
                var token = $('input[name=_token]').val();
                //alert(token);
                $.ajax({
                    url: '/test/1',
                    type: 'PUT',    //请求方式
                    data: {_token: token},
                    success: function(msg) {
                        //...
                        $('#qq').html(msg);
                    }
                });
            }

            //destory
            function showDelete() {
                var token = $('input[name=_token]').val();
                $.ajax({
                    url: '/test/1',
                    type: 'DELETE', //请求方式
                    data: {_token: token},
                    success: function(msg) {
                        $('#qq').html(msg);
                    }
                });
            }




        </script>
    </head>
    <body>
        <div class="container">
            <div class="content">
                <div class=""><form action="/test" method="post">
                        name : <input type="text" name="name" />{!! csrf_field() !!}
                        <input type="submit" value="submit" />
                    </form>
                    <input type="button" onclick="showIndex()" value="index"><br>
                    <input type="button" onclick="showCreate()" value="create"><br>
                    <input type="button" onclick="showEdit()" value="edit"><br>
                    <input type="button" onclick="showPost()" value="store"><br>
                    <input type="button" onclick="show()" value="show"><br>
                    <input type="button" onclick="showPut()" value="put"><br>
                    <input type="button" onclick="showDelete()" value="delete"><br>

                </div>
                <div id="qq"></div>
            </div>
        </div>
    </body>
</html>
