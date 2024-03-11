<x-default-layout>

    @section('title')
        Brands
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('brands.index') }}
    @endsection

    <div class="card">
        <!--begin::Card header-->
        <div class="card-header border-0 pt-6">
            <!--begin::Card title-->
            <div class="card-title">
                <!--begin::Search-->
                <div class="d-flex align-items-center position-relative my-1">
                    {!! getIcon('magnifier', 'fs-3 position-absolute ms-5') !!}
                    <input type="text" data-kt-user-table-filter="search"
                           class="form-control form-control-solid w-250px ps-13" placeholder="Search Brand"
                           id="mySearchInput"/>
                </div>
                <!--end::Search-->
            </div>
            <!--begin::Card title-->

            <!--begin::Card toolbar-->
            <div class="card-toolbar">
                <!--begin::Toolbar-->
                <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                    <!--begin::Add user-->
                    <a class="btn btn-light-primary" id="add_brand">
                        {!! getIcon('plus', 'fs-2', '', 'i') !!}
                        Add Brand
                    </a>
                    <!--end::Add user-->
                </div>
                <!--end::Toolbar-->
            </div>
            <!--end::Card toolbar-->
        </div>
        <!--end::Card header-->

        <!--begin::Card body-->
        <div class="card-body py-4">
            <!--begin::Table-->
            <div class="table-responsive">
                {{ $dataTable->table() }}
            </div>
            <!--end::Table-->
        </div>
        <!--end::Card body-->
    </div>

    @push('scripts')
        {{ 
            $dataTable->scripts() 
        }}

        <script>

            addModal('add_brand', '{{ route('catalog.brands.create') }}', 'Add Brand', 'brandForm', 'brands-table');
            editModal('edit_btn', 'catalog/brands', 'Edit Brand', 'brandForm', 'brands-table');
            remove('remove_btn', 'catalog/brands', 'brands-table', '{{ csrf_token() }}');

            document.getElementById('mySearchInput').addEventListener('keyup', function () {
                window.LaravelDataTables['brands-table'].search(this.value).draw();
            });

        </script>
    @endpush

</x-default-layout>
