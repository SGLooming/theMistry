    {{-- <h5 class="col-12 pb-4">{!! trans('lang.main_fields') !!}</h5> --}}
    <div class="d-flex flex-column col-sm-12 col-md-6">
        <!-- title Field -->
        <div class="form-group align-items-baseline d-flex flex-column flex-md-row">
            {!! Form::label('title', trans('lang.advertisement_title'), [
                'class' => 'col-md-3 control-label text-md-right mx-1',
            ]) !!}
            <div class="col-md-9">
                {!! Form::text('title', null, [
                    'class' => 'form-control',
                    'placeholder' => trans('lang.advertisement_title_placeholder'),
                ]) !!}
                <div class="form-text text-muted">
                    {{ trans('lang.advertisement_title_help') }}
                </div>
            </div>
        </div>

        <!-- Description Field -->
        <div class="form-group align-items-baseline d-flex flex-column flex-md-row">
            {!! Form::label('description', trans('lang.advertisement_description'), [
                'class' => 'col-md-3 control-label text-md-right mx-1',
            ]) !!}
            <div class="col-md-9">
                {!! Form::textarea('description', null, [
                    'class' => 'form-control',
                    'placeholder' => trans('lang.advertisement_description_placeholder'),
                ]) !!}
                <div class="form-text text-muted">{{ trans('lang.advertisement_description_help') }}</div>
            </div>
        </div>



    </div>
    <div class="d-flex flex-column col-sm-12 col-md-6">
        <!-- Image Field -->
        <div class="form-group align-items-start d-flex flex-column flex-md-row">
            {!! Form::label('image', trans('lang.image'), [
                'class' => 'col-md-3 control-label text-md-right mx-1',
            ]) !!}
            <div class="col-md-9">
                <div style="width: 100%" class="dropzone image" id="image" data-field="image">
                    <input type="hidden" name="image">
                </div>
                <a href="#loadMediaModal" data-dropzone="image" data-toggle="modal" data-target="#mediaModal"
                    class="btn btn-outline-{{ setting('theme_color', 'primary') }} btn-sm float-right mt-1">{{ trans('lang.e_image_help') }}</a>
                <div class="form-text text-muted w-50">
                    {{ trans('lang.e_image_help') }}
                </div>
            </div>
        </div>
        @prepend('scripts')
            <script type="text/javascript">
                var var16110650672130312723ble = '';
                @if (isset($advertisement) && $advertisement->hasMedia('image'))
                    var16110650672130312723ble = {
                        name: "{!! $advertisement->getFirstMedia('image')->name !!}",
                        size: "{!! $advertisement->getFirstMedia('image')->size !!}",
                        type: "{!! $advertisement->getFirstMedia('image')->mime_type !!}",
                        collection_name: "{!! $advertisement->getFirstMedia('image')->collection_name !!}"
                    };
                @endif
                var dz_var16110650672130312723ble = $(".dropzone.image").dropzone({
                    url: "{!! url('uploads/store') !!}",
                    addRemoveLinks: true,
                    maxFiles: 1,
                    init: function() {
                        @if (isset($advertisement) && $advertisement->hasMedia('image'))
                            dzInit(this, var16110650672130312723ble, '{!! url($advertisement->getFirstMediaUrl('image')) !!}')
                        @endif
                    },
                    accept: function(file, done) {
                        dzAccept(file, done, this.element, "{!! config('medialibrary.icons_folder') !!}");
                    },
                    sending: function(file, xhr, formData) {
                        dzSending(this, file, formData, '{!! csrf_token() !!}');
                    },
                    maxfilesexceeded: function(file) {
                        dz_var16110650672130312723ble[0].mockFile = '';
                        dzMaxfile(this, file);
                    },
                    complete: function(file) {
                        dzComplete(this, file, var16110650672130312723ble, dz_var16110650672130312723ble[0].mockFile);
                        dz_var16110650672130312723ble[0].mockFile = file;
                    },
                    removedfile: function(file) {
                        dzRemoveFile(
                            file, var16110650672130312723ble, '{!! url('advertisements/remove-media') !!}',
                            'image', '{!! isset($advertisement) ? $advertisement->id : 0 !!}', '{!! url('uplaods/clear') !!}',
                            '{!! csrf_token() !!}'
                        );
                    }
                });
                dz_var16110650672130312723ble[0].mockFile = var16110650672130312723ble;
                dropzoneFields['image'] = dz_var16110650672130312723ble;
            </script>
        @endprepend
        <!-- services Field -->
        <div class="form-group align-items-baseline d-flex flex-column flex-md-row">
            {!! Form::label('services', trans('lang.service'), [
                'class' => 'col-md-3 control-label text-md-right mx-1',
            ]) !!}
            <div class="col-md-9">
                <select name="services[]" style="width: 50% !important"
                    class="select2 form-control {{ $errors->has('services') ? ' is-invalid' : '' }}" multiple="multiple"
                    title="{{ __('auth.services') }}">
                    @foreach ($services as $key => $service)
                        <option value="{{ $key }}"
                            @isset($service_of_ads)
                          {{ in_array($key, $service_of_ads) ? 'selected' : '' }} 
                        @endisset>
                            {{ $service }} </option>
                    @endforeach
                </select>
                <div class="form-text text-muted">{{ trans('lang.e_service_help') }}</div>
            </div>
        </div>
    </div>
    <!-- Submit Field -->
    <div
        class="form-group col-12 d-flex flex-column flex-md-row justify-content-md-end justify-content-sm-center border-top pt-4">
        <div class="d-flex flex-row justify-content-between align-items-center">
            {!! Form::label(
                'featured',
                trans('lang.advertisiment_featured_help'),
                ['class' => 'control-label my-0 mx-3'],
                false,
            ) !!} {!! Form::hidden('featured', 0, ['id' => 'hidden_featured']) !!}
            <span class="icheck-{{ setting('theme_color') }}">
                {!! Form::checkbox('featured', 1, null) !!} <label for="featured"></label> </span>
        </div>
        <button type="submit" class="btn bg-{{ setting('theme_color') }} mx-md-3 my-lg-0 my-xl-0 my-md-0 my-2">
            <i class="fa fa-save"></i> {{ trans('lang.save') }} {{ trans('lang.advertisement') }}
        </button>
        <a href="{!! route('categories.index') !!}" class="btn btn-default"><i class="fa fa-undo"></i>
            {{ trans('lang.cancel') }}</a>
    </div>
