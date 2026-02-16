@extends('layouts.master')

@section('top')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
@endsection

@section('content')

{{-- ALERT --}}
@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif
@if(session('error'))
<div class="alert alert-danger">{{ session('error') }}</div>
@endif

{{-- ================= TOP ACTION ================= --}}
<div class="row mb-4">
    {{-- IMPORT AOI --}}
    <div class="col-md-6 mt-5" style="padding-bottom: 50px;">
        <form action="{{ route('admin.vitrox.import.aoi') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="d-flex align-items-end gap-2">
                <div class="form-group mb-0 w-100">
                    <label>Upload Excel AOI</label>
                    <input type="file" name="file" class="form-control" accept=".xls,.xlsx" required
                        {{ $aoiData->count() > 0 ? 'disabled' : '' }}>
                </div>
                <button class="btn btn-success"
                    {{ $aoiData->count() > 0 ? 'disabled' : '' }}>
                    Import AOI
                </button>
                <label>
                    @if ($aoiData->count() > 0)
                    <small class="text-muted d-block mt-2">
                        AXI data already exists. Import is disabled.
                    </small>
                    @endif
                </label>
            </div>
        </form>
    </div>

    {{-- BULK IMAGE --}}
    <div class="col-md-6 mt-4 d-flex">
        <form action="{{ route('admin.vitrox.aoi.bulkUploadImages') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label>Bulk Upload AOI Images</label>
                <input type="file" name="images[]" class="form-control" multiple accept="image/*" required>
            </div>
            <button class="btn btn-primary">Upload Images</button>
        </form>
    </div>

    <div class="col-md-8 d-flex"></div>
    <div class="col-md-2 d-flex" style="padding-left: 10px; padding-bottom: 5px; padding-right: 5px; display:flex; justify-content:flex-end;">
        {{-- Tombol Tambah Data --}}
        <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#addAxiModal">
            + Tambah Data Manual
        </button>
    </div>

    <div class="col-md-2 d-flex" style="padding-bottom: 5px; padding-right: 10px; display:flex; justify-content:flex-end;">
        <form action="{{ route('admin.vitrox.truncate.axi') }}" method="POST"
            onsubmit="return confirm('Yakin ingin mengosongkan seluruh data AXI? Tindakan ini tidak bisa dibatalkan.');"
            class="w-50">
            @csrf
            <button type="submit" class="btn btn-danger w-50">Truncate AXI</button>
        </form>
    </div>

</div>

<div style="border-bottom: 2px solid #ccc; margin: 20px 0;"></div>

{{-- ================= TABLE ================= --}}
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
        @foreach($aoiData as $item)
        <tr>

            {{-- AKSI --}}
            <td class="text-center">
                <div class="d-flex justify-content-center" style="gap:8px;">

                    <a href="javascript:void(0)"
                        class="btn-detail"
                        data-toggle="modal"
                        data-target="#detailModal"
                        data-partnum="{{ $item->PartNum }}"
                        data-partdesc="{{ $item->PartDesc }}"
                        data-warehouse="{{ $item->WareHouseCode }}"
                        data-binnum="{{ $item->BinNum }}"
                        data-maintranqty="{{ $item->MainTranQty }}"
                        data-physicalqty="{{ $item->PhysicalQty }}"
                        data-remarks="{{ $item->mtscbat_remarks }}">
                        <i class="fa fa-eye text-primary"></i>
                    </a>
                    {{-- EDIT button (pensil) --}}
                    <a href="javascript:void(0);"
                        class="btn-edit"
                        title="Edit Data"
                        data-toggle="modal"
                        data-target="#editModal"
                        data-id="{{ $item->aoi_id }}"
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
                    <form action="{{ route('admin.vitrox.delete.aoi', $item->aoi_id) }}"
                        method="POST"
                        onsubmit="return confirm('Hapus data ini?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-link p-0">
                            <i class="fa fa-trash text-danger"></i>
                        </button>
                    </form>

                </div>
            </td>

            <td>{{ $item->PartNum }}</td>
            <td>{{ $item->PartDesc }}</td>
            <td>{{ $item->WareHouseCode }}</td>
            <td>{{ $item->BinNum }}</td>

            <td @if($item->MainTranQty != $item->PhysicalQty) style="background:yellow;" @endif>
                {{ $item->MainTranQty }}
            </td>
            <td @if($item->MainTranQty != $item->PhysicalQty) style="background:yellow;" @endif>
                {{ $item->PhysicalQty }}
            </td>

            <td>{{ $item->mtscbat_remarks }}</td>

            {{-- PICTURES --}}
            <td>
                @if($item->images && $item->images->count())
                @foreach($item->images as $img)
                <img src="{{ asset($img->image_path) }}"
                    width="70"
                    class="img-thumbnail mb-1">
                @endforeach
                @else
                <span class="text-muted">No image</span>
                @endif
            </td>

        </tr>
        @endforeach
    </tbody>
</table>

{{-- ================= DETAIL MODAL ================= --}}
<div class="modal fade" id="detailModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Detail AOI</h4>
                <button class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered">
                    <tr>
                        <th>PartNum</th>
                        <td id="dPartNum"></td>
                    </tr>
                    <tr>
                        <th>PartDesc</th>
                        <td id="dPartDesc"></td>
                    </tr>
                    <tr>
                        <th>Warehouse</th>
                        <td id="dWarehouse"></td>
                    </tr>
                    <tr>
                        <th>Bin</th>
                        <td id="dBin"></td>
                    </tr>
                    <tr>
                        <th>Main Qty</th>
                        <td id="dMainQty"></td>
                    </tr>
                    <tr>
                        <th>Physical Qty</th>
                        <td id="dPhysicalQty"></td>
                    </tr>
                    <tr>
                        <th>Remarks</th>
                        <td id="dRemarks"></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
{{-- Modal Tambah Data --}}
<div class="modal fade" id="addaoiModal" tabindex="-1" role="dialog" aria-labelledby="addaoiModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="{{ route('admin.vitrox.add.aoi') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h3 class="modal-title" id="addaoiModalLabel"><b>Tambah Data aoi Manual</b></h3>
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
            <form id="editaoiForm" method="POST"
                action="{{ isset($item) ? route('admin.vitrox.update.aoi', $item->aoi_id) : '' }}"
                enctype="multipart/form-data">

                @csrf
                {{-- gunakan hidden id agar controller tahu record mana yang diupdate --}}
                <input type="hidden" name="id" id="editId">

                <div class="modal-header">
                    <h3 id="editModalLabel" class="modal-title"><b>Edit Data aoi</b></h3>
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
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>

<script>
    $(function() {

        $('#aoiTable').DataTable({
            pageLength: 10,
            ordering: true,
            language: {
                search: "Cari:",
                zeroRecords: "Data tidak ditemukan"
            }
        });

        $('.btn-detail').click(function() {
            $('#dPartNum').text($(this).data('partnum'));
            $('#dPartDesc').text($(this).data('partdesc'));
            $('#dWarehouse').text($(this).data('warehouse'));
            $('#dBin').text($(this).data('binnum'));
            $('#dMainQty').text($(this).data('maintranqty'));
            $('#dPhysicalQty').text($(this).data('physicalqty'));
            $('#dRemarks').text($(this).data('remarks'));
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