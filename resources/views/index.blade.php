<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Pizza Heist</title>

    <!-- Bootstrap 4 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <!-- Font Awesome CDN for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">


    
</head>

<body>
<nav class="navbar navbar-expand-lg navbar-light mt-3">
    <img src="{{ asset('img/logo.webp') }}" alt="Logo" height="50px" width="50px" class="rounded" />
    <a class="navbar-brand ml-4" href="#">Pizza Heist</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <!-- Search Bar Centered with Search Icon -->
        <form class="form-inline my-1 my-lg-0">
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                </div>
                <input class="form-control form-control-lg" id="search-bar" type="search" placeholder="Search..."
                    aria-label="Search">
                <!-- Dropdown for suggestions -->
                <div class="dropdown-menu w-100" id="search-results" style="display: none;"></div>
            </div>
        </form>

        <ul class="navbar-nav ml-auto">
            <li class="nav-item active">
                <a class="nav-link" href="#"><i class="fas fa-cogs"></i> Categories</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#"><i class="fas fa-shopping-cart"></i> Cart</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#" data-toggle="modal" data-target="#accountModal">
                    <i class="fas fa-user"></i> Account
                </a>
            </li>
        </ul>
    </div>
</nav>

    <hr>




    <!-- Cards section moved to bottom -->
    <div class="container mt-1 bottom-content">
    <div class="row">
        <!-- Card 1 -->
        <div class="col-md-4 mb-4">
            <div class="card">
                <img class="card-img-top" src="img/img 1.webp" alt="Card image 1">
            </div>
        </div>

        <!-- Card 2 -->
        <div class="col-md-4 mb-4">
            <div class="card">
                <img class="card-img-top" src="img/img 2.webp" alt="Card image 2">
            </div>
        </div>

        <!-- Card 3 -->
        <div class="col-md-4 mb-4">
            <div class="card">
                <img class="card-img-top" src="img/img 3.webp" alt="Card image 3">
            </div>
        </div>
    </div>
</div>
<hr>
<div class="container">
        <div class="container-fluid">
            <div class="row">
                <!-- Left Section (Categories) -->
                <div class="col-md-3">
                    <div class="">
                        <ul class="list-unstyled">
                            <!-- Dynamically showing categories -->
                            @foreach($categories_name as $category)
                            <li class="mt-2">
                                <a href="javascript:void(0);" class="category-link text-black fs-1 hover-link font-1"
                                    data-category="{{ strtolower($category->categories_name) }}">{{ $category->categories_name }}</a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <!-- Center Section (Products) -->
                <div class="col-md-6">
                    <div id="product-container" class="mt-3" style="max-height: 500px; overflow-y: auto;">
                        <!-- Dynamically showing product categories and items -->
                        @foreach($products->groupBy('categories') as $category => $productsInCategory)
                        <div class="category-group mt-3" data-category="{{ strtolower($category) }}">
                            <h5>{{ $category }} <span class="badge bg-primary text-light">{{ count($productsInCategory) }}</span></h5>
                            @foreach($productsInCategory as $product)
                            <div class="bordered mt-3 product-item" data-category="{{ $product->categories }}">
                                <div class="d-flex bg-light">
                                    <div class="col-md-4">
                                        <img src="{{ asset('storage/' . $product->image) }}" class="img-fluid rounded w-75" alt="{{ $product->title_name }}">
                                    </div>
                                    <div class="col-md-8"><br>
                                        <h5>{{ $product->title_name }}</h5>
                                        <p class="d-flex justify-content-between align-items-center mb-0">
                                            <b>Price: ₹{{ $product->price }}</b>
                                            <button class="btn btn-outline-primary border add-to-cart" 
                                                    data-title="{{ $product->title_name }}" 
                                                    data-price="{{ $product->price }}" 
                                                    data-image="{{ asset('storage/' . $product->image) }}">
                                                ADD <i class="fas fa-plus me-1"></i>
                                            </button>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Right Section (Cart) -->
                <div class="col-md-3">
                    <div class="">
                        <h5>Cart</h5>
                        <div id="cart-items">
                            <p>No products in the cart</p>
                        </div>
                        <h6 id="total-price" class="mt-3">Total: ₹0</h6>
                        <div class="d-flex justify-content-between mt-2">
                            <button class="btn btn-danger" id="clear-cart">Clear Cart</button>
                            <button class="btn btn-success" id="checkout">Checkout</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Account -->
    <div class="modal fade" id="accountModal" tabindex="-1" role="dialog" aria-labelledby="accountModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="accountModalLabel">Sign in</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="otpForm">
                        <div class="mb-4">

                            <input type="text" class="form-control" id="phoneNumber"
                                placeholder="Enter your phone number" required>
                        </div>
                        <div class="mb-3 d-flex justify-content-center">
                            <button type="submit" class="btn btn-primary btn-lg">Send OTP</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <footer class="bg-dark text-white text-center py-4 mt-5">
        <div class="container">
            <div class="row">
                <!-- Free Delivery Section with Icon -->
                <div class="col-md-4">
                    <i class="fas fa-truck fa-3x mb-2 text-primary"></i>
                    <h5>Free Delivery</h5>
                    <p>Delivery happens within: 30-60 minutes</p>
                </div>

                <!-- Payment Options Section with Icon -->
                <div class="col-md-4">
                    <i class="fas fa-credit-card fa-3x mb-2 text-success"></i>
                    <h5>Payment Options</h5>
                    <p>Cash on delivery and online payment</p>
                </div>

                <!-- Customer Support Section with Icon -->
                <div class="col-md-4">
                    <i class="fas fa-headset fa-3x mb-2 text-warning"></i>
                    <h5>Customer Support</h5>
                    <p>pizzaheist.com@gmail.com</p>
                </div>
            </div>

            <hr class="my-4">

            <!-- Store Details -->
            <p><strong>Store Details:</strong></p>
            <p>Pizza Heist</p>
            <p>Pukhrayan, Kanpur Dehat, Uttar Pradesh</p>

            <hr class="my-4">

            <!-- Follow Us Section -->
            <p><strong>Follow us:</strong></p>
            <a href="https://www.instagram.com/" target="_blank" class="text-light">
                <i class="fab fa-instagram  "></i> Instagram
            </a>
        </div>
    </footer>




    <!-- Optional JavaScript: jQuery and Bootstrap Bundle -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        
        $(document).ready(function () {
            $('#otpForm').on('submit', function (event) {
                event.preventDefault();
                let phoneNumber = $('#phoneNumber').val();

                if (phoneNumber) {
                    // Here you can send an AJAX request to the server to send OTP


                    // You can also update the modal with a success message or close it
                    $('#accountModal').modal('hide'); // Close modal after sending OTP
                }
            });
        });
    </script>


<script>
    $(document).ready(function () {
        // Initially show all categories
        $('.category-group').show();

        // Handle category click event
        $('.category-link').on('click', function () {
            var selectedCategory = $(this).data('category').toLowerCase();

            // Re-order the selected category to the top
            if (selectedCategory === 'all categories') {
                // Show all categories if 'All Categories' is clicked
                $('.category-group').show();
            } else {
                // Move selected category to top and show it
                var selectedGroup = $('.category-group[data-category="' + selectedCategory + '"]');
                
                // Hide all groups
                $('.category-group').hide();

                // Show selected group at the top
                $('#product-container').prepend(selectedGroup.show());

                // Then, show other categories below the selected one
                $('.category-group').not(selectedGroup).show();
            }
        });

        // Trigger click on "All Categories" on page load to show all products initially
        $('.category-link:first').trigger('click');
    });
</script>



<script>
        $(document).ready(function() {
            const cart = [];

            // Handle adding products to cart
            $('.add-to-cart').on('click', function() {
                const productTitle = $(this).data('title');
                const productPrice = parseFloat($(this).data('price'));
                const productImage = $(this).data('image');

                const product = {
                    title: productTitle,
                    price: productPrice,
                    image: productImage
                };

                // Add product to cart
                cart.push(product);
                updateCartDisplay();
            });

            // Update the cart display
            function updateCartDisplay() {
                const cartItemsContainer = $('#cart-items');
                cartItemsContainer.empty();
                let total = 0; // Initialize total price

                if (cart.length === 0) {
                    cartItemsContainer.append('<p>No products in the cart</p>');
                    $('#total-price').text('Total: ₹0'); // Update total price display
                    return;
                }

                cart.forEach((item, index) => {
                    total += item.price; // Calculate total price
                    cartItemsContainer.append(`
                        <div class="cart-item d-flex justify-content-between align-items-center my-2">
                            <img src="${item.image}" alt="${item.title}" class="img-fluid" style="width: 50px; height: 50px;">
                            <div class="flex-grow-1 mx-2">
                                <strong>${item.title}</strong>
                                <p>Price: ₹${item.price}</p>
                            </div>
                            <button class="btn btn-danger btn-sm remove-item" data-index="${index}">Remove</button>
                        </div>
                    `);
                });

                $('#total-price').text(`Total: ₹${total.toFixed(2)}`); // Update total price display

                // Add remove functionality
                $('.remove-item').on('click', function() {
                    const index = $(this).data('index');
                    cart.splice(index, 1); // Remove item from cart
                    updateCartDisplay(); // Update cart display
                });
            }

            // Clear cart functionality
            $('#clear-cart').on('click', function() {
                cart.length = 0; // Clear the cart array
                updateCartDisplay(); // Update cart display
            });

            // Checkout functionality
            $('#checkout').on('click', function() {
                if (cart.length === 0) {
                    alert('Your cart is empty!');
                    return;
                }
                // Handle checkout logic here (e.g., redirect to a checkout page)
                alert('Proceeding to checkout...');
            });
        });
    </script>
    <script>
$(document).ready(function() {
    $('#search-bar').on('input', function() {
        let query = $(this).val();

        if (query.length > 0) {
            $.ajax({
                url: "{{ route('product.search') }}",
                method: 'GET',
                data: { query: query },
                success: function(data) {
                    $('#search-results').empty(); // Clear previous results
                    if (data.length > 0) {
                        $.each(data, function(index, product) {
                            $('#search-results').append(
                                `<div class="dropdown-item">
                                    <img src="{{ asset('storage/') }}/${product.image}" class="img-fluid rounded w-25 mr-2" alt="${product.title_name}">
                                    ${product.title_name}
                                </div>`
                            );
                        });
                        $('#search-results').show(); // Show results
                    } else {
                        $('#search-results').hide(); // Hide if no results
                    }
                }
            });
        } else {
            $('#search-results').hide(); // Hide if input is empty
        }
    });

    // Hide results when clicking outside
    $(document).click(function(event) {
        if (!$(event.target).closest('#search-results, #search-bar').length) {
            $('#search-results').hide();
        }
    });
});
</script>

</body>

</html>