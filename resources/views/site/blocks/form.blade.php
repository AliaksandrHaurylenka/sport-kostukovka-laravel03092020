<div class="col-md-3 col-lg-4 col-xl-3 mx-auto my-4">
	<!-- Content -->
	<h6 class="text-uppercase font-weight-bold">Напишите нам</h6>
	<hr class="deep-purple accent-2 mb-4 mt-0 d-inline-block mx-auto" style="width: 60px;">

	<!-- Default form group -->
	<form action="/letter" method="post">
			{{ csrf_field() }}
		<div class="form-row mb-4">
			<div class="col">
					<a href="" id="refresh"><img src="{{ Captcha::src('flat') }}" alt="captcha" class="captcha-img btn-form" data-refresh-config="default"></a>
			</div>
			<div class="col">
					<input class="form-control" type="text" placeholder="Код*" name="captcha" required>
			</div>
		</div>
	  <!-- Default input -->
	  <div class="form-group">
	    <input type="text" class="form-control" placeholder="Имя*" name="name" value="{{old('name')}}" required>
	  </div>
	  
	  <!-- Default input -->
	  <div class="form-group">
	    <input type="email" class="form-control" placeholder="E-mail*" name="email" value="{{old('email')}}" required>
	  </div>
	  
	  	<!--Material textarea-->
		<div class="form-group md-form md-outline">
		  <textarea id="form75" class="form-control white" rows="3" name="text" required>{{old('text')}}</textarea>
		  <label for="form75">Ваше сообщение*</label>
		</div>
			
		@if(session('status'))
			<div class="col-12 alert alert-info">
				{{session('status')}}
			</div>
		@endif
		@include('admin.errors')
		
		<!-- Sign in button -->
		<button class="btn btn-outline-info btn-rounded btn-block my-4 waves-effect z-depth-0 btn-form" type="submit">Отправить</button>
	</form>
</div>