<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cửa Hàng Điện Tử - Pros Studio</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
</head>

<body class="bg-gray-100">
    <!-- Header -->
    <div class="fixed top-0 left-0 z-50 w-full shadow-lg bg-white">
        <div class="container mx-auto">
            <header class="bg-gradient-to-r text-black p-4 w-full flex justify-between items-center">
                <a href="{{ route('users.home') }}">
                    <h1 class="text-3xl font-bold tracking-widest ml-4">ProsStudio Store</h1>
                </a>
                <nav class="space-x-6 hidden md:flex">
                    <a href="{{ route('users.home') }}" class="hover:text-yellow-300 transition">TRANG CHỦ</a>
                    <a href="{{ route('users.introduce') }}" class="hover:text-yellow-300 transition">GIỚI THIỆU</a>
                    <a href="{{ route('users.products.list') }}" class="hover:text-yellow-300 transition">SẢN PHẨM</a>
                    <a href="{{ route('users.promotion') }}" class="hover:text-yellow-300 transition">KHUYẾN MÃI</a>
                    <a href="{{ route('users.contact') }}" class="hover:text-yellow-300 transition">LIÊN HỆ</a>
                </nav>
                <div class="flex items-center space-x-4 mr-4">
                    <a href="{{ route('users.products.cart') }}" class="relative">
                        <i class="fa-solid fa-cart-shopping text-xl"></i>
                        <span
                            class="absolute -top-2 -right-2 bg-red-500 text-white text-xs px-2 rounded-full">{{ $cartCount }}</span>
                    </a>
                    <div class="relative">
                        @if ($user)
                            <a href="{{ route('users.orders.index', ['id' => $user->id]) }}"
                                class="bg-gray-300 text-black px-4 py-2 rounded-lg font-semibold hover:bg-yellow-400 transition">ĐƠN
                                HÀNG</a>
                        @endif
                    </div>
                    @if (!$user)
                        <a href="{{ route('users.login') }}"
                            class="bg-black text-white px-4 py-2 rounded-lg font-semibold">Đăng Nhập</a>
                    @else
                        <form action="{{ route('users.products.logout') }}" method="post">
                            @csrf
                            <button type="submit" class="underline text-black px-4 py-2 rounded-lg">Đăng Xuất</button>
                        </form>
                    @endif
                </div>
            </header>
        </div>
    </div>

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-24 mt-16">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 bg-white p-8 rounded-lg shadow-lg">
            <!-- Product Image Slider -->
            <div>
                <div class="swiper mySwiper">
                    <div class="swiper-wrapper">
                        @foreach ($products->images as $image)
                            <div class="swiper-slide">
                                <img src="{{ asset($image->image_path) }}"
                                    class="w-full h-[400px] object-cover rounded-lg shadow-md">
                            </div>
                        @endforeach
                    </div>
                    <!-- Navigation Buttons -->

                    <div class="swiper-pagination"></div>
                </div>
            </div>


            <!-- Product Details -->
            <div>
                <h2 class="text-3xl font-bold text-gray-900">{{ $products->name }}</h2>
                <p class="text-red-500 font-bold text-2xl mt-2 base-price" data-base-price="{{ $products->price }}">
                    {{ number_format($products->price, 0, ',', '.') }} VNĐ
                </p>
                <p class="text-gray-600 mt-2">Còn lại: {{ $products->sell }}</p>
                <p class="text-gray-600 mt-2">Sản xuất: {{ $products->provider->name }}</p>
                <p class="text-gray-600 mt-2">Xuất xứ: {{ $products->provider->address }}</p>
                <!-- Lựa chọn màu sắc -->
                <div class="mt-4">
                    <label class="text-gray-700 font-semibold">Chọn Màu:</label>
                    <div class="flex space-x-2 mt-2">
                        @foreach ($products->colors as $color)
                            <button class="border px-4 py-2 rounded-lg color-option"
                                style="background-color: {{ $color->hex_code }};" data-id="{{ $color->id }}"
                                data-price="{{ $color->price }}">
                                {{ $color->name }}
                            </button>
                        @endforeach
                    </div>
                </div>


                <!-- Lựa chọn dung lượng -->
                <div class="mt-4">
                    <label class="text-gray-700 font-semibold">Chọn Dung Lượng:</label>
                    <div class="flex space-x-2 mt-2">
                        @foreach ($products->capacities as $capacity)
                            <button id="capacity" class="border px-4 py-2 rounded-lg bg-gray-200 hover:bg-gray-300"
                                data-price="{{ $capacity->price }}">
                                {{ $capacity->name }} GB
                            </button>
                        @endforeach
                    </div>
                </div><br><br>
                <!-- Form thêm vào giỏ hàng -->
                <div class="mt-4">
                    @if ($products->sell < 0)
                        <p class="text-red-500 font-semibold">Sản phẩm này hiện đang hết hàng</p>
                    @else
                        <form action="{{ route('users.products.addtocart') }}" method="post" class="mt-6">
                            @csrf
                            <input type="hidden" name="color_id" id="selected_color">
                            <input type="hidden" name="capacity_id" id="selected_capacity">
                            <button type="submit"
                                class="w-full bg-black text-white py-3 rounded-lg font-semibold hover:opacity-80 transition shadow-lg">Thêm
                                vào Giỏ</button>
                        </form>
                    @endif
                </div>
            </div>
            <h3 class="text-2xl text-gray-800 mb-6 title relative pl-[20px]">SẢN PHẨM BÁN CHẠY NHẤT</h3>
            <div class="grid grid-cols-4 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
                @foreach ($bestProduct as $product)
                    <div class="bg-white p-6 rounded-xl shadow-lg hover:shadow-2xl transition text-center">
                        <a href="{{ route('users.products.productDetail', ['id' => $product->id]) }}">
                            <img src="{{ asset($product->images->where('sort_order', 0)->first()->image_path ?? ($product->images->first()->image_path ?? 'default-image.jpg')) }}"
                                class="w-full h-[19rem] object-cover rounded-lg hover:scale-105 transition">
                        </a>
                        <h4 class="text-2xl font-bold mt-3 text-gray-900">{{ $product->name }}</h4>
                        <p class="text-red-500 font-bold mt-2 text-xl">
                            {{ number_format($product->price, 0, ',', '.') }} VNĐ</p>
                        <p class="text-gray-600">Còn lại: {{ $product->sell }}</p>

                        <div class="mt-4">
                            @if ($product->sell < 0)
                                <p class="text-red-500 font-semibold">Sản phẩm này hiện đang hết hàng</p>
                            @else
                                <form action="{{ route('users.products.addtocart') }}" method="post">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <button type="submit"
                                        class="w-full bg-black text-white py-3 rounded-lg font-semibold hover:opacity-75 transition shadow-lg">Thêm
                                        vào Giỏ</button>
                                </form>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mt-12 bg-white p-6 rounded-lg shadow-lg">
                <h3 class="text-2xl font-bold text-gray-900 mb-4">Đánh giá sản phẩm</h3>
                <!-- Danh sách đánh giá -->
                <div class="space-y-4">
                    @foreach ($products->reviews as $review)
                        <div class="border-b pb-4">
                            <p class="text-gray-800 font-semibold">
                                {{ $review->user->name }}
                                <span class="text-gray-500 text-sm">{{ $review->created_at->format('d/m/Y') }}</span>
                            </p>
                            <div class="text-yellow-500 rating-stars">
                                @for ($i = 1; $i <= 5; $i++)
                                    <i class="fa-star {{ $i <= $review->rating ? 'fas' : 'far' }}"></i>
                                @endfor
                            </div>
                            <p class="text-gray-700 mt-2">{{ $review->comment }}</p>
                        </div>
                    @endforeach
                </div>

                <!-- Form đánh giá -->
                @if (auth()->check())
                    <form action="{{ route('users.products.reviewProduct', $products->id) }}" method="post"
                        class="mt-6">
                        @csrf
                        <label class="block text-gray-700 font-semibold">Đánh giá của bạn:</label>

                        <!-- Rating -->
                        <div class="flex space-x-1 mt-2 rating-stars flex-row-reverse justify-end">
                            @for ($i = 5; $i >= 1; $i--)
                                <input type="radio" id="star{{ $i }}" name="rating"
                                    value="{{ $i }}" class="hidden">
                                <label for="star{{ $i }}"
                                    class="cursor-pointer text-2xl text-gray-400 hover:text-yellow-400">
                                    <i class="fas fa-star"></i>
                                </label>
                            @endfor
                        </div>
                        <!-- Comment -->
                        <textarea name="comment" required rows="3" placeholder="Viết đánh giá của bạn..."
                            class="w-full mt-3 px-4 py-2 border border-gray-300 rounded-lg"></textarea>

                        <button type="submit"
                            class="mt-4 w-full bg-black text-white py-3 rounded-lg font-semibold hover:opacity-80 transition shadow-lg">
                            Gửi đánh giá
                        </button>
                    </form>
                @endif
            </div>
    </main>

    <!-- Footer -->
    <footer class="bg-black text-[#999999] p-4 w-full mt-[35px]">
        <div class="container mx-auto flex flex-col md:flex-row justify-between items-center py-3">
            <p>&copy; 2025 Cửa Hàng Điện Tử Pros studio</p>
            <div class="flex space-x-4">
                <a href="https://www.facebook.com/thuan.phamtran.9/" class="hover:text-gray-300"><i
                        class="fab fa-facebook text-xl"></i></a>
                <a href="https://www.instagram.com/phamtran.thuan/" class="hover:text-gray-300"><i
                        class="fab fa-instagram text-xl"></i></a>
                <a href="#" class="hover:text-gray-300"><i class="fab fa-twitter text-xl"></i></a>
            </div>
        </div>
    </footer>

    <script>
        var swiper = new Swiper(".mySwiper", {
            loop: true,
            spaceBetween: 10,
            slidesPerView: 1,
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
            autoplay: {
                delay: 3000, // Tự động lướt ảnh sau 3s
                disableOnInteraction: false,
            },
        });
        const capacityButtons = document.querySelectorAll('#capacity');
        const colorButtons = document.querySelectorAll('.color-option');
        const priceElement = document.querySelector('.base-price');
        const basePrice = parseInt(priceElement.getAttribute('data-base-price'));

        let selectedCapacityPrice = 0;
        let selectedColorPrice = 0;

        function updatePrice() {
            const finalPrice = basePrice + selectedCapacityPrice + selectedColorPrice;
            priceElement.innerText = new Intl.NumberFormat('vi-VN', {
                style: 'currency',
                currency: 'VND'
            }).format(finalPrice) + ' VNĐ';
        }

        // Xử lý chọn dung lượng
        capacityButtons.forEach(button => {
            button.addEventListener('click', function() {
                selectedCapacityPrice = parseInt(button.getAttribute('data-price')) || 0;
                document.getElementById('selected_capacity').value = button.innerText.split(' ')[0];
                updatePrice();

                // Highlight button đang chọn
                capacityButtons.forEach(btn => btn.classList.remove('bg-yellow-300'));
                button.classList.add('bg-yellow-300');
            });
        });

        // Xử lý chọn màu sắc
        colorButtons.forEach(button => {
            button.addEventListener('click', function() {
                selectedColorPrice = parseInt(button.getAttribute('data-price')) || 0;
                document.getElementById('selected_color').value = button.getAttribute('data-id');
                updatePrice();

                // Highlight màu đang chọn
                colorButtons.forEach(btn => btn.classList.remove('ring-4', 'ring-yellow-300'));
                button.classList.add('ring-4', 'ring-yellow-300');
            });
        });
    </script>

</body>

</html>
<style>
    .rating-stars input[type="radio"] {
        display: none;
    }

    .rating-stars label {
        cursor: pointer;
        font-size: 2rem;
        color: gray;
    }

    /* Màu vàng cho sao đã chọn và các sao bên phải sẽ sáng */
    .rating-stars input[type="radio"]:checked+label,
    .rating-stars input[type="radio"]:checked~label {
        color: gold;
    }

    /* Hiệu ứng hover cho các sao */
    .rating-stars label:hover+label,
    .rating-stars label:hover~label {
        color: gray;
    }

    .swiper-slide img {
        width: 704px;
        height: 700px;
        object-fit: cover;
    }
</style>
