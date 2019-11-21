@extends('layout.admin.index' )
@section('title')
   Create new Prodcuts
@stop
@section('extra_css')
@stop
@section('content')
   <div class="form-group">
      <label class="col-sm-3 control-label no-padding-right" for="form-field-tags">Tag input</label>
      <div class="col-sm-9">
         <div class="inline">
            <input type="text" name="tags" id="form-field-tags" value="Tag Input Control" placeholder="Enter tags ..." />
         </div>
      </div>
   </div>

@endsection
@section('extra_js')

   <script src="{{ asset('admin-assets/js/bootstrap-tag.min.js') }}"></script>
   <script>
       var tag_input = $('#form-field-tags');
       try{
           tag_input.tag(
               {
                   placeholder:tag_input.attr('placeholder'),
                   //enable typeahead by specifying the source array
                   source: ace.vars['US_STATES'],//defined in ace.js >> ace.enable_search_ahead
                   /**
                    //or fetch data from database, fetch those that match "query"
                    source: function(query, process) {
						  $.ajax({url: 'remote_source.php?q='+encodeURIComponent(query)})
						  .done(function(result_items){
							process(result_items);
						  });
						}
                    */
               }
           )

           //programmatically add/remove a tag
           var $tag_obj = $('#form-field-tags').data('tag');
           $tag_obj.add('Programmatically Added');

           var index = $tag_obj.inValues('some tag');
           $tag_obj.remove(index);
       }
       catch(e) {
           //display a textarea for old IE, because it doesn't support this plugin or another one I tried!
           tag_input.after('<textarea id="'+tag_input.attr('id')+'" name="'+tag_input.attr('name')+'" rows="3">'+tag_input.val()+'</textarea>').remove();
           //autosize($('#form-field-tags'));
       }

   </script>
@stop