$(document).ajaxSend(function() {
    $("#ajax-send").show();
});

$(document).ajaxSuccess(function() {
    $("#ajax-send").hide();
});

$(document).ready(function(){
    $("#module-comment").on("click","#child-comment-form .submit",function(e) {
        url = $('#child-comment-form').attr('action');
        insert = $(this).parents('.content').parent();
        console.log(insert);
        if($("#child-comment-form #frm-name").val().length == 0){
            alert('input name');
        }else{
            if($("#child-comment-form #frm-comment").val().length == 0){
                alert('input Comment');
            }else{
                data = {
                    name: $("#child-comment-form #frm-name").val(),
                    comment: $("#child-comment-form #frm-comment").val(),
                    _token:  $("#child-comment-form #_token").val(),
                    id: $("#child-comment-form #frm-id").val(),
                    typeid: $("#child-comment-form #type-id").val(),
                    idcomment: $("#child-comment-form #frm-idcomment").val(),
                };
                console.log(data);
                $.ajax({
                    type: "POST",
                    url: url,
                    data: data,
                    success: function(html){
                        htm =  '<ul><li>';
                        htm += html;
                        htm += '</li></ul>';
                        insert.append(htm);
                        html = '<form id="comment-form" method="POST" action="/laravel/insertComment">';
                        html += $("#child-comment-form").html();
                        html +='</form>';
                        $("#child-comment-form").remove();
                        $('#comment-script .reply').text('Hồi đáp')
                        $("#comment-script").append(html);
                    }
                });
            }
        }
        return false;
    });
    $("#module-comment").on("click","#comment-form .submit",function(e) {
        url = $('#comment-form').attr('action');
        id = $("#comment-form #frm-id").val();
        if($("#comment-form #frm-name").val().length == 0){
            alert('input name');
        }else{
            if($("#comment-form #frm-comment").val().length == 0){
                alert('input Comment');
            }else{
                data = {
                    name: $("#comment-form #frm-name").val(),
                    comment: $("#comment-form #frm-comment").val(),
                    _token:  $("#comment-form #_token").val(),
                    typeid: $("#comment-form #type-id").val(),
                    id: $("#comment-form #frm-id").val()};
                console.log(data);
                $.ajax({
                    type: "POST",
                    url: url,
                    data: data,
                    success: function(html){
                        $("#comment-script").append(html);
                    }
                });
            }
        }
        return false;
    });
    $("#comment-script .reply").click(function() {
        if($(this).text() !='Hủy'){
            $('#comment-script .reply').text('Hồi đáp')
            $(this).text('Hủy');
            html = '<form id="child-comment-form" method="POST" action="/laravel/insertComment">';
            html += '<input type="hidden" id="frm-idcomment" name="frm-idcomment" value="'+$(this).attr('data')+'">';
            html += $("#comment-form").html();
            html +='</form>';
            $("#comment-form").remove();
            $(this).parent().append(html);
        }else{
            $(this).text('Hồi đáp');
            html = '<form id="comment-form" method="POST" action="/laravel/insertComment">';
            html += $("#child-comment-form").html();
            html +='</form>';
            $("#child-comment-form").remove();
            $("#comment-script").append(html);
        }
    });
});
