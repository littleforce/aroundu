$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(".article-audit").click(function (event) {
    target = $(event.target);
    var article_id = target.attr("article-id");
    var status = target.attr("article-action-status");

    $.ajax({
        url: "/admin/articles/" + article_id + "/status",
        method: "POST",
        data: { "status": status },
        dataType: "json",
        success: function success(data) {
            if (data.error != 0) {
                alert(data.msg);
                return;
            }

            target.parent().parent().remove();
        }
    });
});

$(".resource-delete").click(function (event) {
    if (confirm("确定执行删除操作么?") == false) {
        return;
    }

    var target = $(event.target);
    event.preventDefault();
    var url = $(target).attr("delete-url");
    $.ajax({
        url: url,
        method: "POST",
        data: { "_method": 'DELETE' },
        dataType: "json",
        success: function success(data) {
            if (data.error != 0) {
                alert(data.msg);
                return;
            }

            window.location.reload();
        }
    });
});