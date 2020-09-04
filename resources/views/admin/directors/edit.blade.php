@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.director.title')</h3>
    
    {!! Form::model($director, ['method' => 'PUT', 'route' => ['admin.directors.update', $director->id], 'files' => true,]) !!}

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.qa_edit')
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('name', trans('quickadmin.director.fields.name').'*', ['class' => 'control-label']) !!}
                    {!! Form::text('name', old('name'), ['class' => 'form-control', 'placeholder' => 'Фамилия Имя Отчество', 'required' => '']) !!}
                    <p class="help-block">Фамилия Имя Отчество</p>
                    @if($errors->has('name'))
                        <p class="help-block">
                            {{ $errors->first('name') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    @if ($director->photo)
                        <img class="photo" src="{{ asset(env('UPLOAD_PATH').App\Director::PATH.$director->photo) }}">
                    @endif
                    {!! Form::label('photo', trans('quickadmin.director.fields.photo').'*', ['class' => 'control-label']) !!}
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
                    {!! Form::label('department', trans('quickadmin.director.fields.department').'*', ['class' => 'control-label']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('department'))
                        <p class="help-block">
                            {{ $errors->first('department') }}
                        </p>
                    @endif
                    <div>
                        <label>
                            {!! Form::radio('department', 'Директор СОК', false, ['required' => '']) !!}
                            СОК
                        </label>
                    </div>
                    <div>
                        <label>
                            {!! Form::radio('department', 'Директор СДЮШОР', false, ['required' => '']) !!}
                            СДЮШОР
                        </label>
                    </div>

                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('description', trans('quickadmin.director.fields.description').'*', ['class' => 'control-label']) !!}
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