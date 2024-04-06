@extends('Admin::Layouts.admin')
@section('content')

<div id="insert" class="container">
	<h3 class="title-insert text-center">
	@if(isset($data))
		{{'Edit'}}
	@endif
	</h3>

	<form class="form-horizontal" method="POST" action="{{ route($resource.'.update', $data['id']) }}" enctype="multipart/form-data">
		{{ csrf_field() }}{{ method_field('put') }}
		@foreach($form as $key => $val)
			<div class="row form-group">
				@switch($val['type'])
					@case('hidden')
						{{Form::input('hidden', $key, isset($data[$key])?$data[$key]:(isset($val['value'])?$val['value']:null), array())}}
					@break
                    @case('has_many')
                        <label class="control-label col-sm-3">{{$val['title']}}</label>
                        <div class="col-sm-9">
                            <div id="product_option"></div>
                            <div class="options_append">
                                <div class="row append">
                                    @foreach($data->$key as $k => $items)
                                        <div class="col-12 mt-1">
                                        @foreach($val['update'] as $field)
                                            {{ Form::input('text', $key.'_update['.$k.']['.$field.']' , $items->$field)}}
                                        @endforeach
                                            <span onclick="removeOption(this)" class="bg-info text-white px-2 py-1"> Xóa </span>
                                        </div>
                                    @endforeach

                                </div>
                                <div class="d-flex mt-3">
                                    <div class="mr-2"><span onclick="addHtmlOption(this)" class="bg-info text-white px-2 py-1"> Thêm lựa chọn </span></div>
                                </div>
                            </div>
                            <script>
                                function addHtmlOption(e){
                                    let html = '<div class="col-12 mt-1">@foreach($val['update'] as $field) {{ Form::input('text', $key.'_insert['.$field.'][]' , '')}} @endforeach </div>';
                                    $(e).parents(".options_append").find(".append").append(html);
                                }
                                function removeOption(e){
                                    $(e).parent().remove();
                                }
                            </script>
                        </div>
                    @break
					@case('text')
						<label class="control-label col-sm-3">{{$val['title']}}</label>
						<div class="col-sm-9">
							{{Form::input('text', $key, isset($data[$key])?$data[$key]:(isset($val['value'])?$val['value']:null),
								array('class' => 'form-control text', 'placeholder' => isset($val['placeholder'])?$val['placeholder']:'Input '.$key))}}
							@error($key)
							<span class="alert alert-danger">{{ $message }}</span>
							@enderror
						</div>
					@break
                    @case('date')
                    <label class="control-label col-sm-3">{{$val['title']}}</label>
                    <div class="col-sm-9">
                        {{Form::input('text', $key, isset($data[$key])?$data[$key]:(isset($val['value'])?$val['value']:null),
                            array('id' => 'datepicker','class' => 'form-control text','data-date-format'=> "dd/mm/yyyy", 'placeholder' =>'dd/mm/yyyy'))}}
                        <script type="text/javascript">
                            $('#datepicker').datepicker({weekStart: 1,daysOfWeekHighlighted: "6,0", autoclose: true,todayHighlight: true,});
                            $('#datepicker').datepicker("setDate", new Date());
                        </script>
                        @error($key)
                        <span class="alert alert-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    @break
					@case('password')
						<label class="control-label col-sm-3">{{$val['title']}}</label>
						<div class="col-sm-9">
							{{Form::input('password', $key, null , array('class' => 'form-control text', 'placeholder' => isset($val['placeholder'])?$val['placeholder']:'Input '.$key))}}
							@error($key)
							<span class="alert alert-danger">{{ $message }}</span>
							@enderror
						</div>
					@break
                    @case('confirm')
                    <label class="control-label col-sm-3">{{$val['title']}}</label>
                    <div class="col-sm-9">
                        {{Form::input('password', $key, null , array('class' => 'form-control text', 'placeholder' => isset($val['placeholder'])?$val['placeholder']:'Input '.$key))}}
                        @error($key)
                        <span class="alert alert-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    @break
					@case('select')
						<label class="control-label col-sm-3">{{$val['title']}}</label>
						<div class="col-sm-9">
							@if(isset($val['ajax']))
								@switch($val['ajax']['type'])
									@case ('select')
									{{Form::select($key, $val['data'], isset($data[$key])?$data[$key]:(isset($val['value'])?$val['value']:null),
									array('class'=>'form-control select render_select', 'table'=>$val['ajax']['table'], 'reference'=>$val['ajax']['reference']))}}
									@break
								@endswitch
							@else
							{{Form::select($key, $val['data'], isset($data[$key])?$data[$key]:(isset($val['value'])?$val['value']:null), array('class'=>'form-control select'))}}
							@endif
							@error($key)
							<label class="alert alert-danger">{{ $message }}</label>
							@enderror
						</div>
					@break
					@case('area')
						<label class="control-label col-sm-3">{{$val['title']}}</label>
						<div class="col-sm-9">
							@include('ckfinder::setup')
							{{Form::textarea($key, isset($data[$key])?$data[$key]:(isset($val['value'])?$val['value']:null),
							array('id'=>$key.'area', 'class'=>'form-control', 'placeholder'=>isset($val['placeholder'])?$val['placeholder']:'Input '.$key))}}
							@error($key)
								<span class="alert alert-danger">{{ $message }}</span>
							@enderror
						</div>
						<script>
							CKEDITOR.replace( '{{$key.'area'}}', {filebrowserBrowseUrl: '{{ route('ckfinder_browser') }}'});
						</script>
						@include('ckfinder::setup')
					@break
                    @case('images')
                    <label class="control-label col-sm-3">{{$val['title']}}</label>
                    <div class="col-sm-9">
                        <span class="images mt-3">
							<p class="image_box_{{$key}}">
								@if(!empty($data[$key]))
									@foreach(explode(',', $data[$key]) as $item)
										<span class="images-group images-delete" url="{{ route($resource.'.update', $data['id']) }}" fid="{{$item}}">
											<img  onerror="this.src='/images/no-image.png'" src="{{route('get-image-thumbnail', $item)}}">
											<span><i class="fa fa-close" aria-hidden="true"></i></span>
										</span>
									@endforeach
								@endif
							</p>
                        </span>
						<span class="inline">
                            {{ Form::file($key.'[]', array('multiple', 'key'=> $key, 'class'=>'upload_images_field')) }}
                        </span>
                        @error($key)
                        	<span class="alert alert-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    @break
					@case('image')
                        <label class="control-label col-sm-3">{{$val['title']}}</label>
                        <div class="col-sm-9">
							<span class="inline image_box_{{$key}}"><img src="{{route('get-image-resource', $data[$key])}}"></span>
							<span class="inline">
                                {{Form::file($key, array('key'=> $key, 'class'=>'upload_images_field', 'value' => isset($data[$key])? $data[$key]: (isset($val['value'])? $val['value']: null)))}}
                            </span>
                            @error($key)
                            	<span class="alert alert-danger">{{ $message }}</span>
                            @enderror
                        </div>
					@break
					@case('image_id')
						<label class="control-label col-sm-3">{{$val['title']}}</label>
						<div class="col-sm-9">
							<span class="inline image_box_{{$key}}"><img onerror="this.src='/images/no-image.png'" src="{{route('get-image-thumbnail', $data[$key])}}"></span>
							<span class="inline">
								{{Form::file($key, array('key'=> $key, 'class'=>'upload_images_field',
								'value'=> isset($data[$key])? route('get-image-thumbnail', $data[$key]): (isset($val['value'])? route('get-image-thumbnail', $val['value']): null)))}}
							</span>
							@error($key)
								<span class="alert alert-danger">{{ $message }}</span>
							@enderror
						</div>
					@break
					@case('file')
						<label class="control-label col-sm-3">{{$val['title']}}</label>
						<div class="col-sm-9">
							<span class="inline text_box">{{preg_replace('/(.)*(?:\/)/','',isset($data[$key])?$data[$key]:(isset($val['value'])?$val['value']:null))}}</span>
							<span class="inline">
								{{Form::file($key, array('id'=>'feature', 'class'=>'form-control' , 'value'=>isset($data[$key])?$data[$key]:(isset($val['value'])?$val['value']:null)))}}
							</span>
							@error($key)
							<span class="alert alert-danger">{{ $message }}</span>
							@enderror
						</div>
					@break

					@case('check')
						<label class="control-label col-sm-3">{{$val['title']}}</label>
						<div class="col-sm-9">
							<span class="check">
								{{Form::input('hidden', $key, 0)}}
								{{Form::checkbox($key, 1, isset($data[$key])?$data[$key]:(isset($val['value'])?$val['value']:null))}}
							</span>
							@error($key)
								<span class="alert alert-danger">{{ $message }}</span>
							@enderror
						</div>
					@break
				@endswitch
			</div>
		@endforeach
	 	<div class="form-group">
	    	<div class="control-label col-sm-3"></div>
	    	<div class="col-sm-9">
	      		<input type="submit" id="submit" name="submit" value="Save & Back List">
	      		<input type="submit" id="submit" name="submit_edit" value="Save & Edit">
                @if(Request::get('back'))
                    <a class="btn btn-second" href="{{Request::root()}}/{{urldecode(Request::get('back'))}}"> Back </a>
                @else
                    <a class="btn btn-second prefix_link" href="{{route($resource.'.index')}}"> Cancel </a>
                @endif
                @if(isset($data['id']))
                    <span class="option-order">
						@if(isset($control['next']))
                            <a class="btn btn-second" href="{{Request::root()}}/{{$control['next']['link']}}/{{$data['id']}}"> {{$control['next']['title']}} <i title="{{$control['next']['title']}}" class="fa fa-chevron-right"></i></a>
                        @endif
                        @if(isset($control['prev']))
                            <a class="btn btn-second" href="{{Request::root()}}/{{$control['prev']['link']}}/{{$data['id']}}"><i title="{{$control['prev']['title']}}" class="fa fa-chevron-left" aria-hidden="true">{{$control['next']['title']}}</i></a>
                        @endif
					</span>
                @endif
	    	</div>
	 	</div>
	</form>
</div>
<div id="footer">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-8 menu">
				Admin theme
			</div>
			<div class="col-md-4 text-right">
				Copyright @ Huy Lê
			</div>
		</div>
	</div>
</div>
@endsection
