<div class="d-flex flex-column col-sm-12 col-md-12">
    <div class="accordion" id="accordionExample">
        <div class="card">
            <div class="card-header" id="headingOne">
                <h2 class="mb-0">
                    <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse"
                        data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        Personal information
                    </button>
                </h2>
            </div>

            <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group align-items-baseline d-flex flex-column flex-md-row">
                                {!! Form::label('image', trans('lang.e_provider_image'), [
                                    'class' => 'col-md-3 control-label text-md-right mx-1',
                                ]) !!}
                                <div class="col-md-9">
                                    <div style="width: 100%" class="dropzone image" id="image" data-field="image">
                                        <input type="hidden" name="image[]">
                                    </div>
                                    <a href="#loadMediaModal" data-dropzone="image" data-toggle="modal"
                                        data-target="#mediaModal"
                                        class="btn btn-outline-{{ setting('theme_color', 'primary') }} btn-sm float-right mt-1">{{ trans('lang.media_select') }}</a>
                                    <div class="form-text text-muted w-50">
                                        {{ trans('lang.e_provider_image_help') }}
                                    </div>
                                </div>
                            </div>

                            @prepend('scripts')
                                <script type="text/javascript">
                                    var var16105363151854745906ble = [];
                                    @if (isset($eProvider) && $eProvider->hasMedia('image'))
                                        @foreach ($eProvider->getMedia('image') as $media)
                                            var16105363151854745906ble.push({
                                                name: "{!! $media->name !!}",
                                                size: "{!! $media->size !!}",
                                                type: "{!! $media->mime_type !!}",
                                                uuid: "{!! $media->getCustomProperty('uuid') !!}",
                                                thumb: "{!! $media->getFirstMediaUrl('thumb') !!}",
                                                collection_name: "{!! $media->collection_name !!}"
                                            });
                                        @endforeach
                                    @endif
                                    var dz_var16105363151854745906ble = $(".dropzone.image").dropzone({
                                        url: "{!! url('uploads/store') !!}",
                                        addRemoveLinks: true,
                                        maxFiles: 5 - var16105363151854745906ble.length,
                                        init: function() {
                                            @if (isset($eProvider) && $eProvider->hasMedia('image'))
                                                var16105363151854745906ble.forEach(media => {
                                                    dzInit(this, media, media.thumb);
                                                });
                                            @endif
                                        },
                                        accept: function(file, done) {
                                            dzAccept(file, done, this.element, "{!! config('medialibrary.icons_folder') !!}");
                                        },
                                        sending: function(file, xhr, formData) {
                                            dzSendingMultiple(this, file, formData, '{!! csrf_token() !!}');
                                        },
                                        complete: function(file) {
                                            dzCompleteMultiple(this, file);
                                            dz_var16105363151854745906ble[0].mockFile = file;
                                        },
                                        removedfile: function(file) {
                                            dzRemoveFileMultiple(
                                                file, var16105363151854745906ble, '{!! url('eProviders/remove-media') !!}',
                                                'image', '{!! isset($eProvider) ? $eProvider->id : 0 !!}', '{!! url('uploads/clear') !!}',
                                                '{!! csrf_token() !!}'
                                            );
                                        }
                                    });
                                    dz_var16105363151854745906ble[0].mockFile = var16105363151854745906ble;
                                    dropzoneFields['image'] = dz_var16105363151854745906ble;
                                </script>
                            @endprepend
                            <!-- Phone Number Field -->
                            <div class="form-group align-items-baseline d-flex flex-column flex-md-row">
                                {!! Form::label('phone_number', trans('lang.e_provider_phone_number'), [
                                    'class' => 'col-md-3 control-label text-md-right mx-1',
                                ]) !!}
                                <div class="col-md-9">
                                    {!! Form::text('phone_number', null, [
                                        'class' => 'form-control',
                                        'placeholder' => trans('lang.e_provider_phone_number_placeholder'),
                                    ]) !!}
                                    <div class="form-text text-muted">
                                        {{ trans('lang.e_provider_phone_number_help') }}
                                    </div>
                                </div>
                            </div>
                            {{-- <!-- Mobile Number Field -->
                            <div class="form-group align-items-baseline d-flex flex-column flex-md-row">
                                {!! Form::label('mobile_number', trans('lang.e_provider_mobile_number'), [
                                    'class' => 'col-md-3 control-label text-md-right mx-1',
                                ]) !!}
                                <div class="col-md-9">
                                    {!! Form::text('mobile_number', null, [
                                        'class' => 'form-control',
                                        'placeholder' => trans('lang.e_provider_mobile_number_placeholder'),
                                    ]) !!}
                                    <div class="form-text text-muted">
                                        {{ trans('lang.e_provider_mobile_number_help') }}
                                    </div>
                                </div>
                            </div> --}}

                            <!-- Availability Range Field -->
                            <div class="form-group align-items-baseline d-flex flex-column flex-md-row ">
                                {!! Form::label('aadhaar_number', trans('auth.aadhaar_number'), [
                                    'class' => 'col-md-3 control-label text-md-right mx-1',
                                ]) !!}
                                <div class="col-md-9">
                                    <div class="input-group">
                                        {!! Form::number('aadhaar_no', null, [
                                            'class' => 'form-control',
                                            'step' => 'any',
                                            'min' => '0',
                                            'placeholder' => trans('auth.aadhaar_number'),
                                        ]) !!}
                                    </div>
                                    <div class="form-text text-muted">
                                        {{ trans('auth.e_aadhaar_number_help') }}
                                    </div>
                                </div>
                            </div>
                            <!-- Availability Range Field -->
                            <div class="form-group align-items-baseline d-flex flex-column flex-md-row ">
                                {!! Form::label('experience', trans('auth.experience'), [
                                    'class' => 'col-md-3 control-label text-md-right mx-1',
                                ]) !!}
                                <div class="input-group mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio"
                                            @if (isset($eProvider->experience) && $eProvider->experience == '1') {{ 'checked' }} @endif id="yes"
                                            name="experience" value="1">
                                        <label class="form-check-label" for="yes">Yes</label>
                                    </div>
                                    <div class="form-check" style="margin-left: 20px">
                                        <input class="form-check-input" type="radio" id="no"
                                            @if (isset($eProvider->experience) && $eProvider->experience == '0') {{ 'checked' }} @endif
                                            name="experience" value="0">
                                        <label class="form-check-label" for="no">No</label>
                                    </div>
                                </div>
                            </div>

                            <!-- Availability Range Field -->
                            <div class="form-group align-items-baseline d-flex flex-column flex-md-row ">
                                {!! Form::label('certification', trans('auth.certification'), [
                                    'class' => 'col-md-3 control-label text-md-right mx-1',
                                ]) !!}
                                <div class="col-md-9">
                                    <div class="input-group">
                                        {!! Form::text('certification', null, [
                                            'class' => 'form-control',
                                            'step' => 'any',
                                            'min' => '0',
                                            'placeholder' => trans('auth.certification'),
                                        ]) !!}
                                    </div>
                                    <div class="form-text text-muted">
                                        {{ trans('auth.e_certification_help') }}
                                    </div>
                                </div>
                            </div>

                            
                            <!-- E Provider Type Id Field -->
                            <div class="form-group align-items-baseline d-flex flex-column flex-md-row">
                                {!! Form::label('e_provider_type_id', trans('lang.e_provider_e_provider_type_id'), [
                                    'class' => 'col-md-3 control-label text-md-right mx-1',
                                ]) !!}
                                <div class="col-md-9">
                                    {!! Form::select('e_provider_type_id', $eProviderType, null, ['class' => 'select2 form-control']) !!}
                                    <div class="form-text text-muted">
                                        {{ trans('lang.e_provider_e_provider_type_id_help') }}
                                    </div>
                                </div>
                            </div>


                        </div>
                        <div class="col-md-6">
                            <!-- Name Field -->
                            <div class="form-group align-items-baseline d-flex flex-column flex-md-row">
                                {!! Form::label('name', trans('lang.e_provider_name'), ['class' => 'col-md-3 control-label text-md-right mx-1']) !!}
                                <div class="col-md-9">
                                    {!! Form::text('name', null, [
                                        'class' => 'form-control',
                                        'placeholder' => trans('lang.e_provider_name_placeholder'),
                                    ]) !!}
                                    <div class="form-text text-muted">
                                        {{ trans('lang.e_provider_name_help') }}
                                    </div>
                                </div>
                            </div>

                            <!-- Date of Birth Field -->
                            <div class="form-group align-items-baseline d-flex flex-column flex-md-row">
                                {!! Form::label('dob', trans('auth.dob'), ['class' => 'col-md-3 control-label text-md-right mx-1']) !!}
                                <div class="col-md-9">
                                    {!! Form::date('dob', null, ['class' => 'form-control', 'placeholder' => trans('auth.dob')]) !!}
                                    <div class="form-text text-muted">
                                        {{ trans('auth.e_dob_help') }}
                                    </div>
                                </div>
                            </div>
                            <!-- Gender Range Field -->
                            <div class="form-group align-items-baseline d-flex flex-column flex-md-row ">
                                {!! Form::label('gender', trans('auth.gender'), ['class' => 'col-md-3 control-label text-md-right mx-1']) !!}
                                <div class="input-group mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio"
                                            @if (isset($eProvider->gender) && $eProvider->gender == 'male') {{ 'checked' }} @endif id="male"
                                            name="gender" value="male">
                                        <label class="form-check-label" for="male">Male</label>
                                    </div>
                                    <div class="form-check" style="margin-left: 20px">
                                        <input class="form-check-input" type="radio"
                                            @if (isset($eProvider->gender) && $eProvider->gender == 'female') {{ 'checked' }} @endif id="female"
                                            name="gender" value="female">
                                        <label class="form-check-label" for="female">Female</label>
                                    </div>
                                </div>
                            </div>

                            <!-- Education Field -->
                            <div class="form-group align-items-baseline d-flex flex-column flex-md-row ">
                                {!! Form::label('education', trans('auth.education'), ['class' => 'col-md-3 control-label text-md-right mx-1']) !!}
                                <div class="col-md-9">
                                    <div class="input-group">
                                        {!! Form::text('education', null, [
                                            'class' => 'form-control',
                                            'step' => 'any',
                                            'min' => '0',
                                            'placeholder' => trans('auth.education'),
                                        ]) !!}
                                    </div>
                                    <div class="form-text text-muted">
                                        {{ trans('auth.e_education_help') }}
                                    </div>
                                </div>
                            </div>


                            <!-- pincode Field -->
                            <div class="form-group align-items-baseline d-flex flex-column flex-md-row">
                                {!! Form::label('pincode', trans('auth.pincode'), ['class' => 'col-md-3 control-label text-md-right mx-1']) !!}
                                <div class="col-md-9">
                                    {!! Form::text('pincode', null, ['class' => 'form-control', 'placeholder' => trans('auth.pincode')]) !!}
                                    <div class="form-text text-muted">
                                        {{ trans('auth.e_pincode_help') }}
                                    </div>
                                </div>
                            </div>


                            <!-- year of experience Range Field -->
                            <div class="form-group align-items-baseline d-flex flex-column flex-md-row ">
                                {!! Form::label('year_of_experience', trans('auth.year_of_experience'), [
                                    'class' => 'col-md-3 control-label text-md-right mx-1',
                                ]) !!}
                                <div class="col-md-9">
                                    <div class="input-group">
                                        {!! Form::text('years_of_experience', null, [
                                            'class' => 'form-control',
                                            'step' => 'any',
                                            'min' => '0',
                                            'placeholder' => trans('auth.year_of_experience'),
                                        ]) !!}
                                    </div>
                                    <div class="form-text text-muted">
                                        {{ trans('auth.e_year_of_experience_help') }}
                                    </div>
                                </div>
                            </div>
                            <!-- Addresses Field -->
                            <div class="form-group align-items-baseline d-flex flex-column flex-md-row">
                                {!! Form::label('addresses[]', trans('lang.e_provider_work_addresses'), [
                                    'class' => 'col-md-3 control-label text-md-right mx-1',
                                ]) !!}
                                <div class="col-md-9">
                                    {!! Form::select('addresses[]', $address, $addressesSelected, [
                                        'class' => 'select2 form-control',
                                        'multiple' => 'multiple',
                                    ]) !!}
                                    <div class="form-text text-muted">
                                        {{ trans('lang.e_provider_addresses_help') }}
                                        @can('addresses.create')
                                            <a href="{{ route('addresses.create') }}"
                                                class="text-success float-right">{{ __('lang.address_create') }}</a>
                                        @endcan
                                    </div>
                                </div>
                            </div>

                            

                            {{-- <!-- Employee Field -->
                            <div class="form-group align-items-baseline d-flex flex-column flex-md-row">
                                {!! Form::label('users[]', trans('lang.e_provider_users'), [
                                    'class' => 'col-md-3 control-label text-md-right mx-1',
                                ]) !!}
                                <div class="col-md-9">
                                    {!! Form::select('users[]', $user, $usersSelected, [
                                        'class' => 'select2 form-control',
                                        'multiple' => 'multiple',
                                    ]) !!}
                                    <div class="form-text text-muted">{{ trans('lang.e_provider_users_help') }}
                                    </div>
                                </div>
                            </div> --}}

                            
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header" id="headingTwo">
                <h2 class="mb-0">
                    <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse"
                        data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        Services
                    </button>
                </h2>
            </div>
            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                <div class="card-body">
                    <div class="row">

                        @if (isset($provider_services))                            
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Sno</th>
                                                <th>Service</th>
                                                <th>Service Category</th>
                                                <!-- <th>Status</th> -->
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (count($services))
                                                @foreach ($provider_services as $key => $service_id)
                                                    <tr>
                                                        <td>{{ ++$key }}</td>
                                                        <td>{{ getServiceName($service_id) }}</td>
                                                        <td>{{ getCategoryName($service_id) }}</td>
                                                        <td>
                                                            <button type="button" title="{{ trans('lang.view') }}"
                                                                data-id="{{ $service_id }}"
                                                                data-image="{{getServiceMedia($service_id)}}"
                                                                data-name="{{getServiceName($service_id)}}"
                                                                data-category="{{getCategoryName($service_id)}}"
                                                                class="view btn btn-primary" data-toggle="modal"
                                                                data-target="#exampleModal">
                                                                <i class="fas fa-eye"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endif
                        <div class="col-md-6">
                            <!-- Description Field -->
                            <div class="form-group align-items-baseline d-flex flex-column flex-md-row">
                                {!! Form::label('description', trans('lang.e_provider_description'), [
                                    'class' => 'col-md-3 control-label text-md-right mx-1',
                                ]) !!}
                                <div class="col-md-9">
                                    {!! Form::textarea('description', null, [
                                        'class' => 'form-control',
                                        'placeholder' => trans('lang.e_provider_description_placeholder'),
                                    ]) !!}
                                    <div class="form-text text-muted">
                                        {{ trans('lang.e_provider_description_help') }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">

                            <!-- Availability Range Field -->
                            <div class="form-group align-items-baseline d-flex flex-column flex-md-row ">
                                {!! Form::label('availability_range', trans('lang.e_provider_availability_range'), [
                                    'class' => 'col-md-3 control-label text-md-right mx-1',
                                ]) !!}
                                <div class="col-md-9">
                                    <div class="input-group">
                                        {!! Form::number('availability_range', null, [
                                            'class' => 'form-control',
                                            'step' => 'any',
                                            'min' => '0',
                                            'placeholder' => trans('lang.e_provider_availability_range_placeholder'),
                                        ]) !!}
                                        <div class="input-group-append">
                                            <div class="input-group-text text-bold px-3">
                                                {{ trans('lang.app_setting_' . setting('distance_unit', 'mi')) }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-text text-muted">
                                        {{ trans('lang.e_provider_availability_range_help') }}
                                    </div>
                                </div>
                            </div>
                            <!-- services -->
                            <div class="form-group align-items-baseline d-flex flex-column flex-md-row ">
                                {!! Form::label('service', trans('auth.service'), ['class' => 'col-md-3 control-label text-md-right mx-1']) !!}
                                <div class="col-md-9">
                                    <div class="input-group">
                                        <select name="services[]" style="width: 50% !important"
                                            class="select2 form-control {{ $errors->has('services') ? ' is-invalid' : '' }}"
                                            multiple="multiple" title="{{ __('auth.services') }}">
                                            @foreach ($services as $key => $service)
                                                <option value="{{ $key }}"
                                                    @isset($provider_services) @if (in_array($key, $provider_services)) {{ 'selected' }} @endif
                                                @endisset>{{ $service }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-text text-muted">
                                    {{ trans('auth.e_service_help') }}
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header" id="headingTwo">
            <h2 class="mb-0">
                <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse"
                    data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                    KYC
                </button>
            </h2>
        </div>
        <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        @if(isset($eProvider) && $eProvider->hasMedia('id_proof'))
                            <img src="{!! url($eProvider->getFirstMediaUrl('id_proof')) !!}" class="img-fluid" />
                        @endif
                    </div>
                    <div class="col-md-6">
                        @if(isset($eProvider) && $eProvider->hasMedia('address_proof'))
                            <img src="{!! url($eProvider->getFirstMediaUrl('address_proof')) !!}" class="img-fluid" />
                        @endif
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group align-items-start d-flex flex-column flex-md-row">
                            {!! Form::label('id_proof', trans("lang.id_proof"), ['class' => 'col-md-3 control-label text-md-right mx-1']) !!}
                            <div class="col-md-9">
                                <div style="width: 100%" class="dropzone id_proof" id="id_proof" data-field="id_proof">
                                    <input type="hidden" name="id_proof">
                                </div>
                                <a href="#loadMediaModal" data-dropzone="id_proof" data-toggle="modal" data-target="#mediaModal" class="btn btn-outline-{{setting('theme_color','primary')}} btn-sm float-right mt-1">{{ trans('lang.e_id_proof_help')}}</a>
                                <div class="form-text text-muted w-50">
                                    {{ trans("lang.e_id_proof_help") }}
                                </div>
                            </div>
                        </div>

                        @prepend('scripts')
                            <script type="text/javascript">
                                var var16110650672130312723ble = '';
                                @if(isset($eProvider) && $eProvider->hasMedia('id_proof'))
                                    var16110650672130312723ble = {
                                    name: "{!! $eProvider->getFirstMedia('id_proof')->name !!}",
                                    size: "{!! $eProvider->getFirstMedia('id_proof')->size !!}",
                                    type: "{!! $eProvider->getFirstMedia('id_proof')->mime_type !!}",
                                    collection_name: "{!! $eProvider->getFirstMedia('id_proof')->collection_name !!}"
                                };
                                @endif
                                var dz_var16110650672130312723ble = $(".dropzone.id_proof").dropzone({
                                    url: "{!!url('uploads/store')!!}",
                                    addRemoveLinks: true,
                                    clickable: true,
                                    maxFiles: 1,
                                    init: function () {
                                        @if(isset($eProvider) && $eProvider->hasMedia('id_proof'))
                                            dzInit(this, var16110650672130312723ble, '{!! url($eProvider->getFirstMediaUrl('id_proof','thumb')) !!}')
                                        @endif
                                    },
                                    accept: function (file, done) {
                                        dzAccept(file, done, this.element, "{!!config('medialibrary.icons_folder')!!}");
                                    },
                                    sending: function (file, xhr, formData) {
                                        dzSending(this, file, formData, '{!! csrf_token() !!}');
                                    },
                                    maxfilesexceeded: function (file) {
                                        dz_var16110650672130312723ble[0].mockFile = '';
                                        dzMaxfile(this, file);
                                    },
                                    complete: function (file) {
                                        dzComplete(this, file, var16110650672130312723ble, dz_var16110650672130312723ble[0].mockFile);
                                        dz_var16110650672130312723ble[0].mockFile = file;
                                    },
                                    removedfile: function (file) {
                                        dzRemoveFile(
                                            file, var16110650672130312723ble, '{!! url("eProviders/remove-media") !!}',
                                            'id_proof', '{!! isset($eProvider) ? $eProvider->id : 0 !!}', '{!! url("uplaods/clear") !!}', '{!! csrf_token() !!}'
                                        );
                                    }
                                });
                                dz_var16110650672130312723ble[0].mockFile = var16110650672130312723ble;
                                dropzoneFields['id_proof'] = dz_var16110650672130312723ble;
                            </script>
                    @endprepend
                    </div>
                    <div class="col-md-6">
                        <div class="form-group align-items-start d-flex flex-column flex-md-row">
                            {!! Form::label('address_proof', trans("lang.address_proof"), ['class' => 'col-md-3 control-label text-md-right mx-1']) !!}
                            <div class="col-md-9">
                                <div style="width: 100%" class="dropzone address_proof" id="address_proof" data-field="address_proof">
                                    <input type="hidden" name="address_proof">
                                </div>
                                <a href="#loadMediaModal" data-dropzone="address_proof" data-toggle="modal" data-target="#mediaModal" class="btn btn-outline-{{setting('theme_color','primary')}} btn-sm float-right mt-1">{{ trans('lang.e_address_proof_help')}}</a>
                                <div class="form-text text-muted w-50">
                                    {{ trans("lang.e_address_proof_help") }}
                                </div>
                            </div>
                        </div>
                        @prepend('scripts')
                            <script type="text/javascript">
                                var var16110650672130312723ble = '';
                                @if(isset($eProvider) && $eProvider->hasMedia('address_proof'))
                                    var16110650672130312723ble = {
                                    name: "{!! $eProvider->getFirstMedia('address_proof')->name !!}",
                                    size: "{!! $eProvider->getFirstMedia('address_proof')->size !!}",
                                    type: "{!! $eProvider->getFirstMedia('address_proof')->mime_type !!}",
                                    collection_name: "{!! $eProvider->getFirstMedia('address_proof')->collection_name !!}"
                                };
                                @endif
                                var dz_var16110650672130312723ble = $(".dropzone.address_proof").dropzone({
                                    url: "{!!url('uploads/store')!!}",
                                    addRemoveLinks: true,
                                    maxFiles: 1,
                                    init: function () {
                                        @if(isset($eProvider) && $eProvider->hasMedia('address_proof'))
                                        dzInit(this, var16110650672130312723ble, '{!! url($eProvider->getFirstMediaUrl('address_proof','thumb')) !!}')
                                        @endif
                                    },
                                    accept: function (file, done) {
                                        dzAccept(file, done, this.element, "{!!config('medialibrary.icons_folder')!!}");
                                    },
                                    sending: function (file, xhr, formData) {
                                        dzSending(this, file, formData, '{!! csrf_token() !!}');
                                    },
                                    maxfilesexceeded: function (file) {
                                        dz_var16110650672130312723ble[0].mockFile = '';
                                        dzMaxfile(this, file);
                                    },
                                    complete: function (file) {
                                        dzComplete(this, file, var16110650672130312723ble, dz_var16110650672130312723ble[0].mockFile);
                                        dz_var16110650672130312723ble[0].mockFile = file;
                                    },
                                    removedfile: function (file) {
                                        dzRemoveFile(
                                            file, var16110650672130312723ble, '{!! url("eProviders/remove-media") !!}',
                                            'address_proof', '{!! isset($eProvider) ? $eProvider->id : 0 !!}', '{!! url("uplaods/clear") !!}', '{!! csrf_token() !!}'
                                        );
                                    }
                                });
                                dz_var16110650672130312723ble[0].mockFile = var16110650672130312723ble;
                                dropzoneFields['address_proof'] = dz_var16110650672130312723ble;
                            </script>
                    @endprepend
                    </div>
                    <div class="col-md-6">
                        <div class="form-group align-items-baseline d-flex flex-column flex-md-row ">
                            {!! Form::label('state', trans('auth.state'), [
                                'class' => 'col-md-3 control-label text-md-right mx-1',
                            ]) !!}
                            <div class="col-md-9">
                                <div class="input-group">
                                    {!! Form::text('state', null, [
                                        'class' => 'form-control',
                                        'placeholder' => trans('auth.state'),
                                    ]) !!}
                                </div>
                                <div class="form-text text-muted">
                                    {{ trans('auth.e_state_help') }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group align-items-baseline d-flex flex-column flex-md-row ">
                            {!! Form::label('city', trans('auth.city'), [
                                'class' => 'col-md-3 control-label text-md-right mx-1',
                            ]) !!}
                            <div class="col-md-9">
                                <div class="input-group">
                                    {!! Form::text('city', null, [
                                        'class' => 'form-control',
                                        'placeholder' => trans('auth.city'),
                                    ]) !!}
                                </div>
                                <div class="form-text text-muted">
                                    {{ trans('auth.e_city_help') }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group align-items-baseline d-flex flex-column flex-md-row ">
                            {!! Form::label('permanent_address', trans('auth.permanent_address'), [
                                'class' => 'col-md-3 control-label text-md-right mx-1',
                            ]) !!}
                            <div class="col-md-9">
                                <div class="input-group">
                                    {!! Form::text('permanent_address', null, [
                                        'class' => 'form-control',
                                        'placeholder' => trans('auth.permanent_address'),
                                    ]) !!}
                                </div>
                                <div class="form-text text-muted">
                                    {{ trans('auth.e_permanent_address_help') }}
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div
        class="form-group col-12 d-flex flex-column flex-md-row justify-content-md-end justify-content-sm-center border-top pt-4">
        @role('admin|madmin')
            <div class="d-flex flex-row justify-content-between align-items-center">
                {!! Form::label('accepted', trans('lang.e_provider_accepted'), ['class' => 'control-label my-0 mx-3']) !!} 
                {!! Form::hidden('accepted', 0, ['id' => 'hidden_accepted']) !!}
                <span class="icheck-{{ setting('theme_color') }}">
                    {!! Form::checkbox('accepted', 1, null) !!} <label for="accepted"></label> </span>
            </div>
        @endrole
        @role('admin|madmin')
            <div class="d-flex flex-row justify-content-between align-items-center">
                {!! Form::label('tm_certified', trans('lang.e_provider_tm_certified'), ['class' => 'control-label my-0 mx-3']) !!} 
                {!! Form::hidden('tm_certified', 0, ['id' => 'hidden_tm_certified']) !!}
                <span class="icheck-{{ setting('theme_color') }}">
                    {!! Form::checkbox('tm_certified', 1, null) !!} <label for="tm_certified"></label> </span>
            </div>
        @endrole
        <div class="d-flex flex-row justify-content-between align-items-center">
            {!! Form::label('available', trans('lang.e_provider_available'), ['class' => 'control-label my-0 mx-3']) !!} {!! Form::hidden('available', 0, ['id' => 'hidden_available']) !!}
            <span class="icheck-{{ setting('theme_color') }}">
                {!! Form::checkbox('available', 1, null) !!} <label for="available"></label> </span>
        </div>
        <div class="d-flex flex-row justify-content-between align-items-center">
            {!! Form::label('featured', trans('lang.e_provider_featured'), ['class' => 'control-label my-0 mx-3']) !!} {!! Form::hidden('featured', 0, ['id' => 'hidden_featured']) !!}
            <span class="icheck-{{ setting('theme_color') }}">
                {!! Form::checkbox('featured', 1, null) !!} <label for="featured"></label> </span>
        </div>
        <button type="submit"
            class="btn bg-{{ setting('theme_color') }} mx-md-3 my-lg-0 my-xl-0 my-md-0 my-2">
            <i class="fa fa-save"></i> {{ trans('lang.save') }}
            {{ trans('lang.e_provider') }}</button>
        <a href="{!! route('eProviders.index') !!}" class="btn btn-default"><i class="fa fa-undo"></i>
            {{ trans('lang.cancel') }}</a>
            @if (isset($eProvider))
                <input type="hidden" name="provider_id" id="provider_id" value="{{$eProvider->id}}">
            @endif
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Service Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <small for="service_name">Service Name</small>
                        <p id="service_name"></p>
                        <small for="category_name">Category Name</small>
                        <p id="category_name"></p>
                    </div>
                    <div class="col-md-12">
                        <small>Image</small>
                        <p id="desc">
                        </p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        $(document).on("click", ".view", function() {
            let service_id = $(this).data('id');
            let name = $(this).data('name');
            let image = $(this).data('image');
            let category = $(this).data('category');
            $("#service_name").text(name)
            $("#category_name").text(category)
            $("#desc").html("<img src='"+image+"' class='img-fluid' />")
        });
    </script>
@endpush
