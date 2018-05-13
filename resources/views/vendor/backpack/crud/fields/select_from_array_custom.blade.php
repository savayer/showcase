<!-- select from array -->
<div id="user_id" style="display: none">
  {{ auth()->user()->id }}
</div>
<div @include('crud::inc.field_wrapper_attributes') >
    <label>{!! $field['label'] !!}  </label>
    @include('crud::inc.field_translatable_icon')
    <select
        name="{{ $field['name'] }}@if (isset($field['allows_multiple']) && $field['allows_multiple']==true)[]@endif"
        @include('crud::inc.field_attributes')
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
                    <option value="{{ $key }}" selected>{{ $value }}</option>
                @else
                    <option value="{{ $key }}">{{ $value }}</option>
                @endif
            @endforeach
        @endif
    </select>

    {{-- HINT --}}
    @if (isset($field['hint']))
        <p class="help-block">{!! $field['hint'] !!}</p>
    @endif
</div>
@push('crud_fields_scripts')
<script src="{{ asset('/js/jquery-1.12.4.min.js') }}"></script>
<script type="text/javascript">
  window.onload = function(){
    var teasersSelect = $('select[name="teasersIds[]"]');
    if (location.href.indexOf('create') != -1) {
        teasersSelect.empty().trigger("change");
    }

    // $.ajax({
    //   url: 'http://worldsmii.info/api/teasers',
    //   data: {
    //     select_lang_id: $('select[name="lang_id"]').val(),
    //     user_id: $('#user_id').text()
    //   },
    //   success: function(data) {
    //     console.log(data);
    //     data.forEach(function(current, i) {
    //       var option = new Option(current.text, current.id, false, false);
    //       option.title = current.image;
    //       teasersSelect.append(option).trigger('change');
    //     })
    //   }
    //
    // })
    $('select[name="lang_id"]').on('change', function() {
      //$('select[name="teasersIds[]"]').val(null).trigger('change');
      var teasersSelect = $('select[name="teasersIds[]"]');
      teasersSelect.empty().trigger("change");

      $.ajax({
        url: 'http://worldsmii.info/api/teasers',
        //url: 'http://showcase.webdatacentr.ru/api/teasers',
        data: {
          select_lang_id: $(this).val(),
          user_id: $('#user_id').text()
        },
        success: function(data) {
          data.forEach(function(current, i) {
            var option = new Option(current.text, current.id, false, false);
            option.title = current.image;
            teasersSelect.append(option).trigger('change');
          })

        }

      })
    })

    $('select[name="country_id"]').on('change', function() {
      //$('select[name="teasersIds[]"]').val(null).trigger('change');
      var articlesSelect = $('select[name="articlesIds[]"]');
      articlesSelect.empty().trigger("change");

      $.ajax({
        url: 'http://worldsmii.info/api/articles',
        //url: 'http://showcase.webdatacentr.ru/api/articles',
        data: {
          select_country_id: $(this).val(),
          user_id: $('#user_id').text()
        },
        success: function(data) {
          console.log(data);
          data.forEach(function(current, i) {
            var option = new Option(current.name, current.id, false, false);
            option.title = current.image;
            option.setAttribute('data-category', current.category);
            articlesSelect.append(option).trigger('change');
          })

        }

      })
    })

  }
</script>
@endpush
