<a href="#" class="btn btn-light btn-active-light-primary btn-flex btn-center btn-sm" data-kt-menu-trigger="click"
   data-kt-menu-placement="bottom-end">
    Actions
    <i class="ki-duotone ki-down fs-5 ms-1"></i>
</a>
<!--begin::Menu-->
<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4"
     data-kt-menu="true">
    <!--begin::Menu item-->
    <div class="menu-item px-3">
        <a href="{{ route('catalog.products.show', $product) }}" class="menu-link px-3">
            View
        </a>
    </div>
    <!--end::Menu item-->

    <!--begin::Menu item-->
    <div class="menu-item px-3">
        <a href="{{ route('catalog.products.edit', ['product' => $product->id]) }}" class="menu-link px-3" data-kt-product-id="{{ $product->id }}" >
            Edit
        </a>
    </div>
    <!--end::Menu item-->

    <!--begin::Menu item-->
    <div class="menu-item px-3">
        <a href="#" class="menu-link px-3 remove_btn" id="{{ $product->id }}" data-kt-action="delete_row">
            Delete
        </a>
    </div>
    <!--end::Menu item-->
</div>
<script>
    KTMenu.createInstances();
</script>
<!--end::Menu-->
{{--<td class="text-end d-flex flex-nowrap">--}}
{{--    <!-- View Button -->--}}
{{--    <a href="{{ route('catalog.products.show', $product) }}" class="btn btn-sm btn-light btn-active-light-primary me-1" title="View">--}}
{{--        <i class="fad fa-eye text-hover-primary fa-xl"></i>--}}
{{--    </a>--}}

{{--    <!-- Edit Button -->--}}
{{--    <a href="{{ route('catalog.products.edit', ['product' => $product->id]) }}" class="btn btn-sm btn-light btn-active-light-primary edit_btn me-1" data-kt-product-id="{{ $product->id }}" title="Edit">--}}
{{--        <i class="fad fa-edit text-hover-primary fa-xl"></i>--}}
{{--    </a>--}}

{{--    <!-- Delete Button -->--}}
{{--    <a href="#" class="btn btn-sm btn-light btn-active-light-danger remove_btn" data-kt-product-id="{{ $product->id }}" data-kt-action="delete_row" title="Delete">--}}
{{--        <i class="fad fa-trash-alt text-hover-danger fa-xl"></i>--}}
{{--    </a>--}}

{{--</td>--}}
