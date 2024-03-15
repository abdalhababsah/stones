<form action="{{ isset($homeImage) ? route('home.home-images.update', $homeImage) : route('home.home-images.store') }}" method="POST" id="homeImageForm" enctype="multipart/form-data">
    @if(isset($homeImage))
        @method('PUT')
    @endif
    @csrf
    <input type="hidden" name="id" value="{{ $homeImage->id ?? '' }}">
    <div class="row">
        <div class="col-md-6 mb-7">
            <label class="required fw-semibold fs-6 mb-2">Image Title</label>
            <input type="text" name="image_title" class="form-control form-control-solid-bg mb-2" placeholder="Image Name" value="{{ $homeImage->image_title ?? '' }}" required>
        </div>

        <!-- Adding the missing Sort Order input here -->
        <div class="col-md-6 mb-7">
            <label class="required fw-semibold fs-6 mb-2">Sort Order</label>
            <input type="number" name="sort_order" class="form-control form-control-solid-bg mb-2" placeholder="Sort Order" value="{{ $homeImage->sort_order ?? '' }}" required>
        </div>

        <div class="col-md-12 imgUp form-group">
            <label class="required fw-semibold d-block fs-6 mb-2">Home Image</label>
            <div class="image-input shadow-sm image-input-circle" data-kt-image-input="true" style="background-image: url(/assets/media/svg/avatars/blank.svg)">
                <div class="image-input-wrapper w-125px h-125px" style="background-image: url('{{ isset($homeImage) ? Storage::disk('s3')->url($homeImage->image_path) : '' }}');"></div>
                <label class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Change image">
                    <i class="ki-duotone ki-pencil fs-6"></i>
                    <input type="file" name="image_path" accept="image/*"/>
                </label>
                @if(isset($homeImage) && $homeImage->image_path)
                    <span class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="Remove image">
                        <i class="ki-outline ki-trash fs-3"></i>
                    </span>
                @endif
            </div>
        </div>

        <div class="col-md-12 form-group">
            <input type="submit" class="btn btn-light-success btn-sm float-end" value="Submit" id="btn-submit">
        </div>
    </div>
</form>

<script>
    KTImageInput.createInstances();
</script>
