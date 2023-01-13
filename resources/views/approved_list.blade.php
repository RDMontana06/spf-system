<!-- Modal -->
<div class="modal fade" id="approvedList" tabindex="-1" role="dialog" aria-labelledby="approvedList" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="approvedList">Approved Requests</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="table-responsive">
					<table class="table table-striped table-bordered table-hover approved-list-tbl">
						<thead>
							<tr>
								<th>SPF Type</th>
								<th>Project</th>
								<th>Name of Payee</th>
								<th>Bank</th>
								<th>Account #</th>
								<th>Amount</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							@if ($form_requests_approved->count() > 0)
								@foreach ($form_requests_approved as $approved)
									<tr id='project{{ $approved->id }}'>
										<td>{{ $approved->spf_type }}</td>
										<td>{{ $approved->project->agency }}</td>
										<td>{{ $approved->name_of_payee }}</td>
										<td>{{ $approved->bank }}</td>
										<td>{{ $approved->account_number }}</td>
										<td>{{ number_format($approved->amount) }}</td>
										<td>
											<button type="button" class="btn btn-icon btn-info btn-sm" data-toggle="modal"
												data-target="#requesLogs{{ $approved->id }}"title="View Request Logs">
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
{{-- @foreach ($form_requests_approved as $approved)
	@include('request_logs')
@endforeach --}}
