$(document).ready(function(){
    $('#checkAll').click(function () {
        $("input[name='check']").prop('checked', this.checked);
    });
});
