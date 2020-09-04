<script src="{{ mix('js/app.js', 'build') }}"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
<script src="/js/jquery.prettyPhoto.js"></script>

<!-- Bootstrap tooltips -->
<script src="/js/popper.min.js"></script>
<script src="/js/mdb_pro.min.js"></script>
<script src="/js/jquery.flexslider.js"></script>
<script src="/js/jquery.scrollUp.min.js"></script>

<!-- Initializations -->
<script src="/js/my_jquery.js"></script>

<script>
  // Animations initialization
  new WOW().init();
</script>

<script>
  let cords = ['scrollX','scrollY'],
      submits = document.querySelectorAll('.btn-form');
  // console.log(submits);
  // Перед закрытием записываем в локалсторадж window.scrollX и window.scrollY как scrollX и scrollY
  submits.forEach(function(submit, i , submits){
    submit.addEventListener('click', e => cords.forEach(cord => localStorage[cord] = window[cord]));
  })
  // Прокручиваем страницу к scrollX и scrollY из localStorage (либо 0,0 если там еще ничего нет)
  window.scroll(...cords.map(cord => localStorage[cord]));
  //Удаляем сразу ключи, чтобы при клике на другие ссылки страница открывалась сверху
  localStorage.removeItem('scrollY');
  localStorage.removeItem('scrollX'); 
</script>