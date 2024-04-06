@extends('Admin::Layouts.admin')
@section('content')
<div id="list" class="container-fluid">
	<table class="table table-bordered table-hover table-striped">
		<thead>
			<tr>
				<td width="3%" class="text-center">
					<input type="checkbox" name="checkall" id="checkAll">
					{{ csrf_field() }}
				</td>
				@foreach($list as $key => $val)
					@if(!isset($val['hidden']))
					<td width="{{isset($val['width'])?$val['width']:''}}%">
						<span class="title">{{isset($val['title'])?$val['title']:''}}</span>
						@if(!isset($val['sort']) || ($val['sort'] != 'hidden'))
						<span class="sort" title="Sắp Xếp">
							<a href="{{Request::url()}}{{(Session::get('page') != null)?
                                '?page='.Session::get('page').'&order='.$key.'&by=asc': '?order='.$key.'&by=asc'}}">
								<i class="
								@if(($sort['order'] == $key)&&($sort['by'] == 'asc'))
									{{'active'}}
								@endif
								fa fa-sort-asc" aria-hidden="true"></i>
							</a>
							<a href="{{Request::url()}}{{(Session::get('page') != null)?
                                '?page='.Session::get('page').'&order='.$key.'&by=desc': '?order='.$key.'&by=desc'}}">
								<i class="
								@if(($sort['order'] == $key)&&($sort['by'] == 'desc'))
									{{'active'}}
								@endif
								fa fa-sort-desc" aria-hidden="true"></i>
							</a>
						</span>
						@endif
					</td>
					@endif
				@endforeach
				<td width="8%" class="text-center">
					Thực Hiện
				</td>
			</tr>
		</thead>
		<form id="filter" method="get" action="{{Request::url().$url_sort}}">
			<tr class="filter-list">
				<td class="text-center">
					#
				</td>
				@foreach($list as $key => $val)
					@if(!isset($val['hidden']))
						<td>
						@if(isset($val['filter']['type']))
							@switch($val['filter']['type'])
								@case('text')
									{{Form::input('text', $key, $val['filter']['value'], array('class' => '', 'placeholder' => $key))}}
								@break
								@case('select')
									{{Form::select($key, $val['data'], isset($val['filter']['value'])? $val['filter']['value']: null, array('class'=>''))}}
								@break
								@default
									{{Form::input('text',$key, $val['filter']['value'], array('class' => '', 'placeholder' => $key))}}
								@break
							@endswitch
						@endif
						</td>
					@endif
				@endforeach
				<td colspan="2" class="text-center">
					<div class="group-button">
						<input type="submit" name="submit" value="Lọc">
						@if(isset($control['add_reference']))
							<a class="btn btn-insert" href="{{Request::root()}}/{{$control['add_reference']['link']}}"> {{$control['add_reference']['title']}} </a>
						@endif
						@if(!isset($control['add']))
							<a class="btn btn-info btn-insert" href="{{route($resource.'.create')}}"> Thêm </a>
						@endif
					</div>
				</td>
			</tr>
		</form>
		<tbody>
			@foreach($data as $l_key => $l_value)
			<tr>
				<td class="text-center">
					<input class="item_id" type="checkbox" name="check" data="{{$l_value['id']}}">
				</td>
				@foreach($list as $key => $val)
					@if(!isset($val['hidden']))
						@if(isset($val['views']) && isset($val['views']['type']))
							@switch($val['views']['type'])
								@case('images')
									<td class="text-center">
										@if(!empty($l_value[$key]))
											@foreach (explode(',', $l_value[$key]) as $item)
												<span><img onerror="this.src='/images/no-image.png'" src="{{route('get-image-thumbnail', $item)}}"></span>
											@endforeach
										@endif
									</td>
								@break
								@case('image')
									<td class="text-center">
									@if(empty($val['update']) )
										<span><img onerror="this.src='/images/no-image.png'" src="{{$l_value[$key]}}"></span>
									@else
										<span class="can_update_text" type="{{$val['views']['type']}}" field="{{$key}}" uid="{{$l_value['id']}}">
											<span><img onerror="this.src='/images/no-image.png'" src="{{$l_value[$key]}}"></span>
										</span>
									@endif
									</td>
								@break
								@case('image_id')
									<td class="text-center">
									@if(empty($val['update']) )
										<span><img onerror="this.src='/images/no-image.png'" src="{{route('get-image-thumbnail', $l_value[$key])}}"></span>
									@else
										<span class="can_update_text" type="{{$val['views']['type']}}" field="{{$key}}" uid="{{$l_value['id']}}">
											<span><img onerror="this.src='/images/no-image.png'" src="{{route('get-image-thumbnail', $l_value[$key])}}"></span>
										</span>
									@endif
									</td>
								@break
								@case('file')
									<td class="text-center">
									@if(empty($val['update']) )
										<span>{{preg_replace('/(.)*(?:\/)/','',$l_value[$key])}}</span>
									@else
										<span class="can_update_text" type="{{$val['views']['type']}}" field="{{$key}}" uid="{{$l_value['id']}}">
											<span>{{preg_replace('/(.)*(?:\/)/','',$l_value[$key])}}</span>
										</span>
									@endif
									</td>
								@break
								@case('check')
									<td class="text-center check-list">
									    {{Form::checkbox($key, $l_value['id'], $l_value[$key], array('fid='.$l_value['id'], (empty($val['update']) )?'disabled':''))}}
									</td>
								@break
								@case('select')
									<td class="text-left">
									@if(empty($val['update']) )
										<span class="no-update">
											@foreach($val['data'] as $k => $value)
												@if($l_value[$key] == $k)
													{{$value}}
												@endif
											@endforeach
										</span>
									@else
										<span class="can_update_text" type="{{$val['views']['type']}}" data="{{json_encode($val['data'])}}" field="{{$key}}" uid="{{$l_value['id']}}">
											@foreach($val['data'] as $k => $value)
												@if($l_value[$key] == $k)
													<span class="inline" uid="{{$k}}">{{$value}}</span>
												@endif
											@endforeach
										</span>
									@endif
									</td>
								@break
								@case('area')
									<td class="text-left">
										@if(empty($val['update']) )
											<span class="no-update">{!! $l_value[$key] !!}</span>
										@else
											<span class="can_update_text" type="{{$val['views']['type']}}" field="{{$key}}" uid="{{$l_value['id']}}">
												<span class="inline">{!! $l_value[$key] !!}</span>
											</span>
										@endif
									</td>
								@break
								@case('text')
									<td class="text-left">
										@if(empty($val['update']) )
											<span class="p-2">{!! $l_value[$key] !!}</span>
										@else
											<span class="can_update_text" type="{{$val['views']['type']}}" field="{{$key}}" uid="{{$l_value['id']}}">
												<span class="p-2">{!! $l_value[$key] !!}</span>
											</span>
										@endif
									</td>
								@break
                                @default
                                    <td class="text-left">
                                        <span class="p-2">{!! $l_value[$key] !!}</span>
                                    </td>
                                @break
							@endswitch
						@else
							<td class="text-left">
							@if(empty($val['update']) )
								<span class="no-update">{!! $l_value[$key] !!}</span>
							@else
								<span class="can_update_text" field="{{$key}}" type="text" uid="{{$l_value['id']}}">
									<span class="inline">{!! $l_value[$key] !!}</span>
								</span>
							@endif
							</td>
						@endif
					@endif
				@endforeach
				<td class="action_row text-center">
					<a title="Sao Chép" href="{{route($resource.'.show', $l_value['id'])}}"> <i class="fa fa-plus-square-o" aria-hidden="true"></i></a>
					<a title="Chỉnh Sửa" href="{{route($resource.'.edit', $l_value['id'])}}"> <i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
					<a title="Xóa" class="ajax_delete" href="javascript:void(0)" url="{{ route($resource.'.destroy', $l_value['id'])}} "><i class="fa fa-minus-square-o" aria-hidden="true"></i></a>
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>
	<div class="row">
		<div class="col-md-6 action mb-2">
		</div>
		<div class="col-md-6">
			@if(!empty($paginate))
				{!! $data->appends(['order' => Request::get('order'), 'by'=>Request::get('by')])->links('vendor.pagination.bootstrap-4') !!}
			@endif
		</div>
	</div>
</div>
@endsection


