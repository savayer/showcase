<a data-route="{{ env('APP_URL') }}api/copy_teaser"
  data-teaser="{{ $entry->getKey() }}"
  href="javascript:void(0)"
  onclick="copyEntry(this)"
  data-button-type="copy"
  class="copyrow btn btn-xs btn-primary"><i class="fa fa-copy"></i> Коп.</a>

  <script>
  	if (typeof copyEntry != 'function') {
  	  $("[data-button-type=copy]").unbind('click');
    
  	  function copyEntry(button) {
  	      // ask for confirmation before deleting an item
  	      // e.preventDefault();
  	      var button = $(button);
  	      var route = button.attr('data-route');
            console.log(route);
          var teaser_id = button.attr('data-teaser');
  	      var row = $("#crudTable a[data-route='"+route+"']").parentsUntil('tr').parent();

  	      if (confirm("{{ trans('backpack::crud.copy_confirm_teaser') }}") == true) {
  	          $.ajax({
  	              url: route,
                  type: 'get',
                  data: {
                    teaser_id: teaser_id
                  },
  	              success: function(result) {
  	                  // Show an alert with the result
  	                  new PNotify({
  	                      title: "{{ trans('backpack::crud.copy_confirmation_title') }}",
  	                      text: "{{ trans('backpack::crud.copy_confirmation_message') }}",
  	                      type: "success"
  	                  });

  	                  // Hide the modal, if any
  	                  $('.modal').modal('hide');

                      location.reload();

  	                  // Remove the row from the datatable
  	                 // row.remove();
  	              },
  	              error: function(result) {
  	                  // Show an alert with the result
  	                  new PNotify({
  	                      title: "{{ trans('backpack::crud.copy_confirmation_not_title') }}",
  	                      text: "{{ trans('backpack::crud.copy_confirmation_not_message') }}",
  	                      type: "warning"
  	                  });
  	              }
  	          });
  	      } else {
  	      	  // Show an alert telling the user we don't know what went wrong
  	          new PNotify({
  	              title: "{{ trans('backpack::crud.copy_confirmation_not_copied_title') }}",
  	              text: "{{ trans('backpack::crud.copy_confirmation_not_copied_message') }}",
  	              type: "info"
  	          });
  	      }
        }
  	}

  	// make it so that the function above is run after each DataTable draw event
  	// crud.addFunctionToDataTablesDrawEventQueue('deleteEntry');
  </script>
