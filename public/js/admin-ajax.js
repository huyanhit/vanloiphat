$(document).ready(function(){
    $("#ajax_send").hide();
    
    $('.ajax_delete').click(function(){
        let url   = this.getAttribute( "url" );
        let token = $('input[name="_token"]').val();
        if(!confirm("Do you want to delete?")){
            return false;
        }
        $.ajax({
            type: 'DELETE',
            url: url,
            data:{
                _token:token,
            }
        }).done(function(){
            window.location.reload(false);
        });
    });

    $('.can_update_text').dblclick(function(event){
        let type = $(this).attr('type');
        let child = $('#update_text_change');
        if(child.length){
            if($(this).find('#update_text_change').length) {
                event.stopPropagation();
            }else{
                ajax_update_field();
            }
        }else{
            if(type == 'select'){
                renderSelect(this);
            }else if(type == 'image'){
                $(this).html('<input class="form-control" id="update_text_change" type="file" data="'+ $(this).find('img').attr('src')+'">' );
            }else if(type == 'file'){
                $(this).html('<input class="form-control" id="update_text_change" type="file" data="'+ $(this).find('span').text()+'">' );
            }else if(type == 'area'){
                renderArea(this);
            }else{
                $(this).html('<input id="update_text_change" type="text" data="'+ $(this).text().trim()+'" value="'+ $(this).text().trim()+'">' );
            }
        }

        event.stopPropagation();
    });

    $('#list .check-list input[type="checkbox"]').click(function(){
        let id    = this.getAttribute( "fid" );
        let field = this.getAttribute( "name" );
        let value = $(this).is(':checked')? 1: 0;
        ajax_update_process(id, field, value);
    });

    $('input[name="apply"]').click(function(){
        let id = [];
        let data = [];
        let choose = $('select[name="apply"]').val();
        let url = window.location.pathname+'/apply';
        let token = $('input[name="_token"]').val();

        $("input[name='check']:checked").each(function(index,elem){
            id.push($(elem).attr('data'));
            data.push(choose);
        });

        $.ajax({
            type: 'POST',
            url: url,
            data:{
                _token:token,
                action:choose,
                id:id,
                data:data
            }
        }).done(function(){
            window.location.reload(false);
        })
    });

    $('.check_reference').each(function(index, elem){
        let id = $(elem).val();
        if($(elem).is(':checked')){
            $('.check_reference_'+id).prop( "disabled", false );;
        }else {
            $('.check_reference_'+id).prop( "disabled", true );
        }
    });

    $('.check_reference').click(function(){
        let id = $(this).val();
        if($(this).is(':checked')){
            $('.check_reference_'+id).prop( "disabled", false );;
        }else {
            $('.check_reference_'+id).prop( "disabled", true );
        }
    });
   
    $('.can_update_text').on("click", function(){
        if($(this).find('#update_text_change').length) event.stopPropagation();
    });

    $('select.render_select').change(function(){
        let reference = $(this).attr('reference');
        let element = $(document).find('select[name="'+reference+'"]');
        if(element.length > 0) {
            let id = $(this).val();
            let table = $(this).attr('table');
            let url = $('.prefix_link').attr('href') + '/getPostSelect/' + table + '/' + id;
            $.ajax({
                type: 'GET',
                url: url,
            }).done(function (response) {
                let element = $(document).find('select[name="' + reference + '"]');
                let html = '<select class="form-control select" name="' + reference + '">';
                html += '<option value=""> Choose </option>';
                Object.keys(response).forEach(function (key) {
                    html += '<option value="' + key + '">' + response[key] + '</option>';
                })
                html += '</select>';

                $(element).html(html);
            });
        }
    });

    $('input[type="radio"].render_select').click(function(){
        let reference = $(this).attr('reference');
        let element = $(document).find('select[name="'+reference+'"]');
        if(element.length > 0) {
            let id = $(this).val();
            let table = $(this).attr('table');
            let url = $('.prefix_link').attr('href') + '/getPostSelect/' + table + '/' + id;
            $.ajax({
                type: 'GET',
                url: url,
            }).done(function (response) {
                let element = $(document).find('select[name="' + reference + '"]');
                let html = '<select class="form-control select" name="' + reference + '">';
                Object.keys(response).forEach(function (key) {
                    html += '<option value="' + key + '">' + response[key] + '</option>';
                })
                html += '</select>';

                $(element).html(html);
            });
        }
    });

    $('.render_select').each(function(index, elem){
        let reference = $(elem).attr('reference');
        let element = $(document).find('select[name="'+reference+'"]');
        let parent_id = $(elem).val();
        let id = $(element).val();
        if(element.length > 0 && parent_id > 0 && id == 0){
            let table = $(elem).attr('table');
            let url = $('.prefix_link').attr('href')+'/getPostSelect/'+table+'/'+id;
            $.ajax({
                type: 'GET',
                url: url,
            }).done(function(response){
                let html  = '<select class="form-control select" name="'+ reference +'">';
                Object.keys(response).forEach(function(key) {
                    html += '<option value="'+key+'">'+ response[key] +'</option>';
                })
                html += '</select>';

                $(element).html(html);
            });
        }
    });

    $('input[type="radio"].render_image').click(function(){
        render_image(this);
    });

    $('input[type="radio"].render_image').each(function(){
        if($(this).is(':checked')){
            render_image(this);
        }
    });

    function renderArea(element) {
        let data  = JSON.parse($(element).attr('data'));
        $(element).html('<textarea class="form-control" id="update_text_change" type="area">' + data 
        + '</textarea><script>CKEDITOR.replace( \'update_text_change\', {customConfig: \'myconfig.js\'});</script>');
    };

    function renderSelect(element) {
        let id    = $(element).find('span').attr('uid');
        let value = $(element).find('span').text();
        let data  = JSON.parse($(element).attr('data'));
        let html  = '<select id="update_text_change" key="'+ id +'" data="'+ value +'">';
        Object.keys(data).forEach(function(key) {
            if(id == key){
                html += '<option value="'+key+'" selected>'+ data[key] +'</option>';
            }else{
                html += '<option value="'+key+'">'+ data[key] +'</option>';
            }
        })
        html += '</select>';

        $(element).html(html);
    }

    function render_image(element){
        let name = $(element).val();
        if($(element).parents('.js_render').find('.image_box').length > 0){
            let html = '<img src="/images/'+name+'.jpg">';
            $(element).parents('.js_render').find('.image_box').html(html)
        }else{
            let html = '<span class="col-md-6 image_box"><img src="/images/'+name+'.jpg"></span>';
            $(element).parents('.js_render').append(html);
        }
    }

    function ajax_update_field() {
        let child  = $('#update_text_change');
        let parent = child.parent();
        if(child.length && parent.length){
            let type   = parent.attr('type');
            let id     = parent.attr('uid');
            let field  = parent.attr('field');
            
            let oldValue   = JSON.parse(parent.attr('data'));
            let value      = child.val();

            if(type == 'select') oldValue = child.attr('key');
            if(type == 'area') value      = CKEDITOR.instances.update_text_change.getData();
            if(value.trim() === oldValue){
                restore_update_field(parent, type, oldValue);
            }else{
                if(type == 'image' || type == 'file'){
                    let urlUpload = window.location.pathname+'/upload/'+type;
                    let formData = new FormData();
                    let file = $('#update_text_change')[0].files[0];
                    if(file === undefined){
                        if(type == 'image'){
                            parent.html('<span><img src="'+ data +'"></span>');
                        }else if(type == 'file'){
                            parent.html('<span>'+ data +'</span>');
                        }
                        return false;
                    }
                    formData.append('file', file);
                    $.ajax({
                        type : 'POST',
                        url : urlUpload,
                        data : formData,
                        processData: false,
                        contentType: false,
                    }).done(function(value){
                        if(value.length != 0){
                            ajax_update_process(id, field, value);
                        }else{
                            if(type == 'image'){
                                parent.html('<span><img src="'+ '/uploads/images/'+ data +'"></span>');
                            }else if(type == 'file'){
                                parent.html('<span>'+ data +'</span>');
                            }
                        }
                    }).error(function(response){
                        if(type == 'image'){
                            parent.html('<span><img src="'+ '/uploads/images/'+ data +'"></span>');
                        }else if(type == 'file'){
                            parent.html('<span>'+ data +'</span>');
                        }
                        let res = JSON.parse(response.responseText);
                        alert(res.errors.value[0]);
                        $("#ajax_send").hide();
                    });
                }else{
                    ajax_update_process(id, field, value);
                }
            }
        }
    } 

    function restore_update_field(element, type, oldValue){
        if(type == 'select'){
            let value_select = $('#update_text_change option:selected').text();
            element.html('<span class="inline" uid="'+oldValue+'">'+value_select+'</span>');
        }else if(type == 'file'){
            element.html('<span>'+ oldValue +'</span>');
        }else if(type == 'area'){
            element.html('<span class="inline">'+ oldValue +'</span>');
        }else{
            element.html('<span class="inline">'+ oldValue +'</span>');
        }

        $("#ajax_send").hide();
    }

    function ajax_update_process(id, field, value) {
        let url    = window.location.pathname+'/'+id;
        let child  = $('#update_text_change');
        let parent = $('#update_text_change').parent();
        let type   = parent.attr('type');
        let token  = $('input[name="_token"]').val();

        $.ajax({
            type: 'PUT',
            url: url,
            data: {'_token':token, [field]: value}
        }).done(function(response){
            if(type == 'select'){
                let id_select    = child.val();
                let value_select = $('#update_text_change option:selected').text();
                parent.html('<span class="inline" uid="'+id_select+'">'+value_select+'</span>');
            }else if(type == 'image'){
                parent.html('<span><img src="'+ '/uploads/images/'+value +'"></span>');
            }else if(type == 'file'){
                parent.html('<span>'+ value +'</span>');
            }else if(type == 'area'){
                parent.attr('data', JSON.stringify(value));
                parent.html('<span class="inline">'+ value +'</span>');
            }else{
                parent.html('<span class="inline">'+ value +'</span>');
            }
        }).error(function(response){
            let res = JSON.parse(response.responseText);
            if(res.message != undefined){
                alert(res.message)
            };
            $("#ajax_send").hide();
        });
    }

    $(document).on("click", function() {
        ajax_update_field();
    });

    $(document).on('keypress',function(e) {
        if(e.which == 13) ajax_update_field();
    });

    $('.row_insert_component').on('click','.js_delete_row', function () {
        let uid = $(this).attr('uid');
        $(this).parents().find('.row_data_'+uid).remove();
    });

    $('.js_insert_row').click(function () {
        let id = $(document).find('input[name="id"]').val();
        let data = $(this).parent().find('.select-data').val();
        let name = $(this).parent().find('.select-data option:selected').text();
        let key = $('input.field_update_key').val();
        let primary = $('input.field_update_primary_id').val();
        let foreign = $('input.field_update_foreign_id').val();
        let fields = $('input.field_update_value');
        let field_data = 0;

        $('.sequence_data').each(function (index, elem) {
            field_data = Math.max($(elem).val(), $(elem).val());
        });

        let count = 0;
        $('.js_delete_row').each( function (index, elem) {
            count = Math.max(count, $(elem).attr('uid'))
        });

        let html = '<div class="row row_data_'+(count+1)+'"> <div class="col-md-3"> ';
        html += '<input name="'+key+'['+primary+'][]" type="hidden" value="'+id+'"> ';
        html += '<input name="'+key+'['+foreign+'][]" type="hidden" value="'+ data +'"> <span class="height-35"> '+name+' </span> </div> <div class="col-md-8"> ';
        fields.each(function (index, e) {
            let field = $(e).attr('key');
            if(field != undefined){
                switch (field) {
                    case 'select':
                        let select = $(".select_reference:first").clone();
                        html += $(select)[0].outerHTML;
                        break;
                    case 'text':
                        if($(e).val() == 'sequence'){
                            field_data += 1;
                            html += '<input class="form-control sequence_data" placeholder="'+ field +'" name="'+key+'['+field+'][]" type="text" value="'+ field_data +'"> </div> ' ;
                        }else{
                            html += '<input class="form-control sequence_data" placeholder="'+ field +'" name="'+key+'['+field+'][]" type="text" value=""> </div> ' ;
                        }
                        break;
                }
            }
        })
        html += '<div class="col-md-1"> <span class="btn js_delete_row" uid="'+(count+1)+'"><i class="fa fa-minus-square-o" aria-hidden="true"></i></span> </div> </div>';
        $('.row_insert_component').append(html);
    });

    $('.images').on('click','.edit', function () {
        let id = $(this).attr('fid');
        showUploadImages(id);
    });

    $('.images').on('change','.upload_images_field', function () {
        $('.upload_images_span').hide();
        uploadImages(this);
    });

    $('.images').on('click','.delete', function () {
        deleteImages(this);
    });

    function showUploadImages(id) {
        $('.upload_images_span').hide();
        $('#upload_images_span_'+id).show();
    }
   
    function deleteImages(element) {
        let id = $(element).attr('fid');
        let parent = $(element).parents('.image_box');
        let token = $('input[name="_token"]').val();
        $.ajax({
            type: 'Get',
            url: location.protocol+'//'+location.hostname+'/admin/images/delete_image?id='+id,
            data:{
                _token: token,
            }
        }).done(function(value){
            if(value == 1){
                parent.remove();
            }
        })
    }

    function uploadImages(element) {
        let id = $(element).attr('fid');
        let parent = $(element).parents('.image_box');
        let urlUpload = location.protocol+'//'+location.hostname+'/admin/images/edit_image/'+id;
        let file = $('#upload_images_field_'+id)[0].files[0];
        let token = $('input[name="_token"]').val();
        let formData = new FormData();
        formData.append('_token', token);
        formData.append('id', id);
        formData.append('title', 'title');
        formData.append('active', 1);
        formData.append('image', file);
        $.ajax({
            type : 'POST',
            url : urlUpload,
            data : formData,
            processData: false,
            contentType: false,
        }).done(function(value){
            if(value == 1){
                parent.find('img').attr('src','/uploads/images/'+ file.name);
            }
        })
    }
});

$(document).ajaxSend(function() {
    $("#ajax_send").show();
});

$(document).ajaxSuccess(function() {
    $("#ajax_send").delay(1000).hide(0);
});
