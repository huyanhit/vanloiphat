@props(['data' => null])
<div class="form-horizontal bg-white p-3 mt-3" id="comment">
    <h4 class="font-bold text-xl text-uppercase">Đánh giá</h4>
    <div class="my-1 bg-gray-100 p-3 border-1">
        <div class="flex flex-col space-y-4">
            <div id="comment_list">
            </div>
            <div class="bg-white p-3 border-1">
                <div class="mb-2 flex">
                    <label class="block text-gray-700 mb-1 text-nowrap" for="comment"> Đánh giá</label>
                    <div class="container">
                        <div class="rating d-flex justify-content-center flex-row-reverse w-[110px]">
                            <input type="radio" id="star5" name="rating" value="5" /><label for="star5" class="mr-1" title="5 star"></label>
                            <input type="radio" id="star4" name="rating" checked value="4" /><label for="star4" class="mr-1" title="4 star"></label>
                            <input type="radio" id="star3" name="rating" value="3" /><label for="star3" class="mr-1" title="3 star"></label>
                            <input type="radio" id="star2" name="rating" value="2" /><label for="star2" class="mr-1" title="2 star"></label>
                            <input type="radio" id="star1" name="rating" value="1" /><label for="star1" class="mr-1" title="1 star"></label>
                        </div>
                        <span id="comment_rating_error" class="text-danger text-xs hidden"></span>
                    </div>
                </div>
                <div class="flex">
                    <div class="mb-2 flex-auto mr-2">
                        <label>Tên hoặc biệt danh</label>
                        <input class="appearance-none w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            id="comment_name" type="text" placeholder="Nhập tên hoặc biệt danh">
                            <span id="comment_name_error" class="text-danger text-xs hidden"></span>
                    </div>
                    <div class="mb-2 flex-auto">
                        <label>Nhập SĐT đã mua hàng</label>
                        <input class="appearance-none w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            id="comment_phone" type="number" placeholder="0123456789">
                            <span id="comment_phone_error" class="text-danger text-xs hidden"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label>Đánh giá</label>
                    <textarea class="appearance-none w-full px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        id="comment_content" rows="3" placeholder="Nhập đánh giá của bạn"></textarea>
                    <span id="comment_content_error" class="text-danger text-xs hidden"></span>
                </div>
                <div class="text-center">
                <button class="text-white bg-cyan-700 hover:bg-cyan-800 focus:ring-4 focus:ring-cyan-300 font-medium text-sm
                    px-5 py-2.5 me-2 mb-2 dark:bg-cyan-600 dark:hover:bg-cyan-700 focus:outline-none dark:focus:ring-blue-800 uppercase"
                    onclick="comment()"> Đánh giá </button>
                </div>
            </div>
        </div>
    </div>
    <script>
        loadComment();
        function checkEmptyValue(elem, label, data, message){
            if(data === ''){
                elem.addClass('border-1 border-red-700');
                label.removeClass('hidden');
                label.text(message);
                return true;
            }
            elem.removeClass('border-1 border-red-700');
            label.addClass('hidden');
            label.text('');
            return false;
        }

        function checkPhone(elem, label, data, message){
            if(data === '' || data.length < 10  || data.length > 12){
                elem.addClass('border-1 border-red-700');
                label.removeClass('hidden');
                label.text(message);
                return true;
            }
            elem.removeClass('border-1 border-red-700');
            label.addClass('hidden');
            label.text('');
            return false;
        }

        function comment(){
            let name = $('#comment_name');
            let phone = $('#comment_phone');
            let rating = $('[name="rating"]:checked');
            let content = $('#comment_content');
            let nameError = $('#comment_name_error');
            let phoneError = $('#comment_phone_error');
            let ratingError = $('#comment_rating_error');
            let contentError = $('#comment_content_error');

            let data = {
                {{isset($data['product_id'])?'product_id:'.$data['product_id'].',':''}}
                {{isset($data['service_id'])?'service_id:'.$data['service_id'].',':''}}
                name: name.val().trim(),
                phone: phone.val().trim(),
                rating: rating.val(),
                content: content.val().trim()
            }

            if( !checkEmptyValue(name, nameError, data.name, 'Bạn chưa nhập tên') &&
                !checkPhone(phone, phoneError, data.phone, 'Số điện thoại không hợp lệ') &&
                !checkEmptyValue(rating, ratingError, data.rating, 'Bạn chưa bình chọn') &&
                !checkEmptyValue(content, contentError, data.content, 'Bạn chưa nhập đánh giá')){
                ajaxComment(data);
            }
        }

        function renderComment(data){
            let rating = '';
            for (let i = 0; i < 5; i++){
                let color = (data.rating > i)?' text-yellow-500':'';
                rating += '<i class="mr-1 bi bi-star-fill'+color+'"></i>';
            }
            $('#comment_list').append('<div class="border-1 bg-white mt-3 p-3"><div class="flex flex-row">'+
                '<span class="flex-auto font-bold inline-block">'+
                '<h5 class="inline uppercase">'+data.name+'</h5>'+
                '<span class="items-center mx-2 inline">'+ rating +'</span>'+
                '</span>'+
                '<span class="flex-auto text-right text-gray-700 text-xs ">'+data.created_at+'</span>'+
                '</div>'+
                '<p class="clear-both text-gray-700 text-sm mt-2">'+data.content+'</p></div>')
        }

        function ajaxComment(data){
            $.ajax({
                type: 'post',
                url: '/ax-comment',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: data
            }).done(function(data){
                renderComment(data);
            });
        }

        function loadComment(){
            @php $param = isset($data['product_id'])?'?product_id='.$data['product_id']:'?service_id='.$data['service_id'] @endphp
            $.ajax({
                type: 'get',
                url: '/ax-load-comment{{$param}}',
            }).done(function(response){
                for (let i in response.data){
                    renderComment(response.data[i])
                }
            });
        }
    </script>
</div>
