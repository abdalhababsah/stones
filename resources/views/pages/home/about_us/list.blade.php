<x-default-layout>
    @section('title')
        About Us
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('about-us.index') }}
    @endsection

    <div class="card">
        <div class="card-header border-0 pt-6">
            <div class="card-title">
                <div class="d-flex align-items-center position-relative my-1">
                    {!! getIcon('magnifier', 'fs-3 position-absolute ms-5') !!}
                    <input type="text" data-kt-user-table-filter="search"
                           class="form-control form-control-solid w-250px ps-13" placeholder="Search About Us"
                           id="mySearchInput"/>
                </div>
            </div>

            <div class="card-toolbar">
                <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                    <a id="add_about_us" class="btn btn-light-primary">
                        {!! getIcon('plus', 'fs-2', '', 'i') !!}
                        Add About Us
                    </a>
                </div>
            </div>
        </div>

        <div class="card-body py-4">
            <div class="table-responsive">
                {{ $dataTable->table(['class' => 'table align-middle table-row-dashed fs-6 gy-5']) }}
            </div>
        </div>
    </div>

    @push('scripts')
        {{ $dataTable->scripts() }}

        <script>
            addModal('add_about_us', '{{ route('home.about-us.create') }}', 'Add About Us', 'aboutUsForm', 'aboutus-table');
            editModal('edit_btn', 'home/about-us', 'Edit About Us', 'aboutUsForm', 'aboutus-table');
            remove('remove_btn', 'home/about-us', 'aboutus-table', '{{ csrf_token() }}');

            document.getElementById('mySearchInput').addEventListener('keyup', function () {
                window.LaravelDataTables['aboutus-table'].search(this.value).draw();
            });
        </script>
    @endpush
</x-default-layout>
