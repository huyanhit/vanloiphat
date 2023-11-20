@extends('Admin::Layouts.admin')
@section('content')
	<div id="insert" class="container">
		<h3 class="title-insert text-center">
			Thêm Mới
		</h3>
		<form class="form-horizontal" method="post" action="{{ route($resource.'.store') }}" enctype="multipart/form-data">
			{{ csrf_field() }}
			@foreach($form as $key => $val)
				<div class="row form-group">
					@switch($val['type'])
						@case('hidden')
						{{Form::input('hidden', $key, isset($val['value'])?$val['value']:(isset($data[$key])?$data[$key]:(isset($val['value'])?$val['value']:null)), array())}}
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
								@if(isset($val['ajax']) && isset($val['data']))
									@switch($val['ajax']['type'])
										@case ('select')
										{{Form::select($key, $val['data'], isset($data[$key])?$data[$key]:(isset($val['value'])?$val['value']:null),
										array('class'=>'form-control select render_select', 'table'=>$val['ajax']['table'], 'reference'=>$val['ajax']['reference']))}}
										@break
									@endswitch
								@else
									{{Form::select($key, isset($val['data'])?$val['data']:null , isset($data[$key])?$data[$key]:(isset($val['value'])?$val['value']:null), array('class'=>'form-control select'))}}
								@endif
								@error($key)
								<span class="alert alert-danger">{{ $message }}</span>
								@enderror
							</div>
						@break
						@case('radio_group')
							<label class="control-label col-sm-3">{{$val['title']}}</label>
							<div class="col-sm-9">
								@if(isset($val['ajax']))
									@switch($val['ajax']['type'])
										@case ('select')
											@if(isset($val['data']))
												@foreach($val['data'] as $r_key => $r_value)
													<div class="item">
														{{ Form::radio($key, $r_value , false,
														array('class'=>'render_select', 'id' =>'render_select_'.$r_key, 'table'=>$val['ajax']['table'],
														'reference'=>$val['ajax']['reference'])) }}
														<label class="position-top-1" for="render_select_{{$r_key}}"> {{ $r_value }} </label>
													</div>
												@endforeach
											@endif
										@break
										@case ('image')
										<div class="row">
											<div class="js_render col row">
												<div class="col-md-3">
													@if(isset($val['data']))
														@foreach($val['data'] as $r_key => $r_value)
															<div class="item">
																{{ Form::radio($key, $r_value , false,
																array('class'=>'render_image', 'id' =>'render_image_'.$r_key)) }}
																<span class="position-top-1" for="render_image_{{$r_key}}"> {{ $r_value }} </span>
															</div>
														@endforeach
													@endif
												</div>
											</div>
										</div>
										@break
									@endswitch
								@else
									@if(isset($val['data']))
									@foreach($val['data'] as $r_key => $r_value)
										<div class="item">
											{{ Form::radio($key, $r_value , $data[$key] == $r_value) }}
											<span class="position-top-1"> {{ $r_value }} </span>
										</div>
									@endforeach
									@endif
								@endif
								@error($key)
								<span class="alert alert-danger">{{ $message }}</span>
								@enderror
							</div>
						@break
						@case('area')
							<label class="control-label col-sm-3">{{$val['title']}}</label>
							<div class="col-sm-9">
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
						@case('code')
							<label class="control-label col-sm-3">{{$val['title']}}</label>
							<div class="col-sm-9">
								{{Form::textarea($key, isset($data[$key])?$data[$key]:(isset($val['value'])?$val['value']:null), array('id'=>$key.'area', 'class'=>'form-control', 'placeholder'=>'Input '.$val['title']))}}
								@error($key)
								<span class="alert alert-danger">{{ $message }}</span>
								@enderror
							</div>
						@break
                        @case('images')
                        <label class="control-label col-sm-3">{{$val['title']}}</label>
                        <div class="col-sm-9">
                        <span class="inline">
                            {{Form::file($key.'[]', array('multiple', 'id'=>'upload_images_field'))}}
                        </span>
                            <div class="form-group images mt-3">
                                @if(isset($data[$key]))
                                    @foreach($data[$key] as $val)
                                        <span class="inline image_box">
                                        <img onerror="this.src='/images/no-image.png'" src="/uploads/images/thumbnail/{{$val['image']}}">
                                        <span class="delete" fid="{{$val['image_id']}}"><i class="fa fa-minus-square-o" aria-hidden="true"></i></span>
                                        <span class="edit" fid="{{$val['image_id']}}"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></span>
                                        <span class="upload_images_span" style="display: none" id="upload_images_span_{{$val['image_id']}}">
                                            {{Form::file('upload_images_field_'.$val['image_id'],
                                                array('id'=>'upload_images_field_'.$val['image_id'], 'class'=>'upload_images_field', 'fid'=>$val['image_id']))}}
                                        </span>
                                    </span>
                                    @endforeach
                                @endif
                            </div>
                            @error($key)
                            <span class="alert alert-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        @break
                        @case('image')
                        <label class="control-label col-sm-3">{{$val['title']}}</label>
                        <div class="col-sm-9">
                            @if($key === 'video')
                                <span class="inline image_box"><img @if(isset($data[$key])) src="/images/video-default.jpg" @else src="/images/no-image.png" @endif></span>
                            @else
                                <span class="inline image_box"><img onerror="this.src='/images/no-image.png'"></span>
                            @endif
                            <span class="inline">
                                {{Form::file($key, array('id'=>'feature', 'class'=>'form-control' , 'value'=>isset($data[$key])?$data[$key]:(isset($val['value'])?$val['value']:null)))}}
                            </span>
                            @error($key)
                            <span class="alert alert-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        @break
						@case('image_id')
                        <label class="control-label col-sm-3">{{$val['title']}}</label>
                        <div class="col-sm-9">
                            @if($key === 'video')
                                <span class="inline image_box"><img @if(isset($data[$key])) src="/images/video-default.jpg" @else src="/images/no-image.png" @endif></span>
                            @else
                                <span class="inline image_box"><img onerror="this.src='/images/no-image.png'" src=""> </span>
                            @endif
                            <span class="inline">
                                {{Form::file($key, array('id'=>'feature', 'class'=>'form-control' , 'value'=>isset($data[$key])?$data[$key]:(isset($val['value'])?$val['value']:null)))}}
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
								<div class="check">
									{{Form::checkbox($key, 1, isset($data[$key])?$data[$key]:(isset($val['value'])?$val['value']:null))}}
								</div>
								@error($key)
								<span class="alert alert-danger">{{ $message }}</span>
								@enderror
							</div>
						@break
						@case('check_group')
							<label class="control-label col-sm-3">{{$val['title']}}</label>
							<div class="col-sm-9 check_group">
								@if(isset($val['data']))
								@foreach($val['data'] as $k => $value)
									<div class="row">
										@if(isset($val['reference']))
											@php $check = false; $option = null; @endphp
											@if(isset($data[$key]))
												@foreach($data[$key] as $re_k => $re_val)
													@if($re_val[$val['reference']['foreign_id']] == $value['id'])
														@php $check = true; $option = $re_val @endphp
													@endif
												@endforeach
											@endif
											<div class="col-md-4">
												{{ Form::input('hidden',  $key.'['.$val['reference']['primary_id'].'][]', null , array()) }}
												{{ Form::checkbox($key.'['.$val['reference']['foreign_id'].'][]', $value['id'], $check, array('class' => 'check_reference')) }}
												<span class="position-top-1"> {{!empty($value['title'])?$value['title']:$value['name']}} </span>
											</div>
											<div class="col-md-8">
												@foreach($val['reference'] as $op_k => $op_val)
													@switch($op_k)
														@case('text')
														{{ Form::input('text', $key.'['.$op_val.'][]', isset($option[$op_val])?$option[$op_val]:'', array('class' => 'check_reference_'.$value['id'].' form-control', 'placeholder'=>$op_val)) }}
														@break
                                                        @case('select')
                                                        {{ Form::select($key.'['.$op_val.'][]', $val[$op_val.'_data'] , isset($option[$op_val])?$option[$op_val]:'', array('class' => 'check_reference_'.$value['id'].' form-control', 'placeholder'=>$op_val)) }}
                                                        @break
													@endswitch
												@endforeach
											</div>
										@endif
									</div>
								@endforeach
								@endif
							</div>
						@break
						@case('row_insert')
							<label class="control-label col-sm-3">{{$val['title']}}</label>
							<div class="col-sm-9 row_insert_component">
								@php $i = 0 @endphp
								@if(isset($val['reference']))
									<input type="hidden" class="field_update_key" value="{{$key}}">
									@foreach($val['reference'] as $op_k => $op_val)
										<input type="hidden" class="field_update_value" key="{{$op_k}}"  value="{{$op_val}}">
									@endforeach
								@endif
								@foreach($val['data'] as $k => $value)
									@php $option = null;@endphp
									@if(isset($val['reference']))
										@if(isset($data[$key]))
											@foreach($data[$key] as $re_k => $re_val)
												@if($re_val[$val['reference']['foreign_id']] == $value['id'])
													@php $check = true; $option = $re_val;  $i++ @endphp
													<div class="row row_data_{{$i}}">
														<div class="col-md-3">
															{{ Form::input('hidden', $key.'['.$val['reference']['primary_id'].'][]', null , array()) }}
															{{ Form::input('hidden', $key.'['.$val['reference']['foreign_id'].'][]', $value['id'] , array()) }}
															<span class="height-35"> {{ !empty($value['title'])?$value['title']:$value['name'] }} </span>
														</div>
														<div class="col-md-8">
															@foreach($val['reference'] as $op_k => $op_val)
																@switch($op_k)
																	@case('text')
																	{{ Form::input('text', $key.'['.$op_val.'][]', $option[$op_val] , array('class'=>'form-control sequence_data', 'placeholder'=>$op_val)) }}
																	@break
                                                                    @case('select')
                                                                    {{ Form::select($key.'['.$op_val.'][]', $val[$op_val.'_data'] , $option[$op_val], array('class' => 'select_reference form-control', 'placeholder'=>$op_val)) }}
                                                                    @break
																@endswitch
															@endforeach
														</div>
														<div class="col-md-1">
															<span class="btn js_delete_row" uid="{{$i}}"><i class="fa fa-minus-square-o" aria-hidden="true"></i></span>
														</div>
													</div>
												@endif
											@endforeach
										@endif
									@endif
								@endforeach
							</div>
							<div class="col-md-3"></div>
							<div class="col-md-9">
								<div class="row">
									<div class="col-md-5">
										@if(isset($val['add']))
										@php krsort($val['add']) @endphp
										{{Form::select('js_select_row', $val['add'] , null, array('class'=>'form-control select-data'))}}
										@endif
										<span class="btn btn-danger js_insert_row "><i class="fa fa-plus-square-o" aria-hidden="true"></i></span>
										<br><br>
									</div>
								</div>
							</div>
						@break
					@endswitch
				</div>
			@endforeach
			<div class="form-group">
				<div class="control-label col-sm-3"></div>
				<div class="col-sm-9">
					<input type="submit" id="submit" name="submit" value="Lưu">
					<input type="submit" id="submit" name="submit_edit" value="Lưu & Chỉnh Sửa Tiếp">
                    @if(Request::get('back'))
                        <a class="btn btn-second" href="{{Request::root()}}/{{urldecode(Request::get('back'))}}"> Quay lại </a>
                    @else
                        <a class="btn btn-second prefix_link" href="{{ route($resource.'.index') }}"> Hủy </a>
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
