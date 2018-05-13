<!-- checkbox field -->

<div @include('crud::inc.field_wrapper_attributes') >
    @include('crud::inc.field_translatable_icon')
    <div class="checkbox">
    	<label>
    	  <input type="hidden" name="{{ $field['name'] }}" value="0">
    	  <input type="checkbox" value="1"

          name="{{ $field['name'] }}"

          @if(old($field['name']) ? old($field['name']) : (isset($field['value']) ? $field['value'] : (isset($field['default']) ? $field['default'] : false )))
                 checked="checked"
          @endif

          @if (isset($field['attributes']))
              @foreach ($field['attributes'] as $attribute => $value)
    			{{ $attribute }}="{{ $value }}"
        	  @endforeach
          @endif
          > {!! $field['label'] !!}
    	</label>

        {{-- HINT --}}
        @if (isset($field['hint']))
            <p class="help-block">{!! $field['hint'] !!}</p>
        @endif
    </div>
</div>
@push('crud_fields_scripts')
<script src="/js/jquery-1.12.4.min.js" charset="utf-8"></script>
  <script type="text/javascript">
    window.onload = function() {
      check();
      $('input[type="checkbox"]').on('change', function() {
      //  console.log($(this).is(':checked'));
        check();
      })

      function check() {
        if ($('input[type="checkbox"]').is(':checked')) {
          $('.gif_image1').show();
          // $('.gif_image2').show();
          $('.teaset_image1').hide();
          $('.teaser_image2').hide();
        } else {
          $('.gif_image1').hide();
          // $('.gif_image2').hide();
          $('.teaset_image1').show();
          $('.teaser_image2').show();
        }
      }

    }
  </script>
@endpush
