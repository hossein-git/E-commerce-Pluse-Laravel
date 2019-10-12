<div class="card">
   <div class="card-body">
      @if($errors->has('commentable_type'))
         <div class="alert alert-danger" role="alert">
            {{ ($errors->get('commentable_type')) }}
         </div>
      @endif
      @if($errors->has('commentable_id'))
         <div class="alert alert-danger" role="alert">
            {{ ($errors->get('commentable_id')) }}
         </div>
      @endif
      <!-- RATING -->
      <div class="form-group">
         <div class="">
            <span>for rating please login</span>
            <fieldset class="rating0">
               <input type="radio" id="star5" name="rating" value="5"/>
               <label class="full" for="star5" title="Awesome - 5 stars"></label>
               <input type="radio" id="star4" name="rating" value="4"/>
               <label class="full" for="star4" title="Pretty good - 4 stars"></label>
               <input type="radio" id="star3" name="rating" value="3"/>
               <label class="full" for="star3" title="Meh - 3 stars"></label>
               <input type="radio" id="star2" name="rating" value="2"/>
               <label class="full" for="star2" title="Kinda bad - 2 stars"></label>
               <input type="radio" id="star1" name="rating" value="1"/>
               <label class="full" for="star1" title="Sucks big time - 1 star"></label>
            </fieldset>
         </div>
         <br>
      </div>
      <!-- /RATING -->
      <form method="POST" action="{{ url('comments') }}">
         @csrf
         <input type="hidden" name="commentable_type" value="\{{ get_class($model) }}"/>
         <input type="hidden" name="commentable_id" value="{{ $model->product_id }}"/>

         {{-- Guest commenting --}}
         @if(isset($guest_commenting) and $guest_commenting == true)

            <div class="form-group">
               {{--                    <label for="message">Enter your name here:</label>--}}
               <input type="text" class="form-control @if($errors->has('guest_name')) is-invalid @endif"
                      name="guest_name" placeholder="Your Name" required/>
               @error('guest_name')
               <div class="invalid-feedback">
                  {{ $message }}
               </div>
               @enderror
            </div>
            <div class="form-group">
               {{--                    <label for="message">Enter your email here:</label>--}}
               <input type="email" class="form-control @if($errors->has('guest_email')) is-invalid @endif"
                      name="guest_email" placeholder="Your Email" required/>
               @error('guest_email')
               <div class="invalid-feedback">
                  {{ $message }}
               </div>
               @enderror
            </div>
         @endif

         <div class="form-group">
            <label for="message">Enter your message here:</label>
            <textarea class="form-control @if($errors->has('message')) is-invalid @endif" name="message" rows="3"
                      required></textarea>
            <div class="invalid-feedback">
               Your message is required.
            </div>
         </div>
         <button type="submit" class="btn btn-sm btn-outline-success text-uppercase">Submit</button>
      </form>
   </div>
</div>
<br/>