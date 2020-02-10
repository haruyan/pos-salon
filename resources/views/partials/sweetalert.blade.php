@section('head-scripts-sweetalert')
    <!-- Sweetalert Css -->
    <link href="{{ asset('adminbsb/plugins/sweetalert/sweetalert.css') }}" rel="stylesheet" />
@endsection

@section('end-scripts-sweetalert')
    <!-- SweetAlert Plugin Js -->
    <script src="{{ asset('adminbsb/plugins/sweetalert/sweetalert.min.js') }}"></script>

    <script type="text/javascript" class="init">
		$(document).ready(function() {
			$('#formAdd').on('submit',function(e){
				e.preventDefault();
				// console.log(e.target);
				// let data = new FormData($('#formAdd')[0])

                var form = document.querySelector('#formAdd');
                var data = new FormData(form);

				axios.post($('#formAdd').attr('action'),data)
					.then(response => {
						if(response.data.error) {
							// console.log('succes error');
							// console.log(response.data);

						} else {
                            // console.log('success success');
                            // console.log(response.data);
							swal({
							title: 'Success',
							text:"Berhasil Menambahkan Data",
                            type:"success",
                            timer: 1000,
                            showConfirmButton: false
                            }, function() {
									 window.location.reload();
							});
							form.reset();
							$('#defaultModal').modal('hide')
						}
					})
					.catch(error => {
						let errors = ""
                        console.log(error);
                        console.log('error');
						try {
							errors = Object.values(error.response.data.errors).map(msg => msg[0])
							errors = errors.join()
							// console.log(errors);
						} catch(e) {
							error = "Gagal menambahkan User"
						}
						swal({
							title: "Gagal",
							text:errors,
							type: 'error'
						});
					})
            })
        } );

        function deleteThis(id) {
            event.preventDefault();
            var form = $('#swal-datatable-'+id);
                swal({
                    title: "Apakah Anda Yakin?",
                    text: "Anda akan menghapus data ini",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Hapus",
                    closeOnConfirm: false
                }, function () {
                    swal({
                        title: "Selesai!",
                        text: "Data berhasil dihapus.",
                        type: "success",
                        timer: 1000,
                        showConfirmButton: false
                    }, function () {
                        form.submit();
                    });
                });
        }
	</script>
@endsection
