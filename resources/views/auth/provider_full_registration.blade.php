@extends('layouts.auth.default')
@push('css')
    <link rel="stylesheet" href="{{ asset('public/vendor/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/vendor/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endpush
@section('content')
    <div class="card-body login-card-body">
        <p class="login-box-msg">{{ __('auth.register_provider') }}</p>

        <form action="{{ url('/provier-full-registration' . '/' . request('id')) }}" method="post"
            enctype="multipart/form-data">
            {!! csrf_field() !!}

            <div class="input-group mb-3">
                <input value="{{ old('aadhaar_number') }}" type="aadhaar_number"
                    class="form-control {{ $errors->has('aadhaar_number') ? ' is-invalid' : '' }}" name="aadhaar_number"
                    placeholder="{{ __('auth.aadhaar_number') }}" aria-label="{{ __('auth.aadhaar_number') }}">
                <div class="input-group-append">
                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                </div>
                @if ($errors->has('aadhaar_number'))
                    <div class="invalid-feedback">
                        {{ $errors->first('aadhaar_number') }}
                    </div>
                @endif
            </div>
            <label class="form-check-label" for="male">{{ __('auth.dob') }}</label>
            <div class="input-group mb-3">
                <input value="{{ old('dob') }}" type="date"
                    class="form-control {{ $errors->has('dob') ? ' is-invalid' : '' }}" name="dob"
                    placeholder="{{ __('auth.dob') }}" aria-label="{{ __('auth.dob') }}"
                    title="{{ __('auth.dob') }}">
                <div class="input-group-append">
                    <span class="input-group-text"><i class="fa fa-birthday-cake"></i></span>
                </div>
                @if ($errors->has('dob'))
                    <div class="invalid-feedback">
                        {{ $errors->first('dob') }}
                    </div>
                @endif
            </div>
            <label class="form-check-label" for="male">{{ __('auth.gender') }}</label>
            <div class="input-group mb-3">
                <div class="form-check">
                    <input class="form-check-input" type="radio" id="male" name="gender" value="male">
                    <label class="form-check-label" for="male">{{ __('auth.male') }}</label>
                </div>
                <div class="form-check" style="margin-left: 20px">
                    <input class="form-check-input" type="radio" id="female" name="gender" value="female">
                    <label class="form-check-label" for="female">{{ __('auth.female') }}</label>
                </div>
            </div>

            <div class="input-group mb-3">
                <textarea value="{{ old('permanent_address') }}"
                    class="form-control {{ $errors->has('permanent_address') ? ' is-invalid' : '' }}" name="permanent_address"
                    placeholder="{{ __('auth.permanent_address') }}" aria-label="{{ __('auth.permanent_address') }}"
                    title="Permanent Address"></textarea>
                <div class="input-group-append">
                    <span class="input-group-text"><i class="fas fa-home"></i></span>
                </div>
                @if ($errors->has('permanent_address'))
                    <div class="invalid-feedback">
                        {{ $errors->first('permanent_address') }}
                    </div>
                @endif
            </div>
            <label class="form-check-label" for="male">{{ __('auth.service_information') }}</label>
            <div class="input-group mb-3">
                <select value="{{ old('service_information') }}"
                    class="form-control {{ $errors->has('service_information') ? ' is-invalid' : '' }}"
                    name="service_information" aria-label="{{ __('auth.service_information') }}">
                    @foreach ($providerTypes as $providerType)
                        <option value="{{ $providerType->id }}">{{ $providerType->name }}</option>
                    @endforeach

                </select>
                <div class="input-group-append">
                    <span class="input-group-text"><i class="fa fa-building"></i></span>
                </div>
                @if ($errors->has('service_information'))
                    <div class="invalid-feedback">
                        {{ $errors->first('service_information') }}
                    </div>
                @endif
            </div>


            <label class="form-check-label" for="male">{{ __('auth.experience') }}</label>
            <div class="input-group mb-3">
                <div class="form-check">
                    <input class="form-check-input" type="radio" id="yes" name="experience" value="1">
                    <label class="form-check-label" for="yes">{{ __('auth.yes') }}</label>
                </div>
                <div class="form-check" style="margin-left: 20px">
                    <input class="form-check-input" type="radio" id="no" name="experience" value="0">
                    <label class="form-check-label" for="no">{{ __('auth.no') }}</label>
                </div>
            </div>

            <div class="input-group mb-3">
                <input value="{{ old('education') }}" type="text"
                    class="form-control {{ $errors->has('education') ? ' is-invalid' : '' }}" name="education"
                    placeholder="{{ __('auth.education') }}" aria-label="{{ __('auth.education') }}"
                    title="{{ __('auth.education') }}">
                <div class="input-group-append">
                    <span class="input-group-text"><i class="fas fa-school"></i></span>
                </div>
                @if ($errors->has('education'))
                    <div class="invalid-feedback">
                        {{ $errors->first('education') }}
                    </div>
                @endif
            </div>

            <div class="input-group mb-3">
                <input value="{{ old('certification') }}" type="text"
                    class="form-control {{ $errors->has('certification') ? ' is-invalid' : '' }}" name="certification"
                    placeholder="{{ __('auth.certification') }}" aria-label="{{ __('auth.certification') }}"
                    title="{{ __('auth.certification') }}">
                <div class="input-group-append">
                    <span class="input-group-text"><i class="fa fa-certificate"></i></span>
                </div>
                @if ($errors->has('certification'))
                    <div class="invalid-feedback">
                        {{ $errors->first('certification') }}
                    </div>
                @endif
            </div>

            <label class="form-check-label" for="info">{{ __('auth.services') }}</label>
            <div class="input-group mb-3">
                <select name="services[]" style="width: 50% !important"
                    class="select2 form-control {{ $errors->has('services') ? ' is-invalid' : '' }}" multiple="multiple"
                    title="{{ __('auth.services') }}">
                    @foreach ($services as $service)
                        <option value="{{ $service->id }}">{{ $service->name }}</option>
                    @endforeach
                </select>
                @if ($errors->has('service'))
                    <div class="invalid-feedback">
                        {{ $errors->first('service') }}
                    </div>
                @endif
            </div>
            <div class="input-group mb-3">
                <textarea value="{{ old('description') }}"
                    class="form-control {{ $errors->has('description') ? ' is-invalid' : '' }}" name="description"
                    placeholder="{{ __('auth.description') }}" aria-label="{{ __('auth.description') }}"
                    title="Permanent Address"></textarea>
                <div class="input-group-append">
                    <span class="input-group-text"><i class="fa fa-info"></i></span>
                </div>
                @if ($errors->has('description'))
                    <div class="invalid-feedback">
                        {{ $errors->first('description') }}
                    </div>
                @endif
            </div>
            <div class="input-group mb-3">
                <input value="{{ old('availability') }}" type="number"
                    class="form-control {{ $errors->has('availability') ? ' is-invalid' : '' }}" name="availability"
                    placeholder="{{ __('auth.availability') }}" aria-label="{{ __('auth.availability_in_range') }}"
                    title="{{ __('auth.availability') }}">
                <div class="input-group-append">
                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                </div>
                @if ($errors->has('availability'))
                    <div class="invalid-feedback">
                        {{ $errors->first('availability') }}
                    </div>
                @endif
            </div>

            <div class="input-group mb-3">
                <textarea value="{{ old('work_address') }}"
                    class="form-control {{ $errors->has('work_address') ? ' is-invalid' : '' }}" name="work_address"
                    placeholder="{{ __('auth.work_address') }}" aria-label="{{ __('auth.work_address') }}"
                    title="Permanent Address"></textarea>
                <div class="input-group-append">
                    <span class="input-group-text"><i class="fa fa-home"></i></span>
                </div>
                @if ($errors->has('work_address'))
                    <div class="invalid-feedback">
                        {{ $errors->first('work_address') }}
                    </div>
                @endif
            </div>
            <div class="input-group mb-3">
                <input value="{{ old('pincode') }}" type="number"
                    class="form-control {{ $errors->has('pincode') ? ' is-invalid' : '' }}" name="pincode"
                    placeholder="{{ __('auth.pincode') }}" aria-label="{{ __('auth.pincode') }}"
                    title="{{ __('auth.pincode') }}">
                <div class="input-group-append">
                    <span class="input-group-text"><i class="fa fa-code"></i></span>
                </div>
                @if ($errors->has('pincode'))
                    <div class="invalid-feedback">
                        {{ $errors->first('pincode') }}
                    </div>
                @endif
            </div>

            <label class="form-check-label" for="info">{{ __('auth.other_information') }}</label>
            <div class="input-group mb-3">
                <input value="{{ old('year_of_experience') }}" type="number"
                    class="form-control {{ $errors->has('year_of_experience') ? ' is-invalid' : '' }}"
                    name="year_of_experience" placeholder="{{ __('auth.year_of_experience') }}"
                    aria-label="{{ __('auth.year_of_experience') }}" title="{{ __('auth.year_of_experience') }}">
                <div class="input-group-append">
                    <span class="input-group-text"><i class="fa fa-history"></i></span>
                </div>
                @if ($errors->has('year_of_experience'))
                    <div class="invalid-feedback">
                        {{ $errors->first('year_of_experience') }}
                    </div>
                @endif
            </div>

            <label class="form-check-label" for="proof">{{ __('auth.id_proof') }}</label>
            <div class="input-group mb-3">
                <input value="{{ old('id_proof') }}" type="file"
                    class="form-control {{ $errors->has('id_proof') ? ' is-invalid' : '' }}" name="id_proof"
                    placeholder="{{ __('auth.id_proof') }}" aria-label="{{ __('auth.id_proof') }}"
                    title="{{ __('auth.id_proof') }}">
                <div class="input-group-append">
                    <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                </div>
                @if ($errors->has('id_proof'))
                    <div class="invalid-feedback">
                        {{ $errors->first('id_proof') }}
                    </div>
                @endif
            </div>

            <label class="form-check-label" for="address_proof">{{ __('auth.address_proof') }}</label>
            <div class="input-group mb-3">
                <input type="file" class="form-control {{ $errors->has('address_proof') ? ' is-invalid' : '' }}"
                    name="address_proof" placeholder="{{ __('auth.address_proof') }}"
                    aria-label="{{ __('auth.address_proof') }}" title="{{ __('auth.address_proof') }}">
                <div class="input-group-append">
                    <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                </div>
                @if ($errors->has('address_proof'))
                    <div class="invalid-feedback">
                        {{ $errors->first('address_proof') }}
                    </div>
                @endif
            </div>


            <div class="row mb-2">
                <div class="col-8">
                    <div class="icheck-primary">
                        {{-- <input type="checkbox" id="remember" name="remember"> <label for="remember">
                            {{ __('auth.agree') }}
                        </label> --}}
                    </div>
                </div>
                <!-- /.col -->
                <div class="col-4">
                    <button type="submit"
                        class="btn btn-primary btn-block">{{ __('auth.service_provider_register') }}</button>
                </div>
                <!-- /.col -->
            </div>
        </form>


        <p class="mb-1 text-center">
            <a href="{{ url('/login') }}">{{ __('auth.already_member') }}</a>
        </p>
    </div>
    <!-- /.login-card-body -->
@endsection


@push('scripts')
    <script src="{{ asset('public/vendor/select2/js/select2.full.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2();
        });
    </script>
@endpush
