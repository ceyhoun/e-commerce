@extends('backend.layouts.layout')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h2>Yeni </h2>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('panel') }}">Home</a></li>
                            <li class="breadcrumb-item active">General Form</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md">
                        <div class="card card-info w-50">
                            <div class="card-header">
                                <h3 class="card-title">Yeni Məhsul Əlavə Et</h3>
                            </div>
                            <form action="{{ route('addproducts') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="card-body">
                                    <!-- Ürün Adı -->
                                    <div class="form-group">
                                        <label for="productnameid">Məhsulun Adı</label>
                                        <input type="text" name="productname" class="form-control" id="productnameid"
                                            placeholder="Məhsulun Adı">
                                    </div>

                                    <!-- Subcategory Seçimi -->
                                    <div class="form-group">
                                        <label for="productsubcategoriesid">Məhsulun Aid Olduğu Kateqoriya</label>
                                        <select name="subcategoryid" id="productsubcategoriesid" class="form-control">
                                            <option value="seçin" selected>Seçin</option>
                                            @foreach ($subcategories as $subcategory)
                                                <option value="{{ $subcategory->id }}">{{ $subcategory->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Ürün Fiyatı -->
                                    <div class="form-group">
                                        <label for="productpriceid">Məhsulun Qiyməti</label>
                                        <input type="number" name="productprice" class="form-control" id="productpriceid"
                                            placeholder="Məhsulun Qiyməti">
                                    </div>

                                    <!-- Ürün Açıklaması -->
                                    <div class="form-group">
                                        <label for="productdescid">Məhsul Haqqında</label>
                                        <input type="text" name="productdesc" class="form-control" id="productdescid"
                                            placeholder="Məhsul Haqqında">
                                    </div>

                                    <!-- Ürün Resmi -->
                                    <div class="form-group">
                                        <label for="productimg">Məhsulun Şəkli</label>
                                        <input name="productimg" type="file" class="form-control-file" id="productimg">
                                    </div>

                                    <!-- Ürün Seçimleri ve Renkler -->
                                    <div id="product-options">
                                        <!-- Kıyafet ve Ayakkabı Seçimleri Dinamik Olarak Burada Gösterilecek -->
                                    </div>

                                    <!-- Ürün Stok Durumu -->
                                    <div class="form-check">
                                        <input type="checkbox" name="productcheck" class="form-check-input"
                                            id="productcheckid">
                                        <label class="form-check-label" for="productcheckid">Məhsulun Statusu</label>
                                    </div>

                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-info">Məhsulu əlavə edin</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
@section('content')
    @push('scripts')
        <script>
            document.getElementById('productsubcategoriesid').addEventListener('change', function() {
                let subcategoryId = this.value;
                let optionsContainer = document.getElementById('product-options');
                let colors = @json($colors);
                let sizes = @json($sizes);
                let shoes = @json($shoes);

                optionsContainer.innerHTML = '';

                if (subcategoryId == 2) {
                    optionsContainer.innerHTML = `
                       <div class="form-group">
                <label>Məhsulun Ölçüsü</label>
                <div class="form-check form-check-inline">
                    ${shoes.map(shoe => `
                        <input class="form-check-input mx-1" type="checkbox" name="productshoe[]" id="productshoe-${shoe.id}" value="${shoe.id}">
                        <label class="form-check-label" for="productshoe-${shoe.id}"><b>${shoe.number}</b></label>
                    `).join('')}
                </div>
            </div>
            <div class="form-group">
                <label>Məhsulun Rəngi</label>
                <div class="form-check form-check-inline">
                    ${colors.map(color => `
                        <input class="form-check-input mx-1" type="checkbox" name="productcolor[]" id="productcolor-${color.id}" value="${color.id}">
                        <label class="form-check-label" for="productcolor-${color.id}"><b>${color.name}</b></label>
                    `).join('')}
                </div>
            </div>
            <p>Miqdar Müəyyən Etmə:</p>
            ${shoes.map(shoe => `
                ${colors.map(color => `
                    <div class="form-group">
                        <label for="quantity-${shoe.id}-${color.id}">
                            ${shoe.number} - ${color.name}
                        </label>
                        <input type="number" name="productqty[${shoe.id}][${color.id}]" id="quantity-${shoe.id}-${color.id}" value="0">
                    </div>
                `).join('')}
            `).join('')}
                    `;
                } else {
                    optionsContainer.innerHTML = `
            <div class="form-group">
                <label>Məhsulun Ölçüsü</label>
                <div class="form-check form-check-inline">
                    ${sizes.map(size => `
                        <input class="form-check-input mx-1" type="checkbox" name="productsize[]" id="productsize-${size.id}" value="${size.id}">
                        <label class="form-check-label" for="productsize-${size.id}"><b>${size.name}</b></label>
                    `).join('')}
                </div>
            </div>
            <div class="form-group">
                <label>Məhsulun Rəngi</label>
                <div class="form-check form-check-inline">
                    ${colors.map(color => `
                        <input class="form-check-input mx-1" type="checkbox" name="productcolor[]" id="productcolor-${color.id}" value="${color.id}">
                        <label class="form-check-label" for="productcolor-${color.id}"><b>${color.name}</b></label>
                    `).join('')}
                </div>
            </div>
            <p>Miqdar Müəyyən Etmə:</p>
            ${sizes.map(size => `
                ${colors.map(color => `
                    <div class="form-group">
                        <label for="quantity-${size.id}-${color.id}">
                            ${size.name} - ${color.name}
                        </label>
                        <input type="number" name="productqty[${size.id}][${color.id}]" id="quantity-${size.id}-${color.id}" value="0">
                    </div>
                `).join('')}
            `).join('')}
        `;
    }
            });
        </script>
    @endpush
@endsection
