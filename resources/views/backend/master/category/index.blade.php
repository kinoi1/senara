@extends('backend.layouts.index')

@section('content')

<style>
  table tbody tr:first-child td {
    width: 19px;
  }
</style>
<div id="categoryForm" class="row d-none">
    <div class="col-4">
      <div class="card mb-4">
        <div class="card-header pb-0">
          <h6>Form Reseller</h6>
        </div>
        <div class="card-body px-0 pt-0 pb-2">
            <div class="table-responsive p-3">
                <form id="form" action="/category/save"  method="POST">
                    <input type="hidden" name="categoryid">
                    @csrf
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="nama" name="nama" required>
                    </div>

                    <div class="mb-3">
                        <label for="price" class="form-label">Price</label>
                        <input type="text" class="form-control" id="price" name="price" required>
                    </div>

                    <div class="mb-3">
                        <label for="qty" class="form-label">Qty</label>
                        <input type="text" class="form-control" id="qty" name="qty" required>
                    </div>

                    <button type="submit" class="btn btn-primary">  Simpan Produk  </button>
                </form>
            </div>
        </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
      <div class="card mb-4">
        <div class="card-header pb-0">
            <button id="toggleFormButton" data-trigger="tambah" class="btn btn-primary">
                Tambah data
            </button>
          <h6></h6>
        </div>
        <div class="card-body px-0 pt-0 pb-2">
          <div class="table-responsive p-0">
            <table id="category" class="table table-responsive">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Gambar</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $no = 1;
                    @endphp
                    @foreach ($list_data as $a )
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $a->Name }}</td>
                            <td>{{ $a->Image }}</td>
                            <td>
                                <a href="#" onclick="deleteCategory({{ $a->CategoryID }}, '{{ csrf_token() }}')"> <span class="fa fa-trash"></span></a>
                                <a href="#" onclick="edit({{ $a->CategoryID }}, '{{ csrf_token() }}')"><span class="fas fa-edit"></span></a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

  <footer class="footer pt-3  ">
    <div class="container-fluid">
      <div class="row align-items-center justify-content-lg-between">
        <div class="col-lg-6 mb-lg-0 mb-4">
          <div class="copyright text-center text-sm text-muted text-lg-start">
            © <script>
              document.write(new Date().getFullYear())
            </script>,
            made with <i class="fa fa-heart"></i> by
            <a href="https://www.creative-tim.com" class="font-weight-bold" target="_blank">Creative Tim</a>
            for a better web.
          </div>
        </div>
        <div class="col-lg-6">
          <ul class="nav nav-footer justify-content-center justify-content-lg-end">
            <li class="nav-item">
              <a href="https://www.creative-tim.com" class="nav-link text-muted" target="_blank">Creative Tim</a>
            </li>
            <li class="nav-item">
              <a href="https://www.creative-tim.com/presentation" class="nav-link text-muted" target="_blank">About Us</a>
            </li>
            <li class="nav-item">
              <a href="https://www.creative-tim.com/blog" class="nav-link text-muted" target="_blank">Blog</a>
            </li>
            <li class="nav-item">
              <a href="https://www.creative-tim.com/license" class="nav-link pe-0 text-muted" target="_blank">License</a>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </footer>
  <script src="{{ asset('assets/backend/category.js') }}"></script>
@endsection