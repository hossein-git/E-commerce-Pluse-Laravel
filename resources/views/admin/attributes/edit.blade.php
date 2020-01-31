@extends('layout.admin.index')
@section('title')
   Edit Attribute
@endsection
@section('extra_css')
@endsection
@section('content')
   <form id="attr_form" method="post" action="{{ route('attribute.update', $id) }}">
      @csrf
      @method("PUT")

      <div class="space-10"></div>
      <div class="form-group row">
         <div class="col-sm-6">
            <label for="attr" class="bolder">Attributes:</label>
            <select class="form-control select2" name="attr_id" id="attr">
               <option disabled selected>Choose Attributes</option>
               @forelse ($attributes as $attr)
                  <option value="{{$attr->attr_id}}">{{ $attr->attr_name }}</option>
               @empty
                  <option disabled>NO data</option>
               @endforelse
            </select>
         </div>
         <div class="col-sm-6">
            <label for="attr_name">Attribute Name</label>
            <input type="text" name="attr_name" id="attr_name" class="form-control">
         </div>
      </div>

      <div class="row">
         <div class="col-sm-3">
            <button class="btn btn-info" id="add_val">Add Value</button>
            <input class="btn btn-success" id="submit" type="submit" value="SAVE">
            <div class="space-2"></div>
            <button class="btn btn-danger" data-id="" id="destroy_attr" title="delete attribute and its values"
                    disabled="">DELETE
            </button>
            <a href="{{ route('attribute.createNew',$id) }}" class="btn btn-warning bolder" id="destroy_attr"
               title="add new attribute">New Attribute</a>
         </div>
         <div class="col-sm-6" id="div_value">
            @include('admin.attributes._data')
         </div>
         <div class="col-sm-3"></div>
      </div>

   </form>

@endsection
@section('extra_js')

   <!-- upload with ajax -->
   @if(env('APP_AJAX'))
      <script type="text/javascript">
          jQuery(document).ready(function () {
              $('#attr_form').submit(function (e) {
                  e.preventDefault();
                  var valuesArray = [],
                      values = $('.values').map(function () {
                          if (typeof $(this).data('id') === typeof undefined) {
                              valuesArray.push($(this).val());
                          } else {
                              valuesArray[$(this).data('id')] = ($(this).val());
                          }
                      });


                  var data = {
                      attr_id: $('#attr').val(),
                      attr_name: $('#attr_name').val(),
                      value: valuesArray,
                      _method: "PUT"
                  };
                  // console.log(values,data);
                  if (upload_ajax("{{ route('attribute.update', $id) }}", data)) {
                      window.location.reload();
                  }
              });
          });
      </script>
   @endif

   <script type="text/javascript">
       jQuery(document).ready(function () {
           $('#add_val').click(function (e) {
               e.preventDefault();
               var widget = '<div id="widget_value" class="widget-box"><div class="widget-header"><h5 class="widget-title">Value:</h5><span class="widget-toolbar"><a href="#" data-action="collapse"><i class="ace-icon fa fa-chevron-up"></i></a><a href="#" data-action="close"><i class="ace-icon fa fa-times"></i></a></span></div><div class="widget-body"><div class="widget-main center"><div class="form-group"><input type="text" id="value" name="value[]" class="input form-control values" placeholder="Value" required></div></div></div></div>';
               $('#div_value').append(widget)
           });

           //delete attr with its values
           $("#destroy_attr").click(function (e) {
               e.preventDefault();
               var id = $(this).data("id");
               if (!confirm('ARE YOU SURE TO DELETE IT?')) {
                   return false
               }
               $.ajaxSetup({
                   headers: {
                       'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                   }
               });
               $.ajax({
                   url: '/admin/attribute/' + id,
                   method: "DELETE",
                   dataType: "Json",
                   data: {"id": id},
                   success: function ($results) {

                       alert($results.message);
                       window.location.reload();
                   },
                   error: function (xhr) {
                       alert(xhr.responseText.message);
                       console.log(xhr.responseText);
                   }
               });
           });

           <!-- SHOW VALUES RELATED BY ATTRIBUTE WITH AJAX -->
           $("select").on('change', function () {
               $(this).find("option:selected").each(function () {
                   var value = $(this).attr("value");
                   var name = $(this).text();
                   $('#attr_name').val(name);
                   $('#destroy_attr').attr('data-id', value).removeAttr('disabled');
                   $('#submit').removeAttr('disabled');
                   $.ajaxSetup({
                       headers: {
                           'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                       }
                   });
                   $.ajax({
                       url: "{{ route('attribute.edit',$id) }}",
                       method: "get",
                       data: {value: value},
                       beforeSend: function () {
                           $(".preview").show();
                       },

                   })
                       .done(function (data) {
                           if (data.html == "") {
                               $('.preview').html("No more records found");
                               return;
                           }
                           // console.log(data.html);
                           $("#div_value").empty().append(data.html);
                           $('.preview').hide();
                       })
                       .fail(function () {
                           alert('error');
                       })

               });
           }).change();

       });

       //delete attr values
       function deleteValue(elem) {
           // elem.preventDefault();
           var value_id = $(elem).data('id');
           if (!confirm('ARE YOU SURE TO DELETE IT?')) {
               return false
           }
           var id = value_id;
           $.ajaxSetup({
               headers: {
                   'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
               }
           });
           $.ajax({
               url: '/admin/attribute/value/' + id,
               method: "DELETE",
               beforeSend: function () {
                   $(".preview").show();
               },
               success: function ($results) {
                   $(".preview").hide();
                   alert($results.message);
                   $(elem).parents().eq(2).remove();
               },
               error: function (xhr) {
                   alert(xhr.responseText.message);
                   console.log(xhr.responseText);
                   $(".preview").hide();
               }
           });

       }
   </script>


@endsection
