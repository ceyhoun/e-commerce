@extends('frontend.layouts.layouts')
@section('content')
    @include('frontend.partials.crumb')
    <div class="container">
        <div id="favorites-section">
            <h3>Favory</h3>
            <div id="favorites-list" class="row"></div>
        </div>
    </div>
@endsection
@section('content')
    @push('content')
    <script>
    $(document).ready(function() {
        // Sayfa yüklendiğinde favori ürünlerin listesini al

        let itemId = $this.data('item-id');
        let favoritesList = $('#favorites-list'); // favoritesList değişkenini tanımla

// Sayfa yüklendiğinde favori ürünlerin listesini al
$.ajax({
    type: "GET",
    url: `/fav/addfav/${itemId}`, // Ürün ID'sine göre URL
    data: {
        _token: $('meta[name="csrf-token"]').attr('content'),
        item_id: itemId
    }// Favori ürünlerin listesini döndüren API
    dataType: "json",
    success: function(data) {
        showfavdata(data); // Gelen verileri showfavdata fonksiyonuna gönder
    },
    error: function(xhr, status, error) {
        console.error('Hata oluştu:', error);
        console.error('Sunucu yanıtı:', xhr.responseText);
    }
});
        function showfavdata(data){
                data.forEach(function(item) {
                    favoritesList.append(`
                        <div class="col-md-4">
                            <div class="favorite-item">
                                <h4>${item.name}</h4>
                                <img src="${item.image}" alt="${item.name}" />
                            </div>
                        </div>
                    `);
                });
            }

    });

    </script>
    @endpush
@endsection

