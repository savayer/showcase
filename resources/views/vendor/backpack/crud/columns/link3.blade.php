<span>
  @if( !empty($entry->{$column['name']}) )
    <a
      href="{{ asset( (isset($column['prefix']) ? $column['prefix'] : '') . $entry->{$column['name']}) }}"
      target="_blank"
    >
      Cloaka
    </a>
  @else
    -
  @endif
</span>
