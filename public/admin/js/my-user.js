$(function () {
    setTimeout(function () {
        $('.main').width('80%'); // Change table width
    }, 3000);

    $('#resetView').click(function () {
        $('#table').bootstrapTable('resetView');
    });
});