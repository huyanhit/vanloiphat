@props(['comment' => null])
<div class="py-2" id="comment">
    <h4 class="font-bold text-xl text-uppercase">Đánh giá</h4>
    <div class="my-1 bg-white p-3 border-1">
        <div class="flex flex-col space-y-4">
            <div class="bg-white p-3 shadow-md">
                <h5 class="font-bold inline-block">Hương</h5>
                <span class="float-right text-gray-700 text-xs mb-2 p-2">Mua ngày 15 - 04 - 2024</span>
                <p class="clear-both text-gray-700 text-sm pl-2">Sản phẩm tốt lắp đặt nhanh</p>
            </div>
            <form class="bg-white p-3 shadow-md">
                <div class="mb-4">
                    <label class="block text-gray-700 mb-1" for="name">
                        Số điện thoại khách đã mua hàng.
                    </label>
                    <input class="appearance-none w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                           id="name" type="number" placeholder="Nhập Số điện thoại">
                </div>
                <div class="mb-1 flex">
                    <label class="block text-gray-700 mb-1 text-nowrap" for="comment"> Đánh giá</label>
                    <div class="container">
                        <div class="rating d-flex justify-content-center flex-row-reverse w-[110px]">
                            <input type="radio" id="star5" name="rating" value="5" /><label for="star5" class="mr-1" title="5 star"></label>
                            <input type="radio" id="star4" name="rating" value="4" /><label for="star4" class="mr-1" title="4 star"></label>
                            <input type="radio" id="star3" name="rating" value="3" /><label for="star3" class="mr-1" title="3 star"></label>
                            <input type="radio" id="star2" name="rating" value="2" /><label for="star2" class="mr-1" title="2 star"></label>
                            <input type="radio" id="star1" name="rating" value="1" /><label for="star1" class="mr-1" title="1 star"></label>
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <textarea
                        class="appearance-none w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        id="comment" rows="3" placeholder="Nhập đánh giá của bạn"></textarea>
                </div>
                <button class="text-white bg-cyan-700 hover:bg-cyan-800 focus:ring-4 focus:ring-cyan-300 font-medium text-sm
                            px-5 py-2.5 me-2 mb-2 dark:bg-cyan-600 dark:hover:bg-cyan-700 focus:outline-none dark:focus:ring-blue-800"
                    onclick="comment(event)"> Đăng </button>
            </form>
        </div>
    </div>
    <script>
        function comment(e){
            alert('Chúng tôi vẫn đang phát triển tính năng này. Cảm phiền bạn hãy quay lại sau!')
        }
    </script>
</div>
