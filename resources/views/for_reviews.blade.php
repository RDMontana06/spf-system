@extends('layouts.header')

@section('content')
	<div class="row wrapper border-bottom white-bg page-heading">
		<div class="col-sm-4">
			<h2>For Review List</h2>
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
					<li class="breadcrumb-item active font-weight-bold" aria-current="page">For Review</li>
				</ol>
			</nav>
		</div>
	</div>
	<div class="wrapper wrapper-content">
		<div class="row">
			<div class="col-lg-3">
				<div class="ibox float-e-margins">
					<div class="ibox-title">
						<span class="label label-warning pull-right">as of Today</span>
						<h5> Pending For Review</h5>
					</div>
					<div class="ibox-content">
						<h1 class="no-margins" id='pending_request'>{{ count($form_requests->where('status', 'Pending')) }}</h1>
						{{-- <div class="stat-percent font-bold text-navy">44% <i class="fa fa-level-up"></i></div> --}}
						<small>&nbsp;</small>
					</div>
				</div>
			</div>
			<div class="col-lg-3">
				<div class="ibox float-e-margins">
					<div class="ibox-title">
						<span class="label label-primary pull-right">as of Today</span>
						<h5>Reviewed Request</h5>
					</div>
					<div class="ibox-content">
						<h1 class="no-margins">{{ {{ count($form_requests->where('status', 'Pending')->where('approval_id', auth()->user()->id)) }} }}</h1>
						{{-- <div class="stat-percent font-bold text-navy">44% <i class="fa fa-level-up"></i></div> --}}
						<small>&nbsp;</small>
					</div>
				</div>
			</div>
			<div class="col-lg-3">
				<div class="ibox float-e-margins">
					<div class="ibox-title">
						<span class="label label-danger pull-right">as of Today</span>
						<h5>Declined Requests</h5>
					</div>
					<div class="ibox-content">
						<h1 class="no-margins" id='declined_request'>0</h1>
						{{-- <div class="stat-percent font-bold text-navy">44% <i class="fa fa-level-up"></i></div> --}}
						<small>&nbsp;</small>
					</div>
				</div>
			</div>
		</div>
		@if (session()->has('status'))
			<div class="alert alert-success alert-dismissable">
				<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
				{{ session()->get('status') }}
			</div>
		@endif
		@include('error')
		<div class="row">
			<div class="col-lg-12 ">
				<div class="ibox float-e-margins">
					{{-- <div class="ibox-title">
                    <h5>Requests
                        <button class="btn btn-primary" data-target="#new_request" data-toggle="modal" type="button"><i class="fa fa-plus-circle"></i>&nbsp;</button>
                    </h5>
                    <div ibox-tools></div>
                </div> --}}

					<div class="ibox-content">
						<table datatable="" dt-options="dtOptions"
							class="table table-striped table-bordered table-hover for-review-tbl">
							<thead>
								<tr>
									{{-- <th>Logo</th> --}}
									<th>SPF Control #</th>
									<th>Requestor</th>
									<th>Date Requested</th>
									<th>Information</th>
									<th>Purpose</th>
									<th>Payee Information</th>
									<th>Amount</th>
									<th>Attachments</th>
									<th>Status</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								@foreach ($form_requests->where('status', 'Pending') as $form)
									<tr>
										<td>
											@if ($form->project != null)
												SPF-{{ $form->project->company->company_code }}-{{ str_pad($form->id, 6, '0', STR_PAD_LEFT) }}
											@else
												SPF-{{ $form->user->company->company_code }}-{{ str_pad($form->id, 6, '0', STR_PAD_LEFT) }}
											@endif
										</td>
										<td>{{ $form->user->name }}</td>
										<td>{{ date('F d, Y', strtotime($form->created_at)) }}</td>
										<td>
											@if ($form->project != null)
												<small>
													Project ID : {{ $form->project->project_id }}
													<br>
													Remaining Budget : {{ number_format($form->project->spf_budget, 2) }}
													<br>
												</small>
											@endif
										</td>
										<td>{!! nl2br(e($form->purpose)) !!}</td>
										<td><small>
												Code : PAYEE-{{ str_pad($form->payee_code, 6, '0', STR_PAD_LEFT) }}
												<br>
												@if ($form->bank_info)
													Bank : {{ $form->bank_info->bank_name }}
												@endif

												<br>
												Account Number : {{ $form->account_number }}
												<br>

										</td>
										<td>{{ number_format($form->amount, 2) }}
										</td>
										<td>

											@if (count($form->attachments) == 0)
												No Data Found
											@else
												@foreach ($form->attachments as $attachment)
												<a href="{{ url($attachment->attachment_url) }}"style="text-decoration:none;" target="_blank" title="Open File" ><span class="fa fa-file"></span></a>
												@endforeach
											@endif
										</td>
										<td>
											<span id="status{{ $form->id }}" class="badge badge-warning">
												{{ $form->status }}
											</span>
										</td>
										<td data-id='{{ $form->id }}'>
											<button class="btn btn-sm btn-info " title='Review Request' data-target="#approveRequest{{ $form->id }}"
												data-toggle="modal"><i class="fa fa-check-square-o"></i></button>
											<button class="btn btn-sm btn-danger declined-request" title='Decline Request'
												data-target="#declinedRequest{{ $form->id }}" data-toggle="modal"><i
													class="fa fa-window-close-o"></i></button>
											@include('approved_request')
											@include('decline_request')
										</td>
									</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
