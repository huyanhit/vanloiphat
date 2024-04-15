@props(['data' => null])
<div class="form-horizontal bg-white p-3 mt-3" id="comment">
    <h4 class="font-bold text-xl text-uppercase">Đánh giá</h4>
    <div class="my-1 bg-white p-3 border-1">
        <div class="flex flex-col space-y-4">
            <div class="bg-white" id="comment_list"></div>
            <div class="bg-white p-3 border-1">
                <div class="mb-2 flex">
                    <label class="block text-gray-700 mb-1 text-nowrap" for="comment"> Đánh giá</label>
                    <div class="container">
                        <div class="rating d-flex justify-content-center flex-row-reverse w-[110px]">
                            <input type="radio" id="star5" name="rating" checked value="5" /><label for="star5" class="mr-1" title="5 star"></label>
                            <input type="radio" id="star4" name="rating" value="4" /><label for="star4" class="mr-1" title="4 star"></label>
                            <input type="radio" id="star3" name="rating" value="3" /><label for="star3" class="mr-1" title="3 star"></label>
                            <input type="radio" id="star2" name="rating" value="2" /><label for="star2" class="mr-1" title="2 star"></label>
                            <input type="radio" id="star1" name="rating" value="1" /><label for="star1" class="mr-1" title="1 star"></label>
                        </div>
                    </div>
                </div>
                <div class="flex">
                    <div class="mb-2 flex-auto mr-2">
                        <input class="appearance-none w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            id="comment_name" type="text" placeholder="Nhập tên hoặc biệt danh">
                        @if ($errors->has('name'))
                            <span class="text-danger">{{ $errors->first('name') }}</span>
                        @endif
                    </div>
                    <div class="mb-2 flex-auto">
                        <input class="appearance-none w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            id="comment_phone" type="number" placeholder="Nhập Số điện thoại đã mua hàng">
                    </div>
                </div>
                <div class="mb-3">
                    <textarea class="appearance-none w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        id="comment_content" rows="3" placeholder="Nhập đánh giá của bạn"></textarea>
                </div>
                <div class="text-center">
                <button class="text-white bg-cyan-700 hover:bg-cyan-800 focus:ring-4 focus:ring-cyan-300 font-medium text-sm
                    px-5 py-2.5 me-2 mb-2 dark:bg-cyan-600 dark:hover:bg-cyan-700 focus:outline-none dark:focus:ring-blue-800"
                    onclick="comment()"> Đánh giá </button>
                </div>
            </div>
        </div>
    </div>
    <script>
        function comment(){
            let name = $('#comment_name').val();
            let phone = $('#comment_phone').val();
            let rating = $('[name="rating"]:checked').val();
            let content = $('#comment_content').val();
            let data = {
                {{isset($data['product_id'])?'product_id:'.$data['product_id'].',':''}}
                {{isset($data['service_id'])?'service_id:'.$data['service_id'].',':''}}
                name: name,
                phone: phone,
                rating:rating,
                content:content
            }
            ajaxComment(data);
        }

        function ajaxComment(data){
            $.ajax({
                type: 'post',
                url: '/comment',
                headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()},
                data: data
            }).done(function(data){
                let rating = '';
                for (let i=0; i< data.rating; i++){
                    rating += '<i class="bi bi-star-fill text-yellow-500"></i>';
                }
                $('#comment_list').append('<div class="border-1 mt-3 p-3"><div class="flex flex-row">'+
                    '<span class="flex-auto font-bold inline-block">'+
                        '<h5 class="inline">'+data.name+'</h5>'+
                        '<span class="items-center mx-2 inline">'+ rating +'</span>'+
                    '</span>'+
                    '<span class="flex-auto text-right text-gray-700 text-xs ">'+data.created_at+'</span>'+
                '</div>'+
                '<p class="clear-both text-gray-700 text-sm mt-2">'+data.content+'</p></div>')
            });
        }
    </script>
</div>
