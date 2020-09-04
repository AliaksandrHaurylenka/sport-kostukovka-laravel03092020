@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.section.title')</h3>
    
    {!! Form::model($section, ['method' => 'PUT', 'route' => ['admin.sections.update', $section->id], 'files' => true,]) !!}

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.qa_edit')
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('title', trans('quickadmin.section.fields.title').'*', ['class' => 'control-label']) !!}
                    {!! Form::text('title', old('title'), ['class' => 'form-control', 'placeholder' => 'Спортивная секция', 'required' => '']) !!}
                    <p class="help-block">Спортивная секция</p>
                    @if($errors->has('title'))
                        <p class="help-block">
                            {{ $errors->first('title') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-3 form-group">
                    @if ($section->photo)
                        <img class="photo" src="{{ asset(env('UPLOAD_PATH').'/images/sections/'.$section->photo) }}">
                    @else
                        <img class="photo" src="{{ asset(env('UPLOAD_PATH').'/images/sections/'.'img-default.jpg') }}"/>
                    @endif
                    {!! Form::label('photo', trans('quickadmin.section.fields.photo'), ['class' => 'control-label']) !!}
                    {!! Form::file('photo', ['class' => 'form-control', 'style' => 'margin-top: 4px;']) !!}
                    {!! Form::hidden('photo_max_size', 2) !!}
                    {!! Form::hidden('photo_max_width', 4096) !!}
                    {!! Form::hidden('photo_max_height', 4096) !!}
                    <p class="help-block"></p>
                    @if($errors->has('photo'))
                        <p class="help-block">
                            {{ $errors->first('photo') }}
                        </p>
                    @endif
                </div>
            </div>
            
            <div class="row">
                <div class="col-xs-12 form-group">
                	@if ($section->photo_sport)
                        <img class="photo" src="{{ asset(env('UPLOAD_PATH').'/images/sections/'.$section->photo_sport) }}">
                    @else
                        <img class="photo" src="{{ asset(env('UPLOAD_PATH').'/images/sections/'.'img-default.jpg') }}"/>
                    @endif
                    {!! Form::label('photo_sport', trans('quickadmin.section.fields.photo_sport'), ['class' => 'control-label']) !!}
                    {!! Form::file('photo_sport', ['class' => 'form-control', 'style' => 'margin-top: 4px;']) !!}
                    {!! Form::hidden('photo_sport_max_size', 2) !!}
                    {!! Form::hidden('photo_sport_max_width', 4096) !!}
                    {!! Form::hidden('photo_sport_max_height', 4096) !!}
                    <p class="help-block"></p>
                    @if($errors->has('photo'))
                        <p class="help-block">
                            {{ $errors->first('photo_sport') }}
                        </p>
                    @endif
                </div>
            </div>
            
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('description_main_page', trans('quickadmin.section.fields.description_main_page').'*', ['class' => 'control-label']) !!}
                    {!! Form::textarea('description_main_page', old('description_main_page'), ['class' => 'form-control editor', 'placeholder' => '', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('description_main_page'))
                        <p class="help-block">
                            {{ $errors->first('description_main_page') }}
                        </p>
                    @endif
                </div>
            </div>
            
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('description', trans('quickadmin.section.fields.description').'*', ['class' => 'control-label']) !!}
                    {!! Form::textarea('description', old('description'), ['class' => 'form-control editor', 'placeholder' => '', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('description'))
                        <p class="help-block">
                            {{ $errors->first('description') }}
                        </p>
                    @endif
                </div>
            </div>
            
        </div>
    </div>

    {!! Form::submit(trans('quickadmin.qa_update'), ['class' => 'btn btn-danger']) !!}
    {!! Form::close() !!}
@stop

@include('admin.block.editor')