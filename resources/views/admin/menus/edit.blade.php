@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.menu.title')</h3>
    
    {!! Form::model($menu, ['method' => 'PUT', 'route' => ['admin.menus.update', $menu->id]]) !!}

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.qa_edit')
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('title', trans('quickadmin.menu.fields.title').'*', ['class' => 'control-label']) !!}
                    {!! Form::text('title', old('title'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('title'))
                        <p class="help-block">
                            {{ $errors->first('title') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('drop', trans('quickadmin.menu.fields.drop').'*', ['class' => 'control-label']) !!}
                    {{--{!! Form::number('drop', old('drop'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}--}}
                    <p class="help-block"></p>
                    @if($errors->has('drop'))
                        <p class="help-block">
                            {{ $errors->first('drop') }}
                        </p>
                    @endif
                    <div>
                        <label>
                            {!! Form::radio('drop', 1, false) !!}
                            Да
                        </label>
                    </div>
                    <div>
                        <label>
                            {!! Form::radio('drop', 0, false) !!}
                            Нет
                        </label>
                    </div>
                </div>
            </div>
            
        </div>
    </div>

    {!! Form::submit(trans('quickadmin.qa_update'), ['class' => 'btn btn-danger']) !!}
    {!! Form::close() !!}
@stop

