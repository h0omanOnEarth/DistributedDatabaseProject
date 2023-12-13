@extends('layouts.main_customer')

@section('content')
    <div class="container mt-5">
        <div class="mb-3">
            <input type="text" class="form-control" id="searchBar" placeholder="Search" onkeyup="filterProducts()">
        </div>

        <div class="row row-cols-1 row-cols-md-3 g-4">

            <!-- Loop through products data -->
            @foreach ($products as $product)
                <div class="col">
                    <div class="card h-100">
                        <!-- Placeholder image, replace with actual image URL -->
                        <img src="https://source.unsplash.com/150x150/?product" class="card-img-top"
                            style="object-fit: cover; height: 150px;" alt="Product Image">


                        <div class="card-body">
                            <h5 class="card-title">{{ $product->nama }}</h5>
                            <p class="card-text">Price: Rp{{ $product->harga }}</p>
                        </div>

                        <div class="card-footer">
                            <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-primary">Add to Cart</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </div>

    <script>
        function filterProducts() {
            var input, filter, cards, card, title, i;
            input = document.getElementById("searchBar");
            filter = input.value.toUpperCase();
            cards = document.getElementsByClassName("card");

            for (i = 0; i < cards.length; i++) {
                card = cards[i];
                title = card.querySelector(".card-title");
                if (title.innerText.toUpperCase().indexOf(filter) > -1) {
                    card.style.display = "";
                } else {
                    card.style.display = "none";
                }
            }
        }
    </script>
@endsection
