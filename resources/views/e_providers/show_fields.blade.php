<div class="col">
    <div class="accordion" id="accordionExample">
        <div class="card">
            <div class="card-header" id="headingOne">
                <h2 class="mb-0">
                    <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse"
                        data-target="#personal_information" aria-expanded="true" aria-controls="personal_information">
                        Personal Information
                    </button>
                </h2>
            </div>
            <div id="personal_information" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <strong>Name : </strong> {{ $eProvider->name }}
                        </div>
                        <div class="col-md-3">
                            <strong>Mobile No. : </strong> {{ $eProvider->mobile_number }}
                        </div>
                        <div class="col-md-3">
                            <strong>Aadhaar No. : </strong> {{ $eProvider->aadhaar_no }}
                        </div>
                        <div class="col-md-3">
                            <strong>Date of Birth : </strong> {{ $eProvider->dob }}
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-md-3">
                            <strong>Gender : </strong> {{ $eProvider->gender }}
                        </div>
                        <div class="col-md-3">
                            <strong>Permanent Address :</strong> {{ $eProvider->permanent_address }}
                        </div>
                        <div class="col-md-3">
                            <strong>Education :</strong> {{ $eProvider->education }}
                        </div>
                        <div class="col-md-3">
                            <strong>Certification :</strong> {{ $eProvider->certification }}
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-md-3">
                            <strong>Availability Range :</strong> {{ $eProvider->availability_range }} KM.
                        </div>
                        <div class="col-md-3">
                            <strong>Featured : </strong>
                            @if ($eProvider->featured)
                                <span class="badge badge-success">Yes</span>
                            @else
                                <span class="badge badge-danger">No</span>
                            @endif
                        </div>
                        <div class="col-md-3">
                            <strong>Accepted :</strong>
                            @if ($eProvider->accepted)
                                <span class="badge badge-success">Yes</span>
                            @else
                                <span class="badge badge-danger">No</span>
                            @endif
                        </div>
                        <div class="col-md-3">
                            <strong>Experience : </strong>
                            @if ($eProvider->experience)
                                <span class="badge badge-success">Yes</span>
                            @else
                                <span class="badge badge-danger">No</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header" id="headingTwo">
                <h2 class="mb-0">
                    <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse"
                        data-target="#services" aria-expanded="false" aria-controls="services">
                        Services
                    </button>
                </h2>
            </div>
            <div id="services" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                <div class="card-body">
                    @if (isset($provider_services))
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>Sno</th>
                                            <th>Service</th>
                                            <th>Service Category</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (count($services))
                                            @foreach ($provider_services as $key => $service_id)
                                                <tr>
                                                    <td>{{ ++$key }}</td>
                                                    <td>{{ getServiceName($service_id) }}</td>
                                                    <td>{{ getCategoryName($service_id) }}</td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif
                    <div class="row mt-2">
                        <div class="col-md-6">
                            <strong>Work Address : </strong> {{ $eProvider->work_address }}
                        </div>
                        <div class="col-md-6">
                            <strong>Pincode : </strong> {{ $eProvider->pincode }}
                        </div>
                        <div class="col-md-12 mt-4">
                            <strong>Description : </strong> {!! $eProvider->description !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header" id="headingThree">
                <h2 class="mb-0">
                    <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse"
                        data-target="#kyc" aria-expanded="false" aria-controls="kyc">
                        KNOW YOUR CLIENT (KYC)
                    </button>
                </h2>
            </div>
            <div id="kyc" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group align-items-start d-flex flex-column flex-md-row">
                                {!! Form::label('id_proof', trans("lang.id_proof"), ['class' => 'col-md-3 control-label text-md-right mx-1']) !!}
                                <div class="col-md-9">
                                    <div style="width: 100%" class="dropzone id_proof" id="id_proof" data-field="id_proof">
                                        <input type="hidden" name="id_proof">
                                    </div>
                                </div>
                            </div>
                            @if (isset($eProvider) && $eProvider->hasMedia('id_proof'))
                                <a href="{!! url($eProvider->getFirstMediaUrl('id_proof', 'thumb')) !!}" title="Address Proof" target="_blank">View</a>
                            @endif
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
                                        addRemoveLinks: false,
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
                                </div>
                            </div>
                            @if (isset($eProvider) && $eProvider->hasMedia('address_proof'))
                                <a href="{!! url($eProvider->getFirstMediaUrl('address_proof', 'thumb')) !!}" title="Address Proof" target="_blank">View</a>
                            @endif
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
                                        addRemoveLinks: false,
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
                                    });
                                    dz_var16110650672130312723ble[0].mockFile = var16110650672130312723ble;
                                    dropzoneFields['address_proof'] = dz_var16110650672130312723ble;
                                </script>
                        @endprepend
                        </div>
                        <div class="col-md-4">
                            <strong>Years of Experience : </strong> {{ $eProvider->years_of_experience }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>