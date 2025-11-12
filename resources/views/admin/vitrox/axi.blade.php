@extends('layouts.master')

@section('top')
{{-- Gunakan CSS DataTables yang kompatibel dengan Bootstrap 3 --}}
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap.min.css">
@endsection

@section('content')

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif
@if(session('error'))
<div class="alert alert-danger">{{ session('error') }}</div>
@endif

<div class="row mb-4">
    {{-- Bagian 1: Import AXI --}}
    <div class="col-md-6 mt-5" style="padding-bottom: 50px;">
        <form action="{{ route('admin.vitrox.import.axi') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="d-flex align-items-end gap-2">
                <div class="form-group mb-0 w-100">
                    <label for="file">Upload Excel AXI</label>
                    <input type="file" name="file" class="form-control" accept=".xlsx, .xls" required>
                </div>
                <button type="submit" class="btn btn-success mb-1">Import AXI</button>
            </div>
        </form>
    </div>

    <div class="col-md-4"></div>

    <div class="col-md-2 d-flex" style="padding-top: 60px; padding-right:10px;">
        <form action="{{ route('admin.vitrox.truncate.axi') }}" method="POST"
            onsubmit="return confirm('Yakin ingin mengosongkan seluruh data AXI? Tindakan ini tidak bisa dibatalkan.');"
            class="w-100">
            @csrf
            <button type="submit" class="btn btn-danger w-100">Truncate AXI</button>
        </form>
    </div>
</div>

{{-- Tombol Tambah Data --}}
<button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#addAxiModal">
    + Tambah Data Manual
</button>

<table id="aoiTable" class="table table-bordered table-striped">
    <thead class="thead-dark">
        <tr>
            <th>Aksi</th>
            <th>PartNum</th>
            <th>PartDesc</th>
            <th>WareHouseCode</th>
            <th>BinNum</th>
            <th>MainTranQty</th>
            <th>PhysicalQty</th>
            <th>Remarks</th>
            <th>Pictures</th>
        </tr>
    </thead>
    <tbody>
        @isset($axiData)
        @foreach ($axiData as $item)
        <tr>
            <td class="text-center">
                <div class="d-flex justify-content-center align-items-center" style="gap: 8px;">
                     {{-- DETAIL button (mata) --}}
                    <a href="javascript:void(0);"
                        class="btn-detail"
                        title="Lihat Detail"
                        data-toggle="modal"
                        data-target="#detailModal"
                        data-id="{{ $item->id }}"
                        data-partnum="{{ $item->PartNum }}"
                        data-partdesc="{{ $item->PartDesc }}"
                        data-warehouse="{{ $item->WareHouseCode }}"
                        data-binnum="{{ $item->BinNum }}"
                        data-maintranqty="{{ $item->MainTranQty }}"
                        data-physicalqty="{{ $item->PhysicalQty }}"
                        data-remarks="{{ $item->mtscbat_remarks }}"
                        data-pictures="{{ $item->pictures ? asset($item->pictures) : '' }}">
                        <i class="fa fa-eye" style="color: #1e88e5; margin-right:8px;"></i>
                    </a>

                    {{-- EDIT button (pensil) --}}
                    <a href="javascript:void(0);"
                        class="btn-edit"
                        title="Edit Data"
                        data-toggle="modal"
                        data-target="#editModal"
                        data-id="{{ $item->id }}"
                        data-partnum="{{ $item->PartNum }}"
                        data-partdesc="{{ $item->PartDesc }}"
                        data-warehouse="{{ $item->WareHouseCode }}"
                        data-binnum="{{ $item->BinNum }}"
                        data-maintranqty="{{ $item->MainTranQty }}"
                        data-physicalqty="{{ $item->PhysicalQty }}"
                        data-remarks="{{ $item->mtscbat_remarks }}"
                        data-pictures="{{ $item->pictures ? asset($item->pictures) : '' }}">
                        <i class="fa fa-pencil" style="color: #28a745;"></i>
                    </a>
                    {{-- DELETE button (tong sampah) --}}
                    <form action="{{ route('admin.vitrox.delete.axi', $item->id) }}" method="POST" style="display:inline;"
                        onsubmit="return confirm('Yakin ingin menghapus data ini? Tindakan ini tidak bisa dibatalkan.');"
                        style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-link p-0 m-0" title="Hapus Data">
                            <i class="fa fa-trash" style="color: #dc3545;"></i>
                        </button>
                    </form>
                </div>
            </td>

            <td>{{ $item->PartNum }}</td>
            <td>{{ $item->PartDesc }}</td>
            <td>{{ $item->WareHouseCode }}</td>
            <td>{{ $item->BinNum }}</td>

            <td @if($item->MainTranQty != $item->PhysicalQty) style="background-color: yellow;" @endif>
                {{ $item->MainTranQty }}
            </td>
            <td @if($item->MainTranQty != $item->PhysicalQty) style="background-color: yellow;" @endif>
                {{ $item->PhysicalQty }}
            </td>

            <td>{{ $item->mtscbat_remarks }}</td>
            <td>
                @if($item->pictures)
                <img src="{{ asset($item->pictures) }}" alt="Picture" width="80" height="80">
                @else
                <span class="text-muted">No image</span>
                @endif
            </td>
        </tr>
        @endforeach
        @endisset
    </tbody>
</table>

{{-- DETAIL Modal (read-only) --}}
<div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 id="detailModalLabel" class="modal-title"><b>Detail Data AXI</b></h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {{-- show pictures (jika ada) --}}
                <div class="text-center mb-3">
                    <img id="detailPicture" src="" alt="Preview" style="max-height:200px; max-width:100%; display:none;">
                </div>

                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th>PartNum</th>
                            <td id="detailPartNum"></td>
                        </tr>
                        <tr>
                            <th>PartDesc</th>
                            <td id="detailPartDesc"></td>
                        </tr>
                        <tr>
                            <th>WareHouseCode</th>
                            <td id="detailWareHouseCode"></td>
                        </tr>
                        <tr>
                            <th>BinNum</th>
                            <td id="detailBinNum"></td>
                        </tr>
                        <tr>
                            <th>MainTranQty</th>
                            <td id="detailMainTranQty"></td>
                        </tr>
                        <tr>
                            <th>PhysicalQty</th>
                            <td id="detailPhysicalQty"></td>
                        </tr>
                        <tr>
                            <th>Remarks</th>
                            <td id="detailRemarks"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- Modal Tambah Data --}}
<div class="modal fade" id="addAxiModal" tabindex="-1" role="dialog" aria-labelledby="addAxiModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="{{ route('admin.vitrox.add.axi') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h3 class="modal-title" id="addAxiModalLabel"><b>Tambah Data AXI Manual</b></h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="form-group">
                        <label>Part Number</label>
                        <input type="text" name="PartNum" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Part Description</label>
                        <input type="text" name="PartDesc" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Warehouse Code</label>
                        <input type="text" name="WareHouseCode" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Bin Number</label>
                        <input type="text" name="BinNum" class="form-control">
                    </div>

                    <div class="form-group">
                        <label>Main Transaction Qty</label>
                        <input type="number" name="MainTranQty" class="form-control" step="0.01">
                    </div>

                    <div class="form-group">
                        <label>Physical Qty</label>
                        <input type="number" name="PhysicalQty" class="form-control" step="0.01">
                    </div>

                    <div class="form-group">
                        <label>Remarks</label>
                        <textarea name="mtscbat_remarks" class="form-control"></textarea>
                    </div>

                    <div class="form-group">
                        <label>Pictures (Upload Gambar)</label>
                        <input type="file" name="pictures" class="form-control-file" accept="image/*">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Simpan</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- EDIT Modal (form) --}}
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            {{-- form akan submit ke route update (controller harus membuat route dan logic) --}}
            <form id="editAxiForm" method="POST"
                action="{{ isset($item) ? route('admin.vitrox.update.axi', $item->id) : '' }}"
                enctype="multipart/form-data">

                @csrf
                {{-- gunakan hidden id agar controller tahu record mana yang diupdate --}}
                <input type="hidden" name="id" id="editId">

                <div class="modal-header">
                    <h3 id="editModalLabel" class="modal-title"><b>Edit Data AXI</b></h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    {{-- pictures preview + upload --}}
                    <div class="form-group text-center">
                        <img id="editPicturePreview" src="" alt="No image" style="max-height:180px; max-width:100%; display:none; margin-bottom:10px;">
                    </div>
                    <div class="form-group">
                        <label for="editPicture">Ganti/Gambar (optional)</label>
                        <input type="file" name="pictures" id="editPicture" class="form-control">
                        <small class="text-muted">Jika tidak mengupload gambar, gambar lama tetap dipakai.</small>
                    </div>

                    <div class="form-group">
                        <label for="editPartNum">PartNum</label>
                        <input type="text" name="PartNum" id="editPartNum" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="editPartDesc">PartDesc</label>
                        <input type="text" name="PartDesc" id="editPartDesc" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="editWareHouseCode">WareHouseCode</label>
                        <input type="text" name="WareHouseCode" id="editWareHouseCode" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="editBinNum">BinNum</label>
                        <input type="text" name="BinNum" id="editBinNum" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="editMainTranQty">MainTranQty</label>
                        <input type="number" name="MainTranQty" id="editMainTranQty" class="form-control" step="1" min="0">
                    </div>

                    <div class="form-group">
                        <label for="editPhysicalQty">PhysicalQty</label>
                        <input type="number" name="PhysicalQty" id="editPhysicalQty" class="form-control" step="1" min="0">
                    </div>

                    <div class="form-group">
                        <label for="editRemarks">Remarks</label>
                        <textarea name="mtscbat_remarks" id="editRemarks" class="form-control" rows="3"></textarea>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>



@endsection

@section('bot')
{{-- DataTables (Bootstrap 3) --}}
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap.min.js"></script>

<script>
    $(document).ready(function() {
        // init DataTable
        $('#aoiTable').DataTable({
            responsive: true,
            pageLength: 10,
            lengthChange: true,
            ordering: true,
            language: {
                search: "Cari:",
                lengthMenu: "Tampilkan _MENU_ data per halaman",
                zeroRecords: "Data tidak ditemukan",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                infoEmpty: "Tidak ada data tersedia",
                paginate: {
                    previous: "Sebelumnya",
                    next: "Berikutnya"
                }
            }
        });

        // DETAIL modal: isi field read-only dan tampilkan
        $('#aoiTable').on('click', '.btn-detail', function(e) {
            e.preventDefault();
            var $btn = $(this);
            $('#detailPartNum').text($btn.data('partnum') ?? '');
            $('#detailPartDesc').text($btn.data('partdesc') ?? '');
            $('#detailWareHouseCode').text($btn.data('warehouse') ?? '');
            $('#detailBinNum').text($btn.data('binnum') ?? '');
            $('#detailMainTranQty').text($btn.data('maintranqty') ?? '');
            $('#detailPhysicalQty').text($btn.data('physicalqty') ?? '');
            $('#detailRemarks').text($btn.data('remarks') ?? '');

            // pictures preview (show/hide)
            var pic = $btn.data('pictures') || '';
            if (pic) {
                $('#detailPicture').attr('src', pic).show();
            } else {
                $('#detailPicture').hide().attr('src', '');
            }
            e.stopPropagation()
            $('#detailModal').modal('show');
        });

        // EDIT modal: isi input form dan preview gambar
        $('#aoiTable').on('click', '.btn-edit', function(e) {
            e.preventDefault();
            var $btn = $(this);

            $('#editId').val($btn.data('id') ?? '');
            $('#editPartNum').val($btn.data('partnum') ?? '');
            $('#editPartDesc').val($btn.data('partdesc') ?? '');
            $('#editWareHouseCode').val($btn.data('warehouse') ?? '');
            $('#editBinNum').val($btn.data('binnum') ?? '');
            $('#editMainTranQty').val($btn.data('maintranqty') ?? '');
            $('#editPhysicalQty').val($btn.data('physicalqty') ?? '');
            $('#editRemarks').val($btn.data('remarks') ?? '');

            // pictures preview
            var pic = $btn.data('pictures') || '';
            if (pic) {
                $('#editPicturePreview').attr('src', pic).show();
            } else {
                $('#editPicturePreview').hide().attr('src', '');
            }

            // clear file input
            $('#editPicture').val('');
            e.stopPropagation()

            $('#editModal').modal('show');
        });

        // optional: preview image on file select in edit modal
        $('#editPicture').on('change', function() {
            var input = this;
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#editPicturePreview').attr('src', e.target.result).show();
                }
                reader.readAsDataURL(input.files[0]);
            }
        });
    });
</script>
@endsection