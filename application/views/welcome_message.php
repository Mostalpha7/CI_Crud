<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
	
	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
 		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


    <title>Hello, world!</title>
  </head>
  <body>
   <div class="container mt-5">
	<!-- <div class="row"> -->
		<h1 class="text-center">CI Crud </h1>
		<hr />
	<!-- </div> -->
		<div class="row">
			<div class="col-md-12 mt-3">
				<!-- Button trigger modal -->
				<button type="button" class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#exampleModal">
					Add Record
				</button>

				<!--Create Modal -->
				<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
							</div>
							<div class="modal-body">
								<form action="" method="post" id="form">
									<div class="form-group">
										<label for="">Name</label>
										<input type="text" id="name" class="form-control">
									</div>
									<div class="form-group">
										<label for="">Email</label>
										<input type="email" id="email" class="form-control">
									</div>

								</form>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
								<button type="button" class="btn btn-primary" id="add">Add</button>
							</div>
						</div>
					</div>
				</div>

				<!-- Edit Modal -->
				<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel">Edit Modal</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
							</div>
							<div class="modal-body">
								<form action="" method="post" id="form">
									<input type="hidden" id="edit_modal_id" value="">

									<div class="form-group">
										<label for="">Name</label>
										<input type="text" id="edit_name" class="form-control">
									</div>
									<div class="form-group">
										<label for="">Email</label>
										<input type="email" id="edit_email" class="form-control">
									</div>

								</form>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
								<button type="button" class="btn btn-primary" id="update">Update</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12 mt-3">
				<table class="table ">
					<thead >
						<tr>
							<th scope="col">#</th>
							<th scope="col">Name</th>
							<th scope="col">Email</th>
							<th scope="col">Action</th>
						</tr>
					</thead>
					<tbody id="tbody">
					</tbody>
				</table>
			</div>
		</div>

   </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
	<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
	
	<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

	<script>
		function fetch(){
			$.ajax({
				url: "<?php echo base_url() ?>fetch",
				type: 'post',
				dataType: 'json',
				success: function(data){
					var tbody = ""

					for( var key in data){
						tbody += "<tr>";
						tbody += "<td>"+ data[key].id + "</td>";
						tbody += "<td>"+ data[key].name + "</td>";
						tbody += "<td>"+ data[key].email + "</td>";
						tbody += `<td>
									<a href="#" id="del" class="btn btn-outline-danger btn-sm" value="${data[key]['id']}"><i class="fa fa-remove"></i></a>
									<a href="#" id="edit" class="btn btn-outline-success btn-sm"  value="${data[key]['id']}"><i class="fa fa-edit"></i></a>
						 		   </td>`;
						tbody += "</tr>";
					}

					$('#tbody').html(tbody)
				}
			})
		}
		fetch()

		$(document).on('click', '#add', function(e){
			e.preventDefault();
			var name = $("#name").val();
			var email = $("#email").val();
			$.ajax({
				url: "<?php echo base_url(); ?>insert",
				type: "post",
				dataType:"json",
				data:{
					name: name,
					email: email
				},
				success: function(data){
					fetch();

					$('#exampleModal').modal('hide')
					
					if(data.responce == "success"){
						toastr_type = "success"
					}else{
						toastr_type = "error"
					}
				
					toastr[toastr_type](data.message)

					toastr.options = {
					"closeButton": true,
					"debug": false,
					"newestOnTop": false,
					"progressBar": true,
					"positionClass": "toast-top-right",
					"preventDuplicates": false,
					"onclick": null,
					"showDuration": "300",
					"hideDuration": "1000",
					"timeOut": "5000",
					"extendedTimeOut": "1000",
					"showEasing": "swing",
					"hideEasing": "linear",
					"showMethod": "fadeIn",
					"hideMethod": "fadeOut"
					}

				}
				
			})
			$('#form')[0].reset();
		})

		
		$(document).on("click", "#del", function(e){
			e.preventDefault();

			var del_id = $(this).attr('value');
			
			const swalWithBootstrapButtons = Swal.mixin({
				customClass: {
					confirmButton: 'btn btn-success ml-2',
					cancelButton: 'btn btn-danger'
				},
				buttonsStyling: false
				})

				swalWithBootstrapButtons.fire({
				title: 'Are you sure?',
				text: "You won't be able to revert this!",
				icon: 'warning',
				showCancelButton: true,
				confirmButtonText: 'Yes, delete it!',
				cancelButtonText: 'No, cancel!',
				reverseButtons: true
				}).then((result) => {
				if (result.value) {

					$.ajax({
						url: "<?php echo base_url(); ?>delete",
						type: "post",
						dataType:"json",
						data:{
							del_id: del_id,
						},
						success: function(data){
							fetch()
							if(data){
								swalWithBootstrapButtons.fire(
									'Success!',
									'Your file has been deleted.',
									'success'
								)
							}
						}
					})
				} else if (
					/* Read more about handling dismissals below */
					result.dismiss === Swal.DismissReason.cancel
				) {
					swalWithBootstrapButtons.fire(
					'Cancelled',
					'Your imaginary file is safe :)',
					'error'
					)
				}
			})
		})

		$(document).on("click", "#edit", function(e){
			e.preventDefault()

			var edit_id = $(this).attr('value');
			
			if(edit_id=="" || edit_id== null){
				alert('Edit_id is Required')
			}else{
				$.ajax({
					url: "<?php echo base_url() ?>edit",
					type: 'post',
					dataType:'json',
					data:{
						edit_id,edit_id
					},
					success: function(data){
						if(data.responce=='success'){

							$('#editModal').modal('show');
							$('#edit_modal_id').val(data.post.id);
							$('#edit_name').val(data.post.name);
							$('#edit_email').val(data.post.email);

						}else{

							toastr[toastr_type](data.message)

							toastr.options = {
							"closeButton": true,
							"debug": false,
							"newestOnTop": false,
							"progressBar": true,
							"positionClass": "toast-top-right",
							"preventDuplicates": false,
							"onclick": null,
							"showDuration": "300",
							"hideDuration": "1000",
							"timeOut": "5000",
							"extendedTimeOut": "1000",
							"showEasing": "swing",
							"hideEasing": "linear",
							"showMethod": "fadeIn",
							"hideMethod": "fadeOut" 
							}

						}

					}
				})
			}
		})

		$(document).on("click", '#update', function(e){
			e.preventDefault()

			var edit_id = $('#edit_modal_id').val();
			var edit_name = $('#edit_name').val();
			var edit_email = $('#edit_email').val();


			if(edit_id==""|| edit_id==null || edit_name==""|| edit_email==""){
				alert('both fields cannot be empty');
			}else{				
				$.ajax({
					url: '<?php echo base_url(); ?>update',
					type: 'post',
					dataType:'json',
					data: {
						edit_id: edit_id,
						edit_name: edit_name,
						edit_email: edit_email
					},
					success: function(data){
						fetch();
			
						$('#editModal').modal('hide');
						if(data.responce == "success"){

							toastr["success"](data.message)

							toastr.options = {
							"closeButton": true,
							"debug": false,
							"newestOnTop": false,
							"progressBar": true,
							"positionClass": "toast-top-right",
							"preventDuplicates": false,
							"onclick": null,
							"showDuration": "300",
							"hideDuration": "1000",
							"timeOut": "5000",
							"extendedTimeOut": "1000",
							"showEasing": "swing",
							"hideEasing": "linear",
							"showMethod": "fadeIn",
							"hideMethod": "fadeOut" 
							}
						}else{
							toastr["error"](data.message)

							toastr.options = {
							"closeButton": true,
							"debug": false,
							"newestOnTop": false,
							"progressBar": true,
							"positionClass": "toast-top-right",
							"preventDuplicates": false,
							"onclick": null,
							"showDuration": "300",
							"hideDuration": "1000",
							"timeOut": "5000",
							"extendedTimeOut": "1000",
							"showEasing": "swing",
							"hideEasing": "linear",
							"showMethod": "fadeIn",
							"hideMethod": "fadeOut" 
							}
						}
					}
				}) 
			}
		})
	</script>
  </body>
</html>