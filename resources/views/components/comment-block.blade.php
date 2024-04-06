@props(['comment' => null])
<div class="py-2 ">
    <h4 class="font-bold text-xl text-uppercase">Đánh giá</h4>
    <div class="my-1 bg-white p-3 border-1">
        <div class="flex flex-col space-y-4">
            <div class="bg-white p-3 rounded-lg shadow-md">
                <h5 class="font-bold inline-block">Hương</h5>
                <span class="float-right text-gray-700 text-xs mb-2 p-2">Mua ngày 15 - 04 - 2024</span>
                <p class="clear-both text-gray-700 text-sm pl-2">Sản phẩm tốt lắp đặt nhanh</p>
            </div>
            <form class="bg-white p-3 rounded-lg shadow-md">
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2" for="name">
                        Số điện thoại khách đã mua hàng.
                    </label>
                    <input class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                           id="name" type="number" placeholder="Nhập Số điện thoại">
                </div>
                <div class="mb-3">
                    <label class="block text-gray-700 font-bold mb-2" for="comment">
                        Nhận xét về sản phẩm, dịch vụ của chúng tôi.
                    </label>
                    <textarea
                        class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        id="comment" rows="3" placeholder="Nhập đánh giá của bạn"></textarea>
                </div>
                <span
                    class="bg-cyan-500 hover:bg-cyan-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                    onclick="comment(event)"> Đăng </span>
            </form>
        </div>
    </div>
    <script>
        function comment(e){
            alert('Chúng tôi vẫn đang phát triển tính năng này. Cảm phiền bạn hãy quay lại sau!')
        }
    </script>
</div>
