<!-- Modal -->
<div class="modal fade" id="cancelledList" tabindex="-1" role="dialog" aria-labelledby="cancelledList" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="cancelledList">Cancelled Request</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="table-responsive">
					<table class="table table-stripe table-hover">
						<thead>
							<tr>
								<th>SPF Type</th>
								<th>Project</th>
								<th>Name of Payee</th>
								<th>Bank</th>
								<th>Account #</th>
								<th>Amount</th>
								<th>Action</th>
								{{-- <th>Action</th>
								<th>Remarks</th>
								<th>Action by</th> --}}
							</tr>
						</thead>
						<tbody>
							@if ($form_requests_cancelled->count() > 0)
								@foreach ($form_requests_cancelled as $cancelled)
									<tr id='project{{ $cancelled->id }}'>
										<td>{{ $cancelled->spf_type }}</td>
										<td>{{ $cancelled->project->project_id }}</td>
										<td>{{ $cancelled->name_of_payee }}</td>
										<td>{{ $cancelled->bank }}</td>
										<td>{{ $cancelled->account_number }}</td>
										<td>{{ number_format($cancelled->amount) }}</td>
										<td>
											<button type="button" class="btn btn-icon btn-info btn-sm" data-toggle="modal"
												data-target="#requesLogs{{ $cancelled->id }}"title="View Request Logs">
												<i class="fa fa-history"></i>
											</button>

										</td>
										{{-- <td>{{ $cancelled->request_history->action }}</td>
									<td>{{ $cancelled->request_history->remarks }}</td>
									<td>{{ $cancelled->request_history->action_by }}</td> --}}
									</tr>
								@endforeach
							@endif

						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
@foreach ($form_requests_cancelled as $cancelled)
	@include('request_logs')
@endforeach
