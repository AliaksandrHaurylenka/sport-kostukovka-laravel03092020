<!-- Section: Contact v.1 -->
<section class="my-5">
    <!-- Form with header -->
    <div class="card">
      <div class="card-body">
        <!-- Header -->
        <div class="form-header blue accent-1">
          <h3 class="mt-2"><i class="fas fa-envelope"></i> Напишите нам:</h3>
        </div>
        <!-- Body -->
        <form action="/letter" method="post">
          {{ csrf_field() }}
          <div class="form-row">
            <div class="col-sm-6">
              <div class="md-form">
                <img src="{{ Captcha::src('flat') }}" alt="captcha" class="captcha-img" data-refresh-config="default">
                <a href="" id="refresh" title="Обновить"><i class="fas fa-sync-alt ml-1 btn-form"></i></a>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="md-form">
                <input id="captcha" class="form-control" type="text" name="captcha" required>
                {{-- <input id="captcha" class="form-control" type="text" name="captcha"> --}}
                <label for="captcha">Код с картинки *</label>
              </div>
            </div>
          </div>
          <div class="md-form">
            <i class="fas fa-user prefix grey-text"></i>
            <input type="text" id="form-name" class="form-control" name="name" value="{{old('name')}}" required>
            {{-- <input type="text" id="form-name" class="form-control" name="name" value="{{old('name')}}"> --}}
            <label for="form-name">Ваше имя *</label>
          </div>
          <div class="md-form">
            <i class="fas fa-envelope prefix grey-text"></i>
            <input type="email" id="form-email" class="form-control" name="email" value="{{old('email')}}" required>
            {{-- <input type="email" id="form-email" class="form-control" name="email" value="{{old('email')}}"> --}}
            <label for="form-email">Ваш e-mail *</label>
          </div>
          <div class="md-form">
            <i class="fas fa-pencil-alt prefix grey-text"></i>
            <textarea id="form-text" class="form-control md-textarea" rows="3" name="text" required>{{old('text')}}</textarea>
            {{-- <textarea id="form-text" class="form-control md-textarea" rows="3" name="text" >{{old('text')}}</textarea> --}}
            <label for="form-text">Сообщение *</label>
          </div>
          {{-- @if(session('status'))
            <div class="col-12 alert alert-info">
              {{session('status')}}
            </div>
          @endif --}}
          @include('admin.errors')
          @include('flash::message')
          <div class="text-center">
            <button type="submit" class="btn btn-light-blue btn-form">Отправить</button>
          </div>
        </form>
      </div>
    </div>
  </section>
  <!-- Section: Contact v.1 -->