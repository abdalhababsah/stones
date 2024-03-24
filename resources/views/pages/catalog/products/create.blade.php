<x-default-layout>
    @section('title') Products @endsection @section('breadcrumbs') {{
  Breadcrumbs::render('products.index') }} @endsection

    <!--begin::Main-->
    <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
        <!--begin::Content wrapper-->
        <div class="d-flex flex-column flex-column-fluid">

            <!--begin::Content-->
            <div id="kt_app_content" class="app-content flex-column-fluid">
                <!--begin::Content container-->
                <div id="kt_app_content_container" class="app-container container-xxl">
                    <!--begin::Form-->
                    <form id="add_product_form" class="form d-flex flex-column flex-lg-row" data-kt-redirect="apps/ecommerce/catalog/products.html" enctype="multipart/form-data" method="post">
                        <!--begin::Aside column-->
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <div class="d-flex flex-column gap-7 gap-lg-10 w-100 w-lg-300px mb-7 me-lg-10">
                            <!--begin::Status-->
                            <div class="card card-flush py-4">
                                <!--begin::Card header-->
                                <div class="card-header">
                                    <!--begin::Card title-->
                                    <div class="card-title">
                                        <h2>Status</h2>
                                    </div>
                                    <!--end::Card title-->
                                    <!--begin::Card toolbar-->
                                    <div class="card-toolbar">
                                        <div
                                                class="rounded-circle bg-success w-15px h-15px"
                                                id="kt_ecommerce_add_product_status"
                                        ></div>
                                    </div>
                                    <!--begin::Card toolbar-->
                                </div>
                                <!--end::Card header-->
                                <!--begin::Card body-->
                                <div class="card-body pt-0">
                                    <!--begin::Select2-->
                                    <select  name="status" class="form-select mb-2" data-control="select2" data-hide-search="true" data-placeholder="Select an option" id="kt_ecommerce_add_product_status_select">
                                        <option></option>
                                        <option value="active" selected="selected">Active</option>
                                        <option value="inactive">Inactive</option>
                                    </select>
                                    <!--end::Select2-->
                                    <!--begin::Description-->
                                    <div class="text-muted fs-7">Set the product status.</div>
                                    <!--end::Description-->
                                </div>
                                <!--end::Card body-->
                            </div>
                            <!--end::Status-->
                            <!--begin::Category & tags-->
                            <div class="card card-flush py-4">
                                <!--begin::Card header-->
                                <div class="card-header">
                                    <!--begin::Card title-->
                                    <div class="card-title">
                                        <h2>Product Details</h2>
                                    </div>
                                    <!--end::Card title-->
                                </div>
                                <!--end::Card header-->
                                <!--begin::Card body-->
                                <div class="card-body pt-0">
                                    <!--begin::Input group-->
                                    <!--begin::Label-->
                                    <label class="form-label">Categories</label>
                                    <!--end::Label-->
                                    <!--begin::Select2-->
                                    <select name="category_id" class="form-select mb-2" data-control="select2" data-placeholder="Select an option" data-allow-clear="true">
                                        <option></option>
                                        @foreach($categories as $category)
                                            <option value="{{$category->id}}">
                                                {{$category->name_en}} , {{$category->name_ar}}
                                            </option>
                                        @endforeach
                                    </select>
                                    <!--end::Select2-->
                                    <!--begin::Description-->
                                    <div class="text-muted fs-7 mb-7">
                                        Add product to a category.
                                    </div>
                                    <!--end::Description-->
                                    <label class="form-label">Category Type</label>

                                    <select
                                            name="category_type"
                                            class="form-select mb-2"
                                            data-control="select2"
                                            data-hide-search="true"
                                            data-placeholder="Select an option"
                                            id="kt_ecommerce_add_product_category_type_select"
                                    >
                                        <option></option>
                                        <option value="normal">Normal</option>
                                        <option value="new">New</option>
                                        <option value="hot">Hot</option>
                                        <option value="featured">Featured</option>
                                    </select>
                                    <!--end::Select2-->
                                    <!--begin::Description-->
                                    <div class="text-muted fs-7">Set the category type.</div>
                                </div>
                                <!--end::Card body-->
                            </div>
                            <!--end::Category & tags-->

                            <div class="card card-flush py-4">
                                <!--begin::Card header-->
                                <div class="card-header">
                                    <div class="card-title">
                                        <h2>Product Dimensions</h2>
                                    </div>
                                </div>
                                <!--end::Card header-->
                                <!--begin::Card body-->
                                <div class="card-body pt-0">
                                    <!--begin::Input group-->

                                    <!--end::Input group-->
                                    <!--begin::Shipping form-->
                                    <div id="kt_ecommerce_add_product_shipping" class="mt-10">
                                        <!--end::Input group-->
                                        <!--begin::Input group-->
                                        <div class="fv-row">
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <div
                                                    class="d-flex flex-nowrap flex-lg-wrap flex-column flex-sm-nowrap flex-md-nowrap gap-3"
                                            >
                                                <input type="number"  id="width" name="dimensions[width]" class="form-control mb-2" placeholder="Width (w)" value=""/>
                                                <input type="number" id="height" name="dimensions[height]" class="form-control mb-2" placeholder="Height (h)" value=""/>
                                                <input type="number" id="length" name="dimensions[length]" class="form-control mb-2" placeholder="Lengtn (l)" value=""/>
                                                <input type="hidden"  name="dimensions[dimension_unit]" value="cm" />
                                            </div>
                                            <div class="text-muted fs-7">
                                                Enter the product dimensions in centimeters (cm).
                                            </div>
                                            <!--end::Description-->
                                        </div>
                                        <!--end::Input group-->
                                    </div>
                                    <!--end::Shipping form-->
                                </div>
                                <!--end::Card header-->
                            </div>
                        </div>
                        <!--end::Aside column-->
                        <!--begin::Main column-->
                        <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
                            <div class="tab-content">
                                <!--begin::Tab pane-->
                                <div
                                        class="tab-pane fade show active"
                                        id="kt_ecommerce_add_product_general"
                                        role="tab-panel"
                                >
                                    <div class="d-flex flex-column gap-7 gap-lg-10">
                                        <!--begin::General options-->
                                        <div
                                                style="padding-bottom: 9rem !important"
                                                class="card card-flush py-4"
                                        >
                                            <!--begin::Card header-->
                                            <div class="card-header">
                                                <div class="card-title">
                                                    <h2>General</h2>
                                                </div>
                                            </div>
                                            <!--end::Card header-->
                                            <!--begin::Card body-->
                                            <div class="card-body pt-0">
                                                <!--begin::Input group for Product Name-->
                                                <div class="row">
                                                    <!-- Product Name English -->
                                                    <div class="col-md-6 mb-10 fv-row">
                                                        <label class="required form-label"
                                                        >Product Name (English)</label
                                                        >
                                                        <input
                                                                id="name_en"
                                                                type="text"
                                                                name="name_en"
                                                                class="form-control mb-2"
                                                                placeholder="Product name in English"
                                                                value=""
                                                        />
                                                        <div class="text-muted fs-7">
                                                            A product name in English is required and
                                                            recommended to be unique.
                                                        </div>
                                                    </div>
                                                    <!-- Product Name Arabic -->
                                                    <div class="col-md-6 mb-10 fv-row">
                                                        <label class="required form-label"
                                                        >اسم المنتج (Arabic)</label
                                                        >
                                                        <input
                                                                id="name_ar"
                                                                type="text"
                                                                name="name_ar"
                                                                class="form-control mb-2"
                                                                placeholder="اسم المنتج بالعربية"
                                                                value=""
                                                        />
                                                        <div class="text-muted fs-7">
                                                            اسم المنتج باللغة العربية مطلوب ويُنصح بأن يكون
                                                            فريدًا.
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--end::Input group for Product Name-->

                                                <!--begin::Input group for Description-->
                                                <div class="row">
                                                    <!-- Description English -->
                                                    <div class="col-md-6">
                                                        <label class="form-label"
                                                        >Description (English)</label
                                                        >
                                                        <textarea
                                                                name="description_en"
                                                                id="kt_ecommerce_add_product_description_en"
                                                                class="form-control mb-2"
                                                                placeholder="Description in English"
                                                        ></textarea>
                                                        <div class="text-muted fs-7">
                                                            Set an English description for better visibility.
                                                        </div>
                                                    </div>
                                                    <!-- Description Arabic -->
                                                    <div class="col-md-6">
                                                        <label class="form-label">الوصف (Arabic)</label>
                                                        <textarea
                                                                name="description_ar"
                                                                id="kt_ecommerce_add_product_description_ar"
                                                                class="form-control mb-2"
                                                                placeholder="الوصف بالعربية"
                                                        ></textarea>
                                                        <div class="text-muted fs-7">
                                                            ضع وصفًا باللغة العربية لزيادة الوضوح.
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--end::Input group for Description-->
                                            </div>
                                            <!--end::Card body-->
                                        </div>
                                        <!--end::General options-->

                                        <!--begin::Media-->
                                        <div class="card card-flush py-4">
                                            <!--begin::Card header-->
                                            <div class="card-header">
                                                <div class="card-title">
                                                    <h2>Media</h2>
                                                </div>
                                            </div>
                                            <!--end::Card header-->
                                            <!--begin::Card body-->
                                            <div class="card-body pt-0">
                                                <!--begin::Input group-->
                                                <div class="fv-row mb-2">
                                                    <!--begin::Dropzone-->
                                                    <div
                                                            class="dropzone"
                                                            id="kt_ecommerce_add_product_media"
                                                    >
                                                        <!--begin::Message-->
                                                        <div class="dz-message needsclick">
                                                            <!--begin::Icon-->
                                                            <i class="ki-duotone ki-file-up text-primary fs-3x">
                                                                <span class="path1"></span>
                                                                <span class="path2"></span>
                                                            </i>
                                                            <!--end::Icon-->
                                                            <!--begin::Info-->
                                                            <div class="ms-4">
                                                                <h3 class="fs-5 fw-bold text-gray-900 mb-1">
                                                                    Drop files here or click to upload.
                                                                </h3>
                                                                <span class="fs-7 fw-semi bold text-gray-500"
                                                                >Upload up to 10 files</span
                                                                >
                                                            </div>
                                                            <!--end::Info-->
                                                        </div>
                                                    </div>
                                                    <!--end::Dropzone-->
                                                </div>
                                                <!--end::Input group-->
                                                <!--begin::Description-->
                                                <div class="text-muted fs-7">
                                                    Set the product media gallery.
                                                </div>
                                                <!--end::Description-->
                                            </div>
                                            <!--end::Card header-->
                                        </div>
                                        <!--end::Media-->
                                        <!--begin::Inventory-->
                                        <div class="card card-flush py-4">
                                            <!--begin::Card header-->
                                            <div class="card-header">
                                                <div class="card-title">
                                                    <h2>Inventory</h2>
                                                </div>
                                            </div>
                                            <!--end::Card header-->
                                            <!--begin::Card body-->
                                            <div class="card-body pt-0">

                                                <div class="mb-10 fv-row">
                                                    <!--begin::Label-->
                                                    <label class="required form-label"
                                                    >Quantity (in square meters)</label
                                                    >
                                                    <!--end::Label-->
                                                    <!--begin::Input-->
                                                    <div class="d-flex gap-3">
                                                        <input
                                                                id="quantity_available"
                                                                type="number"
                                                                name="quantity_available"
                                                                class="form-control mb-2"
                                                                placeholder="Quantity in m²"
                                                                value=""
                                                        />
                                                    </div>
                                                    <!--end::Input-->
                                                    <!--begin::Description-->
                                                    <div class="text-muted fs-7">
                                                        Enter the product quantity in square meters.
                                                    </div>
                                                    <!--end::Description-->
                                                </div>
                                                <!--end::Input group-->
                                            </div>
                                            <!--end::Card header-->
                                        </div>
                                        <!--end::Inventory-->
                                        <!--begin::Variations-->
                                        <div class="card card-flush py-4">
                                            <!--begin::Card header-->
                                            <div class="card-header">
                                                <div class="card-title">
                                                    <h2>Variations</h2>
                                                </div>
                                            </div>
                                            <!--end::Card header-->
                                            <!--begin::Card body-->
                                            <div class="card-body pt-0">
                                                <!--begin::Input group-->
                                                <div
                                                        class=""
                                                        data-kt-ecommerce-catalog-add-product="auto-options"
                                                >
                                                    <!--begin::Label-->
                                                    <label class="form-label"
                                                    >Add Product Variations</label
                                                    >
                                                    <!--end::Label-->
                                                    <!--begin::Repeater-->
                                                    <div id="kt_ecommerce_add_product_options">
                                                        <!--begin::Form group-->
                                                        <div class="form-group">
                                                            <div
                                                                    data-repeater-list="kt_ecommerce_add_product_options"
                                                                    class="d-flex flex-column gap-3">
                                                                <div
                                                                        data-repeater-item=""
                                                                        class="form-group d-flex flex-wrap align-items-center gap-5">
                                                                    <!--begin::Select for Variation Type-->
                                                                    <div class="w-100 w-md-200px">
                                                                        <select class=" variant form-select" name="variants[0][variant_type_id]" data-placeholder="Select a variation" data-kt-ecommerce-catalog-add-product="product_option">
                                                                            <option></option>
                                                                            @foreach($variants as $variantType)
                                                                                <option value="{{ $variantType->id }}">
                                                                                    {{ $variantType->name_en }} , {{ $variantType->name_ar }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <!--end::Select-->
                                                                    <!--begin::Input for English Variation-->
                                                                    <input
                                                                            id="en_variation"
                                                                            name="variants[0][variant_value_en]"
                                                                            type="text"
                                                                            class="form-control mw-100 w-200px"
                                                                            placeholder="Variation (English)"
                                                                    />
                                                                    <!--end::Input-->
                                                                    <!--begin::Input for Arabic Variation-->
                                                                    <input id="ar_variation" type="text " class="form-control mw-100 w-200px" name="variants[0][variant_value_ar]" placeholder="Variation (Arabic)"/>
                                                                    <!--end::Input-->
                                                                    <button type="button" data-repeater-delete="" class="btn btn-sm btn-icon btn-light-danger">
                                                                        <i class="ki-duotone ki-cross fs-1">
                                                                            <span class="path1"></span>
                                                                            <span class="path2"></span>
                                                                        </i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!--end::Form group-->
                                                        <!--begin::Form group-->
                                                        <div class="form-group mt-5">
                                                            <button type="button" data-repeater-create="" class="btn btn-sm btn-light-primary">
                                                                <i class="ki-duotone ki-plus fs-2"></i>Add
                                                                another variation
                                                            </button>
                                                        </div>
                                                        <!--end::Form group-->
                                                    </div>
                                                    <!--end::Repeater-->
                                                </div>
                                                <!--end::Input group-->
                                            </div>
                                            <!--end::Card header-->
                                        </div>
                                        <!--end::Variations-->
                                    </div>
                                </div>
                                <!--end::Tab pane-->

                                <!--end::Tab pane-->
                            </div>
                            <!--end::Tab content-->
                            <div class="d-flex justify-content-end">
                                <!--begin::Button-->
                                <a
                                        href="apps/ecommerce/catalog/products.html"
                                        id="kt_ecommerce_add_product_cancel"
                                        class="btn btn-light me-5"
                                >Cancel</a
                                >
                                <!--end::Button-->
                                <!--begin::Button-->
                                <button
                                        type="submit"
                                        id="kt_ecommerce_add_product_submit"
                                        class="btn btn-primary"
                                >
                                    <span class="indicator-label">Save Changes</span>
                                    <span class="indicator-progress"
                                    >Please wait...
                    <span
                            class="spinner-border spinner-border-sm align-middle ms-2"
                    ></span
                    ></span>
                                </button>
                                <!--end::Button-->
                            </div>
                        </div>
                        <!--end::Main column-->
                    </form>
                    <!--end::Form-->
                </div>
                <!--end::Content container-->
            </div>
            <!--end::Content-->
        </div>
        <!--end::Content wrapper-->
    </div>
    <!--end:::Main-->
    <script src="https://code.jquery.com/jquery-3.x-git.min.js"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function () {
            // Initialize select2 for the first load
            initSelect2();

            // Initialize the repeater
            initRepeater();

            // Function to initialize select2
            function initSelect2() {
                $('.variant').select2();
                $('.variant').on('change', function() {
                    updateVariantNames();
                });
            }

            // Function to handle adding new variant
            function initRepeater() {
                $("[data-repeater-create]").click(function () {
                    var repeaterList = $("[data-repeater-list]");
                    var newItem = repeaterList.find("[data-repeater-item]:first").clone();

                    newItem.find("input").val(""); // Reset input values
                    newItem.find("select").prop("selectedIndex", 0); // Reset select values

                    // Remove the duplicated select2 container if any and re-initialize select2
                    newItem.find('.select2-container').remove();
                    repeaterList.append(newItem);
                    initSelect2(); // Reinitialize select2 for new dropdowns

                    updateVariantNames();
                    checkVariantDeletability();
                });

                // Handle deletion of a variant
                $(document).on("click", "[data-repeater-delete]", function () {
                    if ($('[data-repeater-item]').length > 1) {
                        $(this).closest("[data-repeater-item]").remove();
                        updateVariantNames();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'At least one variant is required!',
                        });
                    }
                    checkVariantDeletability();
                });
            }
            function checkVariantDeletability() {
                if ($('[data-repeater-item]').length <= 1) {
                    $('[data-repeater-delete]').prop('disabled', true).addClass('disabled');
                } else {
                    $('[data-repeater-delete]').prop('disabled', false).removeClass('disabled');
                }
            }
            checkVariantDeletability();
            // Update variant input names based on their order in the list
            function updateVariantNames() {
                $('[data-repeater-list]').find('[data-repeater-item]').each(function(index, item) {
                    $(item).find('[name]').each(function() {
                        var name = $(this).attr('name').replace(/variants\[\d+\]/, 'variants[' + index + ']');
                        $(this).attr('name', name);
                    });
                });
            }
        });




        $(document).ready(function () {
            var myDropzone = new Dropzone("#kt_ecommerce_add_product_media", {
                url: "#", // Replace "#" with your actual submission script
                autoProcessQueue: false,
                uploadMultiple: true,
                paramName: "images",
                maxFiles: 10,
                maxFilesize: 10,
                addRemoveLinks: true,
            });

            $('#add_product_form').on('submit', function (e) {
                e.preventDefault(); // Prevent form from submitting immediately

                // Validate form inputs
                var isValid = true;
                var messages = [];

                // Additional validation for Dropzone (images)
                if (myDropzone.files.length === 0) {
                    isValid = false;
                    messages.push("At least one image is required.");
                }
                // Check product name in English and Arabic
                if ($('#name_en').val().trim() === '') {
                    isValid = false;
                    messages.push('Product Name (English) is required.');
                }
                if ($('#name_ar').val().trim() === '') {
                    isValid = false;
                    messages.push('اسم المنتج (Arabic) is required.');
                }

                // Check descriptions
                if ($('#kt_ecommerce_add_product_description_en').val().trim() === '') {
                    isValid = false;
                    messages.push('Description (English) is required.');
                }
                if ($('#kt_ecommerce_add_product_description_ar').val().trim() === '') {
                    isValid = false;
                    messages.push('الوصف (Arabic) is required.');
                }
                if ($('select[name="category_type"]').val() === '') {
                    isValid = false;
                    messages.push("Category type is required.");
                }
                // Check category selection
                if (!$('select[name="category_id"]').val()) {
                    isValid = false;
                    messages.push('Category is required.');
                }

                var variationsValid = true;
                $('select[name^="variants"]').each(function() {
                    if (!$(this).val()) variationsValid = false;
                });
                if (!variationsValid) {
                    isValid = false;
                    messages.push("At least one variation is required.");
                }
                // Check status selection
                if (!$('select[name="status"]').val()) {
                    isValid = false;
                    messages.push('Status is required.');
                }

                // Dimensions validation
                ['width', 'height', 'length'].forEach(function (dimension) {
                    var dimensionValue = parseFloat($('input[name="dimensions['+dimension+']"]').val());
                    if ($('input[name="dimensions['+dimension+']"]').val().trim() === '' || isNaN(dimensionValue) || dimensionValue <= 0) {
                        isValid = false;
                        messages.push(`Product ${dimension} is required and must be a positive number.`);
                    }
                });


                // Check quantity - it must be numeric and a positive number
                var quantityAvailable = parseFloat($('#quantity_available').val());
                if ($('#quantity_available').val().trim() === '' || isNaN(quantityAvailable) || quantityAvailable <= 0) {
                    isValid = false;
                    messages.push('Quantity (in square meters) is required,and must be a positive number.');
                }


                // Display validation errors or proceed to submit
                if (!isValid) {
                    // Update messages with line numbers
                    messages = messages.map((message, index) => (index + 1) + '. ' + message);

                    Swal.fire({
                        icon: 'error',
                        title: 'Validation Error',
                        html: messages.join('<br>'),
                        customClass: {
                            htmlContainer: 'text-left'
                        },
                        didOpen: () => {
                            // This ensures the custom class styles are applied
                            const container = Swal.getHtmlContainer();
                            if (container) {
                                container.style.textAlign = 'left';
                            }
                        }
                    });

                } else {
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "Do you want to proceed with these details?",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, submit it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Form is valid, proceed to submit
                            var formData = new FormData(this);
                            myDropzone.files.forEach(function(file, index) {
                                formData.append('images[' + index + ']', file);
                            });

                            $.ajax({
                                url: '{{ route("catalog.products.store") }}',
                                type: 'POST',
                                data: formData,
                                contentType: false,
                                processData: false,
                                headers: {
                                    'X-CSRF-TOKEN': $('input[name="_token"]').val()
                                },
                                success: function(response) {
                                    Swal.fire({
                                        title: 'Submitted!',
                                        text: 'Product created successfully.',
                                        icon: 'success'
                                    }).then((result) => {
                                        if (result.value) {
                                            window.location.href = '{{ route("catalog.products.index") }}'; // Specify the path to redirect
                                        }
                                    });
                                },
                                error: function(xhr, status, error) {
                                    // Check if there are validation errors
                                    if (xhr.status === 422 || xhr.status === 500) {                                        var errors = xhr.responseJSON.errors;
                                        var errorMessages = Object.keys(errors).map(function(key) {
                                            return errors[key].join('<br>');
                                        }).join('<br>');

                                        Swal.fire('Validation Error', errorMessages, 'error');
                                    } else {
                                        // Handle other errors
                                        Swal.fire('Error!', 'An error occurred. Please try again.', 'error');
                                    }
                                }
                            });
                        }
                    });
                }
            });
        });

    </script>


    <script src="{{ asset('assets/plugins/custom/formrepeater/formrepeater.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/custom/apps/ecommerce/catalog/save-product.js') }}"></script>
    <!--begin::Global Javascript Bundle-->
    <script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
</x-default-layout>
