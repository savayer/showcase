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
                    <option value="{{ $key }}" title="{{ $value[1] }}" selected>{{ $value[0] }}</option> <!--num_order="{{ $loop->iteration }}"-->
                @else
                    <option value="{{ $key }}" title="{{ $value[1] }}" >{{ $value[0] }}</option>
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
        display: inline-block;
      }
      .select2-container--bootstrap .select2-selection--multiple .select2-selection__choice {
        min-width: 98% !important;
      }
      .select2-container--bootstrap .select2-selection--multiple .select2-selection__choice__remove {
        float: right;
      }
      .select2-container--bootstrap .select2-results__option[aria-selected=true] {
        background-color: #cecece !important;
        color: #555 !important;
      }
    </style>
    <script>
        jQuery(document).ready(function($) {
            function format (option) {
              if (!option.id) { return option.text; }
              var ob = '<img src="/'+option.title+'" class="select_image"/>' + option.text;
              return ob;
            };

            $('.select2_from_array').each(function (i, obj) {
                if (!$(obj).hasClass("select2-hidden-accessible"))
                {
                  //var counter = 0;
                  // Индекс сортировки
                  var $select = $(obj);
                  var sortIndex = 0;
                    var select2Instance = $(obj).select2({
                        theme: "bootstrap",
                        templateResult: format,
                        templateSelection: function (option) {
                            if (option.id.length > 0 ) {
                              //option.num = ++counter;
                                //return option.num+'. <img src="/'+option.title+'" class="select_image">'+option.text;
                                return '<img src="/'+option.title+'" class="select_image">'+option.text;
                            } else {
                                return option.text;
                            }
                        },
                        escapeMarkup: function (m) {
                  				return m;
                  			},
                        sorter: function (data) {
                          return data.sort(function (a, b) {
                              if (Number(a.id) > Number(b.id)) return 1;
                              else if (Number(a.id) < Number(b.id)) return -1;
                              return 0;
                          });
                        }
                    }).data().select2;

                    // Событие когда выбрали элемен в dropdown (перед вставкой в select2)
                    select2Instance.on('selecting', function (e) {
                        // Увеличиваем индекс сортировки и привайваем ноде
                        // в виде нового свойства объекта (лучше в dataset запихать)
                        e.args.data.element.sortIndex = ++sortIndex;

                        // Получвем все option из select`а
                        var $options = $select.find('option');

                        // Сортируем все option`ы по индексу сортировки
                        $options.sort(function (a, b) {
                            if (~~a.sortIndex > ~~b.sortIndex) return 1;
                            else if (~~a.sortIndex < ~~b.sortIndex) return -1;
                            return 0;
                        });

                        // Очищаем select от option`ов и аппендим отсортированные
                        $select.empty().append($options);
                    });
                }
            });
        });
    </script>
    @endpush

@endif
{{-- End of Extra CSS and JS --}}
{{-- ########################################## --}}
