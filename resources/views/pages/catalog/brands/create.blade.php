@if(isset($brand))
    <form action="{{ route('catalog.brands.update', $brand) }}" id="brandForm" method="POST"
          enctype="multipart/form-data">
        @method('PUT')
        @csrf
        <input type="hidden" name="id" value="{{ $brand->id }}">
        @else
            <form action="{{ route('catalog.brands.store') }}" method="POST" id="brandForm"
                  enctype="multipart/form-data">
                @endif
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-7">
                        <label class="required fw-semibold fs-6 mb-2">Name</label>
                        <input type="text" name="name_en" class="form-control form-control-solid-bg mb-2"
                               placeholder="Brand Name" @isset($brand) value="{{ $brand->name_en }}" @endisset>
                    </div>
                    <div class="col-md-6 mb-7">
                        <label class="required fw-semibold fs-6 mb-2">Order</label>
                        <input type="number" name="sort_order"
                               class="form-control form-control-solid-bg mb-2 @error('sort_order') is-invalid @enderror"
                               placeholder="Order" @isset($brand) value="{{ $brand->sort_order }}" @endisset>
                    </div>

                    <div class="col-md-2 imgUp form-group">

                        <label class="required fw-semibold  d-block fs-6 mb-2">Brand Icon</label>
                        <div class="image-input shadow-sm image-input-circle" data-kt-image-input="true"
                             style="background-image: url(/assets/media/svg/avatars/blank.svg)">
                            <!--begin::Image preview wrapper-->
                            <div class="image-input-wrapper w-125px h-125px"
                                 @if(isset($brand)) style="background:url('{{$brand->icon_path ?: config('filesystems.disks.s3.url').$brand->logo_path }}');" @endif></div>
                            <!--end::Image preview wrapper-->

                            <!--begin::Edit button-->
                            <label
                                    class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow"
                                    data-kt-image-input-action="change" data-bs-toggle="tooltip" data-bs-dismiss="click"
                                    title="Change avatar">
                                <i class="ki-duotone ki-pencil fs-6"><span class="path1"></span><span
                                            class="path2"></span></i>

                                <!--begin::Inputs-->
                                <input type="file" name="icon_path" id="logo_path" class="uploadFile img"
                                       accept="image/*"
                                       style="width: 0px;height: 0px;overflow: hidden;" @if(isset($brand))
                                           value="{{ $brand->icon_path }}" @endif />

                                <!--end::Inputs-->
                            </label>
                            <!--end::Edit button-->

                            <!--begin::Cancel button-->
                            <span
                                    class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow"
                                    data-kt-image-input-action="cancel" data-bs-toggle="tooltip" data-bs-dismiss="click"
                                    title="Cancel avatar">
                        <i class="ki-outline ki-cross fs-3"></i>
                    </span>
                            <!--end::Cancel button-->

                            <!--begin::Remove button-->
                            <span
                                    class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow"
                                    data-kt-image-input-action="remove" data-bs-toggle="tooltip" data-bs-dismiss="click"
                                    title="Remove avatar">
                        <i class="ki-outline ki-cross fs-3"></i>
                    </span>
                            <!--end::Remove button-->
                        </div>
                        <!--end::Image input-->
                    </div>
                    <div class="col-md-12 form-group">
                        <input type="submit" class="btn btn-light-success btn-sm float-end" value="Submit"
                               id="btn-submit">
                    </div>
                </div>
            </form>


            <script>
                KTImageInput.createInstances();

            </script>