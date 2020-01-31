@forelse ($values as $value)
   <div id="widget_value" class="widget-box ">
      <div class="widget-header">
         <h4 class="widget-title">Value:</h4>
         <span class="widget-toolbar">
            <a href="#" data-action="collapse"><i class="ace-icon fa fa-chevron-up"></i></a>
            <a href="#" onclick="deleteValue(this)" class="close_value red" data-id="{{ $value->attr_value_id }}">
               <i class="ace-icon fa fa-times"></i></a>
         </span>
      </div>
      <div class="widget-body">
         <div class="widget-main center">
            <div class="form-group">
               <label for="value"></label>
               <input type="text" value="{{ $value->value }}" id="value" data-id="{{$value->attr_value_id}}" name="value[][{{ $value->attr_value_id }}]"
                      class="input form-control values" placeholder="Value">

            </div>
         </div>
      </div>
   </div>
@empty
   <h2>SELECT ATTRIBUTE</h2>
@endforelse
