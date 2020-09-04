@extends('layouts.site')

@section('title', 'Тяжелая атлетика.Спорт-Костюковка')
@section('description', 'г. Гомель, микрорайон Костюковка, Государственное учреждение "Физкультурно-оздоровительный центр "Костюковка-Спорт"')

@section('content')
	
	@include('site.sections.sectionsTemplate', ['sport' => 'Тяжелая атлетика'])

@endsection