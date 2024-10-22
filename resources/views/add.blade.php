<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Pizza Heist - Add Product</title>

    <!-- Bootstrap 4 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <!-- Font Awesome CDN for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>

<body>
    <div class="container mt-5">
        <h2 class="mb-4">Add New Product</h2>

        <!-- Display Success or Error Message -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <form action="{{url('/') }}/add" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Product Name -->
            <div class="form-group">
                <label for="productName">Product Name</label>
                <input type="text" class="form-control" id="productName" name="productName" placeholder="Enter product name" required>
                @error('productName')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <!-- Product Category -->
            <div class="form-group">
                <label for="productCategory">Category</label>
                <select class="form-control" id="productCategory" name="productCategory" required>
                    <option value="" disabled selected>Select Category</option>
                    <option value="Pizza">Pizza</option>
                    @foreach($categories_name as $categories)
                        <option value="{{$categories->categories_name}}">{{$categories->categories_name}}</option>
                    @endforeach
                </select>
                @error('productCategory')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <!-- Product Price -->
            <div class="form-group">
                <label for="productPrice">Price (₹)</label>
                <input type="number" class="form-control" id="productPrice" name="productPrice" placeholder="Enter product price" required>
                @error('productPrice')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <!-- Product Image -->
            <div class="form-group">
                <label for="productImage">Product Image</label>
                <input type="file" class="form-control-file" id="productImage" name="productImage" accept="image/*" required>
                @error('productImage')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary">Add Product</button>
        </form>
    </div>

    <!-- Bootstrap JS and dependencies (Popper.js and jQuery) -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9O7xH35Jp6WOgL1p4ZxIpFBOCE6pFu5u5KJ0" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFwA5pt0tvpRyrR5T3i3zjx7yw7" crossorigin="anonymous"></script>

</body>

</html>
