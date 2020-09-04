<div class="col-md-2 col-lg-2 col-xl-2 mx-auto my-4" id="menu-sport-sections-footer">

  <!-- Links -->
  <h6 class="text-uppercase font-weight-bold">Спортивные секции</h6>
  <hr class="deep-purple accent-2 mb-4 mt-0 d-inline-block mx-auto" style="width: 60px;">
  <ul class="list-unstyled">
    @if(isset($sportSections))
      @foreach($sportSections as $menu)
        <li>
          <a href="{{route($menu->slug)}}">{{$menu->title}}</a>
        </li>
      @endforeach
    @endif
  </ul>
</div>