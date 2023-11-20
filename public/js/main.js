function counter(){
    $.ajax({
        type: 'get',
        url: '/counter'
    });
}

$(document).ready(function(){
    console.log('sss');
    counter();
})
