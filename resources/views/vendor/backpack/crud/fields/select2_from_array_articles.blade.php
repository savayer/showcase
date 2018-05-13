<!-- select2 from array -->
<div @include('crud::inc.field_wrapper_attributes') >
    <label>{!! $field['label'] !!}</label>
    <select
        name="{{ $field['name'] }}@if (isset($field['allows_multiple']) && $field['allows_multiple']==true)[]@endif"
        style="width: 100%"
        @include('crud::inc.field_attributes', ['default_class' =>  'form-control select2_from_array'])
        @if (isset($field['allows_multiple']) && $field['allows_multiple']==true)multiple @endif
        >

        @if (isset($field['allows_null']) && $field['allows_null']==true)
            <option value="">-</option>
        @endif

        @if (count($field['options']))
            @foreach ($field['options'] as $key => $value)
                @if((old($field['name']) && (
                        $key == old($field['name']) ||
                        (is_array(old($field['name'])) &&
                        in_array($key, old($field['name']))))) ||
                        (null === old($field['name']) &&
                            ((isset($field['value']) && (
                                        $key == $field['value'] || (
                                                is_array($field['value']) &&
                                                in_array($key, $field['value'])
                                                )
                                        )) ||
                                (isset($field['default']) &&
                                ($key == $field['default'] || (
                                                is_array($field['default']) &&
                                                in_array($key, $field['default'])
                                            )
                                        )
                                ))
                        ))
                    <option value="{{ $key }}" title="{{ $value[1] }}" data-category="{{ $value[2] }}" data-id="{{ $key }}" selected>{{ $value[0] }}</option> <!--num_order="{{ $loop->iteration }}"-->
                @else
                    <option value="{{ $key }}" title="{{ $value[1] }}" data-category="{{ $value[2] }}" data-id="{{ $key }}">{{ $value[0] }}</option>
                @endif
            @endforeach
        @endif
    </select>

    {{-- HINT --}}
    @if (isset($field['hint']))
        <p class="help-block">{!! $field['hint'] !!}</p>
    @endif
</div>

{{-- ########################################## --}}
{{-- Extra CSS and JS for this particular field --}}
{{-- If a field type is shown multiple times on a form, the CSS and JS will only be loaded once --}}
@if ($crud->checkIfFieldIsFirstOfItsType($field, $fields))

    {{-- FIELD CSS - will be loaded in the after_styles section --}}
    @push('crud_fields_styles')
    <!-- include select2 css-->
    <link href="{{ asset('vendor/adminlte/bower_components/select2/dist/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/0.1.0-beta.10/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />
    @endpush

    {{-- FIELD JS - will be loaded in the after_scripts section --}}
    @push('crud_fields_scripts')
    <!-- include select2 js-->
    <script src="{{ asset('vendor/adminlte/bower_components/select2/dist/js/select2.min.js') }}"></script>
    <style media="screen">
      .select_image {
        margin-right: 10px;
        max-height: 35px;
        /* float: left; */
      }
      .select2-container--bootstrap .select2-selection--multiple .select2-selection__choice {
        /* min-width: 98% !important; */
        width: 98%;
      }
      .select2-container--bootstrap .select2-selection--multiple .select2-selection__choice__remove {
        float: right;
      }
      .select2-container--bootstrap .select2-results__option[aria-selected=true] {
        background-color: #cecece !important;
        color: #555 !important;
      }
      .select2-container--bootstrap .select2-selection--multiple .select2-selection__choice {
        white-space: initial;
      }
      .prefix_option {
        text-transform: uppercase;
        display: block;
      }
    </style>
    <script>
        jQuery(document).ready(function($) {
            function format (option) {
              //if (!option.id) { return option.text; }
              //console.log(option.element.attributes[2].nodeValue);
              $('button[type="submit"]').removeAttr('disabled');

              var category= '';
              if(option.element){
                category = option.element.attributes[2].nodeValue;
              }

              var ob = '<b class="prefix_option" data-id="'+option.id+'">'+category + '</b><img src="/'+option.title+'" class="select_image"/>' + option.text;
              return ob;
            };

            $('.type_data_articles .select2_from_array').each(function (i, obj) {
                if (!$(obj).hasClass("select2-hidden-accessible"))
                {
                    $(obj).select2({
                        tags: true,
                        theme: "bootstrap",
                        templateResult: format,
                        templateSelection: function (option) {
                          //console.log(option);
                          //console.log(option.element.attributes[2].nodeValue);
                          var idx = $(obj).val().indexOf(option.id)+1;
                          return '<b class="prefix_option" data-id="'+option.id+'">'+idx + ') '+option.element.attributes[2].nodeValue+ '.</b> <img src="/'+option.title+'" class="select_image">'+option.text;
                        },
                        escapeMarkup: function (m) {
                          return m;
                        }
                    });
                }
            });

            var list = $(".type_data_articles ul.select2-selection__rendered"),
                list_li = $(".type_data_articles ul.select2-selection__rendered li.select2-selection__choice"),
                list_b = $(".type_data_articles ul.select2-selection__rendered b"),
                select2 = $(".type_data_articles .select2_from_array"),
                select2Backup = $(".type_data_articles .select2_from_array option");

            list.sortable({
              containment: 'parent',
              update: function() {
                  var select2val = [];
                  $(".type_data_articles ul.select2-selection__rendered li.select2-selection__choice").each(function() {
                    select2val.push( $(this).children('b').data('id'));
                  });

                  select2.empty().trigger('change');
                  for (var i = 0; i < select2val.length; i++) {
                    select2Backup.each(function(index, elem){
                      if ($(this).attr('value') == select2val[i]) {
                        var option = new Option($(this).text(), $(this).attr('value'), true, true);
                        option.setAttribute('data-category', $(this).attr('data-category'));
                        option.title = $(this).attr('title');
                        select2.append(option).trigger('change');
                        return false;
                      }
                    });
                  }
                  select2Backup.each(function(index, elem){
                    if (select2val.indexOf( +$(this).attr('value') ) == -1) {
                      var option = new Option($(this).text(), $(this).attr('value'), false, false);
                      option.title = $(this).attr('title');
                      option.setAttribute('data-category', $(this).data('category'));
                      select2.append(option).trigger('change');
                    }
                  });

              }
            });


            select2.on("select2:select", function (evt) {
              var element = evt.params.data.element;
              $(this).append($(element));
            //  console.log($(".type_data_articles .select2_from_array").val())
            });
        });
    </script>
    @endpush

@endif
{{-- End of Extra CSS and JS --}}
{{-- ########################################## --}}
